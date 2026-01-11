<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Social_model extends CI_Model
{
    // Friends management
    public function add_friend($user_id, $friend_id)
    {
        if ($user_id === $friend_id) {
            return false;
        }

        $existing = $this->db->where('user_id', $user_id)
            ->where('friend_id', $friend_id)
            ->get('user_friends')
            ->row();

        if ($existing) {
            return false;
        }

        return $this->db->insert('user_friends', [
            'user_id' => $user_id,
            'friend_id' => $friend_id,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function get_friends($user_id)
    {
        return $this->db->select('users.id, users.username, user_friends.status')
            ->from('user_friends')
            ->join('users', 'user_friends.friend_id = users.id', 'inner')
            ->where('user_friends.user_id', $user_id)
            ->where('user_friends.status', 'accepted')
            ->get()
            ->result();
    }

    public function get_friend_requests($user_id)
    {
        return $this->db->select('users.id, users.username, user_friends.created_at')
            ->from('user_friends')
            ->join('users', 'user_friends.user_id = users.id', 'inner')
            ->where('user_friends.friend_id', $user_id)
            ->where('user_friends.status', 'pending')
            ->get()
            ->result();
    }

    public function accept_friend($user_id, $friend_id)
    {
        return $this->db->where('user_id', $friend_id)
            ->where('friend_id', $user_id)
            ->update('user_friends', ['status' => 'accepted']);
    }

    public function remove_friend($user_id, $friend_id)
    {
        $this->db->where('user_id', $user_id)->where('friend_id', $friend_id)->delete('user_friends');
        return $this->db->where('user_id', $friend_id)->where('friend_id', $user_id)->delete('user_friends');
    }

    // Messaging
    public function send_message($from_id, $to_id, $subject, $message)
    {
        return $this->db->insert('user_messages', [
            'from_id' => $from_id,
            'to_id' => $to_id,
            'subject' => $subject,
            'message' => $message,
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function get_messages($user_id, $limit = 20, $offset = 0)
    {
        return $this->db->select('user_messages.*, users.username as from_username')
            ->from('user_messages')
            ->join('users', 'user_messages.from_id = users.id', 'left')
            ->where('user_messages.to_id', $user_id)
            ->order_by('user_messages.created_at', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    public function get_unread_count($user_id)
    {
        return $this->db->where('to_id', $user_id)
            ->where('is_read', 0)
            ->count_all_results('user_messages');
    }

    public function mark_message_read($message_id, $user_id)
    {
        return $this->db->where('id', $message_id)
            ->where('to_id', $user_id)
            ->update('user_messages', ['is_read' => 1]);
    }

    // Guild features
    public function get_guild($guild_id)
    {
        return $this->db->where('guildid', $guild_id)->get('guild')->row();
    }

    public function get_guild_members($guild_id)
    {
        return $this->db->select('characters.*, guild_member.rank')
            ->from('guild_member')
            ->join('characters', 'guild_member.guid = characters.guid', 'inner')
            ->where('guild_member.guildid', $guild_id)
            ->order_by('guild_member.rank', 'ASC')
            ->get()
            ->result();
    }

    public function get_top_guilds($limit = 10)
    {
        return $this->db->select('guild.*, COUNT(guild_member.guid) as member_count')
            ->from('guild')
            ->join('guild_member', 'guild.guildid = guild_member.guildid', 'left')
            ->group_by('guild.guildid')
            ->order_by('member_count', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    // Social feed
    public function get_social_feed($user_id, $limit = 20, $offset = 0)
    {
        return $this->db->select('user_activities.*, users.username')
            ->from('user_activities')
            ->join('users', 'user_activities.user_id = users.id', 'left')
            ->join('user_friends', 'user_activities.user_id = user_friends.friend_id', 'left')
            ->where('user_friends.user_id', $user_id)
            ->where('user_friends.status', 'accepted')
            ->where('user_activities.is_public', 1)
            ->order_by('user_activities.created_at', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    public function get_all_settings()
    {
        $query = $this->db->get('social_settings');
        $settings = [];
        
        foreach ($query->result() as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }
        
        return $settings;
    }

    public function update_setting($key, $value)
    {
        return $this->db->where('setting_key', $key)
            ->update('social_settings', [
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }
}
