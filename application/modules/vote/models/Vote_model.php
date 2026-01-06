<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Vote_model extends BS_Model
{
    protected $table = 'vote_sites';

    protected $setCreatedField = true;
    protected $setUpdatedField = true;

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all active vote sites
     *
     * @return array
     */
    public function get_sites()
    {
        return $this->db->from($this->table)
            ->where('is_active', 1)
            ->order_by('sort_order', 'ASC')
            ->get()
            ->result();
    }

    /**
     * Get all sites for admin
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get_all_sites($limit = 20, $offset = 0)
    {
        return $this->db->from($this->table)
            ->order_by('sort_order', 'ASC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    /**
     * Count all sites
     *
     * @return int
     */
    public function count_all_sites()
    {
        return $this->db->from($this->table)
            ->count_all_results();
    }

    /**
     * Get a single site by ID
     *
     * @param int $id
     * @return object|null
     */
    public function get_site($id)
    {
        return $this->db->from($this->table)
            ->where('id', $id)
            ->get()
            ->row();
    }

    /**
     * Check if user can vote on a site (cooldown check)
     *
     * @param int $user_id
     * @param int $site_id
     * @return bool
     */
    public function can_vote($user_id, $site_id)
    {
        $site = $this->get_site($site_id);
        
        if (!$site || !$site->is_active) {
            return false;
        }

        $cooldown_time = date('Y-m-d H:i:s', strtotime("-{$site->cooldown_hours} hours"));

        $last_vote = $this->db->from('vote_logs')
            ->where('user_id', $user_id)
            ->where('site_id', $site_id)
            ->where('created_at >', $cooldown_time)
            ->get()
            ->row();

        return empty($last_vote);
    }

    /**
     * Get time until user can vote again
     *
     * @param int $user_id
     * @param int $site_id
     * @return int|null Seconds until next vote, null if can vote now
     */
    public function get_cooldown_remaining($user_id, $site_id)
    {
        $site = $this->get_site($site_id);
        
        if (!$site) {
            return null;
        }

        $last_vote = $this->db->select('created_at')
            ->from('vote_logs')
            ->where('user_id', $user_id)
            ->where('site_id', $site_id)
            ->order_by('created_at', 'DESC')
            ->limit(1)
            ->get()
            ->row();

        if (!$last_vote) {
            return null;
        }

        $next_vote_time = strtotime($last_vote->created_at) + ($site->cooldown_hours * 3600);
        $remaining = $next_vote_time - time();

        return $remaining > 0 ? $remaining : null;
    }

    /**
     * Log a vote
     *
     * @param int $user_id
     * @param int $site_id
     * @param int $vp_awarded
     * @return bool
     */
    public function log_vote($user_id, $site_id, $vp_awarded)
    {
        return $this->db->insert('vote_logs', [
            'user_id'    => $user_id,
            'site_id'    => $site_id,
            'vp_awarded' => $vp_awarded,
            'ip_address' => $this->input->ip_address(),
            'created_at' => current_date()
        ]);
    }

    /**
     * Get vote logs for a user
     *
     * @param int $user_id
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get_user_logs($user_id, $limit = 20, $offset = 0)
    {
        return $this->db->select('vote_logs.*, vote_sites.name as site_name')
            ->from('vote_logs')
            ->join('vote_sites', 'vote_sites.id = vote_logs.site_id', 'left')
            ->where('vote_logs.user_id', $user_id)
            ->order_by('vote_logs.created_at', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    /**
     * Count user vote logs
     *
     * @param int $user_id
     * @return int
     */
    public function count_user_logs($user_id)
    {
        return $this->db->from('vote_logs')
            ->where('user_id', $user_id)
            ->count_all_results();
    }

    /**
     * Get all vote logs for admin
     *
     * @param int $limit
     * @param int $offset
     * @param array $filters
     * @return array
     */
    public function get_all_logs($limit = 30, $offset = 0, $filters = [])
    {
        $query = $this->db->select('vote_logs.*, vote_sites.name as site_name, users.nickname, users.username')
            ->from('vote_logs')
            ->join('vote_sites', 'vote_sites.id = vote_logs.site_id', 'left')
            ->join('users', 'users.id = vote_logs.user_id', 'left');

        if (!empty($filters['site_id'])) {
            $query->where('vote_logs.site_id', $filters['site_id']);
        }

        if (!empty($filters['search'])) {
            $query->group_start()
                ->like('users.nickname', $filters['search'])
                ->or_like('users.username', $filters['search'])
                ->group_end();
        }

        return $query->order_by('vote_logs.created_at', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    /**
     * Count all vote logs
     *
     * @param array $filters
     * @return int
     */
    public function count_all_logs($filters = [])
    {
        $query = $this->db->from('vote_logs')
            ->join('users', 'users.id = vote_logs.user_id', 'left');

        if (!empty($filters['site_id'])) {
            $query->where('vote_logs.site_id', $filters['site_id']);
        }

        if (!empty($filters['search'])) {
            $query->group_start()
                ->like('users.nickname', $filters['search'])
                ->or_like('users.username', $filters['search'])
                ->group_end();
        }

        return $query->count_all_results();
    }

    /**
     * Get top voters
     *
     * @param int $limit
     * @return array
     */
    public function get_top_voters($limit = 10)
    {
        return $this->db->select('users.id, users.nickname, users.avatar, COUNT(vote_logs.id) as vote_count, SUM(vote_logs.vp_awarded) as total_vp')
            ->from('vote_logs')
            ->join('users', 'users.id = vote_logs.user_id')
            ->group_by('vote_logs.user_id')
            ->order_by('vote_count', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    /**
     * Get vote statistics
     *
     * @return object
     */
    public function get_statistics()
    {
        $stats = new stdClass();

        // Total votes
        $stats->total_votes = $this->db->from('vote_logs')->count_all_results();

        // Total VP awarded
        $vp = $this->db->select('SUM(vp_awarded) as total')
            ->from('vote_logs')
            ->get()
            ->row();
        $stats->total_vp = $vp->total ?? 0;

        // Votes today
        $today_start = date('Y-m-d 00:00:00');
        $stats->today_votes = $this->db->from('vote_logs')
            ->where('created_at >=', $today_start)
            ->count_all_results();

        // Votes this month
        $month_start = date('Y-m-01 00:00:00');
        $stats->month_votes = $this->db->from('vote_logs')
            ->where('created_at >=', $month_start)
            ->count_all_results();

        // Active vote sites
        $stats->active_sites = $this->db->from($this->table)
            ->where('is_active', 1)
            ->count_all_results();

        return $stats;
    }

    /**
     * Get user's vote status for all sites
     *
     * @param int $user_id
     * @return array
     */
    public function get_user_vote_status($user_id)
    {
        $sites = $this->get_sites();
        $result = [];

        foreach ($sites as $site) {
            $remaining = $this->get_cooldown_remaining($user_id, $site->id);
            $result[$site->id] = [
                'site' => $site,
                'can_vote' => $remaining === null,
                'cooldown_remaining' => $remaining
            ];
        }

        return $result;
    }
}
