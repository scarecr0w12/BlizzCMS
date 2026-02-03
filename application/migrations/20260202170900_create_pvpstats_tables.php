<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_pvpstats_tables extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'bracket_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'type' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'winner' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'start_time' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP'
            ],
            'end_time' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'duration' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'index' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ]
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('bracket_id');
        $this->dbforge->add_key('type');
        $this->dbforge->add_key('winner');
        $this->dbforge->add_key('start_time');
        $this->dbforge->create_table('pvpstats_battlegrounds', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);

        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'battleground_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'guid' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'race' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'class' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'level' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'faction' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'killing_blows' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'deaths' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'honorable_kills' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'bonus_honor' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'damage_done' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'default' => 0
            ],
            'healing_done' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'default' => 0
            ],
            'flag_captures' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'flag_returns' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'bases_assaulted' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'bases_defended' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'nodes_captured' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'nodes_assaulted' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'towers_assaulted' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'towers_defended' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'mines_captured' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'farms_captured' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'graveyards_assaulted' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'graveyards_defended' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'team' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ]
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('guid');
        $this->dbforge->add_key('name');
        $this->dbforge->add_key('battleground_id');
        $this->dbforge->add_key('faction');
        $this->dbforge->add_foreign_key('battleground_id', 'pvpstats_battlegrounds', 'id', 'CASCADE', 'CASCADE');
        $this->dbforge->create_table('pvpstats_players', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);

        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'setting_key' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true
            ],
            'setting_value' => [
                'type' => 'LONGTEXT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP'
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP'
            ]
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('pvpstats_settings', true, ['ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4', 'COLLATE' => 'utf8mb4_unicode_ci']);

        $this->db->insert_batch('pvpstats_settings', [
            ['setting_key' => 'pvpstats_enabled', 'setting_value' => '1'],
            ['setting_key' => 'pvpstats_show_details', 'setting_value' => '1'],
            ['setting_key' => 'pvpstats_top_players_limit', 'setting_value' => '20'],
            ['setting_key' => 'pvpstats_top_guilds_limit', 'setting_value' => '5']
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_table('pvpstats_players', true);
        $this->dbforge->drop_table('pvpstats_battlegrounds', true);
        $this->dbforge->drop_table('pvpstats_settings', true);
    }
}
