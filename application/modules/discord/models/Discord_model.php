<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discord_model extends CI_Model
{
    public function get_all_settings()
    {
        $query = $this->db->get('discord_settings');
        $settings = [];
        
        foreach ($query->result() as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }
        
        return $settings;
    }

    public function get_setting($key)
    {
        $query = $this->db->where('setting_key', $key)->get('discord_settings');
        $row = $query->row();
        
        return $row ? $row->setting_value : null;
    }

    public function update_setting($key, $value)
    {
        $data = [
            'setting_value' => $value,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        return $this->db->where('setting_key', $key)
            ->update('discord_settings', $data);
    }

    public function get_user_link($user_id)
    {
        return $this->db->where('user_id', $user_id)
            ->get('discord_users')
            ->row();
    }

    public function get_user_by_discord_id($discord_id)
    {
        return $this->db->where('discord_id', $discord_id)
            ->get('discord_users')
            ->row();
    }

    public function link_account($data)
    {
        $existing = $this->get_user_link($data['user_id']);
        
        if ($existing) {
            return $this->db->where('user_id', $data['user_id'])
                ->update('discord_users', array_merge($data, [
                    'updated_at' => date('Y-m-d H:i:s')
                ]));
        } else {
            return $this->db->insert('discord_users', array_merge($data, [
                'linked_at' => date('Y-m-d H:i:s')
            ]));
        }
    }

    public function unlink_account($user_id)
    {
        return $this->db->where('user_id', $user_id)
            ->delete('discord_users');
    }

    public function get_all_webhooks()
    {
        return $this->db->get('discord_webhooks')->result();
    }

    public function get_webhook($id)
    {
        return $this->db->where('id', $id)
            ->get('discord_webhooks')
            ->row();
    }

    public function get_webhooks_by_event($event_type)
    {
        return $this->db->where('event_type', $event_type)
            ->where('enabled', 1)
            ->get('discord_webhooks')
            ->result();
    }

    public function add_webhook($data)
    {
        return $this->db->insert('discord_webhooks', array_merge($data, [
            'created_at' => date('Y-m-d H:i:s')
        ]));
    }

    public function update_webhook($id, $data)
    {
        return $this->db->where('id', $id)
            ->update('discord_webhooks', $data);
    }

    public function delete_webhook($id)
    {
        return $this->db->where('id', $id)
            ->delete('discord_webhooks');
    }

    public function get_linked_users_count()
    {
        return $this->db->count_all('discord_users');
    }

    public function get_recent_links($limit = 10)
    {
        return $this->db->order_by('linked_at', 'DESC')
            ->limit($limit)
            ->get('discord_users')
            ->result();
    }
}
