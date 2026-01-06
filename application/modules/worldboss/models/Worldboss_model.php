<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Worldboss_model extends CI_Model
{
    /**
     * Eluna database name
     *
     * @var string
     */
    protected $eluna_db = 'ac_eluna';

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
     * Connect to characters DB for a specific realm
     *
     * @param int $realm
     * @return object|false
     */
    protected function connect_chars($realm)
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
     * Get all world bosses configuration
     * Boss IDs follow the pattern: 1112001, 1112011, 1112021, etc.
     * - Boss entry ends with 1
     * - NPC entry ends with 2
     * - Add entry ends with 3
     *
     * @return array
     */
    public function get_bosses()
    {
        return [
            ['id' => 1112011, 'name' => 'Pondulum of Deem'],
            ['id' => 1112013, 'name' => 'Seawitch'],
            ['id' => 1112001, 'name' => 'Glorifrir Flintshoulder'],
            ['id' => 1112003, 'name' => 'Zombie Captain'],
            ['id' => 1112031, 'name' => 'Crocodile Bunbee'],
            ['id' => 1112033, 'name' => 'Crokolisk Minion'],
            ['id' => 1112021, 'name' => 'Crocolisk Dundee'],
            ['id' => 1112023, 'name' => 'Aligator Minion'],
            ['id' => 1112041, 'name' => 'Crocolisk Rundee'],
            ['id' => 1112043, 'name' => 'Aligator Guard'],
            ['id' => 1112051, 'name' => 'One-Three-Three-Seven'],
            ['id' => 1112053, 'name' => 'Ragnaros Qt'],
        ];
    }

    /**
     * Get boss name by ID
     *
     * @param int $boss_id
     * @return string|null
     */
    public function get_boss_name($boss_id)
    {
        $bosses = $this->get_bosses();
        
        foreach ($bosses as $boss) {
            if ($boss['id'] == $boss_id) {
                return $boss['name'];
            }
        }
        
        return null;
    }

    /**
     * Calculate boss ID from encounter number and group type
     * RaidEntry = 10*(encounterId - 1) + 1112000 + 1
     * PartyEntry = 10*(encounterId - 1) + 1112000 + 3
     *
     * @param int $encounter
     * @param int $group_type
     * @return int
     */
    protected function get_boss_entry($encounter, $group_type)
    {
        return 10 * ($encounter - 1) + 1112000 + ($group_type === 1 ? 3 : 1);
    }

    /**
     * Get encounters for a specific boss
     *
     * @param int $realm
     * @param int $boss_id
     * @param int $limit
     * @return array
     */
    public function get_encounters($realm, $boss_id, $limit = 100)
    {
        $db = $this->connect_chars($realm);

        if ($db === false) {
            return [];
        }

        // Query the eventscript_encounters table joined with characters
        // The boss_id filter is calculated from encounter and group_type
        $sql = "
            SELECT 
                e.time_stamp,
                e.playerGuid,
                e.encounter,
                e.difficulty,
                e.group_type,
                e.duration,
                c.name,
                c.race,
                c.class,
                c.gender,
                c.level
            FROM `{$this->eluna_db}`.`eventscript_encounters` e
            INNER JOIN `characters` c ON c.guid = e.playerGuid
            WHERE (10 * (e.encounter - 1) + 1112000 + IF(e.group_type = 1, 3, 1)) = ?
            ORDER BY e.difficulty DESC, e.duration ASC
            LIMIT ?
        ";

        $query = $db->query($sql, [$boss_id, $limit]);

        if ($query === false) {
            return [];
        }

        $results = $query->result();

        // Add calculated fields
        foreach ($results as &$row) {
            $row->boss_id = $this->get_boss_entry($row->encounter, $row->group_type);
            $row->group_type_name = $row->group_type === 1 ? 'Party' : 'Raid';
            $row->faction = $this->get_faction($row->race);
            $row->timestamp_formatted = date('d M Y H:i:s', $row->time_stamp);
            $row->duration_formatted = $this->format_duration($row->duration);
        }

        return $results;
    }

    /**
     * Get all encounters (for default view)
     *
     * @param int $realm
     * @param int $limit
     * @return array
     */
    public function get_all_encounters($realm, $limit = 100)
    {
        $db = $this->connect_chars($realm);

        if ($db === false) {
            return [];
        }

        $sql = "
            SELECT 
                e.time_stamp,
                e.playerGuid,
                e.encounter,
                e.difficulty,
                e.group_type,
                e.duration,
                c.name,
                c.race,
                c.class,
                c.gender,
                c.level
            FROM `{$this->eluna_db}`.`eventscript_encounters` e
            INNER JOIN `characters` c ON c.guid = e.playerGuid
            ORDER BY e.difficulty DESC, e.duration ASC
            LIMIT ?
        ";

        $query = $db->query($sql, [$limit]);

        if ($query === false) {
            return [];
        }

        $results = $query->result();

        // Add calculated fields
        foreach ($results as &$row) {
            $row->boss_id = $this->get_boss_entry($row->encounter, $row->group_type);
            $row->group_type_name = $row->group_type === 1 ? 'Party' : 'Raid';
            $row->faction = $this->get_faction($row->race);
            $row->timestamp_formatted = date('d M Y H:i:s', $row->time_stamp);
            $row->duration_formatted = $this->format_duration($row->duration);
        }

        return $results;
    }

    /**
     * Get faction based on race
     *
     * @param int $race
     * @return string
     */
    protected function get_faction($race)
    {
        // Horde races: 2 (Orc), 5 (Undead), 6 (Tauren), 8 (Troll), 9 (Goblin), 10 (Blood Elf)
        // Alliance races: 1 (Human), 3 (Dwarf), 4 (Night Elf), 7 (Gnome), 11 (Draenei)
        $horde_races = [2, 5, 6, 8, 9, 10];
        $alliance_races = [1, 3, 4, 7, 11];

        if (in_array($race, $horde_races)) {
            return 'horde';
        } elseif (in_array($race, $alliance_races)) {
            return 'alliance';
        }

        return 'neutral';
    }

    /**
     * Format duration from milliseconds to MM:SS
     *
     * @param int $millis
     * @return string
     */
    protected function format_duration($millis)
    {
        $minutes = floor($millis / 60000);
        $seconds = (int)(($millis % 60000) / 1000);

        if ($seconds == 60) {
            return ($minutes + 1) . ':00';
        }

        return sprintf('%d:%02d', $minutes, $seconds);
    }

    /**
     * Get statistics for the rankings
     *
     * @param int $realm
     * @param int|null $boss_id
     * @return object
     */
    public function get_stats($realm, $boss_id = null)
    {
        $db = $this->connect_chars($realm);

        if ($db === false) {
            return (object)[
                'total_encounters' => 0,
                'horde_count' => 0,
                'alliance_count' => 0
            ];
        }

        $where_clause = '';
        $params = [];

        if ($boss_id !== null) {
            $where_clause = 'WHERE (10 * (e.encounter - 1) + 1112000 + IF(e.group_type = 1, 3, 1)) = ?';
            $params[] = $boss_id;
        }

        $sql = "
            SELECT 
                COUNT(*) as total_encounters,
                SUM(CASE WHEN c.race IN (2, 5, 6, 8, 9, 10) THEN 1 ELSE 0 END) as horde_count,
                SUM(CASE WHEN c.race IN (1, 3, 4, 7, 11) THEN 1 ELSE 0 END) as alliance_count
            FROM `{$this->eluna_db}`.`eventscript_encounters` e
            INNER JOIN `characters` c ON c.guid = e.playerGuid
            {$where_clause}
        ";

        $query = $db->query($sql, $params);

        if ($query === false) {
            return (object)[
                'total_encounters' => 0,
                'horde_count' => 0,
                'alliance_count' => 0
            ];
        }

        return $query->row();
    }

    /**
     * Check if the eventscript_encounters table exists
     *
     * @param int $realm
     * @return bool
     */
    public function table_exists($realm)
    {
        $db = $this->connect_chars($realm);

        if ($db === false) {
            return false;
        }

        $query = $db->query("SHOW TABLES LIKE '{$this->eluna_db}.eventscript_encounters'");

        return $query !== false && $query->num_rows() > 0;
    }
}
