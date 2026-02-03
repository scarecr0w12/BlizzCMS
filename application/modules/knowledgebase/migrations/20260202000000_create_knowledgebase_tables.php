<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_knowledgebase_tables extends CI_Migration
{
    public function up()
    {
        // Create KB categories table
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
                'unique'     => true
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'icon' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],
            'order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0
            ],
            'is_active' => [
                'type'    => 'TINYINT',
                'default' => 1
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP'
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP'
            ]
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('slug');
        $this->dbforge->create_table('kb_categories');

        // Create KB articles table
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
                'unique'     => true
            ],
            'content' => [
                'type' => 'LONGTEXT',
                'null' => false
            ],
            'excerpt' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'featured_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],
            'author_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true
            ],
            'views' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0
            ],
            'is_published' => [
                'type'    => 'TINYINT',
                'default' => 0
            ],
            'is_featured' => [
                'type'    => 'TINYINT',
                'default' => 0
            ],
            'order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0
            ],
            'published_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP'
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP'
            ]
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('category_id');
        $this->dbforge->add_key('slug');
        $this->dbforge->add_key('is_published');
        $this->dbforge->add_foreign_key('category_id', 'kb_categories', 'id', 'CASCADE', 'CASCADE');
        $this->dbforge->create_table('kb_articles');

        // Create KB tags table
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
                'unique'     => true
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
                'unique'     => true
            ],
            'color' => [
                'type'       => 'VARCHAR',
                'constraint' => 7,
                'default'    => '#6B7280'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP'
            ]
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('slug');
        $this->dbforge->create_table('kb_tags');

        // Create KB article tags junction table
        $this->dbforge->add_field([
            'article_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false
            ],
            'tag_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false
            ]
        ]);
        $this->dbforge->add_key(['article_id', 'tag_id'], true);
        $this->dbforge->add_foreign_key('article_id', 'kb_articles', 'id', 'CASCADE', 'CASCADE');
        $this->dbforge->add_foreign_key('tag_id', 'kb_tags', 'id', 'CASCADE', 'CASCADE');
        $this->dbforge->create_table('kb_article_tags');

        // Create KB comments table
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'article_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true
            ],
            'author_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],
            'author_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => false
            ],
            'is_approved' => [
                'type'    => 'TINYINT',
                'default' => 0
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP'
            ]
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('article_id');
        $this->dbforge->add_key('user_id');
        $this->dbforge->add_foreign_key('article_id', 'kb_articles', 'id', 'CASCADE', 'CASCADE');
        $this->dbforge->create_table('kb_comments');
    }

    public function down()
    {
        $this->dbforge->drop_table('kb_article_tags');
        $this->dbforge->drop_table('kb_comments');
        $this->dbforge->drop_table('kb_articles');
        $this->dbforge->drop_table('kb_tags');
        $this->dbforge->drop_table('kb_categories');
    }
}
