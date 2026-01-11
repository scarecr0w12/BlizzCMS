<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_webhook_tables extends CI_Migration
{
    public function up()
    {
        // Webhooks table
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
            'event_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'webhook_url' => [
                'type' => 'TEXT',
                'null' => FALSE,
            ],
            'secret' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('user_id');
        $this->dbforge->add_key('event_type');
        $this->dbforge->create_table('webhooks', TRUE);

        // Webhook logs table
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'webhook_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'http_code' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'success' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
            ],
            'delivered_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('webhook_id');
        $this->dbforge->create_table('webhook_logs', TRUE);

        // API keys table
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
            'api_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'api_secret' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'last_used' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('user_id');
        $this->dbforge->add_key('api_key');
        $this->dbforge->create_table('api_keys', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('webhooks', TRUE);
        $this->dbforge->drop_table('webhook_logs', TRUE);
        $this->dbforge->drop_table('api_keys', TRUE);
    }
}
