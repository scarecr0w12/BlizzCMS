<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics_model extends CI_Model
{
    public function get_user_metrics($days = 30)
    {
        return [
            'total_users' => $this->db->count_all('users'),
            'new_users' => 0,
            'active_users' => 0,
            'banned_users' => 0,
        ];
    }

    public function get_revenue_metrics($days = 30)
    {
        return [
            'total_revenue' => 0,
            'total_orders' => 0,
            'avg_order_value' => 0,
        ];
    }

    public function get_engagement_metrics($days = 30)
    {
        $date = date('Y-m-d', strtotime("-{$days} days"));
        
        return [
            'total_logins' => $this->db->where('created_at >', $date)->count_all_results('user_activities'),
            'avg_session_time' => $this->get_avg_session_time($date),
            'total_events' => $this->db->where('created_at >', $date)->count_all_results('events'),
            'event_attendance' => $this->db->where('created_at >', $date)->count_all_results('event_rsvps'),
        ];
    }

    public function get_server_metrics()
    {
        return [
            'total_characters' => 0,
            'online_players' => 0,
            'total_guilds' => 0,
            'avg_level' => 0,
        ];
    }

    public function get_daily_stats($days = 30)
    {
        $stats = [];
        
        for ($i = $days; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            
            $stats[] = [
                'date' => $date,
                'users' => 0,
                'logins' => 0,
                'revenue' => 0,
            ];
        }
        
        return $stats;
    }

    public function get_top_items($limit = 10)
    {
        return $this->db->select('shop_items.*, COUNT(shop_order_items.id) as sales')
            ->from('shop_items')
            ->join('shop_order_items', 'shop_items.id = shop_order_items.item_id', 'left')
            ->group_by('shop_items.id')
            ->order_by('sales', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    public function get_user_retention($days = 30)
    {
        return [
            'cohort_size' => 0,
            'retained' => 0,
            'retention_rate' => 0,
        ];
    }

    public function get_feature_usage()
    {
        return [
            'shop_users' => $this->db->select('DISTINCT user_id')->count_all_results('shop_orders'),
            'leaderboard_views' => $this->db->count_all('shop_item_views'),
            'event_participants' => $this->db->count_all('event_rsvps'),
            'profile_visits' => $this->db->count_all('profile_visits'),
            'notifications_sent' => $this->db->count_all('notifications'),
        ];
    }

    private function get_avg_session_time($date)
    {
        $result = $this->db->select_avg('session_duration')
            ->where('created_at >', $date)
            ->get('user_sessions')
            ->row();

        return $result->session_duration ?? 0;
    }

    public function log_event($event_type, $data = null)
    {
        return $this->db->insert('analytics_events', [
            'event_type' => $event_type,
            'event_data' => $data ? json_encode($data) : null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function get_all_settings()
    {
        $query = $this->db->get('analytics_settings');
        $settings = [];
        
        foreach ($query->result() as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }
        
        return $settings;
    }

    public function update_setting($key, $value)
    {
        return $this->db->where('setting_key', $key)
            ->update('analytics_settings', [
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }
}
