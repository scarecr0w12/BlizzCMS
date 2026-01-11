<?php
/**
 * BlizzCMS - Profile Enhanced Tables Migration
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_profile_enhanced_tables extends CI_Migration
{
    public function up()
    {
        // User activity timeline
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
            'activity_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'activity_data' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'reference_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => TRUE,
            ],
            'is_public' => [
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
        $this->dbforge->add_key('created_at');
        $this->dbforge->create_table('user_activities', TRUE);

        // User achievements showcase
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
            'achievement_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'character_guid' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => TRUE,
            ],
            'showcase' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'earned_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('user_id');
        $this->dbforge->add_key('showcase');
        $this->dbforge->create_table('user_achievement_showcase', TRUE);

        // Profile customization
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
            'bio' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'location' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => TRUE,
            ],
            'website' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => TRUE,
            ],
            'avatar_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => TRUE,
            ],
            'cover_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => TRUE,
            ],
            'theme' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'default',
            ],
            'show_achievements' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'show_characters' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'show_activity' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('user_id');
        $this->dbforge->create_table('user_profiles', TRUE);

        // Profile visits tracking
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'profile_user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'visitor_user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
                'null'       => TRUE,
            ],
            'visited_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('profile_user_id');
        $this->dbforge->create_table('profile_visits', TRUE);

        // Profile enhanced settings
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
        $this->dbforge->create_table('profile_enhanced_settings', TRUE);

        $this->db->insert_batch('profile_enhanced_settings', [
            ['setting_key' => 'enable_timeline', 'setting_value' => '1'],
            ['setting_key' => 'enable_achievements', 'setting_value' => '1'],
            ['setting_key' => 'enable_character_gallery', 'setting_value' => '1'],
            ['setting_key' => 'enable_profile_visits', 'setting_value' => '1'],
            ['setting_key' => 'enable_social_links', 'setting_value' => '1'],
            ['setting_key' => 'enable_profile_themes', 'setting_value' => '1'],
            ['setting_key' => 'max_showcase_achievements', 'setting_value' => '6'],
            ['setting_key' => 'default_profile_visibility', 'setting_value' => 'public'],
            ['setting_key' => 'require_bio_approval', 'setting_value' => '0'],
            ['setting_key' => 'max_bio_length', 'setting_value' => '500'],
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_table('user_activities', TRUE);
        $this->dbforge->drop_table('user_achievement_showcase', TRUE);
        $this->dbforge->drop_table('user_profiles', TRUE);
        $this->dbforge->drop_table('profile_visits', TRUE);
        $this->dbforge->drop_table('profile_enhanced_settings', TRUE);
    }
}
