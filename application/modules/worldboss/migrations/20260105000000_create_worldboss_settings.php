<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_worldboss_settings extends CI_Migration
{
    public function up()
    {
        // Register the module
        $this->db->insert('modules', [
            'module'  => 'worldboss',
            'version' => '1.0.0'
        ]);

        // Add settings
        $this->db->insert_batch('settings', [
            [
                'key'   => 'worldboss_enabled',
                'value' => 'true',
                'type'  => 'bool'
            ],
            [
                'key'   => 'worldboss_items_per_page',
                'value' => '100',
                'type'  => 'int'
            ],
            [
                'key'   => 'worldboss_eluna_database',
                'value' => 'ac_eluna',
                'type'  => 'string'
            ]
        ]);
    }

    public function down()
    {
        // Remove the module
        $this->db->where('module', 'worldboss')->delete('modules');

        // Remove settings
        $this->db->where_in('key', [
            'worldboss_enabled',
            'worldboss_items_per_page',
            'worldboss_eluna_database'
        ])->delete('settings');
    }
}
