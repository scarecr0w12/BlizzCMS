<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('shop_enhanced_model');
    }

    public function index()
    {
        try {
            $statistics = $this->shop_enhanced_model->get_statistics();
            $popular_items = $this->shop_enhanced_model->get_popular_items(5);
        } catch (Exception $e) {
            $statistics = [
                'total_wishlists' => 0,
                'total_carts' => 0,
                'total_reviews' => 0,
                'total_views' => 0,
            ];
            $popular_items = [];
        }

        $data = [
            'statistics' => $statistics,
            'popular_items' => $popular_items,
        ];

        $this->template->title('Shop Enhanced Administration');
        $this->template->build('admin/index', $data);
    }

    public function settings()
    {
        if ($this->input->post()) {
            try {
                $settings = [
                    'enable_wishlist' => $this->input->post('enable_wishlist'),
                    'enable_cart' => $this->input->post('enable_cart'),
                    'enable_reviews' => $this->input->post('enable_reviews'),
                    'enable_compare' => $this->input->post('enable_compare'),
                    'enable_item_preview' => $this->input->post('enable_item_preview'),
                    'max_cart_items' => $this->input->post('max_cart_items'),
                    'max_wishlist_items' => $this->input->post('max_wishlist_items'),
                    'max_compare_items' => $this->input->post('max_compare_items'),
                    'require_review_purchase' => $this->input->post('require_review_purchase'),
                    'min_review_length' => $this->input->post('min_review_length'),
                ];

                foreach ($settings as $key => $value) {
                    $this->shop_enhanced_model->update_setting($key, $value);
                }

                $this->session->set_flashdata('success', 'Settings saved successfully');
            } catch (Exception $e) {
                $this->session->set_flashdata('error', 'Error saving settings. Please run migrations first.');
            }
            redirect('shop_enhanced/admin/settings');
        }

        try {
            $settings = $this->shop_enhanced_model->get_all_settings();
        } catch (Exception $e) {
            $settings = [];
        }

        $data = [
            'settings' => $settings,
        ];

        $this->template->title('Shop Enhanced Settings');
        $this->template->build('admin/settings', $data);
    }
}
