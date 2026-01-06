<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if (! function_exists('format_playtime'))
{
    /**
     * Format playtime seconds to human readable format
     *
     * @param int $seconds
     * @return string
     */
    function format_playtime($seconds)
    {
        if ($seconds < 60) {
            return $seconds . ' seconds';
        }

        $days = floor($seconds / 86400);
        $hours = floor(($seconds % 86400) / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        $parts = [];

        if ($days > 0) {
            $parts[] = $days . ' ' . ($days == 1 ? 'day' : 'days');
        }

        if ($hours > 0) {
            $parts[] = $hours . ' ' . ($hours == 1 ? 'hour' : 'hours');
        }

        if ($minutes > 0 && $days == 0) {
            $parts[] = $minutes . ' ' . ($minutes == 1 ? 'minute' : 'minutes');
        }

        return implode(', ', $parts);
    }
}

if (! function_exists('format_money'))
{
    /**
     * Format copper amount to gold/silver/copper
     *
     * @param int $copper
     * @return string
     */
    function format_money($copper)
    {
        $gold = floor($copper / 10000);
        $silver = floor(($copper % 10000) / 100);
        $copper_remaining = $copper % 100;

        $parts = [];

        if ($gold > 0) {
            $parts[] = '<span class="bc-gold">' . number_format($gold) . 'g</span>';
        }

        if ($silver > 0) {
            $parts[] = '<span class="bc-silver">' . $silver . 's</span>';
        }

        if ($copper_remaining > 0 || empty($parts)) {
            $parts[] = '<span class="bc-copper">' . $copper_remaining . 'c</span>';
        }

        return implode(' ', $parts);
    }
}

if (! function_exists('get_faction'))
{
    /**
     * Get faction name from race ID
     *
     * @param int $race
     * @return string
     */
    function get_faction($race)
    {
        $alliance_races = config_item('alliance_races') ?? [1, 3, 4, 7, 11, 22, 25, 29, 30, 32, 34, 37, 52];
        $horde_races = config_item('horde_races') ?? [2, 5, 6, 8, 9, 10, 26, 27, 28, 31, 35, 36, 70];

        if (in_array($race, $alliance_races)) {
            return 'alliance';
        }

        if (in_array($race, $horde_races)) {
            return 'horde';
        }

        return 'unknown';
    }
}

if (! function_exists('item_quality_class'))
{
    /**
     * Get CSS class for item quality
     *
     * @param int $quality
     * @return string
     */
    function item_quality_class($quality)
    {
        $classes = [
            0 => 'bc-quality-poor',      // Gray
            1 => 'bc-quality-common',    // White
            2 => 'bc-quality-uncommon',  // Green
            3 => 'bc-quality-rare',      // Blue
            4 => 'bc-quality-epic',      // Purple
            5 => 'bc-quality-legendary', // Orange
            6 => 'bc-quality-artifact',  // Gold
            7 => 'bc-quality-heirloom'   // Light Gold
        ];

        return $classes[$quality] ?? 'bc-quality-common';
    }
}
