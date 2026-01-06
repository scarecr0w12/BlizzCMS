<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Donate_model extends BS_Model
{
    protected $table = 'donate_packages';

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
     * Get all active packages
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get_packages($limit = 10, $offset = 0)
    {
        return $this->db->from($this->table)
            ->where('is_active', 1)
            ->order_by('sort_order', 'ASC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    /**
     * Get featured packages
     *
     * @param int $limit
     * @return array
     */
    public function get_featured_packages($limit = 4)
    {
        return $this->db->from($this->table)
            ->where('is_active', 1)
            ->where('featured', 1)
            ->order_by('sort_order', 'ASC')
            ->limit($limit)
            ->get()
            ->result();
    }

    /**
     * Get a single package by ID
     *
     * @param int $id
     * @return object|null
     */
    public function get_package($id)
    {
        return $this->db->from($this->table)
            ->where('id', $id)
            ->get()
            ->row();
    }

    /**
     * Count active packages
     *
     * @return int
     */
    public function count_packages()
    {
        return $this->db->from($this->table)
            ->where('is_active', 1)
            ->count_all_results();
    }

    /**
     * Get all packages for admin
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get_all_packages($limit = 20, $offset = 0)
    {
        return $this->db->from($this->table)
            ->order_by('sort_order', 'ASC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    /**
     * Count all packages
     *
     * @return int
     */
    public function count_all_packages()
    {
        return $this->db->from($this->table)
            ->count_all_results();
    }

    /**
     * Get all active gateways
     *
     * @return array
     */
    public function get_gateways()
    {
        return $this->db->from('donate_gateways')
            ->where('is_active', 1)
            ->order_by('sort_order', 'ASC')
            ->get()
            ->result();
    }

    /**
     * Get all gateways for admin
     *
     * @return array
     */
    public function get_all_gateways()
    {
        return $this->db->from('donate_gateways')
            ->order_by('sort_order', 'ASC')
            ->get()
            ->result();
    }

    /**
     * Get a gateway by name
     *
     * @param string $name
     * @return object|null
     */
    public function get_gateway($name)
    {
        return $this->db->from('donate_gateways')
            ->where('name', $name)
            ->get()
            ->row();
    }

    /**
     * Update gateway configuration
     *
     * @param string $name
     * @param array $data
     * @return bool
     */
    public function update_gateway($name, $data)
    {
        $data['updated_at'] = current_date();
        return $this->db->update('donate_gateways', $data, ['name' => $name]);
    }

    /**
     * Create a donation log
     *
     * @param array $data
     * @return int|bool
     */
    public function create_log($data)
    {
        $data['created_at'] = current_date();
        $this->db->insert('donate_logs', $data);
        return $this->db->insert_id();
    }

    /**
     * Update donation log
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update_log($id, $data)
    {
        $data['updated_at'] = current_date();
        return $this->db->update('donate_logs', $data, ['id' => $id]);
    }

    /**
     * Get donation log by ID
     *
     * @param int $id
     * @return object|null
     */
    public function get_log($id)
    {
        return $this->db->from('donate_logs')
            ->where('id', $id)
            ->get()
            ->row();
    }

    /**
     * Get donation log by transaction ID
     *
     * @param string $transaction_id
     * @return object|null
     */
    public function get_log_by_transaction($transaction_id)
    {
        return $this->db->from('donate_logs')
            ->where('transaction_id', $transaction_id)
            ->get()
            ->row();
    }

    /**
     * Get donation logs for a user
     *
     * @param int $user_id
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get_user_logs($user_id, $limit = 20, $offset = 0)
    {
        return $this->db->select('donate_logs.*, donate_packages.name as package_name')
            ->from('donate_logs')
            ->join('donate_packages', 'donate_packages.id = donate_logs.package_id', 'left')
            ->where('donate_logs.user_id', $user_id)
            ->order_by('donate_logs.created_at', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    /**
     * Count user donation logs
     *
     * @param int $user_id
     * @return int
     */
    public function count_user_logs($user_id)
    {
        return $this->db->from('donate_logs')
            ->where('user_id', $user_id)
            ->count_all_results();
    }

    /**
     * Get all donation logs for admin
     *
     * @param int $limit
     * @param int $offset
     * @param array $filters
     * @return array
     */
    public function get_all_logs($limit = 20, $offset = 0, $filters = [])
    {
        $query = $this->db->select('donate_logs.*, donate_packages.name as package_name, users.nickname, users.username')
            ->from('donate_logs')
            ->join('donate_packages', 'donate_packages.id = donate_logs.package_id', 'left')
            ->join('users', 'users.id = donate_logs.user_id', 'left');

        if (!empty($filters['status'])) {
            $query->where('donate_logs.status', $filters['status']);
        }

        if (!empty($filters['gateway'])) {
            $query->where('donate_logs.gateway', $filters['gateway']);
        }

        if (!empty($filters['search'])) {
            $query->group_start()
                ->like('users.nickname', $filters['search'])
                ->or_like('users.username', $filters['search'])
                ->or_like('donate_logs.transaction_id', $filters['search'])
                ->group_end();
        }

        return $query->order_by('donate_logs.created_at', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    /**
     * Count all donation logs
     *
     * @param array $filters
     * @return int
     */
    public function count_all_logs($filters = [])
    {
        $query = $this->db->from('donate_logs')
            ->join('users', 'users.id = donate_logs.user_id', 'left');

        if (!empty($filters['status'])) {
            $query->where('donate_logs.status', $filters['status']);
        }

        if (!empty($filters['gateway'])) {
            $query->where('donate_logs.gateway', $filters['gateway']);
        }

        if (!empty($filters['search'])) {
            $query->group_start()
                ->like('users.nickname', $filters['search'])
                ->or_like('users.username', $filters['search'])
                ->or_like('donate_logs.transaction_id', $filters['search'])
                ->group_end();
        }

        return $query->count_all_results();
    }

    /**
     * Get top donators
     *
     * @param int $limit
     * @return array
     */
    public function get_top_donators($limit = 10)
    {
        return $this->db->select('users.id, users.nickname, users.avatar, SUM(donate_logs.amount) as total_donated, COUNT(donate_logs.id) as donation_count')
            ->from('donate_logs')
            ->join('users', 'users.id = donate_logs.user_id')
            ->where('donate_logs.status', 'completed')
            ->group_by('donate_logs.user_id')
            ->order_by('total_donated', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    /**
     * Get donation statistics
     *
     * @return object
     */
    public function get_statistics()
    {
        $stats = new stdClass();

        // Total donations
        $total = $this->db->select('SUM(amount) as total')
            ->from('donate_logs')
            ->where('status', 'completed')
            ->get()
            ->row();
        $stats->total_amount = $total->total ?? 0;

        // Total DP awarded
        $dp = $this->db->select('SUM(dp_awarded) as total')
            ->from('donate_logs')
            ->where('status', 'completed')
            ->get()
            ->row();
        $stats->total_dp = $dp->total ?? 0;

        // Count completed donations
        $stats->completed_count = $this->db->from('donate_logs')
            ->where('status', 'completed')
            ->count_all_results();

        // Count pending donations
        $stats->pending_count = $this->db->from('donate_logs')
            ->where('status', 'pending')
            ->count_all_results();

        // This month's donations
        $month_start = date('Y-m-01 00:00:00');
        $month_total = $this->db->select('SUM(amount) as total')
            ->from('donate_logs')
            ->where('status', 'completed')
            ->where('created_at >=', $month_start)
            ->get()
            ->row();
        $stats->month_amount = $month_total->total ?? 0;

        return $stats;
    }
}
