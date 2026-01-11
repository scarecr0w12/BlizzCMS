<?php
/**
 * BlizzCMS - Server Status Settings Migration
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_serverstatus_settings extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'setting_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'setting_value' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('setting_key');
        $this->dbforge->create_table('serverstatus_settings', TRUE);

        $this->db->insert_batch('serverstatus_settings', [
            ['setting_key' => 'enable_realtime_updates', 'setting_value' => '1'],
            ['setting_key' => 'update_interval', 'setting_value' => '30'],
            ['setting_key' => 'show_faction_balance', 'setting_value' => '1'],
            ['setting_key' => 'show_class_distribution', 'setting_value' => '1'],
            ['setting_key' => 'show_level_distribution', 'setting_value' => '1'],
            ['setting_key' => 'track_uptime', 'setting_value' => '1'],
        ]);

        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'realm_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'timestamp' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ],
            'online_players' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'alliance_count' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'horde_count' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'uptime_seconds' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'default'    => 0,
            ],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key(['realm_id', 'timestamp']);
        $this->dbforge->create_table('serverstatus_history', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('serverstatus_settings', TRUE);
        $this->dbforge->drop_table('serverstatus_history', TRUE);
    }
}
