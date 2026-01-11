<?php
$mysqli = new mysqli("dbserver", "blizzcms", "blizzcmspassword", "blizzcms");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$categories = [
    ['Mounts', 'mounts', 'Rare and exotic mounts for travel', 'fa-horse', 'item', 1],
    ['Pets & Companions', 'pets-companions', 'Vanity pets and battle companions', 'fa-paw', 'item', 2],
    ['Consumables', 'consumables', 'Potions, elixirs, and temporary boosts', 'fa-flask', 'item', 3],
    ['Cosmetics', 'cosmetics', 'Transmog items and appearance customization', 'fa-sparkles', 'item', 4],
    ['Character Services', 'character-services', 'Modify your character with premium services', 'fa-user-edit', 'service', 1],
    ['Progression Services', 'progression-services', 'Speed up your progression with boosts', 'fa-rocket', 'service', 2],
    ['VIP Memberships', 'vip-memberships', 'Premium membership with exclusive benefits', 'fa-crown', 'subscription', 1],
];

foreach ($categories as $cat) {
    $stmt = $mysqli->prepare("INSERT INTO shop_categories (name, slug, description, icon, type, sort_order, is_active, created_at) VALUES (?, ?, ?, ?, ?, ?, 1, NOW())");
    $stmt->bind_param("sssssi", $cat[0], $cat[1], $cat[2], $cat[3], $cat[4], $cat[5]);
    if (!$stmt->execute()) {
        echo "Error inserting category: " . $stmt->error . "\n";
    }
    $stmt->close();
}

$items = [
    [1, 'Spectral Tiger', 'A majestic spectral tiger mount with glowing effects', 32458, 1, 50.00, 0, 9.99, 1],
    [1, 'Swift Flying Carpet', 'Fast flying mount for quick travel', 32456, 1, 35.00, 500, 6.99, 1],
    [1, 'Celestial Dragon', 'Legendary dragon mount with celestial aura', 32459, 1, 75.00, 1000, 14.99, 1],
    [2, 'Ethereal Phoenix', 'Rare vanity pet with ethereal flames', 32460, 1, 25.00, 250, 4.99, 1],
    [2, 'Mechanical Owl', 'Steampunk-themed mechanical companion', 32461, 1, 20.00, 200, 3.99, 0],
    [3, 'Experience Boost Potion (7 Days)', '+50% experience gain for 7 days', 32462, 1, 15.00, 150, 2.99, 1],
    [3, 'Gold Pouch (50,000 Gold)', 'Instant 50,000 gold to your account', 32463, 1, 30.00, 400, 5.99, 0],
    [3, 'Reputation Token Bundle', '5x reputation tokens for faction grinding', 32464, 5, 20.00, 250, 3.99, 0],
    [4, 'Transmog: Eternal Warrior Set', 'Legendary warrior transmog appearance', 32465, 1, 40.00, 600, 7.99, 0],
    [4, 'Transmog: Mystic Mage Robes', 'Elegant mystic mage transmog set', 32466, 1, 40.00, 600, 7.99, 0],
];

foreach ($items as $item) {
    $stmt = $mysqli->prepare("INSERT INTO shop_items (category_id, name, description, item_id, item_count, price_dp, price_vp, price_money, currency, featured, stock, max_per_user, realm_id, is_active, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'USD', ?, -1, ?, 0, 1, NOW())");
    $stmt->bind_param("issiidddii", $item[0], $item[1], $item[2], $item[3], $item[4], $item[5], $item[6], $item[7], $item[8], $max_per_user);
    $max_per_user = ($item[0] == 3) ? 0 : 1;
    if (!$stmt->execute()) {
        echo "Error inserting item: " . $stmt->error . "\n";
    }
    $stmt->close();
}

$services = [
    [5, 'Character Rename', 'Change your character\'s name to something new', 'rename', 10.00, 100, 1.99, 1],
    [5, 'Appearance Customization', 'Customize your character\'s appearance (face, hair, etc)', 'customize', 15.00, 150, 2.99, 1],
    [5, 'Race Change', 'Change your character to a different race', 'change_race', 25.00, 300, 4.99, 1],
    [5, 'Faction Change', 'Switch between Alliance and Horde', 'change_faction', 30.00, 400, 5.99, 1],
    [6, 'Level Boost to Max', 'Instantly boost your character to maximum level', 'boost', 50.00, 800, 9.99, 1],
    [6, 'Profession Boost (Max)', 'Instantly max out a profession to 450', 'boost', 20.00, 250, 3.99, 1],
    [6, 'Gold Boost (100,000)', 'Receive 100,000 gold instantly', 'other', 45.00, 700, 8.99, 0],
];

foreach ($services as $service) {
    $requires_char = ($service[3] == 'other') ? 0 : 1;
    $stmt = $mysqli->prepare("INSERT INTO shop_services (category_id, name, description, service_type, price_dp, price_vp, price_money, currency, requires_character, realm_id, is_active, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'USD', ?, 0, 1, NOW())");
    $stmt->bind_param("isssddii", $service[0], $service[1], $service[2], $service[3], $service[4], $service[5], $service[6], $requires_char);
    if (!$stmt->execute()) {
        echo "Error inserting service: " . $stmt->error . "\n";
    }
    $stmt->close();
}

$subscriptions = [
    [7, 'VIP Bronze (Monthly)', 'Monthly VIP membership with great benefits', 30, 10.00, 150, 2.99, '["+25% Experience Gain", "+25% Gold Gain", "Priority Login Queue", "VIP Chat Color", "Monthly Item Delivery"]', '["Increased XP", "Increased Gold"]'],
    [7, 'VIP Silver (Monthly)', 'Enhanced VIP membership with premium benefits', 30, 25.00, 400, 6.99, '["+50% Experience Gain", "+50% Gold Gain", "Priority Login Queue", "VIP Chat Color & Title", "Weekly Item Delivery", "Access to VIP-Only Areas", "Exclusive Transmog Items"]', '["2x XP", "2x Gold", "VIP Access"]'],
    [7, 'VIP Gold (Monthly)', 'Premium VIP membership with all benefits', 30, 50.00, 800, 12.99, '["+100% Experience Gain", "+100% Gold Gain", "Priority Login Queue", "VIP Chat Color & Title", "Daily Item Delivery", "Access to VIP-Only Areas", "Exclusive Transmog Items", "Monthly Cosmetic Item", "Free Service Discount (10%)"]', '["4x XP", "4x Gold", "Full VIP Access", "Service Discount"]'],
];

foreach ($subscriptions as $sub) {
    $stmt = $mysqli->prepare("INSERT INTO shop_subscriptions (category_id, name, description, duration_days, price_dp, price_vp, price_money, currency, benefits, perks, is_active, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'USD', ?, ?, 1, NOW())");
    $stmt->bind_param("issiddsss", $sub[0], $sub[1], $sub[2], $sub[3], $sub[4], $sub[5], $sub[6], $sub[7], $sub[8]);
    if (!$stmt->execute()) {
        echo "Error inserting subscription: " . $stmt->error . "\n";
    }
    $stmt->close();
}

echo "Shop data inserted successfully!\n";
$mysqli->close();
?>
