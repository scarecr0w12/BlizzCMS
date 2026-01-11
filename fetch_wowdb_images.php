<?php
$mysqli = new mysqli("dbserver", "blizzcms", "blizzcmspassword", "blizzcms");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$uploads_dir = '/var/www/html/uploads/shop';
if (!is_dir($uploads_dir)) {
    mkdir($uploads_dir, 0755, true);
}

// WoWDB image sources - using multiple fallback sources
function get_item_image_url($item_id) {
    // Try multiple WoW image sources
    $sources = [
        "https://wow.zamimg.com/images/wow/icons/large/{$item_id}.jpg",
        "https://render.worldofwarcraft.com/us/item/{$item_id}/128x128.jpg",
        "https://wow.tools/dbc/api/item/{$item_id}",
    ];
    return $sources;
}

$context = stream_context_create([
    'http' => [
        'timeout' => 15,
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ]
]);

// Fetch and update item images
$result = $mysqli->query('SELECT id, name, item_id FROM shop_items WHERE item_id > 0');

while ($row = $result->fetch_assoc()) {
    $item_id = $row['item_id'];
    $filename = preg_replace('/[^a-z0-9]/i', '_', strtolower($row['name'])) . '.jpg';
    $filepath = $uploads_dir . '/' . $filename;
    
    $sources = get_item_image_url($item_id);
    $downloaded = false;
    
    foreach ($sources as $url) {
        $image_data = @file_get_contents($url, false, $context);
        
        if ($image_data !== false && strlen($image_data) > 500) {
            if (file_put_contents($filepath, $image_data) !== false) {
                echo "✓ Downloaded image for: " . $row['name'] . " (ID: $item_id) from $url\n";
                $downloaded = true;
                break;
            }
        }
    }
    
    if (!$downloaded) {
        echo "✗ Failed to download image for: " . $row['name'] . " (ID: $item_id)\n";
    }
}

echo "\nImage fetch complete!\n";
$mysqli->close();
?>
