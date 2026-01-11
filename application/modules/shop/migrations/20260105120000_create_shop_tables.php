<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_shop_tables extends CI_Migration
{
    public function up()
    {
        // Register the module
        $this->db->insert('modules', [
            'module'  => 'shop',
            'version' => '1.0.0'
        ]);

        // Shop Categories table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => ''
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => ''
            ],
            'type' => [
                'type' => 'ENUM("item","service","subscription")',
                'default' => 'item'
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => TRUE,
                'default' => 1
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('slug');
        $this->dbforge->create_table('shop_categories', FALSE, ['ENGINE' => 'InnoDB']);

        // Shop Items table (in-game items)
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'item_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'comment' => 'Game item entry ID'
            ],
            'item_count' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 1
            ],
            'price_dp' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'price_vp' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ],
            'price_money' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => 3,
                'default' => 'USD'
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => ''
            ],
            'featured' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => TRUE,
                'default' => 0
            ],
            'stock' => [
                'type' => 'INT',
                'constraint' => 10,
                'default' => -1,
                'comment' => '-1 for unlimited'
            ],
            'max_per_user' => [
                'type' => 'INT',
                'constraint' => 10,
                'default' => 0,
                'comment' => '0 for unlimited'
            ],
            'realm_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0,
                'comment' => '0 for all realms'
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => TRUE,
                'default' => 1
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('category_id');
        $this->dbforge->add_key('item_id');
        $this->dbforge->create_table('shop_items', FALSE, ['ENGINE' => 'InnoDB']);

        // Shop Services table (character services)
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'service_type' => [
                'type' => 'ENUM("rename","customize","race_change","faction_change","level_boost","profession_boost","gold","custom")',
                'default' => 'custom'
            ],
            'service_value' => [
                'type' => 'TEXT',
                'null' => TRUE,
                'comment' => 'JSON data for service parameters'
            ],
            'price_dp' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'price_vp' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ],
            'price_money' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => 3,
                'default' => 'USD'
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => ''
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => ''
            ],
            'requires_character' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => TRUE,
                'default' => 1
            ],
            'realm_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0,
                'comment' => '0 for all realms'
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => TRUE,
                'default' => 1
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('category_id');
        $this->dbforge->create_table('shop_services', FALSE, ['ENGINE' => 'InnoDB']);

        // Shop Subscriptions table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'subscription_type' => [
                'type' => 'ENUM("vip","premium","item_delivery","service_access","custom")',
                'default' => 'custom'
            ],
            'benefits' => [
                'type' => 'TEXT',
                'null' => TRUE,
                'comment' => 'JSON array of benefits'
            ],
            'interval_type' => [
                'type' => 'ENUM("daily","weekly","monthly","yearly")',
                'default' => 'monthly'
            ],
            'interval_count' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 1
            ],
            'price_dp' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'price_vp' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ],
            'price_money' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => 3,
                'default' => 'USD'
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => ''
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => ''
            ],
            'delivery_items' => [
                'type' => 'TEXT',
                'null' => TRUE,
                'comment' => 'JSON array of items to deliver each interval'
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => TRUE,
                'default' => 1
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('category_id');
        $this->dbforge->create_table('shop_subscriptions', FALSE, ['ENGINE' => 'InnoDB']);

        // Orders table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'user_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE
            ],
            'order_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => TRUE
            ],
            'status' => [
                'type' => 'ENUM("pending","processing","completed","failed","refunded","cancelled")',
                'default' => 'pending'
            ],
            'payment_method' => [
                'type' => 'ENUM("dp","vp","paypal","stripe","mixed")',
                'default' => 'dp'
            ],
            'total_dp' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'total_vp' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ],
            'total_money' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => 3,
                'default' => 'USD'
            ],
            'transaction_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'payment_data' => [
                'type' => 'TEXT',
                'null' => TRUE,
                'comment' => 'JSON data from payment gateway'
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('user_id');
        $this->dbforge->add_key('order_number');
        $this->dbforge->create_table('shop_orders', FALSE, ['ENGINE' => 'InnoDB']);

        // Order Items table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'order_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ],
            'product_type' => [
                'type' => 'ENUM("item","service","subscription")',
                'default' => 'item'
            ],
            'product_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ],
            'product_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 1
            ],
            'price_dp' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'price_vp' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ],
            'price_money' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'realm_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ],
            'character_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => TRUE
            ],
            'character_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'status' => [
                'type' => 'ENUM("pending","delivered","failed")',
                'default' => 'pending'
            ],
            'delivered_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'product_data' => [
                'type' => 'TEXT',
                'null' => TRUE,
                'comment' => 'JSON snapshot of product at purchase time'
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('order_id');
        $this->dbforge->create_table('shop_order_items', FALSE, ['ENGINE' => 'InnoDB']);

        // User Subscriptions table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'user_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE
            ],
            'subscription_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ],
            'order_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'null' => TRUE
            ],
            'status' => [
                'type' => 'ENUM("active","paused","cancelled","expired")',
                'default' => 'active'
            ],
            'payment_method' => [
                'type' => 'ENUM("dp","vp","paypal","stripe")',
                'default' => 'dp'
            ],
            'external_subscription_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE,
                'comment' => 'PayPal/Stripe subscription ID'
            ],
            'realm_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ],
            'character_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'null' => TRUE
            ],
            'started_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'current_period_start' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'current_period_end' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'cancelled_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'last_delivery_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('user_id');
        $this->dbforge->add_key('subscription_id');
        $this->dbforge->create_table('shop_user_subscriptions', FALSE, ['ENGINE' => 'InnoDB']);

        // Payment logs table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'order_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'null' => TRUE
            ],
            'user_subscription_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'null' => TRUE
            ],
            'payment_method' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'transaction_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ],
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => 3,
                'default' => 'USD'
            ],
            'status' => [
                'type' => 'ENUM("pending","completed","failed","refunded")',
                'default' => 'pending'
            ],
            'gateway_response' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('order_id');
        $this->dbforge->create_table('shop_payment_logs', FALSE, ['ENGINE' => 'InnoDB']);

        // Add shop settings
        $this->db->insert_batch('settings', [
            ['key' => 'shop_enabled', 'value' => 'true', 'type' => 'bool'],
            ['key' => 'shop_currency', 'value' => 'USD', 'type' => 'string'],
            ['key' => 'shop_items_per_page', 'value' => '12', 'type' => 'int'],
            ['key' => 'shop_allow_dp_payment', 'value' => 'true', 'type' => 'bool'],
            ['key' => 'shop_allow_vp_payment', 'value' => 'true', 'type' => 'bool'],
            ['key' => 'shop_allow_money_payment', 'value' => 'true', 'type' => 'bool'],
            ['key' => 'shop_paypal_enabled', 'value' => 'false', 'type' => 'bool'],
            ['key' => 'shop_paypal_sandbox', 'value' => 'true', 'type' => 'bool'],
            ['key' => 'shop_paypal_client_id', 'value' => '', 'type' => 'string'],
            ['key' => 'shop_paypal_secret', 'value' => '', 'type' => 'string'],
            ['key' => 'shop_stripe_enabled', 'value' => 'false', 'type' => 'bool'],
            ['key' => 'shop_stripe_publishable_key', 'value' => '', 'type' => 'string'],
            ['key' => 'shop_stripe_secret_key', 'value' => '', 'type' => 'string'],
            ['key' => 'shop_stripe_webhook_secret', 'value' => '', 'type' => 'string'],
            ['key' => 'shop_vp_to_dp_rate', 'value' => '10', 'type' => 'int'],
            ['key' => 'shop_dp_to_money_rate', 'value' => '1', 'type' => 'float']
        ]);

        // Insert default categories
        $this->db->insert_batch('shop_categories', [
            [
                'name' => 'Items',
                'slug' => 'items',
                'description' => 'In-game items for your characters',
                'icon' => 'fa-solid fa-box',
                'type' => 'item',
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Services',
                'slug' => 'services',
                'description' => 'Character services like rename, race change, etc.',
                'icon' => 'fa-solid fa-wand-magic-sparkles',
                'type' => 'service',
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Subscriptions',
                'slug' => 'subscriptions',
                'description' => 'Premium memberships and recurring benefits',
                'icon' => 'fa-solid fa-crown',
                'type' => 'subscription',
                'sort_order' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);

        // Insert shop permissions
        $this->load->model('permission_model');
        $this->permission_model->insert_batch([
            ['key' => 'view.shop', 'module' => 'shop', 'description' => 'Can view shop admin dashboard'],
            ['key' => 'view.shop.category', 'module' => 'shop', 'description' => 'Can view shop categories'],
            ['key' => 'add.shop.category', 'module' => 'shop', 'description' => 'Can add shop categories'],
            ['key' => 'edit.shop.category', 'module' => 'shop', 'description' => 'Can edit shop categories'],
            ['key' => 'delete.shop.category', 'module' => 'shop', 'description' => 'Can delete shop categories'],
            ['key' => 'view.shop.item', 'module' => 'shop', 'description' => 'Can view shop items'],
            ['key' => 'add.shop.item', 'module' => 'shop', 'description' => 'Can add shop items'],
            ['key' => 'edit.shop.item', 'module' => 'shop', 'description' => 'Can edit shop items'],
            ['key' => 'delete.shop.item', 'module' => 'shop', 'description' => 'Can delete shop items'],
            ['key' => 'view.shop.service', 'module' => 'shop', 'description' => 'Can view shop services'],
            ['key' => 'add.shop.service', 'module' => 'shop', 'description' => 'Can add shop services'],
            ['key' => 'edit.shop.service', 'module' => 'shop', 'description' => 'Can edit shop services'],
            ['key' => 'delete.shop.service', 'module' => 'shop', 'description' => 'Can delete shop services'],
            ['key' => 'view.shop.subscription', 'module' => 'shop', 'description' => 'Can view shop subscriptions'],
            ['key' => 'add.shop.subscription', 'module' => 'shop', 'description' => 'Can add shop subscriptions'],
            ['key' => 'edit.shop.subscription', 'module' => 'shop', 'description' => 'Can edit shop subscriptions'],
            ['key' => 'delete.shop.subscription', 'module' => 'shop', 'description' => 'Can delete shop subscriptions'],
            ['key' => 'view.shop.order', 'module' => 'shop', 'description' => 'Can view shop orders'],
            ['key' => 'process.shop.order', 'module' => 'shop', 'description' => 'Can process shop orders'],
            ['key' => 'view.shop.payment', 'module' => 'shop', 'description' => 'Can view shop payments'],
            ['key' => 'edit.shop.settings', 'module' => 'shop', 'description' => 'Can edit shop settings']
        ]);

        // Assign all shop permissions to Administrator role (role_id = 5)
        $shop_permissions = $this->permission_model->find_all(['module' => 'shop']);
        if (! empty($shop_permissions)) {
            $role_permissions = [];
            foreach ($shop_permissions as $permission) {
                $role_permissions[] = [
                    'role_id' => 5,
                    'permission_id' => $permission->id
                ];
            }
            $this->db->insert_batch('roles_permissions', $role_permissions);
        }
    }

    public function down()
    {
        // Remove the module
        $this->db->where('module', 'shop')->delete('modules');

        // Remove settings
        $this->db->like('key', 'shop_', 'after')->delete('settings');

        // Remove permissions and role assignments
        $this->load->model('permission_model');
        $shop_permissions = $this->permission_model->find_all(['module' => 'shop'], 'array');
        $permission_ids = array_column($shop_permissions, 'id');
        if (! empty($permission_ids)) {
            $this->db->where_in('permission_id', $permission_ids)->delete('roles_permissions');
            $this->permission_model->delete_in('id', $permission_ids);
        }

        // Drop tables
        $this->dbforge->drop_table('shop_payment_logs', TRUE);
        $this->dbforge->drop_table('shop_user_subscriptions', TRUE);
        $this->dbforge->drop_table('shop_order_items', TRUE);
        $this->dbforge->drop_table('shop_orders', TRUE);
        $this->dbforge->drop_table('shop_subscriptions', TRUE);
        $this->dbforge->drop_table('shop_services', TRUE);
        $this->dbforge->drop_table('shop_items', TRUE);
        $this->dbforge->drop_table('shop_categories', TRUE);
    }
}
