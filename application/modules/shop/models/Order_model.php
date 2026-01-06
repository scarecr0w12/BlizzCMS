<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends BS_Model
{
    protected $table = 'shop_orders';
    protected $setCreatedField = true;
    protected $setUpdatedField = true;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Generate unique order number
     *
     * @return string
     */
    public function generate_order_number()
    {
        do {
            $number = 'ORD-' . strtoupper(bin2hex(random_bytes(8)));
        } while ($this->db->where('order_number', $number)->count_all_results($this->table) > 0);

        return $number;
    }

    /**
     * Create new order
     *
     * @param array $data
     * @return int|false
     */
    public function create_order($data)
    {
        $data['order_number'] = $this->generate_order_number();
        $data['created_at'] = current_date();
        $data['ip_address'] = $this->input->ip_address();

        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }

        return false;
    }

    /**
     * Add item to order
     *
     * @param int $order_id
     * @param array $item
     * @return bool
     */
    public function add_order_item($order_id, $item)
    {
        $item['order_id'] = $order_id;
        return $this->db->insert('shop_order_items', $item);
    }

    /**
     * Get order by ID
     *
     * @param int $id
     * @return object|null
     */
    public function get_order($id)
    {
        return $this->db->where('id', $id)
            ->get($this->table)
            ->row();
    }

    /**
     * Get order by order number
     *
     * @param string $order_number
     * @return object|null
     */
    public function get_order_by_number($order_number)
    {
        return $this->db->where('order_number', $order_number)
            ->get($this->table)
            ->row();
    }

    /**
     * Get order items
     *
     * @param int $order_id
     * @return array
     */
    public function get_order_items($order_id)
    {
        return $this->db->where('order_id', $order_id)
            ->get('shop_order_items')
            ->result();
    }

    /**
     * Get user orders with pagination
     *
     * @param int $user_id
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function get_user_orders($user_id, $limit = 10, $offset = 0)
    {
        return $this->db->where('user_id', $user_id)
            ->order_by('created_at', 'DESC')
            ->limit($limit, $offset)
            ->get($this->table)
            ->result();
    }

    /**
     * Count user orders
     *
     * @param int $user_id
     * @return int
     */
    public function count_user_orders($user_id)
    {
        return $this->db->where('user_id', $user_id)
            ->count_all_results($this->table);
    }

    /**
     * Update order status
     *
     * @param int $order_id
     * @param string $status
     * @return bool
     */
    public function update_status($order_id, $status)
    {
        return $this->update([
            'status' => $status
        ], ['id' => $order_id]);
    }

    /**
     * Update order item status
     *
     * @param int $item_id
     * @param string $status
     * @return bool
     */
    public function update_item_status($item_id, $status)
    {
        $data = ['status' => $status];
        
        if ($status === 'delivered') {
            $data['delivered_at'] = current_date();
        }

        return $this->db->where('id', $item_id)
            ->update('shop_order_items', $data);
    }

    /**
     * Set transaction ID
     *
     * @param int $order_id
     * @param string $transaction_id
     * @param string $payment_data
     * @return bool
     */
    public function set_transaction($order_id, $transaction_id, $payment_data = null)
    {
        return $this->update([
            'transaction_id' => $transaction_id,
            'payment_data' => $payment_data
        ], ['id' => $order_id]);
    }

    /**
     * Get all orders with pagination (admin)
     *
     * @param int $limit
     * @param int $offset
     * @param array $filters
     * @return array
     */
    public function get_all_orders($limit, $offset, $filters = [])
    {
        $query = $this->db->from($this->table . ' o')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->select('o.*, u.nickname, u.username, u.email');

        if (! empty($filters['status'])) {
            $query->where('o.status', $filters['status']);
        }

        if (! empty($filters['search'])) {
            $query->group_start()
                ->like('o.order_number', $filters['search'])
                ->or_like('u.nickname', $filters['search'])
                ->or_like('u.username', $filters['search'])
                ->group_end();
        }

        if (! empty($filters['date_from'])) {
            $query->where('o.created_at >=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->where('o.created_at <=', $filters['date_to']);
        }

        return $query->order_by('o.created_at', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    /**
     * Count all orders (admin)
     *
     * @param array $filters
     * @return int
     */
    public function count_all_orders($filters = [])
    {
        $query = $this->db->from($this->table . ' o')
            ->join('users u', 'u.id = o.user_id', 'left');

        if (! empty($filters['status'])) {
            $query->where('o.status', $filters['status']);
        }

        if (! empty($filters['search'])) {
            $query->group_start()
                ->like('o.order_number', $filters['search'])
                ->or_like('u.nickname', $filters['search'])
                ->group_end();
        }

        return $query->count_all_results();
    }

    /**
     * Get pending orders count
     *
     * @return int
     */
    public function count_pending_orders()
    {
        return $this->db->where('status', 'pending')
            ->count_all_results($this->table);
    }

    /**
     * Get orders statistics
     *
     * @return object
     */
    public function get_statistics()
    {
        $stats = new stdClass();
        
        $stats->total_orders = $this->db->count_all_results($this->table);
        
        $stats->pending = $this->db->where('status', 'pending')
            ->count_all_results($this->table);
        
        $stats->completed = $this->db->where('status', 'completed')
            ->count_all_results($this->table);
        
        $revenue = $this->db->select_sum('total_money')
            ->where('status', 'completed')
            ->get($this->table)
            ->row();
        $stats->total_revenue = $revenue->total_money ?? 0;

        $dp_spent = $this->db->select_sum('total_dp')
            ->where('status', 'completed')
            ->get($this->table)
            ->row();
        $stats->total_dp_spent = $dp_spent->total_dp ?? 0;

        $vp_spent = $this->db->select_sum('total_vp')
            ->where('status', 'completed')
            ->get($this->table)
            ->row();
        $stats->total_vp_spent = $vp_spent->total_vp ?? 0;

        return $stats;
    }

    /**
     * Log payment
     *
     * @param array $data
     * @return bool
     */
    public function log_payment($data)
    {
        $data['created_at'] = current_date();
        $data['ip_address'] = $this->input->ip_address();
        return $this->db->insert('shop_payment_logs', $data);
    }

    /**
     * Get payment logs for order
     *
     * @param int $order_id
     * @return array
     */
    public function get_payment_logs($order_id)
    {
        return $this->db->where('order_id', $order_id)
            ->order_by('created_at', 'DESC')
            ->get('shop_payment_logs')
            ->result();
    }
}
