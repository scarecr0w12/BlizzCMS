<?php
/**
 * BlizzCMS - Discord Tables Migration
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_discord_tables extends CI_Migration
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
        $this->dbforge->create_table('discord_settings', TRUE);

        $this->db->insert_batch('discord_settings', [
            ['setting_key' => 'enable_oauth', 'setting_value' => '0'],
            ['setting_key' => 'client_id', 'setting_value' => ''],
            ['setting_key' => 'client_secret', 'setting_value' => ''],
            ['setting_key' => 'redirect_uri', 'setting_value' => ''],
            ['setting_key' => 'guild_id', 'setting_value' => ''],
            ['setting_key' => 'widget_enabled', 'setting_value' => '1'],
            ['setting_key' => 'webhook_url', 'setting_value' => ''],
            ['setting_key' => 'webhook_enabled', 'setting_value' => '0'],
            ['setting_key' => 'bot_token', 'setting_value' => ''],
        ]);

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
            'discord_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'discord_username' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'discord_discriminator' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
            'discord_avatar' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'access_token' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'refresh_token' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'expires_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ],
            'linked_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('user_id');
        $this->dbforge->add_key('discord_id');
        $this->dbforge->create_table('discord_users', TRUE);

        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'webhook_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'webhook_url' => [
                'type' => 'TEXT',
                'null' => FALSE,
            ],
            'event_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'enabled' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('discord_webhooks', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('discord_settings', TRUE);
        $this->dbforge->drop_table('discord_users', TRUE);
        $this->dbforge->drop_table('discord_webhooks', TRUE);
    }
}
