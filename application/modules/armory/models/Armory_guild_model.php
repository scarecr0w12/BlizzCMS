<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Armory_guild_model extends CI_Model
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
     * Get guild by ID
     *
     * @param int $realm
     * @param int $guild_id
     * @return object|null
     */
    public function get_guild($realm, $guild_id)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return null;
        }

        return $db->select('guildid, name, leaderguid, EmblemStyle, EmblemColor, BorderStyle, BorderColor, BackgroundColor, info, motd, createdate, BankMoney')
            ->from('guild')
            ->where('guildid', $guild_id)
            ->get()
            ->row();
    }

    /**
     * Get guild by name
     *
     * @param int $realm
     * @param string $name
     * @return object|null
     */
    public function get_guild_by_name($realm, $name)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return null;
        }

        return $db->select('guildid, name, leaderguid, EmblemStyle, EmblemColor, BorderStyle, BorderColor, BackgroundColor, info, motd, createdate, BankMoney')
            ->from('guild')
            ->where('LOWER(name)', strtolower($name))
            ->get()
            ->row();
    }

    /**
     * Get character's guild
     *
     * @param int $realm
     * @param int $guid
     * @return object|null
     */
    public function get_character_guild($realm, $guid)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return null;
        }

        $member = $db->select('guildid, `rank`')
            ->from('guild_member')
            ->where('guid', $guid)
            ->get()
            ->row();

        if (empty($member)) {
            return null;
        }

        $guild = $this->get_guild($realm, $member->guildid);

        if (! empty($guild)) {
            $guild->member_rank = $member->rank;
            
            // Get rank name
            $rank = $db->select('rname')
                ->from('guild_rank')
                ->where('guildid', $member->guildid)
                ->where('rid', $member->rank)
                ->get()
                ->row();
            
            $guild->rank_name = $rank->rname ?? '';
        }

        return $guild;
    }

    /**
     * Get guild members
     *
     * @param int $realm
     * @param int $guild_id
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get_members($realm, $guild_id, $limit = 50, $offset = 0)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return [];
        }

        $members = $db->select('gm.guid, gm.`rank`, c.name, c.race, c.class, c.gender, c.level, c.online, c.zone')
            ->from('guild_member gm')
            ->join('characters c', 'c.guid = gm.guid', 'left')
            ->where('gm.guildid', $guild_id)
            ->order_by('gm.`rank`', 'ASC')
            ->order_by('c.level', 'DESC')
            ->order_by('c.name', 'ASC')
            ->limit($limit, $offset)
            ->get()
            ->result();

        // Get rank names
        $ranks = $db->select('rid, rname')
            ->from('guild_rank')
            ->where('guildid', $guild_id)
            ->get()
            ->result();

        $rank_names = [];
        foreach ($ranks as $rank) {
            $rank_names[$rank->rid] = $rank->rname;
        }

        foreach ($members as &$member) {
            $member->rank_name = $rank_names[$member->rank] ?? '';
        }

        return $members;
    }

    /**
     * Count guild members
     *
     * @param int $realm
     * @param int $guild_id
     * @return int
     */
    public function count_members($realm, $guild_id)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return 0;
        }

        return $db->from('guild_member')
            ->where('guildid', $guild_id)
            ->count_all_results();
    }

    /**
     * Search guilds by name
     *
     * @param int $realm
     * @param string $query
     * @param int $limit
     * @return array
     */
    public function search_guilds($realm, $query, $limit = 20)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return [];
        }

        return $db->select('guildid, name')
            ->from('guild')
            ->like('name', $query, 'both')
            ->limit($limit)
            ->order_by('name', 'ASC')
            ->get()
            ->result();
    }

    /**
     * Get all guilds
     *
     * @param int $realm
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get_all_guilds($realm, $limit = 50, $offset = 0)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return [];
        }

        $guilds = $db->select('guildid, name, leaderguid, EmblemStyle, EmblemColor, BorderStyle, BorderColor, BackgroundColor, createdate')
            ->from('guild')
            ->order_by('name', 'ASC')
            ->limit($limit, $offset)
            ->get()
            ->result();

        // Get member counts
        foreach ($guilds as &$guild) {
            $guild->member_count = $this->count_members($realm, $guild->guildid);
        }

        return $guilds;
    }

    /**
     * Get guild leader info
     *
     * @param int $realm
     * @param int $leader_guid
     * @return object|null
     */
    public function get_leader($realm, $leader_guid)
    {
        $db = $this->connect($realm);

        if ($db === false) {
            return null;
        }

        return $db->select('guid, name, race, class, gender, level')
            ->from('characters')
            ->where('guid', $leader_guid)
            ->get()
            ->row();
    }
}
