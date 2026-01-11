-- Insert Shop Categories
INSERT INTO shop_categories (name, slug, description, icon, type, sort_order, is_active, created_at) VALUES
('Mounts', 'mounts', 'Rare and exotic mounts for travel', 'fa-horse', 'item', 1, 1, NOW()),
('Pets & Companions', 'pets-companions', 'Vanity pets and battle companions', 'fa-paw', 'item', 2, 1, NOW()),
('Consumables', 'consumables', 'Potions, elixirs, and temporary boosts', 'fa-flask', 'item', 3, 1, NOW()),
('Cosmetics', 'cosmetics', 'Transmog items and appearance customization', 'fa-sparkles', 'item', 4, 1, NOW()),
('Character Services', 'character-services', 'Modify your character with premium services', 'fa-user-edit', 'service', 1, 1, NOW()),
('Progression Services', 'progression-services', 'Speed up your progression with boosts', 'fa-rocket', 'service', 2, 1, NOW()),
('VIP Memberships', 'vip-memberships', 'Premium membership with exclusive benefits', 'fa-crown', 'subscription', 1, 1, NOW());

-- Insert Shop Items
INSERT INTO shop_items (category_id, name, description, item_id, item_count, price_dp, price_vp, price_money, currency, featured, stock, max_per_user, realm_id, is_active, created_at) VALUES
((SELECT id FROM shop_categories WHERE slug = 'mounts'), 'Spectral Tiger', 'A majestic spectral tiger mount with glowing effects', 32458, 1, 50.00, 0, 9.99, 'USD', 1, -1, 1, 0, 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'mounts'), 'Swift Flying Carpet', 'Fast flying mount for quick travel', 32456, 1, 35.00, 500, 6.99, 'USD', 1, -1, 1, 0, 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'mounts'), 'Celestial Dragon', 'Legendary dragon mount with celestial aura', 32459, 1, 75.00, 1000, 14.99, 'USD', 1, -1, 1, 0, 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'pets-companions'), 'Ethereal Phoenix', 'Rare vanity pet with ethereal flames', 32460, 1, 25.00, 250, 4.99, 'USD', 1, -1, 1, 0, 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'pets-companions'), 'Mechanical Owl', 'Steampunk-themed mechanical companion', 32461, 1, 20.00, 200, 3.99, 'USD', 0, -1, 1, 0, 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'consumables'), 'Experience Boost Potion (7 Days)', '+50% experience gain for 7 days', 32462, 1, 15.00, 150, 2.99, 'USD', 1, -1, 0, 0, 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'consumables'), 'Gold Pouch (50,000 Gold)', 'Instant 50,000 gold to your account', 32463, 1, 30.00, 400, 5.99, 'USD', 0, -1, 0, 0, 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'consumables'), 'Reputation Token Bundle', '5x reputation tokens for faction grinding', 32464, 5, 20.00, 250, 3.99, 'USD', 0, -1, 0, 0, 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'cosmetics'), 'Transmog: Eternal Warrior Set', 'Legendary warrior transmog appearance', 32465, 1, 40.00, 600, 7.99, 'USD', 0, -1, 1, 0, 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'cosmetics'), 'Transmog: Mystic Mage Robes', 'Elegant mystic mage transmog set', 32466, 1, 40.00, 600, 7.99, 'USD', 0, -1, 1, 0, 1, NOW());

-- Insert Shop Services
INSERT INTO shop_services (category_id, name, description, service_type, service_value, price_dp, price_vp, price_money, currency, requires_character, realm_id, is_active, created_at) VALUES
((SELECT id FROM shop_categories WHERE slug = 'character-services'), 'Character Rename', 'Change your character''s name to something new', 'rename', '{"max_length": 12}', 10.00, 100, 1.99, 'USD', 1, 0, 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'character-services'), 'Appearance Customization', 'Customize your character''s appearance (face, hair, etc)', 'customize', '{"options": "all"}', 15.00, 150, 2.99, 'USD', 1, 0, 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'character-services'), 'Race Change', 'Change your character to a different race', 'race_change', '{"available_races": "all"}', 25.00, 300, 4.99, 'USD', 1, 0, 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'character-services'), 'Faction Change', 'Switch between Alliance and Horde', 'faction_change', '{"options": "all"}', 30.00, 400, 5.99, 'USD', 1, 0, 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'progression-services'), 'Level Boost to Max', 'Instantly boost your character to maximum level', 'level_boost', '{"target_level": 80}', 50.00, 800, 9.99, 'USD', 1, 0, 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'progression-services'), 'Profession Boost (Max)', 'Instantly max out a profession to 450', 'profession_boost', '{"max_skill": 450}', 20.00, 250, 3.99, 'USD', 1, 0, 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'progression-services'), 'Gold Boost (100,000)', 'Receive 100,000 gold instantly', 'gold', '{"amount": 100000}', 45.00, 700, 8.99, 'USD', 0, 0, 1, NOW());

-- Insert Shop Subscriptions
INSERT INTO shop_subscriptions (category_id, name, description, subscription_type, benefits, interval_type, interval_count, price_dp, price_vp, price_money, currency, delivery_items, is_active, created_at) VALUES
((SELECT id FROM shop_categories WHERE slug = 'vip-memberships'), 'VIP Bronze (Monthly)', 'Monthly VIP membership with great benefits', 'vip', '["\\u002B25% Experience Gain", "\\u002B25% Gold Gain", "Priority Login Queue", "VIP Chat Color", "Monthly Item Delivery"]', 'monthly', 1, 10.00, 150, 2.99, 'USD', '[{"item_id": 32462, "quantity": 1}]', 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'vip-memberships'), 'VIP Silver (Monthly)', 'Enhanced VIP membership with premium benefits', 'vip', '["\\u002B50% Experience Gain", "\\u002B50% Gold Gain", "Priority Login Queue", "VIP Chat Color & Title", "Weekly Item Delivery", "Access to VIP-Only Areas", "Exclusive Transmog Items"]', 'monthly', 1, 25.00, 400, 6.99, 'USD', '[{"item_id": 32462, "quantity": 2}, {"item_id": 32464, "quantity": 1}]', 1, NOW()),
((SELECT id FROM shop_categories WHERE slug = 'vip-memberships'), 'VIP Gold (Monthly)', 'Premium VIP membership with all benefits', 'vip', '["\\u002B100% Experience Gain", "\\u002B100% Gold Gain", "Priority Login Queue", "VIP Chat Color & Title", "Daily Item Delivery", "Access to VIP-Only Areas", "Exclusive Transmog Items", "Monthly Cosmetic Item", "Free Service Discount (10%)"]', 'monthly', 1, 50.00, 800, 12.99, 'USD', '[{"item_id": 32462, "quantity": 3}, {"item_id": 32463, "quantity": 1}, {"item_id": 32464, "quantity": 2}]', 1, NOW());
