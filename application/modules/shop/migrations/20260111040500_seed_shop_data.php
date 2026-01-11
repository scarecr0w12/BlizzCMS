<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Seed_shop_data extends CI_Migration {

    public function up()
    {
        // Create categories
        $categories = [
            // Item categories
            [
                'name' => 'Mounts',
                'slug' => 'mounts',
                'description' => 'Rare and exotic mounts for travel',
                'icon' => 'fa-horse',
                'type' => 'item',
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Pets & Companions',
                'slug' => 'pets-companions',
                'description' => 'Vanity pets and battle companions',
                'icon' => 'fa-paw',
                'type' => 'item',
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Consumables',
                'slug' => 'consumables',
                'description' => 'Potions, elixirs, and temporary boosts',
                'icon' => 'fa-flask',
                'type' => 'item',
                'sort_order' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Cosmetics',
                'slug' => 'cosmetics',
                'description' => 'Transmog items and appearance customization',
                'icon' => 'fa-sparkles',
                'type' => 'item',
                'sort_order' => 4,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            // Service categories
            [
                'name' => 'Character Services',
                'slug' => 'character-services',
                'description' => 'Modify your character with premium services',
                'icon' => 'fa-user-edit',
                'type' => 'service',
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Progression Services',
                'slug' => 'progression-services',
                'description' => 'Speed up your progression with boosts',
                'icon' => 'fa-rocket',
                'type' => 'service',
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            // Subscription categories
            [
                'name' => 'VIP Memberships',
                'slug' => 'vip-memberships',
                'description' => 'Premium membership with exclusive benefits',
                'icon' => 'fa-crown',
                'type' => 'subscription',
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        foreach ($categories as $category) {
            $this->db->insert('shop_categories', $category);
        }

        // Get category IDs
        $mounts_cat = $this->db->where('slug', 'mounts')->get('shop_categories')->row();
        $pets_cat = $this->db->where('slug', 'pets-companions')->get('shop_categories')->row();
        $consumables_cat = $this->db->where('slug', 'consumables')->get('shop_categories')->row();
        $cosmetics_cat = $this->db->where('slug', 'cosmetics')->get('shop_categories')->row();
        $char_services_cat = $this->db->where('slug', 'character-services')->get('shop_categories')->row();
        $progression_cat = $this->db->where('slug', 'progression-services')->get('shop_categories')->row();
        $vip_cat = $this->db->where('slug', 'vip-memberships')->get('shop_categories')->row();

        // Create items
        $items = [
            // Mounts
            [
                'category_id' => $mounts_cat->id,
                'name' => 'Spectral Tiger',
                'description' => 'A majestic spectral tiger mount with glowing effects',
                'item_id' => 32458,
                'item_count' => 1,
                'price_dp' => 50.00,
                'price_vp' => 0,
                'price_money' => 9.99,
                'currency' => 'USD',
                'featured' => 1,
                'stock' => -1,
                'max_per_user' => 1,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $mounts_cat->id,
                'name' => 'Swift Flying Carpet',
                'description' => 'Fast flying mount for quick travel',
                'item_id' => 32456,
                'item_count' => 1,
                'price_dp' => 35.00,
                'price_vp' => 500,
                'price_money' => 6.99,
                'currency' => 'USD',
                'featured' => 1,
                'stock' => -1,
                'max_per_user' => 1,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $mounts_cat->id,
                'name' => 'Celestial Dragon',
                'description' => 'Legendary dragon mount with celestial aura',
                'item_id' => 32459,
                'item_count' => 1,
                'price_dp' => 75.00,
                'price_vp' => 1000,
                'price_money' => 14.99,
                'currency' => 'USD',
                'featured' => 1,
                'stock' => -1,
                'max_per_user' => 1,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            // Pets
            [
                'category_id' => $pets_cat->id,
                'name' => 'Ethereal Phoenix',
                'description' => 'Rare vanity pet with ethereal flames',
                'item_id' => 32460,
                'item_count' => 1,
                'price_dp' => 25.00,
                'price_vp' => 250,
                'price_money' => 4.99,
                'currency' => 'USD',
                'featured' => 1,
                'stock' => -1,
                'max_per_user' => 1,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $pets_cat->id,
                'name' => 'Mechanical Owl',
                'description' => 'Steampunk-themed mechanical companion',
                'item_id' => 32461,
                'item_count' => 1,
                'price_dp' => 20.00,
                'price_vp' => 200,
                'price_money' => 3.99,
                'currency' => 'USD',
                'featured' => 0,
                'stock' => -1,
                'max_per_user' => 1,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            // Consumables
            [
                'category_id' => $consumables_cat->id,
                'name' => 'Experience Boost Potion (7 Days)',
                'description' => '+50% experience gain for 7 days',
                'item_id' => 32462,
                'item_count' => 1,
                'price_dp' => 15.00,
                'price_vp' => 150,
                'price_money' => 2.99,
                'currency' => 'USD',
                'featured' => 1,
                'stock' => -1,
                'max_per_user' => 0,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $consumables_cat->id,
                'name' => 'Gold Pouch (50,000 Gold)',
                'description' => 'Instant 50,000 gold to your account',
                'item_id' => 32463,
                'item_count' => 1,
                'price_dp' => 30.00,
                'price_vp' => 400,
                'price_money' => 5.99,
                'currency' => 'USD',
                'featured' => 0,
                'stock' => -1,
                'max_per_user' => 0,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $consumables_cat->id,
                'name' => 'Reputation Token Bundle',
                'description' => '5x reputation tokens for faction grinding',
                'item_id' => 32464,
                'item_count' => 5,
                'price_dp' => 20.00,
                'price_vp' => 250,
                'price_money' => 3.99,
                'currency' => 'USD',
                'featured' => 0,
                'stock' => -1,
                'max_per_user' => 0,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            // Cosmetics
            [
                'category_id' => $cosmetics_cat->id,
                'name' => 'Transmog: Eternal Warrior Set',
                'description' => 'Legendary warrior transmog appearance',
                'item_id' => 32465,
                'item_count' => 1,
                'price_dp' => 40.00,
                'price_vp' => 600,
                'price_money' => 7.99,
                'currency' => 'USD',
                'featured' => 0,
                'stock' => -1,
                'max_per_user' => 1,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $cosmetics_cat->id,
                'name' => 'Transmog: Mystic Mage Robes',
                'description' => 'Elegant mystic mage transmog set',
                'item_id' => 32466,
                'item_count' => 1,
                'price_dp' => 40.00,
                'price_vp' => 600,
                'price_money' => 7.99,
                'currency' => 'USD',
                'featured' => 0,
                'stock' => -1,
                'max_per_user' => 1,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        foreach ($items as $item) {
            $this->db->insert('shop_items', $item);
        }

        // Create services
        $services = [
            [
                'category_id' => $char_services_cat->id,
                'name' => 'Character Rename',
                'description' => 'Change your character\'s name to something new',
                'service_type' => 'rename',
                'service_value' => json_encode(['max_length' => 12]),
                'price_dp' => 10.00,
                'price_vp' => 100,
                'price_money' => 1.99,
                'currency' => 'USD',
                'requires_character' => 1,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $char_services_cat->id,
                'name' => 'Appearance Customization',
                'description' => 'Customize your character\'s appearance (face, hair, etc)',
                'service_type' => 'customize',
                'service_value' => json_encode(['options' => 'all']),
                'price_dp' => 15.00,
                'price_vp' => 150,
                'price_money' => 2.99,
                'currency' => 'USD',
                'requires_character' => 1,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $char_services_cat->id,
                'name' => 'Race Change',
                'description' => 'Change your character to a different race',
                'service_type' => 'race_change',
                'service_value' => json_encode(['available_races' => 'all']),
                'price_dp' => 25.00,
                'price_vp' => 300,
                'price_money' => 4.99,
                'currency' => 'USD',
                'requires_character' => 1,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $char_services_cat->id,
                'name' => 'Faction Change',
                'description' => 'Switch between Alliance and Horde',
                'service_type' => 'faction_change',
                'service_value' => json_encode(['options' => 'all']),
                'price_dp' => 30.00,
                'price_vp' => 400,
                'price_money' => 5.99,
                'currency' => 'USD',
                'requires_character' => 1,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $progression_cat->id,
                'name' => 'Level Boost to Max',
                'description' => 'Instantly boost your character to maximum level',
                'service_type' => 'level_boost',
                'service_value' => json_encode(['target_level' => 80]),
                'price_dp' => 50.00,
                'price_vp' => 800,
                'price_money' => 9.99,
                'currency' => 'USD',
                'requires_character' => 1,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $progression_cat->id,
                'name' => 'Profession Boost (Max)',
                'description' => 'Instantly max out a profession to 450',
                'service_type' => 'profession_boost',
                'service_value' => json_encode(['max_skill' => 450]),
                'price_dp' => 20.00,
                'price_vp' => 250,
                'price_money' => 3.99,
                'currency' => 'USD',
                'requires_character' => 1,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $progression_cat->id,
                'name' => 'Gold Boost (100,000)',
                'description' => 'Receive 100,000 gold instantly',
                'service_type' => 'gold',
                'service_value' => json_encode(['amount' => 100000]),
                'price_dp' => 45.00,
                'price_vp' => 700,
                'price_money' => 8.99,
                'currency' => 'USD',
                'requires_character' => 0,
                'realm_id' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        foreach ($services as $service) {
            $this->db->insert('shop_services', $service);
        }

        // Create subscriptions
        $subscriptions = [
            [
                'category_id' => $vip_cat->id,
                'name' => 'VIP Bronze (Monthly)',
                'description' => 'Monthly VIP membership with great benefits',
                'subscription_type' => 'vip',
                'benefits' => json_encode([
                    '+25% Experience Gain',
                    '+25% Gold Gain',
                    'Priority Login Queue',
                    'VIP Chat Color',
                    'Monthly Item Delivery'
                ]),
                'interval_type' => 'monthly',
                'interval_count' => 1,
                'price_dp' => 10.00,
                'price_vp' => 150,
                'price_money' => 2.99,
                'currency' => 'USD',
                'delivery_items' => json_encode([
                    ['item_id' => 32462, 'quantity' => 1]
                ]),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $vip_cat->id,
                'name' => 'VIP Silver (Monthly)',
                'description' => 'Enhanced VIP membership with premium benefits',
                'subscription_type' => 'vip',
                'benefits' => json_encode([
                    '+50% Experience Gain',
                    '+50% Gold Gain',
                    'Priority Login Queue',
                    'VIP Chat Color & Title',
                    'Weekly Item Delivery',
                    'Access to VIP-Only Areas',
                    'Exclusive Transmog Items'
                ]),
                'interval_type' => 'monthly',
                'interval_count' => 1,
                'price_dp' => 25.00,
                'price_vp' => 400,
                'price_money' => 6.99,
                'currency' => 'USD',
                'delivery_items' => json_encode([
                    ['item_id' => 32462, 'quantity' => 2],
                    ['item_id' => 32464, 'quantity' => 1]
                ]),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'category_id' => $vip_cat->id,
                'name' => 'VIP Gold (Monthly)',
                'description' => 'Premium VIP membership with all benefits',
                'subscription_type' => 'vip',
                'benefits' => json_encode([
                    '+100% Experience Gain',
                    '+100% Gold Gain',
                    'Priority Login Queue',
                    'VIP Chat Color & Title',
                    'Daily Item Delivery',
                    'Access to VIP-Only Areas',
                    'Exclusive Transmog Items',
                    'Monthly Cosmetic Item',
                    'Free Service Discount (10%)'
                ]),
                'interval_type' => 'monthly',
                'interval_count' => 1,
                'price_dp' => 50.00,
                'price_vp' => 800,
                'price_money' => 12.99,
                'currency' => 'USD',
                'delivery_items' => json_encode([
                    ['item_id' => 32462, 'quantity' => 3],
                    ['item_id' => 32463, 'quantity' => 1],
                    ['item_id' => 32464, 'quantity' => 2]
                ]),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        foreach ($subscriptions as $subscription) {
            $this->db->insert('shop_subscriptions', $subscription);
        }
    }

    public function down()
    {
        $this->db->truncate('shop_subscriptions');
        $this->db->truncate('shop_services');
        $this->db->truncate('shop_items');
        $this->db->truncate('shop_categories');
    }
}
