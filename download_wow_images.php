<?php
$mysqli = new mysqli("dbserver", "blizzcms", "blizzcmspassword", "blizzcms");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$uploads_dir = '/var/www/html/uploads/shop';
if (!is_dir($uploads_dir)) {
    mkdir($uploads_dir, 0755, true);
}

// WoW item icon URLs from multiple sources
$item_images = [
    // Mounts
    'Spectral Tiger' => 'https://render.worldofwarcraft.com/us/item/33225/128x128.jpg',
    'Swift Flying Carpet' => 'https://render.worldofwarcraft.com/us/item/32853/128x128.jpg',
    'Celestial Dragon' => 'https://render.worldofwarcraft.com/us/item/54810/128x128.jpg',
    // Pets
    'Ethereal Phoenix' => 'https://render.worldofwarcraft.com/us/item/32604/128x128.jpg',
    'Mechanical Owl' => 'https://render.worldofwarcraft.com/us/item/32825/128x128.jpg',
    // Consumables
    'Experience Boost Potion (7 Days)' => 'https://render.worldofwarcraft.com/us/item/40211/128x128.jpg',
    'Gold Pouch (50,000 Gold)' => 'https://render.worldofwarcraft.com/us/item/29434/128x128.jpg',
    'Reputation Token Bundle' => 'https://render.worldofwarcraft.com/us/item/47241/128x128.jpg',
    // Cosmetics
    'Transmog: Eternal Warrior Set' => 'https://render.worldofwarcraft.com/us/item/40107/128x128.jpg',
    'Transmog: Mystic Mage Robes' => 'https://render.worldofwarcraft.com/us/item/40109/128x128.jpg',
];

$service_images = [
    'Character Rename' => 'https://render.worldofwarcraft.com/us/item/6948/128x128.jpg',
    'Appearance Customization' => 'https://render.worldofwarcraft.com/us/item/6948/128x128.jpg',
    'Race Change' => 'https://render.worldofwarcraft.com/us/item/6948/128x128.jpg',
    'Faction Change' => 'https://render.worldofwarcraft.com/us/item/6948/128x128.jpg',
    'Level Boost to Max' => 'https://render.worldofwarcraft.com/us/item/40211/128x128.jpg',
    'Profession Boost (Max)' => 'https://render.worldofwarcraft.com/us/item/6948/128x128.jpg',
    'Gold Boost (100,000)' => 'https://render.worldofwarcraft.com/us/item/29434/128x128.jpg',
];

$subscription_images = [
    'VIP Bronze (Monthly)' => 'https://render.worldofwarcraft.com/us/item/32837/128x128.jpg',
    'VIP Silver (Monthly)' => 'https://render.worldofwarcraft.com/us/item/32837/128x128.jpg',
    'VIP Gold (Monthly)' => 'https://render.worldofwarcraft.com/us/item/32837/128x128.jpg',
];

$context = stream_context_create([
    'http' => [
        'timeout' => 10,
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
    ]
]);

// Download item images
foreach ($item_images as $item_name => $url) {
    $filename = preg_replace('/[^a-z0-9]/i', '_', strtolower($item_name)) . '.jpg';
    $filepath = $uploads_dir . '/' . $filename;
    
    $image_data = @file_get_contents($url, false, $context);
    if ($image_data === false || strlen($image_data) < 100) {
        echo "Failed to download: $item_name from $url\n";
        continue;
    }
    
    if (file_put_contents($filepath, $image_data) === false) {
        echo "Failed to save: $item_name\n";
        continue;
    }
    
    $image_path = 'uploads/shop/' . $filename;
    $stmt = $mysqli->prepare("UPDATE shop_items SET image = ? WHERE name = ?");
    $stmt->bind_param("ss", $image_path, $item_name);
    if ($stmt->execute()) {
        echo "✓ Updated $item_name\n";
    }
    $stmt->close();
}

// Download service images
foreach ($service_images as $service_name => $url) {
    $filename = preg_replace('/[^a-z0-9]/i', '_', strtolower($service_name)) . '.jpg';
    $filepath = $uploads_dir . '/' . $filename;
    
    $image_data = @file_get_contents($url, false, $context);
    if ($image_data === false || strlen($image_data) < 100) {
        echo "Failed to download: $service_name from $url\n";
        continue;
    }
    
    if (file_put_contents($filepath, $image_data) === false) {
        echo "Failed to save: $service_name\n";
        continue;
    }
    
    $image_path = 'uploads/shop/' . $filename;
    $stmt = $mysqli->prepare("UPDATE shop_services SET image = ? WHERE name = ?");
    $stmt->bind_param("ss", $image_path, $service_name);
    if ($stmt->execute()) {
        echo "✓ Updated $service_name\n";
    }
    $stmt->close();
}

// Download subscription images
foreach ($subscription_images as $sub_name => $url) {
    $filename = preg_replace('/[^a-z0-9]/i', '_', strtolower($sub_name)) . '.jpg';
    $filepath = $uploads_dir . '/' . $filename;
    
    $image_data = @file_get_contents($url, false, $context);
    if ($image_data === false || strlen($image_data) < 100) {
        echo "Failed to download: $sub_name from $url\n";
        continue;
    }
    
    if (file_put_contents($filepath, $image_data) === false) {
        echo "Failed to save: $sub_name\n";
        continue;
    }
    
    $image_path = 'uploads/shop/' . $filename;
    $stmt = $mysqli->prepare("UPDATE shop_subscriptions SET image = ? WHERE name = ?");
    $stmt->bind_param("ss", $image_path, $sub_name);
    if ($stmt->execute()) {
        echo "✓ Updated $sub_name\n";
    }
    $stmt->close();
}

echo "\nImage download complete!\n";
$mysqli->close();
?>
