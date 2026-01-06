<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_vote_tables extends CI_Migration
{
    public function up()
    {
        // Register the module
        $this->db->insert('modules', [
            'module'  => 'vote',
            'version' => '1.0.0'
        ]);

        // Vote Sites table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'comment' => 'Vote URL with {username} placeholder'
            ],
            'callback_url' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => TRUE,
                'comment' => 'URL to check if user voted'
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => ''
            ],
            'vp_reward' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 1,
                'comment' => 'Vote points rewarded'
            ],
            'cooldown_hours' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 12,
                'comment' => 'Hours until user can vote again'
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => TRUE,
                'default' => 1
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('vote_sites', FALSE, ['ENGINE' => 'InnoDB']);

        // Vote Logs table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ],
            'site_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ],
            'vp_awarded' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => TRUE
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('user_id');
        $this->dbforge->add_key('site_id');
        $this->dbforge->add_key(['user_id', 'site_id', 'created_at']);
        $this->dbforge->create_table('vote_logs', FALSE, ['ENGINE' => 'InnoDB']);

        // Insert default vote sites
        $sites = [
            [
                'name' => 'Top 100 Arena',
                'description' => 'Vote for us on Top 100 Arena!',
                'url' => 'https://www.top100arena.com/in/{username}',
                'image' => '',
                'vp_reward' => 1,
                'cooldown_hours' => 12,
                'sort_order' => 1,
                'is_active' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'TopG',
                'description' => 'Vote for us on TopG!',
                'url' => 'https://topg.org/server-{username}',
                'image' => '',
                'vp_reward' => 1,
                'cooldown_hours' => 12,
                'sort_order' => 2,
                'is_active' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'GTop100',
                'description' => 'Vote for us on GTop100!',
                'url' => 'https://gtop100.com/vote/{username}',
                'image' => '',
                'vp_reward' => 1,
                'cooldown_hours' => 12,
                'sort_order' => 3,
                'is_active' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->insert_batch('vote_sites', $sites);

        // Add vote settings
        $settings = [
            ['key' => 'vote_enabled', 'value' => '1', 'type' => 'bool'],
            ['key' => 'vote_points_per_vote', 'value' => '1', 'type' => 'int'],
            ['key' => 'vote_cooldown_hours', 'value' => '12', 'type' => 'int']
        ];

        $this->db->insert_batch('settings', $settings);
    }

    public function down()
    {
        // Remove settings
        $this->db->where_in('key', [
            'vote_enabled',
            'vote_points_per_vote',
            'vote_cooldown_hours'
        ])->delete('settings');

        // Drop tables
        $this->dbforge->drop_table('vote_logs', TRUE);
        $this->dbforge->drop_table('vote_sites', TRUE);

        // Remove module registration
        $this->db->where('module', 'vote')->delete('modules');
    }
}
