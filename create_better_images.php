<?php
$mysqli = new mysqli("dbserver", "blizzcms", "blizzcmspassword", "blizzcms");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$uploads_dir = '/var/www/html/uploads/shop';
if (!is_dir($uploads_dir)) {
    mkdir($uploads_dir, 0755, true);
}

function createItemImage($text, $icon_char, $colors) {
    $width = 256;
    $height = 256;
    
    $image = imagecreatetruecolor($width, $height);
    
    // Create gradient background
    $top_color = imagecolorallocate($image, $colors['top'][0], $colors['top'][1], $colors['top'][2]);
    $bottom_color = imagecolorallocate($image, $colors['bottom'][0], $colors['bottom'][1], $colors['bottom'][2]);
    
    // Draw gradient
    for ($y = 0; $y < $height; $y++) {
        $ratio = $y / $height;
        $r = (int)($colors['top'][0] * (1 - $ratio) + $colors['bottom'][0] * $ratio);
        $g = (int)($colors['top'][1] * (1 - $ratio) + $colors['bottom'][1] * $ratio);
        $b = (int)($colors['top'][2] * (1 - $ratio) + $colors['bottom'][2] * $ratio);
        $color = imagecolorallocate($image, $r, $g, $b);
        imageline($image, 0, $y, $width, $y, $color);
    }
    
    // Add border
    $border_color = imagecolorallocate($image, 100, 100, 100);
    imagerectangle($image, 0, 0, $width - 1, $height - 1, $border_color);
    imagerectangle($image, 1, 1, $width - 2, $height - 2, $border_color);
    
    // Add center icon/symbol
    $white = imagecolorallocate($image, 255, 255, 255);
    $fontFile = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf';
    
    // Try to add icon if font available
    if (file_exists($fontFile)) {
        imagettftext($image, 80, 0, $width/2 - 40, $height/2 + 20, $white, $fontFile, $icon_char);
    }
    
    // Add text at bottom
    $text_lines = str_split($text, 20);
    $line_height = 16;
    $start_y = $height - 50;
    
    foreach ($text_lines as $i => $line) {
        $y = $start_y + ($i * $line_height);
        if (file_exists($fontFile)) {
            imagettftext($image, 10, 0, 10, $y, $white, $fontFile, $line);
        }
    }
    
    return $image;
}

$items = [
    ['name' => 'Spectral Tiger', 'icon' => '🐯', 'colors' => ['top' => [180, 100, 200], 'bottom' => [100, 50, 150]]],
    ['name' => 'Swift Flying Carpet', 'icon' => '✈', 'colors' => ['top' => [200, 150, 100], 'bottom' => [150, 100, 50]]],
    ['name' => 'Celestial Dragon', 'icon' => '🐉', 'colors' => ['top' => [100, 180, 220], 'bottom' => [50, 130, 200]]],
    ['name' => 'Ethereal Phoenix', 'icon' => '🔥', 'colors' => ['top' => [220, 150, 100], 'bottom' => [200, 80, 20]]],
    ['name' => 'Mechanical Owl', 'icon' => '⚙', 'colors' => ['top' => [150, 150, 150], 'bottom' => [100, 100, 100]]],
    ['name' => 'Experience Boost Potion (7 Days)', 'icon' => '⚡', 'colors' => ['top' => [100, 200, 100], 'bottom' => [50, 150, 50]]],
    ['name' => 'Gold Pouch (50,000 Gold)', 'icon' => '💰', 'colors' => ['top' => [220, 200, 100], 'bottom' => [200, 180, 50]]],
    ['name' => 'Reputation Token Bundle', 'icon' => '★', 'colors' => ['top' => [200, 100, 100], 'bottom' => [150, 50, 50]]],
    ['name' => 'Transmog: Eternal Warrior Set', 'icon' => '⚔', 'colors' => ['top' => [180, 100, 100], 'bottom' => [130, 50, 50]]],
    ['name' => 'Transmog: Mystic Mage Robes', 'icon' => '✨', 'colors' => ['top' => [150, 100, 200], 'bottom' => [100, 50, 150]]],
];

