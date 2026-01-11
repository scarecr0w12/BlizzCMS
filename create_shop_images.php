<?php
$mysqli = new mysqli("dbserver", "blizzcms", "blizzcmspassword", "blizzcms");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$uploads_dir = '/var/www/html/uploads/shop';
if (!is_dir($uploads_dir)) {
    mkdir($uploads_dir, 0755, true);
}

function createPlaceholderImage($text, $color = [100, 150, 200]) {
    $width = 256;
    $height = 256;
    
    $image = imagecreatetruecolor($width, $height);
    
    // Create gradient background
    $bgColor = imagecolorallocate($image, $color[0], $color[1], $color[2]);
    imagefill($image, 0, 0, $bgColor);
    
    // Add border
    $borderColor = imagecolorallocate($image, $color[0] - 30, $color[1] - 30, $color[2] - 30);
    imagerectangle($image, 0, 0, $width - 1, $height - 1, $borderColor);
    
    // Add text
    $textColor = imagecolorallocate($image, 255, 255, 255);
    $fontFile = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf';
    
    // Wrap text
    $words = explode(' ', $text);
    $lines = [];
    $currentLine = '';
    
    foreach ($words as $word) {
        if (strlen($currentLine . ' ' . $word) > 20) {
            if ($currentLine) $lines[] = $currentLine;
            $currentLine = $word;
        } else {
            $currentLine = $currentLine ? $currentLine . ' ' . $word : $word;
        }
    }
    if ($currentLine) $lines[] = $currentLine;
    
    // Center text vertically and horizontally
    $lineHeight = 20;
    $totalHeight = count($lines) * $lineHeight;
    $startY = ($height - $totalHeight) / 2;
    
    foreach ($lines as $i => $line) {
        $bbox = imagettfbbox(14, 0, $fontFile, $line);
        $textWidth = $bbox[2] - $bbox[0];
        $x = ($width - $textWidth) / 2;
        $y = $startY + ($i * $lineHeight) + 15;
        imagettftext($image, 14, 0, $x, $y, $textColor, $fontFile, $line);
    }
    
    return $image;
}

$items = [
    // Mounts
    ['name' => 'Spectral Tiger', 'color' => [180, 100, 200]],
    ['name' => 'Swift Flying Carpet', 'color' => [200, 150, 100]],
    ['name' => 'Celestial Dragon', 'color' => [100, 180, 220]],
    // Pets
    ['name' => 'Ethereal Phoenix', 'color' => [220, 150, 100]],
    ['name' => 'Mechanical Owl', 'color' => [150, 150, 150]],
    // Consumables
    ['name' => 'Experience Boost Potion (7 Days)', 'color' => [100, 200, 100]],
    ['name' => 'Gold Pouch (50,000 Gold)', 'color' => [220, 200, 100]],
    ['name' => 'Reputation Token Bundle', 'color' => [200, 100, 100]],
    // Cosmetics
    ['name' => 'Transmog: Eternal Warrior Set', 'color' => [180, 100, 100]],
    ['name' => 'Transmog: Mystic Mage Robes', 'color' => [150, 100, 200]],
];

foreach ($items as $item) {
    $filename = preg_replace('/[^a-z0-9]/i', '_', strtolower($item['name'])) . '.png';
    $filepath = $uploads_dir . '/' . $filename;
    
    $image = createPlaceholderImage($item['name'], $item['color']);
    imagepng($image, $filepath);
    imagedestroy($image);
    
    $image_path = 'uploads/shop/' . $filename;
    $stmt = $mysqli->prepare("UPDATE shop_items SET image = ? WHERE name = ?");
    $stmt->bind_param("ss", $image_path, $item['name']);
    if ($stmt->execute()) {
        echo "Created image for: " . $item['name'] . "\n";
    }
    $stmt->close();
}

$services = [
    ['name' => 'Character Rename', 'color' => [150, 150, 200]],
    ['name' => 'Appearance Customization', 'color' => [200, 150, 150]],
    ['name' => 'Race Change', 'color' => [150, 200, 150]],
    ['name' => 'Faction Change', 'color' => [200, 150, 200]],
    ['name' => 'Level Boost to Max', 'color' => [220, 180, 100]],
    ['name' => 'Profession Boost (Max)', 'color' => [180, 150, 100]],
    ['name' => 'Gold Boost (100,000)', 'color' => [220, 200, 100]],
];

foreach ($services as $service) {
    $filename = preg_replace('/[^a-z0-9]/i', '_', strtolower($service['name'])) . '.png';
    $filepath = $uploads_dir . '/' . $filename;
    
    $image = createPlaceholderImage($service['name'], $service['color']);
    imagepng($image, $filepath);
    imagedestroy($image);
    
    $image_path = 'uploads/shop/' . $filename;
    $stmt = $mysqli->prepare("UPDATE shop_services SET image = ? WHERE name = ?");
    $stmt->bind_param("ss", $image_path, $service['name']);
    if ($stmt->execute()) {
        echo "Created image for: " . $service['name'] . "\n";
    }
    $stmt->close();
}

$subscriptions = [
    ['name' => 'VIP Bronze (Monthly)', 'color' => [180, 140, 100]],
    ['name' => 'VIP Silver (Monthly)', 'color' => [200, 200, 200]],
    ['name' => 'VIP Gold (Monthly)', 'color' => [220, 200, 100]],
];

foreach ($subscriptions as $sub) {
    $filename = preg_replace('/[^a-z0-9]/i', '_', strtolower($sub['name'])) . '.png';
    $filepath = $uploads_dir . '/' . $filename;
    
    $image = createPlaceholderImage($sub['name'], $sub['color']);
    imagepng($image, $filepath);
    imagedestroy($image);
    
    $image_path = 'uploads/shop/' . $filename;
    $stmt = $mysqli->prepare("UPDATE shop_subscriptions SET image = ? WHERE name = ?");
    $stmt->bind_param("ss", $image_path, $sub['name']);
    if ($stmt->execute()) {
        echo "Created image for: " . $sub['name'] . "\n";
    }
    $stmt->close();
}

echo "\nAll shop images created successfully!\n";
$mysqli->close();
?>
