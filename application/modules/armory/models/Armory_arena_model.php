<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Armory_arena_model extends CI_Model
{
    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Connect to characters DB
     *
     * @param int $realm
     * @return object|false
     */
    protected function connect($realm)
    {
        $row = $this->realm_model->find(['id' => $realm]);

        if (empty($row)) {
            return false;
        }

        $database = $this->load->database([
            'hostname' => $row->char_hostname,
            'username' => $row->char_username,
            'password' => decrypt($row->char_password),
            'database' => $row->char_database,
            'port'     => $row->char_port,
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

    /**
     * Get arena team by ID
     *
     * @param int $realm
     * @param int $team_id
     * @return object|null
     */
    public function get_team($realm, $team_id)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return null;
        }

        if (! $db->table_exists('arena_team')) {
            return null;
        }

        return $db->select('arenaTeamId, name, captainGuid, type, rating, seasonGames, seasonWins, weekGames, weekWins, `rank`, backgroundColor, emblemStyle, emblemColor, borderStyle, borderColor')
            ->from('arena_team')
            ->where('arenaTeamId', $team_id)
            ->get()
            ->row();
    }

    /**
     * Get top arena teams
     *
     * @param int $realm
     * @param int $type (2=2v2, 3=3v3, 5=5v5)
     * @param int $limit
     * @return array
     */
    public function get_top_teams($realm, $type = 2, $limit = 100)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return [];
        }

        if (! $db->table_exists('arena_team')) {
            return [];
        }

        return $db->select('arenaTeamId, name, captainGuid, type, rating, seasonGames, seasonWins, weekGames, weekWins, `rank`, backgroundColor, emblemStyle, emblemColor, borderStyle, borderColor')
            ->from('arena_team')
            ->where('type', $type)
            ->where('rating >', 0)
            ->order_by('rating', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    /**
     * Get arena team members
     *
     * @param int $realm
     * @param int $team_id
     * @return array
     */
    public function get_team_members($realm, $team_id)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return [];
        }

        if (! $db->table_exists('arena_team_member')) {
            return [];
        }

        return $db->select('atm.guid, atm.weekGames, atm.weekWins, atm.seasonGames, atm.seasonWins, atm.personalRating, c.name, c.race, c.class, c.gender, c.level')
            ->from('arena_team_member atm')
            ->join('characters c', 'c.guid = atm.guid', 'left')
            ->where('atm.arenaTeamId', $team_id)
            ->order_by('atm.personalRating', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Get team captain info
     *
     * @param int $realm
     * @param int $captain_guid
     * @return object|null
     */
    public function get_captain($realm, $captain_guid)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return null;
        }

        return $db->select('guid, name, race, class, gender, level')
            ->from('characters')
            ->where('guid', $captain_guid)
            ->get()
            ->row();
    }

    /**
     * Get arena team type name
     *
     * @param int $type
     * @return string
     */
    public function get_type_name($type)
    {
        $types = [
            2 => '2v2',
            3 => '3v3',
            5 => '5v5'
        ];

        return $types[$type] ?? 'Unknown';
    }

    /**
     * Calculate win rate
     *
     * @param int $wins
     * @param int $games
     * @return float
     */
    public function calculate_win_rate($wins, $games)
    {
        if ($games <= 0) {
            return 0;
        }

        return round(($wins / $games) * 100, 1);
    }
}
