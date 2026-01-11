<?php
/**
 * BlizzCMS Shop Helper
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Get WoW item image URL from WoWDB or local storage
 *
 * @param object $item Shop item object
 * @return string Image URL
 */
function get_item_image($item)
{
    // Use local image if available
    if (!empty($item->image)) {
        return '/uploads/shop/' . $item->image;
    }
    
    // Fallback to placeholder
    return '/assets/img/item-placeholder.png';
}

/**
 * Get service icon based on service type
 *
 * @param object $service Shop service object
 * @return string Font Awesome icon class
 */
function get_service_icon($service)
{
    $icons = [
        'character_rename' => 'fa-solid fa-pen',
        'appearance' => 'fa-solid fa-wand-magic-sparkles',
        'race_change' => 'fa-solid fa-person',
        'faction_change' => 'fa-solid fa-shield',
        'level_boost' => 'fa-solid fa-arrow-up',
        'profession_boost' => 'fa-solid fa-hammer',
        'gold_boost' => 'fa-solid fa-coins',
    ];
    
    $service_slug = strtolower(str_replace(' ', '_', $service->name));
    
    foreach ($icons as $key => $icon) {
        if (strpos($service_slug, $key) !== false) {
            return $icon;
        }
    }
    
    return 'fa-solid fa-gear';
}

/**
 * Get subscription tier icon
 *
 * @param object $subscription Shop subscription object
 * @return string Font Awesome icon class with color
 */
function get_subscription_icon($subscription)
{
    $name = strtolower($subscription->name);
    
    if (strpos($name, 'gold') !== false) {
        return '<i class="fa-solid fa-crown fa-3x" style="color: gold;"></i>';
    } elseif (strpos($name, 'silver') !== false) {
        return '<i class="fa-solid fa-crown fa-3x" style="color: silver;"></i>';
    } elseif (strpos($name, 'bronze') !== false) {
        return '<i class="fa-solid fa-crown fa-3x" style="color: #cd7f32;"></i>';
    }
    
    return '<i class="fa-solid fa-crown fa-3x" style="color: gold;"></i>';
}
?>
