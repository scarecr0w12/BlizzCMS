<?php
/**
 * BlizzCMS - Leaderboards Settings Migration
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_leaderboards_settings extends CI_Migration
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
        $this->dbforge->create_table('leaderboards_settings', TRUE);

        $this->db->insert_batch('leaderboards_settings', [
            ['setting_key' => 'enable_pvp_rankings', 'setting_value' => '1'],
            ['setting_key' => 'enable_honor_kills', 'setting_value' => '1'],
            ['setting_key' => 'enable_arena_rankings', 'setting_value' => '1'],
            ['setting_key' => 'enable_achievements', 'setting_value' => '1'],
            ['setting_key' => 'enable_professions', 'setting_value' => '1'],
            ['setting_key' => 'enable_guild_rankings', 'setting_value' => '1'],
            ['setting_key' => 'items_per_page', 'setting_value' => '50'],
            ['setting_key' => 'cache_duration', 'setting_value' => '300'],
        ]);

        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'character_guid' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'achievement_date' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ],
            'achievement_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'achievement_value' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key(['character_guid', 'achievement_type']);
        $this->dbforge->create_table('leaderboards_firsts', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('leaderboards_settings', TRUE);
        $this->dbforge->drop_table('leaderboards_firsts', TRUE);
    }
}
