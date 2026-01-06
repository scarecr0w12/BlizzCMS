<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Armory_character_model extends CI_Model
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
     * Search characters by name
     *
     * @param int $realm
     * @param string $query
     * @param int $limit
     * @return array
     */
    public function search_characters($realm, $query, $limit = 50)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return [];
        }

        return $db->select('guid, name, race, class, gender, level, online')
            ->from('characters')
            ->like('name', $query, 'both')
            ->limit($limit)
            ->order_by('level', 'DESC')
            ->order_by('name', 'ASC')
            ->get()
            ->result();
    }

    /**
     * Get character by GUID
     *
     * @param int $realm
     * @param int $guid
     * @return object|null
     */
    public function get_character($realm, $guid)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return null;
        }

        return $db->select('guid, account, name, race, class, gender, level, skin, face, hairStyle, hairColor, facialStyle, playerFlags, online, zone, map, totaltime, totalKills, todayKills, yesterdayKills, chosenTitle, health, power1, power2, power3, power4, power5, power6, power7')
            ->from('characters')
            ->where('guid', $guid)
            ->get()
            ->row();
    }

    /**
     * Get character by name
     *
     * @param int $realm
     * @param string $name
     * @return object|null
     */
    public function get_character_by_name($realm, $name)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return null;
        }

        return $db->select('guid, account, name, race, class, gender, level, skin, face, hairStyle, hairColor, facialStyle, playerFlags, online, zone, map, totaltime, totalKills, todayKills, yesterdayKills, chosenTitle, health, power1, power2, power3, power4, power5, power6, power7')
            ->from('characters')
            ->where('LOWER(name)', strtolower($name))
            ->get()
            ->row();
    }

    /**
     * Get character equipment
     *
     * @param int $realm
     * @param int $guid
     * @return array
     */
    public function get_equipment($realm, $guid)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return [];
        }

        // Equipment slots for character paperdoll (0-18)
        // 0: Head, 1: Neck, 2: Shoulder, 3: Body (Shirt), 4: Chest
        // 5: Waist, 6: Legs, 7: Feet, 8: Wrists, 9: Hands
        // 10: Finger1, 11: Finger2, 12: Trinket1, 13: Trinket2, 14: Back
        // 15: MainHand, 16: OffHand, 17: Ranged, 18: Tabard

        $items = $db->select('ci.slot, ci.item, ii.itemEntry, ii.enchantments, ii.randomPropertyId')
            ->from('character_inventory ci')
            ->join('item_instance ii', 'ii.guid = ci.item', 'left')
            ->where('ci.guid', $guid)
            ->where('ci.bag', 0)
            ->where('ci.slot <', 19)
            ->order_by('ci.slot', 'ASC')
            ->get()
            ->result();

        $equipment = [];
        foreach ($items as $item) {
            $equipment[$item->slot] = [
                'slot'             => $item->slot,
                'item_guid'        => $item->item,
                'item_entry'       => $item->itemEntry,
                'enchantments'     => $item->enchantments,
                'random_property'  => $item->randomPropertyId
            ];
        }

        return $equipment;
    }

    /**
     * Get character stats (placeholder - actual implementation depends on emulator)
     *
     * @param int $realm
     * @param int $guid
     * @return object|null
     */
    public function get_stats($realm, $guid)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return null;
        }

        // Try to get stats from character_stats table if it exists
        if ($db->table_exists('character_stats')) {
            return $db->select('*')
                ->from('character_stats')
                ->where('guid', $guid)
                ->get()
                ->row();
        }

        return null;
    }

    /**
     * Get character talents
     *
     * @param int $realm
     * @param int $guid
     * @return array
     */
    public function get_talents($realm, $guid)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return [];
        }

        // Check which talent table exists (varies by emulator)
        if ($db->table_exists('character_talent')) {
            return $db->select('spell, specMask')
                ->from('character_talent')
                ->where('guid', $guid)
                ->get()
                ->result();
        }

        return [];
    }

    /**
     * Get character glyphs
     *
     * @param int $realm
     * @param int $guid
     * @return array
     */
    public function get_glyphs($realm, $guid)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return [];
        }

        if ($db->table_exists('character_glyphs')) {
            return $db->select('*')
                ->from('character_glyphs')
                ->where('guid', $guid)
                ->get()
                ->result();
        }

        return [];
    }

    /**
     * Get character achievements
     *
     * @param int $realm
     * @param int $guid
     * @return array
     */
    public function get_achievements($realm, $guid)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return [];
        }

        if ($db->table_exists('character_achievement')) {
            return $db->select('achievement, date')
                ->from('character_achievement')
                ->where('guid', $guid)
                ->order_by('date', 'DESC')
                ->get()
                ->result();
        }

        return [];
    }

    /**
     * Get character arena teams
     *
     * @param int $realm
     * @param int $guid
     * @return array
     */
    public function get_arena_teams($realm, $guid)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return [];
        }

        if ($db->table_exists('arena_team') && $db->table_exists('arena_team_member')) {
            return $db->select('at.arenaTeamId, at.name, at.type, at.rating, at.seasonWins, at.seasonGames, at.weekWins, at.weekGames, atm.personalRating, atm.seasonWins as memberSeasonWins, atm.seasonGames as memberSeasonGames')
                ->from('arena_team_member atm')
                ->join('arena_team at', 'at.arenaTeamId = atm.arenaTeamId', 'left')
                ->where('atm.guid', $guid)
                ->get()
                ->result();
        }

        return [];
    }

    /**
     * Get character PvP stats
     *
     * @param int $realm
     * @param int $guid
     * @return object|null
     */
    public function get_pvp_stats($realm, $guid)
    {
        $character = $this->get_character($realm, $guid);

        if (empty($character)) {
            return null;
        }

        return (object) [
            'total_kills'     => $character->totalKills ?? 0,
            'today_kills'     => $character->todayKills ?? 0,
            'yesterday_kills' => $character->yesterdayKills ?? 0
        ];
    }

    /**
     * Get total characters count in realm
     *
     * @param int $realm
     * @return int
     */
    public function count_characters($realm)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return 0;
        }

        return $db->count_all('characters');
    }

    /**
     * Get top characters by level
     *
     * @param int $realm
     * @param int $limit
     * @return array
     */
    public function get_top_characters($realm, $limit = 10)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return [];
        }

        return $db->select('guid, name, race, class, gender, level, totalKills')
            ->from('characters')
            ->order_by('level', 'DESC')
            ->order_by('totalKills', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }
}
