<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pvpstats_battleground_model extends CI_Model
{
    private $table = 'pvpstats_battlegrounds';
    private $players_table = 'pvpstats_players';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all battlegrounds with pagination
     */
    public function get_battlegrounds($limit = 20, $offset = 0, $filters = [])
    {
        $this->db->select('b.*, COUNT(p.id) as player_count')
                 ->from($this->table . ' b')
                 ->join($this->players_table . ' p', 'b.id = p.battleground_id', 'left')
                 ->group_by('b.id');

        if (!empty($filters['type'])) {
            $this->db->where('b.type', $filters['type']);
        }

        if (!empty($filters['bracket_id'])) {
            $this->db->where('b.bracket_id', $filters['bracket_id']);
        }

        if (!empty($filters['start_date'])) {
            $this->db->where('DATE(b.start_time) >=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $this->db->where('DATE(b.start_time) <=', $filters['end_date']);
        }

        $this->db->order_by('b.start_time', 'DESC')
                 ->limit($limit, $offset);

        return $this->db->get()->result();
    }

    /**
     * Count total battlegrounds
     */
    public function count_battlegrounds($filters = [])
    {
        // Check if table exists
        if (!$this->db->table_exists($this->table)) {
            return 0;
        }

        $this->db->from($this->table);

        if (!empty($filters['type'])) {
            $this->db->where('type', $filters['type']);
        }

        if (!empty($filters['bracket_id'])) {
            $this->db->where('bracket_id', $filters['bracket_id']);
        }

        if (!empty($filters['start_date'])) {
            $this->db->where('DATE(start_time) >=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $this->db->where('DATE(start_time) <=', $filters['end_date']);
        }

        return $this->db->count_all_results();
    }

    /**
     * Get battleground details by ID
     */
    public function get_battleground_detail($battleground_id)
    {
        // Check if table exists
        if (!$this->db->table_exists($this->table)) {
            return null;
        }

        $result = $this->db->where('id', $battleground_id)
                        ->get($this->table);
        return $result ? $result->row() : null;
    }

    /**
     * Get players in a specific battleground
     */
    public function get_battleground_players($battleground_id)
    {
        // Check if table exists
        if (!$this->db->table_exists($this->players_table)) {
            return [];
        }

        $result = $this->db->where('battleground_id', $battleground_id)
                        ->order_by('team', 'ASC')
                        ->order_by('killing_blows', 'DESC')
                        ->get($this->players_table);
        return $result ? $result->result() : [];
    }

    /**
     * Get battleground statistics
     */
    public function get_statistics($time_period = 'all')
    {
        // Check if table exists
        if (!$this->db->table_exists($this->table)) {
            return [];
        }

        $query = "
            SELECT 
                b.type,
                COUNT(b.id) as total_matches,
                SUM(CASE WHEN b.winner = 0 THEN 1 ELSE 0 END) as alliance_wins,
                SUM(CASE WHEN b.winner = 1 THEN 1 ELSE 0 END) as horde_wins,
                AVG(TIMESTAMPDIFF(MINUTE, b.start_time, b.end_time)) as avg_duration
            FROM " . $this->table . " b
        ";

        if ($time_period === 'today') {
            $query .= " WHERE DATE(b.start_time) = CURDATE()";
        } elseif ($time_period === 'week') {
            $query .= " WHERE b.start_time >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        } elseif ($time_period === 'month') {
            $query .= " WHERE YEAR(b.start_time) = YEAR(NOW()) AND MONTH(b.start_time) = MONTH(NOW())";
        }

        $query .= " GROUP BY b.type ORDER BY total_matches DESC";

        $result = $this->db->query($query);
        return $result ? $result->result() : [];
    }

    /**
     * Get top players by kills
     */
    public function get_top_players($limit = 20, $time_period = 'all')
    {
        // Check if table exists
        if (!$this->db->table_exists($this->players_table)) {
            return [];
        }

        $query = "
            SELECT 
                p.guid,
                p.name,
                p.race,
                p.class,
                p.level,
                p.faction,
                COUNT(DISTINCT p.battleground_id) as matches_played,
                SUM(p.killing_blows) as total_kills,
                SUM(p.deaths) as total_deaths,
                SUM(p.honorable_kills) as total_honorable_kills,
                SUM(p.damage_done) as total_damage,
                SUM(p.healing_done) as total_healing,
                ROUND(SUM(p.killing_blows) / COUNT(DISTINCT p.battleground_id), 2) as avg_kills
            FROM " . $this->players_table . " p
            JOIN " . $this->table . " b ON p.battleground_id = b.id
        ";

        if ($time_period === 'today') {
            $query .= " WHERE DATE(b.start_time) = CURDATE()";
        } elseif ($time_period === 'week') {
            $query .= " WHERE b.start_time >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        } elseif ($time_period === 'month') {
            $query .= " WHERE YEAR(b.start_time) = YEAR(NOW()) AND MONTH(b.start_time) = MONTH(NOW())";
        }

        $query .= " GROUP BY p.guid, p.name ORDER BY total_kills DESC LIMIT " . (int)$limit;

        $result = $this->db->query($query);
        return $result ? $result->result() : [];
    }

    /**
     * Get top guilds
     */
    public function get_top_guilds($limit = 5, $time_period = 'all')
    {
        // Check if table exists
        if (!$this->db->table_exists($this->players_table)) {
            return [];
        }

        $query = "
            SELECT 
                g.guildid,
                g.name,
                COUNT(DISTINCT p.battleground_id) as matches_played,
                COUNT(DISTINCT p.guid) as unique_players,
                SUM(p.killing_blows) as total_kills,
                SUM(p.deaths) as total_deaths,
                SUM(p.damage_done) as total_damage
            FROM " . $this->players_table . " p
            JOIN " . $this->table . " b ON p.battleground_id = b.id
            JOIN guild g ON p.guid IN (
                SELECT guid FROM characters WHERE guildid = g.guildid
            )
        ";

        if ($time_period === 'today') {
            $query .= " WHERE DATE(b.start_time) = CURDATE()";
        } elseif ($time_period === 'week') {
            $query .= " WHERE b.start_time >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        } elseif ($time_period === 'month') {
            $query .= " WHERE YEAR(b.start_time) = YEAR(NOW()) AND MONTH(b.start_time) = MONTH(NOW())";
        }

        $query .= " GROUP BY g.guildid, g.name ORDER BY total_kills DESC LIMIT " . (int)$limit;

        $result = $this->db->query($query);
        return $result ? $result->result() : [];
    }

    /**
     * Get faction statistics
     */
    public function get_faction_statistics($time_period = 'all')
    {
        // Check if table exists
        if (!$this->db->table_exists($this->table)) {
            return [];
        }

        $query = "
            SELECT 
                b.winner as faction,
                COUNT(b.id) as wins
            FROM " . $this->table . " b
        ";

        if ($time_period === 'today') {
            $query .= " WHERE DATE(b.start_time) = CURDATE()";
        } elseif ($time_period === 'week') {
            $query .= " WHERE b.start_time >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        } elseif ($time_period === 'month') {
            $query .= " WHERE YEAR(b.start_time) = YEAR(NOW()) AND MONTH(b.start_time) = MONTH(NOW())";
        }

        $query .= " GROUP BY b.winner";

        $result = $this->db->query($query);
        return $result ? $result->result() : [];
    }

    /**
     * Insert battleground record
     */
    public function insert_battleground($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Insert player record
     */
    public function insert_player($data)
    {
        return $this->db->insert($this->players_table, $data);
    }
}
