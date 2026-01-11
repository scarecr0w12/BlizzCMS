<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_enhanced_model extends CI_Model
{
    // Wishlist functions
    public function get_wishlist($user_id)
    {
        return $this->db->select('shop_wishlist.*, shop_items.*')
            ->from('shop_wishlist')
            ->join('shop_items', 'shop_wishlist.item_id = shop_items.id', 'left')
            ->where('shop_wishlist.user_id', $user_id)
            ->order_by('shop_wishlist.added_at', 'DESC')
            ->get()
            ->result();
    }

    public function add_to_wishlist($user_id, $item_id)
    {
        $existing = $this->db->where('user_id', $user_id)
            ->where('item_id', $item_id)
            ->get('shop_wishlist')
            ->row();

        if ($existing) {
            return false;
        }

        return $this->db->insert('shop_wishlist', [
            'user_id' => $user_id,
            'item_id' => $item_id,
            'added_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function remove_from_wishlist($user_id, $item_id)
    {
        return $this->db->where('user_id', $user_id)
            ->where('item_id', $item_id)
            ->delete('shop_wishlist');
    }

    public function is_in_wishlist($user_id, $item_id)
    {
        return $this->db->where('user_id', $user_id)
            ->where('item_id', $item_id)
            ->count_all_results('shop_wishlist') > 0;
    }

    // Cart functions
    public function get_cart($user_id)
    {
        return $this->db->select('shop_cart.*, shop_items.*')
            ->from('shop_cart')
            ->join('shop_items', 'shop_cart.item_id = shop_items.id', 'left')
            ->where('shop_cart.user_id', $user_id)
            ->get()
            ->result();
    }

    public function add_to_cart($user_id, $item_id, $quantity = 1)
    {
        $existing = $this->db->where('user_id', $user_id)
            ->where('item_id', $item_id)
            ->get('shop_cart')
            ->row();

        if ($existing) {
            return $this->db->where('user_id', $user_id)
                ->where('item_id', $item_id)
                ->update('shop_cart', ['quantity' => $existing->quantity + $quantity]);
        }

        return $this->db->insert('shop_cart', [
            'user_id' => $user_id,
            'item_id' => $item_id,
            'quantity' => $quantity,
            'added_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function update_cart_quantity($user_id, $item_id, $quantity)
    {
        if ($quantity <= 0) {
            return $this->remove_from_cart($user_id, $item_id);
        }

        return $this->db->where('user_id', $user_id)
            ->where('item_id', $item_id)
            ->update('shop_cart', ['quantity' => $quantity]);
    }

    public function remove_from_cart($user_id, $item_id)
    {
        return $this->db->where('user_id', $user_id)
            ->where('item_id', $item_id)
            ->delete('shop_cart');
    }

    public function clear_cart($user_id)
    {
        return $this->db->where('user_id', $user_id)->delete('shop_cart');
    }

    public function get_cart_total($user_id)
    {
        $cart = $this->get_cart($user_id);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item->price * $item->quantity;
        }

        return $total;
    }

    public function get_cart_count($user_id)
    {
        return $this->db->where('user_id', $user_id)
            ->count_all_results('shop_cart');
    }

    // Reviews functions
    public function get_item_reviews($item_id, $limit = 10, $offset = 0)
    {
        return $this->db->select('shop_reviews.*, users.username')
            ->from('shop_reviews')
            ->join('users', 'shop_reviews.user_id = users.id', 'left')
            ->where('shop_reviews.item_id', $item_id)
            ->order_by('shop_reviews.created_at', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    public function get_average_rating($item_id)
    {
        $result = $this->db->select_avg('rating')
            ->where('item_id', $item_id)
            ->get('shop_reviews')
            ->row();

        return $result ? round($result->rating, 1) : 0;
    }

    public function add_review($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('shop_reviews', $data);
    }

    // Item views tracking
    public function track_view($item_id)
    {
        $existing = $this->db->where('item_id', $item_id)
            ->get('shop_item_views')
            ->row();

        if ($existing) {
            return $this->db->where('item_id', $item_id)
                ->update('shop_item_views', [
                    'view_count' => $existing->view_count + 1,
                    'last_viewed' => date('Y-m-d H:i:s'),
                ]);
        }

        return $this->db->insert('shop_item_views', [
            'item_id' => $item_id,
            'view_count' => 1,
            'last_viewed' => date('Y-m-d H:i:s'),
        ]);
    }

    public function get_popular_items($limit = 10)
    {
        return $this->db->select('shop_items.*, shop_item_views.view_count')
            ->from('shop_items')
            ->join('shop_item_views', 'shop_items.id = shop_item_views.item_id', 'inner')
            ->order_by('shop_item_views.view_count', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    // Settings
    public function get_all_settings()
    {
        $query = $this->db->get('shop_enhanced_settings');
        $settings = [];
        
        foreach ($query->result() as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }
        
        return $settings;
    }

    public function update_setting($key, $value)
    {
        return $this->db->where('setting_key', $key)
            ->update('shop_enhanced_settings', [
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function get_statistics()
    {
        return [
            'total_wishlists' => $this->db->count_all('shop_wishlist'),
            'total_carts' => $this->db->select('DISTINCT user_id')->count_all_results('shop_cart'),
            'total_reviews' => $this->db->count_all('shop_reviews'),
            'total_views' => $this->db->select_sum('view_count')->get('shop_item_views')->row()->view_count ?? 0,
        ];
    }
}
