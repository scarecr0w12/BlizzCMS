<?php
$mysqli = new mysqli("dbserver", "blizzcms", "blizzcmspassword", "blizzcms");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$images = [
    // Mounts
    32458 => 'https://wow.zamimg.com/images/wow/icons/large/inv_mount_spectraltiger.jpg', // Spectral Tiger
    32456 => 'https://wow.zamimg.com/images/wow/icons/large/inv_mount_carpetflyingcarpet.jpg', // Flying Carpet
    32459 => 'https://wow.zamimg.com/images/wow/icons/large/inv_mount_celestialdrake.jpg', // Celestial Dragon
    // Pets
    32460 => 'https://wow.zamimg.com/images/wow/icons/large/inv_pet_phoenix.jpg', // Ethereal Phoenix
    32461 => 'https://wow.zamimg.com/images/wow/icons/large/inv_pet_mechanical_owl.jpg', // Mechanical Owl
    // Consumables
    32462 => 'https://wow.zamimg.com/images/wow/icons/large/inv_potion_golempower.jpg', // Experience Potion
    32463 => 'https://wow.zamimg.com/images/wow/icons/large/inv_misc_coin_01.jpg', // Gold Pouch
    32464 => 'https://wow.zamimg.com/images/wow/icons/large/inv_misc_token_01.jpg', // Reputation Token
    // Cosmetics
    32465 => 'https://wow.zamimg.com/images/wow/icons/large/inv_chest_plate_raiddeathknight_p_01.jpg', // Warrior Set
    32466 => 'https://wow.zamimg.com/images/wow/icons/large/inv_chest_cloth_raidpriestmoon_p_01.jpg', // Mage Robes
];

$uploads_dir = '/var/www/html/uploads/shop';
if (!is_dir($uploads_dir)) {
    mkdir($uploads_dir, 0755, true);
}

$item_mapping = [
    'Spectral Tiger' => 32458,
    'Swift Flying Carpet' => 32456,
    'Celestial Dragon' => 32459,
    'Ethereal Phoenix' => 32460,
    'Mechanical Owl' => 32461,
    'Experience Boost Potion (7 Days)' => 32462,
    'Gold Pouch (50,000 Gold)' => 32463,
    'Reputation Token Bundle' => 32464,
    'Transmog: Eternal Warrior Set' => 32465,
    'Transmog: Mystic Mage Robes' => 32466,
];

foreach ($item_mapping as $item_name => $item_id) {
    $url = $images[$item_id];
    $filename = 'item_' . $item_id . '.jpg';
    $filepath = $uploads_dir . '/' . $filename;
    
    // Download image
    $image_data = @file_get_contents($url);
    if ($image_data === false) {
        echo "Failed to download image for $item_name from $url\n";
        continue;
    }
    
    // Save image
    if (file_put_contents($filepath, $image_data) === false) {
        echo "Failed to save image for $item_name\n";
        continue;
    }
    
    // Update database
    $image_path = 'uploads/shop/' . $filename;
    $stmt = $mysqli->prepare("UPDATE shop_items SET image = ? WHERE name = ?");
    $stmt->bind_param("ss", $image_path, $item_name);
    if (!$stmt->execute()) {
        echo "Error updating item $item_name: " . $stmt->error . "\n";
    } else {
        echo "Updated $item_name with image\n";
    }
    $stmt->close();
}

// Update service images
$service_images = [
    'Character Rename' => 'https://wow.zamimg.com/images/wow/icons/large/inv_misc_note_01.jpg',
    'Appearance Customization' => 'https://wow.zamimg.com/images/wow/icons/large/inv_misc_mirror_01.jpg',
    'Race Change' => 'https://wow.zamimg.com/images/wow/icons/large/inv_misc_book_01.jpg',
    'Faction Change' => 'https://wow.zamimg.com/images/wow/icons/large/inv_banner_02.jpg',
    'Level Boost to Max' => 'https://wow.zamimg.com/images/wow/icons/large/inv_misc_experience.jpg',
    'Profession Boost (Max)' => 'https://wow.zamimg.com/images/wow/icons/large/inv_misc_wrench_01.jpg',
    'Gold Boost (100,000)' => 'https://wow.zamimg.com/images/wow/icons/large/inv_misc_coin_01.jpg',
];

foreach ($service_images as $service_name => $url) {
    $service_id = preg_replace('/[^a-z0-9]/i', '_', strtolower($service_name));
    $filename = 'service_' . $service_id . '.jpg';
    $filepath = $uploads_dir . '/' . $filename;
    
    // Download image
    $image_data = @file_get_contents($url);
    if ($image_data === false) {
        echo "Failed to download image for $service_name from $url\n";
        continue;
    }
    
    // Save image
    if (file_put_contents($filepath, $image_data) === false) {
        echo "Failed to save image for $service_name\n";
        continue;
    }
    
    // Update database
    $image_path = 'uploads/shop/' . $filename;
    $stmt = $mysqli->prepare("UPDATE shop_services SET image = ? WHERE name = ?");
    $stmt->bind_param("ss", $image_path, $service_name);
    if (!$stmt->execute()) {
        echo "Error updating service $service_name: " . $stmt->error . "\n";
    } else {
        echo "Updated $service_name with image\n";
    }
    $stmt->close();
}

// Update subscription images
$subscription_images = [
    'VIP Bronze (Monthly)' => 'https://wow.zamimg.com/images/wow/icons/large/inv_jewelry_ring_01.jpg',
    'VIP Silver (Monthly)' => 'https://wow.zamimg.com/images/wow/icons/large/inv_jewelry_ring_02.jpg',
    'VIP Gold (Monthly)' => 'https://wow.zamimg.com/images/wow/icons/large/inv_jewelry_ring_03.jpg',
];

foreach ($subscription_images as $sub_name => $url) {
    $sub_id = preg_replace('/[^a-z0-9]/i', '_', strtolower($sub_name));
    $filename = 'subscription_' . $sub_id . '.jpg';
    $filepath = $uploads_dir . '/' . $filename;
    
    // Download image
    $image_data = @file_get_contents($url);
    if ($image_data === false) {
        echo "Failed to download image for $sub_name from $url\n";
        continue;
    }
    
    // Save image
    if (file_put_contents($filepath, $image_data) === false) {
        echo "Failed to save image for $sub_name\n";
        continue;
    }
    
    // Update database
    $image_path = 'uploads/shop/' . $filename;
    $stmt = $mysqli->prepare("UPDATE shop_subscriptions SET image = ? WHERE name = ?");
    $stmt->bind_param("ss", $image_path, $sub_name);
    if (!$stmt->execute()) {
        echo "Error updating subscription $sub_name: " . $stmt->error . "\n";
    } else {
        echo "Updated $sub_name with image\n";
    }
    $stmt->close();
}

echo "\nShop images added successfully!\n";
$mysqli->close();
?>
