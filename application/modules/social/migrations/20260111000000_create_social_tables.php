<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_social_tables extends CI_Migration
{
    public function up()
    {
        // Friends table
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
            'friend_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'pending',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key(['user_id', 'friend_id']);
        $this->dbforge->create_table('user_friends', TRUE);

        // Messages table
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'from_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'to_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'subject' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'message' => [
                'type' => 'TEXT',
                'null' => FALSE,
            ],
            'is_read' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('to_id');
        $this->dbforge->add_key('is_read');
        $this->dbforge->create_table('user_messages', TRUE);

        // Social settings table
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
        $this->dbforge->create_table('social_settings', TRUE);

        $this->db->insert_batch('social_settings', [
            ['setting_key' => 'enable_friends', 'setting_value' => '1'],
            ['setting_key' => 'enable_messaging', 'setting_value' => '1'],
            ['setting_key' => 'enable_guild_features', 'setting_value' => '1'],
            ['setting_key' => 'max_friends', 'setting_value' => '100'],
            ['setting_key' => 'message_retention_days', 'setting_value' => '90'],
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_table('user_friends', TRUE);
        $this->dbforge->drop_table('user_messages', TRUE);
        $this->dbforge->drop_table('social_settings', TRUE);
    }
}
