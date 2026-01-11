<?php
/**
 * BlizzCMS - Playermap Model
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Playermap_model extends CI_Model
{
    private $horde_races = 0x2B2;
    private $alliance_races = 0x44D;
    private $outland_inst = [540,542,543,544,545,546,547,548,550,552,553,554,555,556,557,558,559,562,564,565];
    private $northrend_inst = [533,574,575,576,578,599,600,601,602,603,604,608,615,616,617,619,624,631,632,649,650,658,668,724];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('server_characters_model');
        $this->load->model('server_auth_model');
    }

    /**
     * Get online players for a realm
     *
     * @param int $realm_id
     * @return array
     */
    public function get_online_players($realm_id)
    {
        $char_db = $this->server_characters_model->connect($realm_id);
        $auth_db = $this->server_auth_model->connect();

        $maps_count = 3;
        $count = array_fill(0, $maps_count, [0, 0]);

        $gm_accounts = $this->get_gm_accounts($auth_db);
        $groups = $this->get_groups($char_db);

        $query = $char_db->select('account, name, class, race, level, gender, position_x, position_y, map, zone, extra_flags')
            ->from('characters')
            ->where('online', 1)
            ->order_by('name', 'ASC')
            ->get();

        $players = [];
        $i = $maps_count;

        foreach ($query->result() as $row) {
            $extension = $this->get_map_extension($row->map, $row->position_y);

            $is_gm = in_array($row->account, $gm_accounts);
            $show_player = $this->should_show_gm($is_gm, $row->extra_flags);

            if (!$is_gm || ($is_gm && config_item('playermap_gm_include_count'))) {
                if ($this->horde_races & (0x1 << ($row->race - 1))) {
                    $count[$extension][1]++;
                } elseif ($this->alliance_races & (0x1 << ($row->race - 1))) {
                    $count[$extension][0]++;
                }
            }

            if ($is_gm && !$show_player) {
                continue;
            }

            $name = $row->name;
            if ($is_gm && config_item('playermap_gm_add_suffix') && $show_player) {
                $name .= ' <small style="color: #EABA28;">{GM}</small>';
            }

            $players[$i] = [
                'x' => $row->position_x,
                'y' => $row->position_y,
                'dead' => 0,
                'name' => $name,
                'map' => $row->map,
                'zone' => $this->get_zone_name($row->zone),
                'cl' => $row->class,
                'race' => $row->race,
                'level' => $row->level,
                'gender' => $row->gender,
                'Extention' => $extension,
                'leaderGuid' => isset($groups[$row->account]) ? $groups[$row->account] : 0
            ];
            $i++;
        }

        usort($players, function($a, $b) {
            if ($a['leaderGuid'] == $b['leaderGuid']) {
                return strcmp($a['name'], $b['name']);
            }
            return ($a['leaderGuid'] < $b['leaderGuid']) ? -1 : 1;
        });

        return array_merge($count, $players);
    }

    /**
     * Get server status information
     *
     * @param int $realm_id
     * @return array|null
     */
    public function get_server_status($realm_id)
    {
        if (!config_item('playermap_show_status')) {
            return null;
        }

        $realm = $this->realm_model->find(['id' => $realm_id]);
        if (empty($realm)) {
            return null;
        }

        $auth_db = $this->server_auth_model->connect();

        $query = $auth_db->select('UNIX_TIMESTAMP() as current_time, starttime, maxplayers')
            ->from('uptime')
            ->where('starttime', '(SELECT MAX(starttime) FROM uptime)', false)
            ->get();

        if (!$query || $query->num_rows() == 0) {
            return null;
        }

        $result = $query->row();

        $is_online = $this->test_realm($realm);

        return [
            'online' => $is_online ? 1 : 0,
            'uptime' => $result->current_time - $result->starttime,
            'maxplayers' => $result->maxplayers,
            'gmonline' => 0
        ];
    }

    /**
     * Get GM account IDs
     *
     * @param object $auth_db
     * @return array
     */
    private function get_gm_accounts($auth_db)
    {
        $gm_accounts = [];

        try {
            if (config_item('playermap_server_type') == 1) {
                $query = $auth_db->select('GROUP_CONCAT(id SEPARATOR " ") as ids')
                    ->from('account_access')
                    ->where('gmlevel >', 0)
                    ->get();
            } else {
                $query = $auth_db->select('GROUP_CONCAT(id SEPARATOR " ") as ids')
                    ->from('account')
                    ->where('gmlevel >', 0)
                    ->get();
            }

            if ($query && $query->num_rows() > 0) {
                $result = $query->row();
                if (!empty($result->ids)) {
                    $gm_accounts = explode(' ', $result->ids);
                }
            }
        } catch (Exception $e) {
            log_message('error', 'Playermap get_gm_accounts error: ' . $e->getMessage());
        }

        return $gm_accounts;
    }

    /**
     * Get group information
     *
     * @param object $char_db
     * @return array
     */
    private function get_groups($char_db)
    {
        $groups = [];

        try {
            $query = $char_db->select('gm.memberGuid, g.leaderGuid')
                ->from('group_member gm')
                ->join('groups g', 'g.guid = gm.guid')
                ->where('gm.memberGuid IN (SELECT guid FROM characters WHERE online = 1)', null, false)
                ->get();

            if ($query && $query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $groups[$row->memberGuid] = $row->leaderGuid;
                }
            }
        } catch (Exception $e) {
            log_message('error', 'Playermap get_groups error: ' . $e->getMessage());
        }

        return $groups;
    }

    /**
     * Determine map extension (Azeroth, Outland, Northrend)
     *
     * @param int $map
     * @param float $position_y
     * @return int
     */
    private function get_map_extension($map, $position_y)
    {
        if (($map == 530 && $position_y > -1000) || in_array($map, $this->outland_inst)) {
            return 1;
        } elseif ($map == 571 || in_array($map, $this->northrend_inst)) {
            return 2;
        }
        return 0;
    }

    /**
     * Check if GM should be shown on map
     *
     * @param bool $is_gm
     * @param int $extra_flags
     * @return bool
     */
    private function should_show_gm($is_gm, $extra_flags)
    {
        if (!$is_gm) {
            return true;
        }

        if (!config_item('playermap_gm_show_online')) {
            return false;
        }

        if (($extra_flags & 0x1) != 0 && config_item('playermap_gm_only_gmoff')) {
            return false;
        }

        if (($extra_flags & 0x10) != 0 && config_item('playermap_gm_only_gmvisible')) {
            return false;
        }

        return true;
    }

    /**
     * Get zone name from zone ID
     *
     * @param int $zone_id
     * @return string
     */
    private function get_zone_name($zone_id)
    {
        $this->load->helper('playermap_zones');
        return get_zone_name_by_id($zone_id);
    }

    /**
     * Test if realm is online
     *
     * @param object $realm
     * @return bool
     */
    private function test_realm($realm)
    {
        $host = $realm->realm_address ?: $realm->realm_hostname;
        $port = $realm->realm_port;

        $socket = @fsockopen($host, $port, $errno, $errstr, 0.5);

        if ($socket) {
            fclose($socket);
            return true;
        }

        return false;
    }
}
