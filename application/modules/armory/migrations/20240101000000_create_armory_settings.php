<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_armory_settings extends CI_Migration
{
    public function up()
    {
        $this->db->insert_batch('settings', [
            [
                'key'   => 'armory_enabled',
                'value' => 'true',
                'type'  => 'bool'
            ],
            [
                'key'   => 'armory_cache_time',
                'value' => '300',
                'type'  => 'int'
            ],
            [
                'key'   => 'armory_show_offline',
                'value' => 'true',
                'type'  => 'bool'
            ],
            [
                'key'   => 'armory_show_guild',
                'value' => 'true',
                'type'  => 'bool'
            ],
            [
                'key'   => 'armory_show_arena',
                'value' => 'true',
                'type'  => 'bool'
            ],
            [
                'key'   => 'armory_show_achievements',
                'value' => 'true',
                'type'  => 'bool'
            ],
            [
                'key'   => 'armory_show_talents',
                'value' => 'true',
                'type'  => 'bool'
            ],
            [
                'key'   => 'armory_show_pvp',
                'value' => 'true',
                'type'  => 'bool'
            ],
            [
                'key'   => 'armory_items_per_page',
                'value' => '25',
                'type'  => 'int'
            ],
            [
                'key'   => 'armory_search_min_chars',
                'value' => '2',
                'type'  => 'int'
            ],
            [
                'key'   => 'armory_wowhead_tooltips',
                'value' => 'true',
                'type'  => 'bool'
            ],
            [
                'key'   => 'armory_3d_models',
                'value' => 'false',
                'type'  => 'bool'
            ],
            [
                'key'   => 'armory_arena_min_games',
                'value' => '10',
                'type'  => 'int'
            ],
            [
                'key'   => 'armory_hide_gms',
                'value' => 'true',
                'type'  => 'bool'
            ],
            [
                'key'   => 'armory_enable_search',
                'value' => 'true',
                'type'  => 'bool'
            ],
            [
                'key'   => 'armory_enable_ladder',
                'value' => 'true',
                'type'  => 'bool'
            ],
            [
                'key'   => 'armory_enable_guilds',
                'value' => 'true',
                'type'  => 'bool'
            ]
        ]);
    }

    public function down()
    {
        $this->db->where_in('key', [
            'armory_enabled',
            'armory_cache_time',
            'armory_show_offline',
            'armory_show_guild',
            'armory_show_arena',
            'armory_show_achievements',
            'armory_show_talents',
            'armory_show_pvp',
            'armory_items_per_page',
            'armory_search_min_chars',
            'armory_wowhead_tooltips',
            'armory_3d_models',
            'armory_arena_min_games',
            'armory_hide_gms',
            'armory_enable_search',
            'armory_enable_ladder',
            'armory_enable_guilds'
        ])->delete('settings');
    }
}
