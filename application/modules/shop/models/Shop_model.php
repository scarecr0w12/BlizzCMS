<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_model extends BS_Model
{
    protected $table = 'shop_items';
    protected $setCreatedField = true;
    protected $setUpdatedField = true;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all active categories
     *
     * @param string|null $type
     * @return array
     */
    public function get_categories($type = null)
    {
        $query = $this->db->from('shop_categories')
            ->where('is_active', 1);

        if ($type !== null) {
            $query->where('type', $type);
        }

        return $query->order_by('sort_order', 'ASC')
            ->get()
            ->result();
    }

    /**
     * Get category by ID
     *
     * @param int $id
     * @return object|null
     */
    public function get_category($id)
    {
        return $this->db->where('id', $id)
            ->get('shop_categories')
            ->row();
    }

    /**
     * Get category by slug
     *
     * @param string $slug
     * @return object|null
     */
    public function get_category_by_slug($slug)
    {
        return $this->db->where('slug', $slug)
            ->where('is_active', 1)
            ->get('shop_categories')
            ->row();
    }

    /**
     * Get items with pagination
     *
     * @param int $limit
     * @param int $offset
     * @param array $filters
     * @return array
     */
    public function get_items($limit, $offset, $filters = [])
    {
        $query = $this->db->from('shop_items')
            ->where('is_active', 1);

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (! empty($filters['search'])) {
            $query->like('name', $filters['search']);
        }

        if (! empty($filters['featured'])) {
            $query->where('featured', 1);
        }

        if (! empty($filters['realm_id'])) {
            $query->group_start()
                ->where('realm_id', 0)
                ->or_where('realm_id', $filters['realm_id'])
                ->group_end();
        }

        return $query->order_by('id', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    /**
     * Count total items
     *
     * @param array $filters
     * @return int
     */
    public function count_items($filters = [])
    {
        $query = $this->db->from('shop_items')
            ->where('is_active', 1);

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (! empty($filters['search'])) {
            $query->like('name', $filters['search']);
        }

        if (! empty($filters['featured'])) {
            $query->where('featured', 1);
        }

        return $query->count_all_results();
    }

    /**
     * Get item by ID
     *
     * @param int $id
     * @return object|null
     */
    public function get_item($id)
    {
        return $this->db->where('id', $id)
            ->get('shop_items')
            ->row();
    }

    /**
     * Get services with pagination
     *
     * @param int $limit
     * @param int $offset
     * @param array $filters
     * @return array
     */
    public function get_services($limit, $offset, $filters = [])
    {
        $query = $this->db->from('shop_services')
            ->where('is_active', 1);

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (! empty($filters['realm_id'])) {
            $query->group_start()
                ->where('realm_id', 0)
                ->or_where('realm_id', $filters['realm_id'])
                ->group_end();
        }

        return $query->order_by('id', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    /**
     * Count total services
     *
     * @param array $filters
     * @return int
     */
    public function count_services($filters = [])
    {
        $query = $this->db->from('shop_services')
            ->where('is_active', 1);

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        return $query->count_all_results();
    }

    /**
     * Get service by ID
     *
     * @param int $id
     * @return object|null
     */
    public function get_service($id)
    {
        return $this->db->where('id', $id)
            ->get('shop_services')
            ->row();
    }

    /**
     * Get subscriptions with pagination
     *
     * @param int $limit
     * @param int $offset
     * @param array $filters
     * @return array
     */
    public function get_subscriptions($limit, $offset, $filters = [])
    {
        $query = $this->db->from('shop_subscriptions')
            ->where('is_active', 1);

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        return $query->order_by('id', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    /**
     * Count total subscriptions
     *
     * @param array $filters
     * @return int
     */
    public function count_subscriptions($filters = [])
    {
        $query = $this->db->from('shop_subscriptions')
            ->where('is_active', 1);

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        return $query->count_all_results();
    }

    /**
     * Get subscription by ID
     *
     * @param int $id
     * @return object|null
     */
    public function get_subscription($id)
    {
        return $this->db->where('id', $id)
            ->get('shop_subscriptions')
            ->row();
    }

    /**
     * Check if user has reached max purchase limit
     *
     * @param int $user_id
     * @param int $item_id
     * @param int $max_per_user
     * @return bool
     */
    public function check_purchase_limit($user_id, $item_id, $max_per_user)
    {
        if ($max_per_user <= 0) {
            return true;
        }

        $count = $this->db->from('shop_order_items oi')
            ->join('shop_orders o', 'o.id = oi.order_id')
            ->where('o.user_id', $user_id)
            ->where('oi.product_type', 'item')
            ->where('oi.product_id', $item_id)
            ->where_in('o.status', ['completed', 'processing'])
            ->select_sum('oi.quantity')
            ->get()
            ->row();

        return ($count->quantity ?? 0) < $max_per_user;
    }

    /**
     * Check item stock
     *
     * @param int $item_id
     * @param int $quantity
     * @return bool
     */
    public function check_stock($item_id, $quantity = 1)
    {
        $item = $this->get_item($item_id);
        
        if (empty($item)) {
            return false;
        }

        if ($item->stock === -1) {
            return true; // Unlimited stock
        }

        return $item->stock >= $quantity;
    }

    /**
     * Reduce item stock
     *
     * @param int $item_id
     * @param int $quantity
     * @return bool
     */
    public function reduce_stock($item_id, $quantity = 1)
    {
        $item = $this->get_item($item_id);
        
        if (empty($item) || $item->stock === -1) {
            return true;
        }

        return $this->db->set('stock', 'stock - ' . (int)$quantity, false)
            ->where('id', $item_id)
            ->where('stock >=', $quantity)
            ->update('shop_items');
    }

    /**
     * Get featured items
     *
     * @param int $limit
     * @return array
     */
    public function get_featured_items($limit = 8)
    {
        return $this->db->from('shop_items')
            ->where('is_active', 1)
            ->where('featured', 1)
            ->order_by('RAND()')
            ->limit($limit)
            ->get()
            ->result();
    }

    /**
     * Insert category
     *
     * @param array $data
     * @return bool
     */
    public function insert_category($data)
    {
        $data['created_at'] = current_date();
        return $this->db->insert('shop_categories', $data);
    }

    /**
     * Update category
     *
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update_category($data, $id)
    {
        $data['updated_at'] = current_date();
        return $this->db->where('id', $id)->update('shop_categories', $data);
    }

    /**
     * Delete category
     *
     * @param int $id
     * @return bool
     */
    public function delete_category($id)
    {
        return $this->db->where('id', $id)->delete('shop_categories');
    }

    /**
     * Insert item
     *
     * @param array $data
     * @return bool
     */
    public function insert_item($data)
    {
        $data['created_at'] = current_date();
        return $this->db->insert('shop_items', $data);
    }

    /**
     * Update item
     *
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update_item($data, $id)
    {
        $data['updated_at'] = current_date();
        return $this->db->where('id', $id)->update('shop_items', $data);
    }

    /**
     * Delete item
     *
     * @param int $id
     * @return bool
     */
    public function delete_item($id)
    {
        return $this->db->where('id', $id)->delete('shop_items');
    }

    /**
     * Insert service
     *
     * @param array $data
     * @return bool
     */
    public function insert_service($data)
    {
        $data['created_at'] = current_date();
        return $this->db->insert('shop_services', $data);
    }

    /**
     * Update service
     *
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update_service($data, $id)
    {
        $data['updated_at'] = current_date();
        return $this->db->where('id', $id)->update('shop_services', $data);
    }

    /**
     * Delete service
     *
     * @param int $id
     * @return bool
     */
    public function delete_service($id)
    {
        return $this->db->where('id', $id)->delete('shop_services');
    }

    /**
     * Insert subscription plan
     *
     * @param array $data
     * @return bool
     */
    public function insert_subscription_plan($data)
    {
        $data['created_at'] = current_date();
        return $this->db->insert('shop_subscriptions', $data);
    }

    /**
     * Update subscription plan
     *
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update_subscription_plan($data, $id)
    {
        $data['updated_at'] = current_date();
        return $this->db->where('id', $id)->update('shop_subscriptions', $data);
    }

    /**
     * Delete subscription plan
     *
     * @param int $id
     * @return bool
     */
    public function delete_subscription_plan($id)
    {
        return $this->db->where('id', $id)->delete('shop_subscriptions');
    }

    /**
     * Get all items (admin)
     *
     * @return array
     */
    public function get_all_items()
    {
        return $this->db->from('shop_items i')
            ->join('shop_categories c', 'c.id = i.category_id', 'left')
            ->select('i.*, c.name as category_name')
            ->order_by('i.id', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Get all services (admin)
     *
     * @return array
     */
    public function get_all_services()
    {
        return $this->db->from('shop_services s')
            ->join('shop_categories c', 'c.id = s.category_id', 'left')
            ->select('s.*, c.name as category_name')
            ->order_by('s.id', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Get all subscription plans (admin)
     *
     * @return array
     */
    public function get_all_subscription_plans()
    {
        return $this->db->from('shop_subscriptions s')
            ->join('shop_categories c', 'c.id = s.category_id', 'left')
            ->select('s.*, c.name as category_name')
            ->order_by('s.id', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Get all categories (admin)
     *
     * @return array
     */
    public function get_all_categories()
    {
        return $this->db->from('shop_categories')
            ->order_by('sort_order', 'ASC')
            ->get()
            ->result();
    }

    /**
     * Count categories
     *
     * @return int
     */
    public function count_categories()
    {
        return $this->db->count_all('shop_categories');
    }
}
