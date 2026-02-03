<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pvpstats_player_model extends CI_Model
{
    private $table = 'pvpstats_players';
    private $battlegrounds_table = 'pvpstats_battlegrounds';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get player statistics by name
     */
    public function get_player_stats($player_name)
    {
        // Check if table exists
        if (!$this->db->table_exists($this->table)) {
            return null;
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
                SUM(p.bonus_honor) as total_bonus_honor,
                SUM(p.damage_done) as total_damage,
                SUM(p.healing_done) as total_healing,
                SUM(p.flag_captures) as total_flag_captures,
                SUM(p.flag_returns) as total_flag_returns,
                SUM(p.bases_assaulted) as total_bases_assaulted,
                SUM(p.bases_defended) as total_bases_defended,
                ROUND(SUM(p.killing_blows) / COUNT(DISTINCT p.battleground_id), 2) as avg_kills,
                ROUND(SUM(p.deaths) / COUNT(DISTINCT p.battleground_id), 2) as avg_deaths,
                ROUND(SUM(p.damage_done) / COUNT(DISTINCT p.battleground_id), 0) as avg_damage,
                ROUND(SUM(p.healing_done) / COUNT(DISTINCT p.battleground_id), 0) as avg_healing
            FROM " . $this->table . " p
            WHERE p.name = ?
            GROUP BY p.guid, p.name
        ";

        $result = $this->db->query($query, [$player_name]);
        return $result ? $result->row() : null;
    }

    /**
     * Get player battleground history
     */
    public function get_player_history($player_name, $limit = 50, $offset = 0)
    {
        // Check if table exists
        if (!$this->db->table_exists($this->table)) {
            return [];
        }

        $query = "
            SELECT 
                b.id,
                b.type,
                b.bracket_id,
                b.winner,
                b.start_time,
                b.end_time,
                p.killing_blows,
                p.deaths,
                p.honorable_kills,
                p.damage_done,
                p.healing_done,
                p.team,
                p.level,
                p.class
            FROM " . $this->table . " p
            JOIN " . $this->battlegrounds_table . " b ON p.battleground_id = b.id
            WHERE p.name = ?
            ORDER BY b.start_time DESC
            LIMIT ? OFFSET ?
        ";

        $result = $this->db->query($query, [$player_name, $limit, $offset]);
        return $result ? $result->result() : [];
    }

    /**
     * Count player battleground history
     */
    public function count_player_history($player_name)
    {
        // Check if table exists
        if (!$this->db->table_exists($this->table)) {
            return 0;
        }

        $query = "
            SELECT COUNT(DISTINCT p.battleground_id) as count
            FROM " . $this->table . " p
            WHERE p.name = ?
        ";

        $result = $this->db->query($query, [$player_name]);
        if (!$result) {
            return 0;
        }
        $row = $result->row();
        return $row ? ($row->count ?? 0) : 0;
    }

    /**
     * Get player statistics by battleground type
     */
    public function get_player_stats_by_type($player_name)
    {
        // Check if table exists
        if (!$this->db->table_exists($this->table)) {
            return [];
        }

        $query = "
            SELECT 
                b.type,
                COUNT(DISTINCT p.battleground_id) as matches,
                SUM(p.killing_blows) as kills,
                SUM(p.deaths) as deaths,
                SUM(p.damage_done) as damage,
                SUM(p.healing_done) as healing,
                ROUND(SUM(p.killing_blows) / COUNT(DISTINCT p.battleground_id), 2) as avg_kills
            FROM " . $this->table . " p
            JOIN " . $this->battlegrounds_table . " b ON p.battleground_id = b.id
            WHERE p.name = ?
            GROUP BY b.type
            ORDER BY matches DESC
        ";

        $result = $this->db->query($query, [$player_name]);
        return $result ? $result->result() : [];
    }

    /**
     * Get player win rate
     */
    public function get_player_win_rate($player_name)
    {
        // Check if table exists
        if (!$this->db->table_exists($this->table)) {
            return null;
        }

        $query = "
            SELECT 
                COUNT(DISTINCT CASE WHEN b.winner = p.team THEN p.battleground_id END) as wins,
                COUNT(DISTINCT p.battleground_id) as total_matches,
                ROUND(COUNT(DISTINCT CASE WHEN b.winner = p.team THEN p.battleground_id END) / COUNT(DISTINCT p.battleground_id) * 100, 2) as win_rate
            FROM " . $this->table . " p
            JOIN " . $this->battlegrounds_table . " b ON p.battleground_id = b.id
            WHERE p.name = ?
        ";

        $result = $this->db->query($query, [$player_name]);
        return $result ? $result->row() : null;
    }
}
