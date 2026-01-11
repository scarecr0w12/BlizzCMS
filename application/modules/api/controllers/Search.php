<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('api_response');
    }

    public function index()
    {
        $query = $this->input->get('q');
        $type = $this->input->get('type') ?: 'all';

        if (!$query || strlen($query) < 2) {
            return $this->api_response->error('Query must be at least 2 characters', 400);
        }

        $results = [];

        if ($type === 'all' || $type === 'events') {
            $results['events'] = $this->search_events($query);
        }

        if ($type === 'all' || $type === 'leaderboards') {
            $results['players'] = $this->search_players($query);
        }

        if ($type === 'all' || $type === 'profiles') {
            $results['profiles'] = $this->search_profiles($query);
        }

        if ($type === 'all' || $type === 'shop') {
            $results['items'] = $this->search_shop($query);
        }

        $this->api_response->success($results);
    }

    private function search_events($query)
    {
        return $this->db->like('title', $query)
            ->where('start_date >=', date('Y-m-d H:i:s'))
            ->limit(5)
            ->get('events')
            ->result();
    }

    private function search_players($query)
    {
        return $this->db->like('name', $query)
            ->limit(5)
            ->get('characters')
            ->result();
    }

    private function search_profiles($query)
    {
        return $this->db->select('users.id, users.username')
            ->from('users')
            ->like('users.username', $query)
            ->limit(5)
            ->get()
            ->result();
    }

    private function search_shop($query)
    {
        return $this->db->like('name', $query)
            ->limit(5)
            ->get('shop_items')
            ->result();
    }
}
