<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leaderboards_model extends CI_Model
{
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

    protected function get_first_realm_id()
    {
        $this->load->model('realm_model');
        $realms = $this->realm_model->find_all();
        if (empty($realms)) {
            log_message('debug', 'Leaderboards: No realms found in database');
            return null;
        }
        return $realms[0]->id;
    }

    public function get_pvp_rankings($limit = 50, $offset = 0, $realm_id = null)
    {
        if (!$realm_id) {
            $realm_id = $this->get_first_realm_id();
        }

        if (!$realm_id) {
            return [];
        }

        try {
            $char_db = $this->connect_to_realm($realm_id);
            if (!$char_db) {
                return [];
            }
            
            return $char_db->select('guid, name, race, class, level, totalKills, arenaPoints, totalHonorPoints')
                ->from('characters')
                ->where('level >=', 70)
                ->order_by('totalKills', 'DESC')
                ->limit($limit, $offset)
                ->get()
                ->result();
        } catch (Exception $e) {
            log_message('error', 'Leaderboards: Failed to get PvP rankings - ' . $e->getMessage());
            return [];
        }
    }

    public function count_pvp_players($realm_id = null)
    {
        if (!$realm_id) {
            $realm_id = $this->get_first_realm_id();
        }

        if (!$realm_id) {
            return 0;
        }

        try {
            $char_db = $this->connect_to_realm($realm_id);
            if (!$char_db) {
                return 0;
            }
            return $char_db->where('level >=', 70)->count_all_results('characters');
        } catch (Exception $e) {
            log_message('error', 'Leaderboards: Failed to count PvP players - ' . $e->getMessage());
            return 0;
        }
    }

    public function get_honor_rankings($limit = 50, $offset = 0, $realm_id = null)
    {
        if (!$realm_id) {
            $realm_id = $this->get_first_realm_id();
        }

        if (!$realm_id) {
            return [];
        }

        try {
            $char_db = $this->connect_to_realm($realm_id);
            if (!$char_db) {
                return [];
            }
            
            return $char_db->select('guid, name, race, class, level, totalHonorPoints, todayHonorPoints, yesterdayHonorPoints')
                ->from('characters')
                ->where('totalHonorPoints >', 0)
                ->order_by('totalHonorPoints', 'DESC')
                ->limit($limit, $offset)
                ->get()
                ->result();
        } catch (Exception $e) {
            log_message('error', 'Leaderboards: Failed to get honor rankings - ' . $e->getMessage());
            return [];
        }
    }

    public function count_honor_players($realm_id = null)
    {
        if (!$realm_id) {
            $realm_id = $this->get_first_realm_id();
        }

        if (!$realm_id) {
            return 0;
        }

        try {
            $char_db = $this->connect_to_realm($realm_id);
            if (!$char_db) {
                return 0;
            }
            return $char_db->where('totalHonorPoints >', 0)->count_all_results('characters');
        } catch (Exception $e) {
            log_message('error', 'Leaderboards: Failed to count honor players - ' . $e->getMessage());
            return 0;
        }
    }

    public function get_arena_rankings($type = '2v2', $limit = 50, $offset = 0, $realm_id = null)
    {
        if (!$realm_id) {
            $realm_id = $this->get_first_realm_id();
        }

        if (!$realm_id) {
            return [];
        }

        try {
            $char_db = $this->connect_to_realm($realm_id);
            if (!$char_db) {
                return [];
            }
            
            $type_id = ['2v2' => 2, '3v3' => 3, '5v5' => 5][$type] ?? 2;
            
            return $char_db->select('arenaTeamId, name, captainGuid, type, rating, seasonGames, seasonWins, weekGames, weekWins')
                ->from('arena_team')
                ->where('type', $type_id)
                ->order_by('rating', 'DESC')
                ->limit($limit, $offset)
                ->get()
                ->result();
        } catch (Exception $e) {
            log_message('error', 'Leaderboards: Failed to get arena rankings - ' . $e->getMessage());
            return [];
        }
    }

    public function count_arena_teams($type = '2v2', $realm_id = null)
    {
        if (!$realm_id) {
            $realm_id = $this->get_first_realm_id();
        }

        if (!$realm_id) {
            return 0;
        }

        try {
            $char_db = $this->connect_to_realm($realm_id);
            if (!$char_db) {
                return 0;
            }
            $type_id = ['2v2' => 2, '3v3' => 3, '5v5' => 5][$type] ?? 2;
            return $char_db->where('type', $type_id)->count_all_results('arena_team');
        } catch (Exception $e) {
            log_message('error', 'Leaderboards: Failed to count arena teams - ' . $e->getMessage());
            return 0;
        }
    }

    public function get_achievement_rankings($limit = 50, $offset = 0, $realm_id = null)
    {
        if (!$realm_id) {
            $realm_id = $this->get_first_realm_id();
        }

        if (!$realm_id) {
            return [];
        }

        try {
            $char_db = $this->connect_to_realm($realm_id);
            if (!$char_db) {
                return [];
            }
            
            return $char_db->select('c.guid, c.name, c.race, c.class, c.level, COUNT(ca.achievement) as achievement_count')
                ->from('characters c')
                ->join('character_achievement ca', 'c.guid = ca.guid', 'left')
                ->group_by('c.guid')
                ->order_by('achievement_count', 'DESC')
                ->limit($limit, $offset)
                ->get()
                ->result();
        } catch (Exception $e) {
            log_message('error', 'Leaderboards: Failed to get achievement rankings - ' . $e->getMessage());
            return [];
        }
    }

    public function count_achievement_players($realm_id = null)
    {
        if (!$realm_id) {
            $realm_id = $this->get_first_realm_id();
        }

        if (!$realm_id) {
            return 0;
        }

        try {
            $char_db = $this->connect_to_realm($realm_id);
            if (!$char_db) {
                return 0;
            }
            return $char_db->count_all('characters');
        } catch (Exception $e) {
            log_message('error', 'Leaderboards: Failed to count achievement players - ' . $e->getMessage());
            return 0;
        }
    }

    public function get_profession_rankings($profession = 'all', $limit = 50, $offset = 0, $realm_id = null)
    {
        if (!$realm_id) {
            $realm_id = $this->get_first_realm_id();
        }

        if (!$realm_id) {
            return [];
        }

        try {
            $char_db = $this->connect_to_realm($realm_id);
            if (!$char_db) {
                return [];
            }
            
            $query = $char_db->select('c.guid, c.name, c.race, c.class, c.level, cs.skill, cs.value, cs.max')
                ->from('characters c')
                ->join('character_skills cs', 'c.guid = cs.guid', 'inner')
                ->where('cs.value >', 0);
            
            if ($profession !== 'all') {
                $query->where('cs.skill', $profession);
            }
            
            return $query->order_by('cs.value', 'DESC')
                ->limit($limit, $offset)
                ->get()
                ->result();
        } catch (Exception $e) {
            log_message('error', 'Leaderboards: Failed to get profession rankings - ' . $e->getMessage());
            return [];
        }
    }

    public function count_profession_players($profession = 'all', $realm_id = null)
    {
        if (!$realm_id) {
            $realm_id = $this->get_first_realm_id();
        }

        if (!$realm_id) {
            return 0;
        }

        try {
            $char_db = $this->connect_to_realm($realm_id);
            if (!$char_db) {
                return 0;
            }
            
            $query = $char_db->where('value >', 0);
            
            if ($profession !== 'all') {
                $query->where('skill', $profession);
            }
            
            return $query->count_all_results('character_skills');
        } catch (Exception $e) {
            log_message('error', 'Leaderboards: Failed to count profession players - ' . $e->getMessage());
            return 0;
        }
    }

    public function get_profession_list()
    {
        return [
            'all' => 'All Professions',
            '171' => 'Alchemy',
            '164' => 'Blacksmithing',
            '333' => 'Enchanting',
            '202' => 'Engineering',
            '773' => 'Inscription',
            '755' => 'Jewelcrafting',
            '165' => 'Leatherworking',
            '197' => 'Tailoring',
            '182' => 'Herbalism',
            '186' => 'Mining',
            '393' => 'Skinning',
        ];
    }

    public function get_guild_rankings($limit = 50, $offset = 0, $realm_id = null)
    {
        if (!$realm_id) {
            $realm_id = $this->get_first_realm_id();
        }

        if (!$realm_id) {
            return [];
        }

        try {
            $char_db = $this->connect_to_realm($realm_id);
            if (!$char_db) {
                return [];
            }
            
            return $char_db->select('g.guildid, g.name, COUNT(gm.guid) as member_count, SUM(c.level) as total_levels')
                ->from('guild g')
                ->join('guild_member gm', 'g.guildid = gm.guildid', 'left')
                ->join('characters c', 'gm.guid = c.guid', 'left')
                ->group_by('g.guildid')
                ->order_by('total_levels', 'DESC')
                ->limit($limit, $offset)
                ->get()
                ->result();
        } catch (Exception $e) {
            log_message('error', 'Leaderboards: Failed to get guild rankings - ' . $e->getMessage());
            return [];
        }
    }

    public function count_guilds($realm_id = null)
    {
        if (!$realm_id) {
            $realm_id = $this->get_first_realm_id();
        }

        if (!$realm_id) {
            return 0;
        }

        try {
            $char_db = $this->connect_to_realm($realm_id);
            if (!$char_db) {
                return 0;
            }
            return $char_db->count_all('guild');
        } catch (Exception $e) {
            log_message('error', 'Leaderboards: Failed to count guilds - ' . $e->getMessage());
            return 0;
        }
    }

    public function get_first_max_levels()
    {
        return $this->db->select('character_guid, achievement_date, achievement_value')
            ->from('leaderboards_firsts')
            ->where('achievement_type', 'first_max_level')
            ->order_by('achievement_date', 'ASC')
            ->limit(10)
            ->get()
            ->result();
    }

    public function get_first_boss_kills()
    {
        return $this->db->select('character_guid, achievement_date, achievement_type, achievement_value')
            ->from('leaderboards_firsts')
            ->where('achievement_type LIKE', 'first_kill_%')
            ->order_by('achievement_date', 'ASC')
            ->limit(20)
            ->get()
            ->result();
    }

    public function get_first_achievements()
    {
        return $this->db->select('character_guid, achievement_date, achievement_type, achievement_value')
            ->from('leaderboards_firsts')
            ->where('achievement_type LIKE', 'first_achievement_%')
            ->order_by('achievement_date', 'ASC')
            ->limit(20)
            ->get()
            ->result();
    }

    public function record_first($character_guid, $type, $value = null)
    {
        $existing = $this->db->where('achievement_type', $type)->get('leaderboards_firsts')->row();
        
        if (!$existing) {
            $data = [
                'character_guid' => $character_guid,
                'achievement_date' => date('Y-m-d H:i:s'),
                'achievement_type' => $type,
                'achievement_value' => $value,
            ];
            
            return $this->db->insert('leaderboards_firsts', $data);
        }
        
        return false;
    }

    public function get_all_settings()
    {
        $query = $this->db->get('leaderboards_settings');
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
            ->update('leaderboards_settings', $data);
    }
}