foreach ($items as $item) {
    $filename = preg_replace('/[^a-z0-9]/i', '_', strtolower($item['name'])) . '.jpg';
    $filepath = $uploads_dir . '/' . $filename;
    
    $image = createItemImage($item['name'], $item['icon'], $item['colors']);
    imagejpeg($image, $filepath, 85);
    imagedestroy($image);
    
    $image_path = $filename;
    $stmt = $mysqli->prepare("UPDATE shop_items SET image = ? WHERE name = ?");
    $stmt->bind_param("ss", $image_path, $item['name']);
    if ($stmt->execute()) {
        echo "✓ Created image for: " . $item['name'] . "\n";
    }
    $stmt->close();
}

$services = [
    ['name' => 'Character Rename', 'icon' => '✏', 'colors' => ['top' => [150, 150, 200], 'bottom' => [100, 100, 150]]],
    ['name' => 'Appearance Customization', 'icon' => '💄', 'colors' => ['top' => [200, 150, 150], 'bottom' => [150, 100, 100]]],
    ['name' => 'Race Change', 'icon' => '👤', 'colors' => ['top' => [150, 200, 150], 'bottom' => [100, 150, 100]]],
    ['name' => 'Faction Change', 'icon' => '⚔', 'colors' => ['top' => [200, 150, 200], 'bottom' => [150, 100, 150]]],
    ['name' => 'Level Boost to Max', 'icon' => '⬆', 'colors' => ['top' => [220, 180, 100], 'bottom' => [200, 150, 50]]],
    ['name' => 'Profession Boost (Max)', 'icon' => '🔧', 'colors' => ['top' => [180, 150, 100], 'bottom' => [150, 120, 70]]],
    ['name' => 'Gold Boost (100,000)', 'icon' => '💎', 'colors' => ['top' => [220, 200, 100], 'bottom' => [200, 180, 50]]],
];

foreach ($services as $service) {
    $filename = preg_replace('/[^a-z0-9]/i', '_', strtolower($service['name'])) . '.jpg';
    $filepath = $uploads_dir . '/' . $filename;
    
    $image = createItemImage($service['name'], $service['icon'], $service['colors']);
    imagejpeg($image, $filepath, 85);
    imagedestroy($image);
    
    $image_path = $filename;
    $stmt = $mysqli->prepare("UPDATE shop_services SET image = ? WHERE name = ?");
    $stmt->bind_param("ss", $image_path, $service['name']);
    if ($stmt->execute()) {
        echo "✓ Created image for: " . $service['name'] . "\n";
    }
    $stmt->close();
}

$subscriptions = [
    ['name' => 'VIP Bronze (Monthly)', 'icon' => '👑', 'colors' => ['top' => [180, 140, 100], 'bottom' => [150, 110, 70]]],
    ['name' => 'VIP Silver (Monthly)', 'icon' => '👑', 'colors' => ['top' => [200, 200, 200], 'bottom' => [170, 170, 170]]],
    ['name' => 'VIP Gold (Monthly)', 'icon' => '👑', 'colors' => ['top' => [220, 200, 100], 'bottom' => [200, 180, 50]]],
];

foreach ($subscriptions as $sub) {
    $filename = preg_replace('/[^a-z0-9]/i', '_', strtolower($sub['name'])) . '.jpg';
    $filepath = $uploads_dir . '/' . $filename;
    
    $image = createItemImage($sub['name'], $sub['icon'], $sub['colors']);
    imagejpeg($image, $filepath, 85);
    imagedestroy($image);
    
    $image_path = $filename;
    $stmt = $mysqli->prepare("UPDATE shop_subscriptions SET image = ? WHERE name = ?");
    $stmt->bind_param("ss", $image_path, $sub['name']);
    if ($stmt->execute()) {
        echo "✓ Created image for: " . $sub['name'] . "\n";
    }
    $stmt->close();
}

echo "\nAll shop images created successfully!\n";
$mysqli->close();
?>
