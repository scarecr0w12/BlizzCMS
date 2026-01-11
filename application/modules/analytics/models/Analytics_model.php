<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics_model extends CI_Model
{
    public function get_user_metrics($days = 30)
    {
        $date = date('Y-m-d', strtotime("-{$days} days"));
        
        return [
            'total_users' => $this->db->count_all('users'),
            'new_users' => $this->db->where('created >', $date)->count_all_results('users'),
            'active_users' => $this->db->where('last_login >', $date)->count_all_results('users'),
            'banned_users' => $this->db->where('banned', 1)->count_all_results('users'),
        ];
    }

    public function get_revenue_metrics($days = 30)
    {
        $date = date('Y-m-d', strtotime("-{$days} days"));
        
        $result = $this->db->select_sum('total')
            ->where('created_at >', $date)
            ->where('status', 'completed')
            ->get('shop_orders')
            ->row();

        return [
            'total_revenue' => $result->total ?? 0,
            'total_orders' => $this->db->where('created_at >', $date)->count_all_results('shop_orders'),
            'avg_order_value' => $result->total ? ($result->total / $this->db->where('created_at >', $date)->count_all_results('shop_orders')) : 0,
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
            'total_characters' => $this->db->count_all('characters'),
            'online_players' => $this->db->where('online', 1)->count_all_results('characters'),
            'total_guilds' => $this->db->count_all('guild'),
            'avg_level' => $this->db->select_avg('level')->get('characters')->row()->level ?? 0,
        ];
    }

    public function get_daily_stats($days = 30)
    {
        $stats = [];
        
        for ($i = $days; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            
            $stats[] = [
                'date' => $date,
                'users' => $this->db->where('DATE(created)', $date)->count_all_results('users'),
                'logins' => $this->db->where('DATE(created_at)', $date)->count_all_results('user_activities'),
                'revenue' => $this->db->select_sum('total')
                    ->where('DATE(created_at)', $date)
                    ->where('status', 'completed')
                    ->get('shop_orders')
                    ->row()->total ?? 0,
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
        $cohort_date = date('Y-m-d', strtotime("-{$days} days"));
        
        $cohort_users = $this->db->where('created >', $cohort_date)->count_all_results('users');
        $retained_users = $this->db->where('created >', $cohort_date)
            ->where('last_login >', $cohort_date)
            ->count_all_results('users');

        return [
            'cohort_size' => $cohort_users,
            'retained' => $retained_users,
            'retention_rate' => $cohort_users > 0 ? round(($retained_users / $cohort_users) * 100, 2) : 0,
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
