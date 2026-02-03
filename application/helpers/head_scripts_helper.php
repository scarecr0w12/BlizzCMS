<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('add_head_script')) {
    function add_head_script($key, $config = [])
    {
        $CI = &get_instance();
        $CI->load->library('head_scripts_manager');
        return $CI->head_scripts_manager->add_script($key, $config);
    }
}

if (!function_exists('add_head_tag')) {
    function add_head_tag($key, $config = [])
    {
        $CI = &get_instance();
        $CI->load->library('head_scripts_manager');
        return $CI->head_scripts_manager->add_tag($key, $config);
    }
}

if (!function_exists('add_head_analytics')) {
    function add_head_analytics($key, $config = [])
    {
        $CI = &get_instance();
        $CI->load->library('head_scripts_manager');
        return $CI->head_scripts_manager->add_analytics($key, $config);
    }
}

if (!function_exists('remove_head_script')) {
    function remove_head_script($key)
    {
        $CI = &get_instance();
        $CI->load->library('head_scripts_manager');
        return $CI->head_scripts_manager->remove_script($key);
    }
}

if (!function_exists('remove_head_tag')) {
    function remove_head_tag($key)
    {
        $CI = &get_instance();
        $CI->load->library('head_scripts_manager');
        return $CI->head_scripts_manager->remove_tag($key);
    }
}

if (!function_exists('remove_head_analytics')) {
    function remove_head_analytics($key)
    {
        $CI = &get_instance();
        $CI->load->library('head_scripts_manager');
        return $CI->head_scripts_manager->remove_analytics($key);
    }
}

if (!function_exists('render_head_scripts')) {
    function render_head_scripts()
    {
        $CI = &get_instance();
        $CI->load->library('head_scripts_manager');
        return $CI->head_scripts_manager->render();
    }
}
