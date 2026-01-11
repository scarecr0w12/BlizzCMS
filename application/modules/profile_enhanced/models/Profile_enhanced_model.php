<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_enhanced_model extends CI_Model
{
    // Activity timeline
    public function add_activity($user_id, $type, $data = null, $reference_id = null)
    {
        return $this->db->insert('user_activities', [
            'user_id' => $user_id,
            'activity_type' => $type,
            'activity_data' => $data ? json_encode($data) : null,
            'reference_id' => $reference_id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function get_user_timeline($user_id, $limit = 20, $offset = 0)
    {
        return $this->db->where('user_id', $user_id)
            ->where('is_public', 1)
            ->order_by('created_at', 'DESC')
            ->limit($limit, $offset)
            ->get('user_activities')
            ->result();
    }

    public function get_recent_activities($limit = 10)
    {
        return $this->db->select('user_activities.*, users.username')
            ->from('user_activities')
            ->join('users', 'user_activities.user_id = users.id', 'left')
            ->where('user_activities.is_public', 1)
            ->order_by('user_activities.created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    // Profile management
    public function get_profile($user_id)
    {
        $profile = $this->db->where('user_id', $user_id)
            ->get('user_profiles')
            ->row();

        if (!$profile) {
            $this->db->insert('user_profiles', ['user_id' => $user_id]);
            return $this->get_profile($user_id);
        }

        return $profile;
    }

    public function update_profile($user_id, $data)
    {
        $existing = $this->db->where('user_id', $user_id)
            ->get('user_profiles')
            ->row();

        $data['updated_at'] = date('Y-m-d H:i:s');

        if ($existing) {
            return $this->db->where('user_id', $user_id)
                ->update('user_profiles', $data);
        } else {
            $data['user_id'] = $user_id;
            return $this->db->insert('user_profiles', $data);
        }
    }

    // Achievements showcase
    public function get_showcased_achievements($user_id)
    {
        return $this->db->where('user_id', $user_id)
            ->where('showcase', 1)
            ->order_by('earned_at', 'DESC')
            ->get('user_achievement_showcase')
            ->result();
    }

    public function add_to_showcase($user_id, $achievement_id, $character_guid = null)
    {
        $showcase_count = $this->db->where('user_id', $user_id)
            ->where('showcase', 1)
            ->count_all_results('user_achievement_showcase');

        $settings = $this->get_all_settings();
        $max_showcase = $settings['max_showcase_achievements'] ?? 6;

        if ($showcase_count >= $max_showcase) {
            return false;
        }

        return $this->db->insert('user_achievement_showcase', [
            'user_id' => $user_id,
            'achievement_id' => $achievement_id,
            'character_guid' => $character_guid,
            'showcase' => 1,
            'earned_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function remove_from_showcase($user_id, $achievement_id)
    {
        return $this->db->where('user_id', $user_id)
            ->where('achievement_id', $achievement_id)
            ->update('user_achievement_showcase', ['showcase' => 0]);
    }

    // Profile visits
    public function track_visit($profile_user_id, $visitor_user_id = null)
    {
        return $this->db->insert('profile_visits', [
            'profile_user_id' => $profile_user_id,
            'visitor_user_id' => $visitor_user_id,
            'visited_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function get_visit_count($user_id)
    {
        return $this->db->where('profile_user_id', $user_id)
            ->count_all_results('profile_visits');
    }

    public function get_recent_visitors($user_id, $limit = 10)
    {
        return $this->db->select('profile_visits.*, users.username')
            ->from('profile_visits')
            ->join('users', 'profile_visits.visitor_user_id = users.id', 'left')
            ->where('profile_visits.profile_user_id', $user_id)
            ->where('profile_visits.visitor_user_id IS NOT NULL')
            ->order_by('profile_visits.visited_at', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    // Statistics
    public function get_user_statistics($user_id)
    {
        return [
            'total_activities' => $this->db->where('user_id', $user_id)->count_all_results('user_activities'),
            'total_achievements' => $this->db->where('user_id', $user_id)->count_all_results('user_achievement_showcase'),
            'profile_visits' => $this->get_visit_count($user_id),
            'join_date' => $this->db->select('created_at')->where('id', $user_id)->get('users')->row()->created_at ?? null,
        ];
    }

    // Characters
    public function get_user_characters($username, $limit = 10)
    {
        $CI =& get_instance();
        $CI->load->model('server_auth_model');
        $CI->load->model('armory/armory_character_model');
        
        // Get account ID from auth database
        $auth_db = $CI->server_auth_model->connect();
        $account = $auth_db->select('id')->where('username', $username)->get('account')->row();
        
        if (!$account) {
            return [];
        }
        
        $account_id = $account->id;
        $characters = [];
        
        // Get characters from all realms
        $realms = $CI->realm_model->find_all();
        
        foreach ($realms as $realm) {
            $realm_chars = $this->get_realm_characters($realm->id, $account_id, $limit);
            foreach ($realm_chars as $char) {
                $char->realm_id = $realm->id;
                $char->realm_name = $realm->name;
                $characters[] = $char;
            }
        }
        
        // Sort by level descending
        usort($characters, function($a, $b) {
            return $b->level - $a->level;
        });
        
        return array_slice($characters, 0, $limit);
    }
    
    protected function get_realm_characters($realm_id, $account_id, $limit = 50)
    {
        $CI =& get_instance();
        
        // Connect to character database
        $realm = $CI->realm_model->find(['id' => $realm_id]);
        
        if (empty($realm)) {
            return [];
        }
        
        $database = $CI->load->database([
            'hostname' => $realm->char_hostname,
            'username' => $realm->char_username,
            'password' => decrypt($realm->char_password),
            'database' => $realm->char_database,
            'port'     => $realm->char_port,
            'dbdriver' => 'mysqli',
            'pconnect' => false,
            'char_set' => 'utf8mb4',
            'dbcollat' => 'utf8mb4_unicode_ci'
        ], true);
        
        if ($database->conn_id === false) {
            return [];
        }
        
        return $database->select('guid, name, race, class, gender, level, online')
            ->from('characters')
            ->where('account', $account_id)
            ->order_by('level', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    // Settings
    public function get_all_settings()
    {
        $query = $this->db->get('profile_enhanced_settings');
        $settings = [];
        
        foreach ($query->result() as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }
        
        return $settings;
    }

    public function get_setting($key)
    {
        $row = $this->db->where('setting_key', $key)->get('profile_enhanced_settings')->row();
        return $row ? $row->setting_value : null;
    }

    public function update_setting($key, $value)
    {
        $exists = $this->db->where('setting_key', $key)->count_all_results('profile_enhanced_settings') > 0;
        
        if ($exists) {
            $this->db->where('setting_key', $key);
            $this->db->update('profile_enhanced_settings', [
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $this->db->insert('profile_enhanced_settings', [
                'setting_key' => $key,
                'setting_value' => $value,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    public function get_module_statistics()
    {
        return [
            'total_profiles' => $this->db->count_all('user_profiles'),
            'total_activities' => $this->db->count_all('user_activities'),
            'total_visits' => $this->db->count_all('profile_visits'),
            'total_showcased' => $this->db->where('showcase', 1)->count_all_results('user_achievement_showcase'),
        ];
    }
}
