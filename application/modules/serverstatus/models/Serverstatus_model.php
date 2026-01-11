<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Serverstatus_model extends CI_Model
{
    public function get_realms_with_stats()
    {
        $realms = $this->db->get('realms')->result();
        
        foreach ($realms as $realm) {
            $realm->online_count = $this->get_online_count($realm->id);
            $realm->uptime = $this->get_current_uptime($realm->id);
        }
        
        return $realms;
    }

    public function get_online_count($realm_id = null)
    {
        if (!$realm_id) {
            return 0;
        }

        try {
            $char_db = $this->connect_to_realm($realm_id);
            if (!$char_db) {
                return 0;
            }
            
            $count = $char_db->where('online', 1)->count_all_results('characters');
            return $count;
        } catch (Exception $e) {
            log_message('error', 'Serverstatus: Failed to get online count - ' . $e->getMessage());
            return 0;
        }
    }

    protected function connect_to_realm($realm_id)
    {
        $this->load->model('realm_model');
        $realm = $this->realm_model->find(['id' => $realm_id]);

        if (empty($realm)) {
            return false;
        }

        $database = $this->load->database([
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
            return false;
        }

        return $database;
    }

    public function get_faction_balance($realm_id = null)
    {
        if (!$realm_id) {
            $this->load->model('realm_model');
            $realms = $this->realm_model->find_all();
            $realm_id = !empty($realms) ? $realms[0]->id : null;
        }

        if (!$realm_id) {
            return ['alliance' => 0, 'horde' => 0, 'total' => 0];
        }

        try {
            $char_db = $this->connect_to_realm($realm_id);
            if (!$char_db) {
                return ['alliance' => 0, 'horde' => 0, 'total' => 0];
            }
            
            $alliance_races = [1, 3, 4, 7, 11, 22];
            $horde_races = [2, 5, 6, 8, 9, 10];

            $alliance_count = $char_db->where_in('race', $alliance_races)
                ->where('online', 1)
                ->count_all_results('characters');

            $horde_count = $char_db->where_in('race', $horde_races)
                ->where('online', 1)
                ->count_all_results('characters');

            return [
                'alliance' => $alliance_count,
                'horde' => $horde_count,
                'total' => $alliance_count + $horde_count
            ];
        } catch (Exception $e) {
            log_message('error', 'Serverstatus: Failed to get faction balance - ' . $e->getMessage());
            return ['alliance' => 0, 'horde' => 0, 'total' => 0];
        }
    }

    public function get_class_distribution($realm_id = null)
    {
        if (!$realm_id) {
            $this->load->model('realm_model');
            $realms = $this->realm_model->find_all();
            $realm_id = !empty($realms) ? $realms[0]->id : null;
        }

        if (!$realm_id) {
            return [];
        }

        try {
            $char_db = $this->connect_to_realm($realm_id);
            if (!$char_db) {
                return [];
            }
            
            $query = $char_db->select('class, COUNT(*) as count')
                ->where('online', 1)
                ->group_by('class')
                ->get('characters');

            $classes = [
                1 => 'Warrior', 2 => 'Paladin', 3 => 'Hunter', 4 => 'Rogue',
                5 => 'Priest', 6 => 'Death Knight', 7 => 'Shaman', 8 => 'Mage',
                9 => 'Warlock', 10 => 'Monk', 11 => 'Druid'
            ];

            $distribution = [];
            foreach ($query->result() as $row) {
                $distribution[] = [
                    'class' => $classes[$row->class] ?? 'Unknown',
                    'count' => $row->count
                ];
            }

            return $distribution;
        } catch (Exception $e) {
            log_message('error', 'Serverstatus: Failed to get class distribution - ' . $e->getMessage());
            return [];
        }
    }

    public function get_level_distribution($realm_id = null)
    {
        if (!$realm_id) {
            $this->load->model('realm_model');
            $realms = $this->realm_model->find_all();
            $realm_id = !empty($realms) ? $realms[0]->id : null;
        }

        if (!$realm_id) {
            return [];
        }

        try {
            $char_db = $this->connect_to_realm($realm_id);
            if (!$char_db) {
                return [];
            }
            
            $query = $char_db->select('
                    CASE 
                        WHEN level BETWEEN 1 AND 9 THEN "1-9"
                        WHEN level BETWEEN 10 AND 19 THEN "10-19"
                        WHEN level BETWEEN 20 AND 29 THEN "20-29"
                        WHEN level BETWEEN 30 AND 39 THEN "30-39"
                        WHEN level BETWEEN 40 AND 49 THEN "40-49"
                        WHEN level BETWEEN 50 AND 59 THEN "50-59"
                        WHEN level BETWEEN 60 AND 69 THEN "60-69"
                        WHEN level BETWEEN 70 AND 79 THEN "70-79"
                        WHEN level >= 80 THEN "80+"
                    END as level_range,
                    COUNT(*) as count
                ', false)
                ->where('online', 1)
                ->group_by('level_range')
                ->get('characters');

            if ($query && $query->num_rows() > 0) {
                return $query->result_array();
            }
            return [];
        } catch (Exception $e) {
            log_message('error', 'Serverstatus: Failed to get level distribution - ' . $e->getMessage());
            return [];
        }
    }

    public function get_peak_players_today($realm_id = null)
    {
        $today_start = strtotime('today midnight');
        
        $query = $this->db->select_max('online_players', 'peak')
            ->where('timestamp >=', date('Y-m-d H:i:s', $today_start));
        
        if ($realm_id) {
            $query->where('realm_id', $realm_id);
        }
        
        $query = $query->get('serverstatus_history');
        $result = $query->row();
        return $result ? $result->peak : 0;
    }

    public function get_current_uptime($realm_id = null)
    {
        $realm = $this->db->where('id', $realm_id)->get('realms')->row();
        if (!$realm) {
            return 0;
        }

        return $realm->uptime ?? 0;
    }

    public function get_uptime_statistics($days = 7, $realm_id = null)
    {
        $start_date = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        
        $query = $this->db->select('AVG(uptime_seconds) as avg_uptime')
            ->where('timestamp >=', $start_date);
        
        if ($realm_id) {
            $query->where('realm_id', $realm_id);
        }
        
        $query = $query->get('serverstatus_history');
        $result = $query->row();
        return $result ? round($result->avg_uptime) : 0;
    }

    public function record_stats($realm_id, $data)
    {
        $record = [
            'realm_id' => $realm_id,
            'timestamp' => date('Y-m-d H:i:s'),
            'online_players' => $data['online_players'] ?? 0,
            'alliance_count' => $data['alliance_count'] ?? 0,
            'horde_count' => $data['horde_count'] ?? 0,
            'uptime_seconds' => $data['uptime_seconds'] ?? 0,
        ];

        return $this->db->insert('serverstatus_history', $record);
    }

    public function get_all_settings()
    {
        $query = $this->db->get('serverstatus_settings');
        $settings = [];
        
        foreach ($query->result() as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }
        
        return $settings;
    }

    public function update_setting($key, $value)
    {
        $data = [
            'setting_value' => $value,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        return $this->db->where('setting_key', $key)
            ->update('serverstatus_settings', $data);
    }

    public function get_admin_overview()
    {
        $total_history = $this->db->count_all('serverstatus_history');
        $total_realms = $this->db->count_all('realms');
        
        return [
            'total_records' => $total_history,
            'realms_tracked' => $total_realms,
        ];
    }

    public function get_recent_history($hours = 24)
    {
        $start_time = date('Y-m-d H:i:s', strtotime("-{$hours} hours"));
        
        return $this->db->where('timestamp >=', $start_time)
            ->order_by('timestamp', 'DESC')
            ->limit(100)
            ->get('serverstatus_history')
            ->result();
    }

    public function get_realm_stats($realm_id)
    {
        $realm = $this->db->where('id', $realm_id)->get('realms')->row();
        if (!$realm) {
            return null;
        }

        $realm->online_count = $this->get_online_count($realm_id);
        $realm->faction_balance = $this->get_faction_balance($realm_id);
        $realm->uptime = $this->get_current_uptime($realm_id);

        return $realm;
    }
}
