<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_analytics_tables extends CI_Migration
{
    public function up()
    {
        // Analytics events table
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'event_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'event_data' => [
                'type' => 'JSON',
                'null' => TRUE,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('event_type');
        $this->dbforge->add_key('created_at');
        $this->dbforge->create_table('analytics_events', TRUE);

        // User sessions table
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'session_duration' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'pages_visited' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ],
            'ended_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('user_id');
        $this->dbforge->create_table('user_sessions', TRUE);

        // Analytics settings table
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
        $this->dbforge->create_table('analytics_settings', TRUE);

        $this->db->insert_batch('analytics_settings', [
            ['setting_key' => 'enable_analytics', 'setting_value' => '1'],
            ['setting_key' => 'track_sessions', 'setting_value' => '1'],
            ['setting_key' => 'retention_days', 'setting_value' => '90'],
            ['setting_key' => 'chart_refresh_interval', 'setting_value' => '300'],
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_table('analytics_events', TRUE);
        $this->dbforge->drop_table('user_sessions', TRUE);
        $this->dbforge->drop_table('analytics_settings', TRUE);
    }
}
