<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_database_viewer_settings extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE,
            ],
            'setting_key' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => TRUE,
            ],
            'setting_value' => [
                'type' => 'LONGTEXT',
                'null' => TRUE,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('database_viewer_settings', TRUE);

        $settings = [
            ['setting_key' => 'database_viewer_enabled', 'setting_value' => '1'],
            ['setting_key' => 'database_viewer_items_per_page', 'setting_value' => '50'],
            ['setting_key' => 'database_viewer_show_quality_colors', 'setting_value' => '1'],
            ['setting_key' => 'database_viewer_enable_tooltips', 'setting_value' => '1'],
        ];

        $this->db->insert_batch('database_viewer_settings', $settings);
    }

    public function down()
    {
        $this->dbforge->drop_table('database_viewer_settings', TRUE);
    }
}
