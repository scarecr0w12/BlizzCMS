<?php
/**
 * BlizzCMS - Events Tables Migration
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_events_tables extends CI_Migration
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
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'event_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'start_date' => [
                'type' => 'DATETIME',
                'null' => FALSE,
            ],
            'end_date' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
            'location' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => TRUE,
            ],
            'max_participants' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => TRUE,
            ],
            'require_rsvp' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'featured' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'realm_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => TRUE,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('event_type');
        $this->dbforge->add_key('start_date');
        $this->dbforge->add_key('featured');
        $this->dbforge->create_table('events', TRUE);

        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'event_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'attending',
            ],
            'character_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => TRUE,
            ],
            'character_class' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => TRUE,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key(['event_id', 'user_id']);
        $this->dbforge->create_table('event_rsvps', TRUE);

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
        $this->dbforge->create_table('event_settings', TRUE);

        $this->db->insert_batch('event_settings', [
            ['setting_key' => 'enable_rsvp', 'setting_value' => '1'],
            ['setting_key' => 'enable_reminders', 'setting_value' => '1'],
            ['setting_key' => 'reminder_hours', 'setting_value' => '24'],
            ['setting_key' => 'default_event_length', 'setting_value' => '2'],
            ['setting_key' => 'events_per_page', 'setting_value' => '12'],
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_table('events', TRUE);
        $this->dbforge->drop_table('event_rsvps', TRUE);
        $this->dbforge->drop_table('event_settings', TRUE);
    }
}
