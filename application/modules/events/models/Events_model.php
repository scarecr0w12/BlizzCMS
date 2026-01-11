<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events_model extends CI_Model
{
    public function get_upcoming_events($limit = 10, $offset = 0)
    {
        return $this->db->where('start_date >=', date('Y-m-d H:i:s'))
            ->order_by('start_date', 'ASC')
            ->limit($limit, $offset)
            ->get('events')
            ->result();
    }

    public function get_featured_events()
    {
        return $this->db->where('featured', 1)
            ->where('start_date >=', date('Y-m-d H:i:s'))
            ->order_by('start_date', 'ASC')
            ->limit(3)
            ->get('events')
            ->result();
    }

    public function get_event($event_id)
    {
        return $this->db->where('id', $event_id)->get('events')->row();
    }

    public function get_events_by_date_range($start, $end)
    {
        return $this->db->where('start_date >=', $start)
            ->where('start_date <=', $end)
            ->order_by('start_date', 'ASC')
            ->get('events')
            ->result();
    }

    public function get_events_by_type($type, $limit = 10)
    {
        return $this->db->where('event_type', $type)
            ->where('start_date >=', date('Y-m-d H:i:s'))
            ->order_by('start_date', 'ASC')
            ->limit($limit)
            ->get('events')
            ->result();
    }

    public function create_event($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('events', $data);
    }

    public function update_event($event_id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $event_id)->update('events', $data);
    }

    public function delete_event($event_id)
    {
        $this->db->where('event_id', $event_id)->delete('event_rsvps');
        return $this->db->where('id', $event_id)->delete('events');
    }

    public function get_rsvps($event_id)
    {
        return $this->db->where('event_id', $event_id)
            ->order_by('created_at', 'ASC')
            ->get('event_rsvps')
            ->result();
    }

    public function get_rsvp_count($event_id)
    {
        return $this->db->where('event_id', $event_id)
            ->where('status', 'attending')
            ->count_all_results('event_rsvps');
    }

    public function get_user_rsvp($event_id, $user_id)
    {
        return $this->db->where('event_id', $event_id)
            ->where('user_id', $user_id)
            ->get('event_rsvps')
            ->row();
    }

    public function create_rsvp($data)
    {
        $existing = $this->get_user_rsvp($data['event_id'], $data['user_id']);
        
        $data['created_at'] = date('Y-m-d H:i:s');
        
        if ($existing) {
            return $this->db->where('event_id', $data['event_id'])
                ->where('user_id', $data['user_id'])
                ->update('event_rsvps', $data);
        } else {
            return $this->db->insert('event_rsvps', $data);
        }
    }

    public function delete_rsvp($event_id, $user_id)
    {
        return $this->db->where('event_id', $event_id)
            ->where('user_id', $user_id)
            ->delete('event_rsvps');
    }

    public function get_user_events($user_id)
    {
        return $this->db->select('events.*, event_rsvps.status')
            ->from('events')
            ->join('event_rsvps', 'events.id = event_rsvps.event_id', 'inner')
            ->where('event_rsvps.user_id', $user_id)
            ->where('events.start_date >=', date('Y-m-d H:i:s'))
            ->order_by('events.start_date', 'ASC')
            ->get()
            ->result();
    }

    public function get_all_settings()
    {
        $query = $this->db->get('event_settings');
        $settings = [];
        
        foreach ($query->result() as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }
        
        return $settings;
    }

    public function update_setting($key, $value)
    {
        return $this->db->where('setting_key', $key)
            ->update('event_settings', [
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function get_statistics()
    {
        return [
            'total_events' => $this->db->count_all('events'),
            'upcoming_events' => $this->db->where('start_date >=', date('Y-m-d H:i:s'))->count_all_results('events'),
            'past_events' => $this->db->where('start_date <', date('Y-m-d H:i:s'))->count_all_results('events'),
            'total_rsvps' => $this->db->count_all('event_rsvps'),
        ];
    }

    public function search_events($query, $type = null, $limit = 50)
    {
        $this->db->like('title', $query);
        $this->db->or_like('description', $query);
        $this->db->where('start_date >=', date('Y-m-d H:i:s'));

        if ($type && $type !== 'all') {
            $this->db->where('event_type', $type);
        }

        return $this->db->order_by('start_date', 'ASC')
            ->limit($limit)
            ->get('events')
            ->result();
    }

    public function get_past_events($limit = 10, $offset = 0)
    {
        return $this->db->where('start_date <', date('Y-m-d H:i:s'))
            ->order_by('start_date', 'DESC')
            ->limit($limit, $offset)
            ->get('events')
            ->result();
    }

    public function get_events_by_realm($realm_id, $limit = 10, $offset = 0)
    {
        return $this->db->where('realm_id', $realm_id)
            ->where('start_date >=', date('Y-m-d H:i:s'))
            ->order_by('start_date', 'ASC')
            ->limit($limit, $offset)
            ->get('events')
            ->result();
    }

    public function get_rsvp_status_count($event_id)
    {
        $statuses = ['attending' => 0, 'tentative' => 0, 'declined' => 0];
        
        $query = $this->db->where('event_id', $event_id)
            ->group_by('status')
            ->select('status, COUNT(*) as count')
            ->get('event_rsvps');

        foreach ($query->result() as $row) {
            if (isset($statuses[$row->status])) {
                $statuses[$row->status] = $row->count;
            }
        }

        return $statuses;
    }

    public function get_event_attendees($event_id)
    {
        return $this->db->where('event_id', $event_id)
            ->where('status', 'attending')
            ->order_by('created_at', 'ASC')
            ->get('event_rsvps')
            ->result();
    }

    public function is_event_full($event_id)
    {
        $event = $this->get_event($event_id);
        
        if (!$event || !$event->max_participants) {
            return false;
        }

        $count = $this->get_rsvp_count($event_id);
        return $count >= $event->max_participants;
    }

    public function get_user_rsvp_status($event_id, $user_id)
    {
        $rsvp = $this->get_user_rsvp($event_id, $user_id);
        return $rsvp ? $rsvp->status : null;
    }

    public function get_events_by_creator($user_id, $limit = 10, $offset = 0)
    {
        return $this->db->where('created_by', $user_id)
            ->order_by('start_date', 'DESC')
            ->limit($limit, $offset)
            ->get('events')
            ->result();
    }

    public function get_setting($key, $default = null)
    {
        $query = $this->db->where('setting_key', $key)->get('event_settings');
        
        if ($query->num_rows() > 0) {
            return $query->row()->setting_value;
        }
        
        return $default;
    }
}
