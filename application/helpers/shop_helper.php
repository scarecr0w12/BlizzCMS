<?php
/**
 * BlizzCMS Shop Helper
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if (! function_exists('get_item_image_url'))
{
    /**
     * Get item image URL from AoWoW or fallback to local
     *
     * @param object $item
     * @return string
     */
    function get_item_image_url($item)
    {
        // Try to use AoWoW icon image if item has an icon_name
        if (! empty($item->icon_name)) {
            return 'https://aowow.oldmanwarcraft.com/static/images/wow/icons/large/' . $item->icon_name . '.jpg';
        }
        
        // Fallback to local image if available
        if (! empty($item->image)) {
            return base_url('uploads/shop/' . $item->image);
        }
        
        // Return placeholder
        return base_url('uploads/shop/placeholder.jpg');
    }
}

if (! function_exists('get_service_icon'))
{
    /**
     * Get service icon or default
     *
     * @param object $service
     * @return string
     */
    function get_service_icon($service)
    {
        if (! empty($service->icon)) {
            return $service->icon;
        }
        
        return 'fa-solid fa-wrench';
    }
}

if (! function_exists('get_subscription_icon'))
{
    /**
     * Get subscription icon or default
     *
     * @param object $subscription
     * @return string
     */
    function get_subscription_icon($subscription)
    {
        if (! empty($subscription->icon)) {
            return $subscription->icon;
        }
        
        return 'fa-solid fa-crown';
    }
}
