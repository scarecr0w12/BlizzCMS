<?php
/**
 * BlizzCMS - Shop Enhanced Tables Migration
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_shop_enhanced_tables extends CI_Migration
{
    public function up()
    {
        // Wishlist table
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
            'item_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'added_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key(['user_id', 'item_id']);
        $this->dbforge->create_table('shop_wishlist', TRUE);

        // Shopping cart table
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
            'item_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'quantity' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
            ],
            'added_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key(['user_id', 'item_id']);
        $this->dbforge->create_table('shop_cart', TRUE);

        // Item reviews table
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'item_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'rating' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'unsigned'   => TRUE,
            ],
            'review' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => FALSE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('item_id');
        $this->dbforge->add_key('user_id');
        $this->dbforge->create_table('shop_reviews', TRUE);

        // Item views tracking
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'item_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => TRUE,
            ],
            'view_count' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'last_viewed' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('item_id');
        $this->dbforge->create_table('shop_item_views', TRUE);

        // Shop enhanced settings
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
        $this->dbforge->create_table('shop_enhanced_settings', TRUE);

        $this->db->insert_batch('shop_enhanced_settings', [
            ['setting_key' => 'enable_wishlist', 'setting_value' => '1'],
            ['setting_key' => 'enable_cart', 'setting_value' => '1'],
            ['setting_key' => 'enable_compare', 'setting_value' => '1'],
            ['setting_key' => 'enable_reviews', 'setting_value' => '1'],
            ['setting_key' => 'max_cart_items', 'setting_value' => '20'],
            ['setting_key' => 'max_compare_items', 'setting_value' => '4'],
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_table('shop_wishlist', TRUE);
        $this->dbforge->drop_table('shop_cart', TRUE);
        $this->dbforge->drop_table('shop_reviews', TRUE);
        $this->dbforge->drop_table('shop_item_views', TRUE);
        $this->dbforge->drop_table('shop_enhanced_settings', TRUE);
    }
}
