<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_item_quality_color')) {
    function get_item_quality_color($quality)
    {
        $colors = [
            0 => '#9d9d9d',
            1 => '#ffffff',
            2 => '#1eff00',
            3 => '#0070dd',
            4 => '#a335ee',
            5 => '#ff8000',
            6 => '#e6cc80',
            7 => '#e6cc80',
        ];
        return isset($colors[$quality]) ? $colors[$quality] : '#9d9d9d';
    }
}

if (!function_exists('get_item_quality_name')) {
    function get_item_quality_name($quality)
    {
        $names = [
            0 => 'Poor',
            1 => 'Common',
            2 => 'Uncommon',
            3 => 'Rare',
            4 => 'Epic',
            5 => 'Legendary',
            6 => 'Artifact',
            7 => 'Heirloom',
        ];
        return isset($names[$quality]) ? $names[$quality] : 'Unknown';
    }
}

if (!function_exists('get_creature_rank_name')) {
    function get_creature_rank_name($rank)
    {
        $names = [
            0 => 'Normal',
            1 => 'Elite',
            2 => 'Rare Elite',
            3 => 'Boss',
            4 => 'Rare Boss',
        ];
        return isset($names[$rank]) ? $names[$rank] : 'Unknown';
    }
}

if (!function_exists('get_creature_type_name')) {
    function get_creature_type_name($type)
    {
        $names = [
            1 => 'Beast',
            2 => 'Dragonkin',
            3 => 'Demon',
            4 => 'Elemental',
            5 => 'Giant',
            6 => 'Undead',
            7 => 'Humanoid',
            8 => 'Critter',
            9 => 'Mechanical',
            10 => 'Gas Cloud',
        ];
        return isset($names[$type]) ? $names[$type] : 'Unknown';
    }
}

if (!function_exists('get_spell_school_name')) {
    function get_spell_school_name($school)
    {
        $names = [
            0 => 'Physical',
            1 => 'Holy',
            2 => 'Fire',
            3 => 'Nature',
            4 => 'Frost',
            5 => 'Shadow',
            6 => 'Arcane',
        ];
        return isset($names[$school]) ? $names[$school] : 'Unknown';
    }
}

if (!function_exists('get_quest_type_name')) {
    function get_quest_type_name($type)
    {
        $names = [
            0 => 'Normal',
            1 => 'Group',
            21 => 'Raid',
            41 => 'Dungeon',
            62 => 'World Event',
            81 => 'Legendary',
            82 => 'Escort',
            83 => 'Heroic',
            84 => 'Raid (10)',
            85 => 'Raid (25)',
        ];
        return isset($names[$type]) ? $names[$type] : 'Unknown';
    }
}

if (!function_exists('format_item_name')) {
    function format_item_name($item, $show_color = true)
    {
        $quality_color = get_item_quality_color($item->quality);
        $quality_name = get_item_quality_name($item->quality);
        
        if ($show_color) {
            return '<span style="color: ' . $quality_color . '" title="' . $quality_name . '">' . htmlspecialchars($item->name) . '</span>';
        }
        return htmlspecialchars($item->name);
    }
}

if (!function_exists('format_creature_name')) {
    function format_creature_name($creature)
    {
        $rank_name = get_creature_rank_name($creature->rank);
        $type_name = get_creature_type_name($creature->type);
        
        return htmlspecialchars($creature->name) . ' <small class="text-muted">(' . $type_name . ' - ' . $rank_name . ')</small>';
    }
}

if (!function_exists('get_database_viewer_enabled')) {
    function get_database_viewer_enabled()
    {
        $CI = &get_instance();
        $CI->load->model('database_viewer_model');
        return (bool) $CI->database_viewer_model->get_setting('database_viewer_enabled', 1);
    }
}

if (!function_exists('get_database_viewer_setting')) {
    function get_database_viewer_setting($key, $default = null)
    {
        $CI = &get_instance();
        $CI->load->model('database_viewer_model');
        return $CI->database_viewer_model->get_setting($key, $default);
    }
}
