<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_donate_tables extends CI_Migration
{
    public function up()
    {
        // Register the module
        $this->db->insert('modules', [
            'module'  => 'donate',
            'version' => '1.0.0'
        ]);

        // Donation Packages table
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
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => 3,
                'default' => 'USD'
            ],
            'dp_amount' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0,
                'comment' => 'Donation points rewarded'
            ],
            'bonus_dp' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0,
                'comment' => 'Bonus donation points'
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
        $this->dbforge->create_table('donate_packages', FALSE, ['ENGINE' => 'InnoDB']);

        // Payment Gateways table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'display_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'config' => [
                'type' => 'TEXT',
                'null' => TRUE,
                'comment' => 'JSON encoded gateway configuration'
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => ''
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
                'default' => 0
            ],
            'is_sandbox' => [
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
        $this->dbforge->add_key('name');
        $this->dbforge->create_table('donate_gateways', FALSE, ['ENGINE' => 'InnoDB']);

        // Donation Logs table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ],
            'package_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'null' => TRUE
            ],
            'gateway' => [
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
            'dp_awarded' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ],
            'status' => [
                'type' => 'ENUM("pending","completed","failed","refunded","cancelled")',
                'default' => 'pending'
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => TRUE
            ],
            'gateway_response' => [
                'type' => 'TEXT',
                'null' => TRUE,
                'comment' => 'JSON encoded gateway response'
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
        $this->dbforge->add_key('transaction_id');
        $this->dbforge->add_key('status');
        $this->dbforge->create_table('donate_logs', FALSE, ['ENGINE' => 'InnoDB']);

        // Insert default payment gateways
        $gateways = [
            [
                'name' => 'paypal',
                'display_name' => 'PayPal',
                'description' => 'Pay securely with PayPal',
                'config' => json_encode([
                    'client_id' => '',
                    'client_secret' => '',
                    'mode' => 'sandbox'
                ]),
                'icon' => 'fa-brands fa-paypal',
                'sort_order' => 1,
                'is_active' => 0,
                'is_sandbox' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'stripe',
                'display_name' => 'Stripe',
                'description' => 'Pay securely with credit card',
                'config' => json_encode([
                    'publishable_key' => '',
                    'secret_key' => '',
                    'webhook_secret' => ''
                ]),
                'icon' => 'fa-brands fa-stripe',
                'sort_order' => 2,
                'is_active' => 0,
                'is_sandbox' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->insert_batch('donate_gateways', $gateways);

        // Insert default donation packages
        $packages = [
            [
                'name' => 'Starter Pack',
                'description' => 'Perfect for beginners - get started with some donation points!',
                'price' => 5.00,
                'currency' => 'USD',
                'dp_amount' => 50,
                'bonus_dp' => 0,
                'featured' => 0,
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Basic Pack',
                'description' => 'A good value pack for regular supporters.',
                'price' => 10.00,
                'currency' => 'USD',
                'dp_amount' => 100,
                'bonus_dp' => 10,
                'featured' => 0,
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Premium Pack',
                'description' => 'Best value! Get bonus points with this popular package.',
                'price' => 25.00,
                'currency' => 'USD',
                'dp_amount' => 250,
                'bonus_dp' => 50,
                'featured' => 1,
                'sort_order' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Ultimate Pack',
                'description' => 'The ultimate supporter package with maximum bonus!',
                'price' => 50.00,
                'currency' => 'USD',
                'dp_amount' => 500,
                'bonus_dp' => 150,
                'featured' => 1,
                'sort_order' => 4,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->insert_batch('donate_packages', $packages);

        // Add donate settings
        $settings = [
            ['key' => 'donate_enabled', 'value' => '1', 'type' => 'bool'],
            ['key' => 'donate_currency', 'value' => 'USD', 'type' => 'string'],
            ['key' => 'donate_min_amount', 'value' => '1', 'type' => 'int'],
            ['key' => 'donate_max_amount', 'value' => '1000', 'type' => 'int']
        ];

        $this->db->insert_batch('settings', $settings);
    }

    public function down()
    {
        // Remove settings
        $this->db->where_in('key', [
            'donate_enabled',
            'donate_currency',
            'donate_min_amount',
            'donate_max_amount'
        ])->delete('settings');

        // Drop tables
        $this->dbforge->drop_table('donate_logs', TRUE);
        $this->dbforge->drop_table('donate_gateways', TRUE);
        $this->dbforge->drop_table('donate_packages', TRUE);

        // Remove module registration
        $this->db->where('module', 'donate')->delete('modules');
    }
}
