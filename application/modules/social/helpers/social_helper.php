<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_unread_message_count')) {
    function get_unread_message_count($user_id = null)
    {
        $CI = &get_instance();
        
        if ($user_id === null) {
            $user_id = $CI->session->userdata('user_id');
        }
        
        if (!$user_id) {
            return 0;
        }
        
        $CI->load->model('social/Social_model');
        return $CI->Social_model->get_unread_count($user_id);
    }
}

if (!function_exists('get_friend_count')) {
    function get_friend_count($user_id = null)
    {
        $CI = &get_instance();
        
        if ($user_id === null) {
            $user_id = $CI->session->userdata('user_id');
        }
        
        if (!$user_id) {
            return 0;
        }
        
        $CI->load->model('social/Social_model');
        return $CI->Social_model->get_friend_count($user_id);
    }
}

if (!function_exists('get_pending_friend_requests')) {
    function get_pending_friend_requests($user_id = null)
    {
        $CI = &get_instance();
        
        if ($user_id === null) {
            $user_id = $CI->session->userdata('user_id');
        }
        
        if (!$user_id) {
            return 0;
        }
        
        $CI->load->model('social/Social_model');
        return $CI->Social_model->get_pending_requests_count($user_id);
    }
}

if (!function_exists('is_friend')) {
    function is_friend($user_id, $friend_id)
    {
        $CI = &get_instance();
        $CI->load->model('social/Social_model');
        return $CI->Social_model->is_friend($user_id, $friend_id);
    }
}

if (!function_exists('log_user_activity')) {
    function log_user_activity($user_id, $activity_type, $activity_description = '', $is_public = 1)
    {
        $CI = &get_instance();
        $CI->load->model('social/Social_model');
        return $CI->Social_model->log_activity($user_id, $activity_type, $activity_description, $is_public);
    }
}

if (!function_exists('get_social_settings')) {
    function get_social_settings()
    {
        $CI = &get_instance();
        $CI->load->model('social/Social_model');
        return $CI->Social_model->get_all_settings();
    }
}

if (!function_exists('is_social_feature_enabled')) {
    function is_social_feature_enabled($feature_key)
    {
        $CI = &get_instance();
        $CI->load->model('social/Social_model');
        $settings = $CI->Social_model->get_all_settings();
        return isset($settings[$feature_key]) && $settings[$feature_key] == '1';
    }
}
