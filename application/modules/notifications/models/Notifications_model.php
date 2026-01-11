<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications_model extends CI_Model
{
    public function create_notification($data)
    {
        $notification = [
            'user_id' => $data['user_id'],
            'type' => $data['type'],
            'title' => $data['title'],
            'message' => $data['message'] ?? null,
            'link' => $data['link'] ?? null,
            'icon' => $data['icon'] ?? $this->get_icon_for_type($data['type']),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        return $this->db->insert('notifications', $notification);
    }

    public function get_user_notifications($user_id, $limit = 20, $offset = 0)
    {
        return $this->db->where('user_id', $user_id)
            ->order_by('created_at', 'DESC')
            ->limit($limit, $offset)
            ->get('notifications')
            ->result();
    }

    public function get_unread_count($user_id)
    {
        return $this->db->where('user_id', $user_id)
            ->where('is_read', 0)
            ->count_all_results('notifications');
    }

    public function get_recent_unread($user_id, $limit = 5)
    {
        return $this->db->where('user_id', $user_id)
            ->where('is_read', 0)
            ->order_by('created_at', 'DESC')
            ->limit($limit)
            ->get('notifications')
            ->result();
    }

    public function mark_as_read($notification_id, $user_id)
    {
        return $this->db->where('id', $notification_id)
            ->where('user_id', $user_id)
            ->update('notifications', [
                'is_read' => 1,
                'read_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function mark_all_read($user_id)
    {
        return $this->db->where('user_id', $user_id)
            ->where('is_read', 0)
            ->update('notifications', [
                'is_read' => 1,
                'read_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function delete_notification($notification_id, $user_id)
    {
        return $this->db->where('id', $notification_id)
            ->where('user_id', $user_id)
            ->delete('notifications');
    }

    public function get_user_preferences($user_id)
    {
        $prefs = $this->db->where('user_id', $user_id)
            ->get('notification_preferences')
            ->row();

        if (!$prefs) {
            $this->db->insert('notification_preferences', ['user_id' => $user_id]);
            return $this->get_user_preferences($user_id);
        }

        return $prefs;
    }

    public function update_preferences($user_id, $preferences)
    {
        $existing = $this->db->where('user_id', $user_id)
            ->get('notification_preferences')
            ->row();

        $preferences['updated_at'] = date('Y-m-d H:i:s');

        if ($existing) {
            return $this->db->where('user_id', $user_id)
                ->update('notification_preferences', $preferences);
        } else {
            $preferences['user_id'] = $user_id;
            return $this->db->insert('notification_preferences', $preferences);
        }
    }

    public function get_all_settings()
    {
        $query = $this->db->get('notification_settings');
        $settings = [];
        
        foreach ($query->result() as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }
        
        return $settings;
    }

    public function update_setting($key, $value)
    {
        return $this->db->where('setting_key', $key)
            ->update('notification_settings', [
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function cleanup_old_notifications($days = 30)
    {
        $cutoff_date = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        
        return $this->db->where('created_at <', $cutoff_date)
            ->where('is_read', 1)
            ->delete('notifications');
    }

    public function get_statistics()
    {
        return [
            'total_sent' => $this->db->count_all('notifications'),
            'total_read' => $this->db->where('is_read', 1)->count_all_results('notifications'),
            'total_unread' => $this->db->where('is_read', 0)->count_all_results('notifications'),
            'users_with_notifications' => $this->db->distinct()->select('user_id')->count_all_results('notifications'),
        ];
    }

    protected function get_icon_for_type($type)
    {
        $icons = [
            'donation' => 'fa-coins',
            'shop' => 'fa-shopping-cart',
            'vote' => 'fa-thumbs-up',
            'news' => 'fa-newspaper',
            'event' => 'fa-calendar',
            'system' => 'fa-bell',
            'achievement' => 'fa-trophy',
            'message' => 'fa-envelope',
        ];

        return $icons[$type] ?? 'fa-bell';
    }

    public function send_bulk_notification($user_ids, $data)
    {
        $notifications = [];
        $timestamp = date('Y-m-d H:i:s');

        foreach ($user_ids as $user_id) {
            $notifications[] = [
                'user_id' => $user_id,
                'type' => $data['type'],
                'title' => $data['title'],
                'message' => $data['message'] ?? null,
                'link' => $data['link'] ?? null,
                'icon' => $data['icon'] ?? $this->get_icon_for_type($data['type']),
                'created_at' => $timestamp,
            ];
        }

        if (!empty($notifications)) {
            return $this->db->insert_batch('notifications', $notifications);
        }

        return false;
    }
}
