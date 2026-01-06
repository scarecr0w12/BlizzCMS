<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if (! function_exists('class_name'))
{
    /**
     * Get a class name
     *
     * @param int $id
     * @return string
     */
    function class_name($id)
    {
        $wowLang = get_instance()->lang->load('wow', '', true);

        if (array_key_exists($id, $wowLang['classes'])) {
            return $wowLang['classes'][$id];
        }

        return lang('unknown');
    }
}

if (! function_exists('race_name'))
{
    /**
     * Get a race name
     *
     * @param int $id
     * @return string
     */
    function race_name($id)
    {
        $wowLang = get_instance()->lang->load('wow', '', true);

        if (array_key_exists($id, $wowLang['races'])) {
            return $wowLang['races'][$id];
        }

        return lang('unknown');
    }
}

if (! function_exists('faction_name'))
{
    /**
     * Get a faction name
     *
     * @param int|string $id
     * @return string
     */
    function faction_name($id)
    {
        if (in_array($id, config_item('alliance_races'))) {
            return lang('alliance');
        }

        if (in_array($id, config_item('horde_races'))) {
            return lang('horde');
        }

        return lang('unknown');
    }
}

if (! function_exists('zone_name'))
{
    /**
     * Get a zone name
     *
     * @param int $id
     * @return string
     */
    function zone_name($id)
    {
        $wowLang = get_instance()->lang->load('wow', '', true);

        if (array_key_exists($id, $wowLang['zones'])) {
            return $wowLang['zones'][$id];
        }

        return lang('unknown');
    }
}

if (! function_exists('format_playtime'))
{
    /**
     * Format playtime in seconds to human readable format
     *
     * @param int $seconds
     * @return string
     */
    function format_playtime($seconds)
    {
        if ($seconds <= 0) {
            return '0 minutes';
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

        return implode(', ', $parts) ?: '0 minutes';
    }
}
