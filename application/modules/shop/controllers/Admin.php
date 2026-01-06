<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        require_permission('view.shop', 'shop');

        $this->load->language('shop/shop');
        $this->load->model([
            'shop/shop_model',
            'shop/order_model',
            'shop/user_subscription_model'
        ]);
    }

    /**
     * Admin shop dashboard
     *
     * @return void
     */
    public function index()
    {
        $order_stats = $this->order_model->get_statistics();
        
        $data = [
            'stats' => [
                'total_orders'     => $order_stats->total_orders ?? 0,
                'completed_orders' => $order_stats->completed ?? 0,
                'total_dp_earned'  => $order_stats->total_dp_spent ?? 0,
                'total_vp_earned'  => $order_stats->total_vp_spent ?? 0,
            ],
            'category_count'     => $this->shop_model->count_categories(),
            'item_count'         => $this->shop_model->count_items([]),
            'service_count'      => $this->shop_model->count_services([]),
            'subscription_count' => $this->shop_model->count_subscriptions([]),
            'recent_orders'      => $this->order_model->get_all_orders(10, 0),
            'pending_orders'     => $this->order_model->count_pending_orders()
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));
        $this->template->build('admin/index', $data);
    }

    /**
     * Categories management
     *
     * @return void
     */
    public function categories()
    {
        $data = [
            'categories' => $this->shop_model->get_all_categories()
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));
        $this->template->build('admin/categories', $data);
    }

    /**
     * Add category
     *
     * @return void
     */
    public function add_category()
    {
        require_permission('add.shop.category', 'shop');

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('name', lang('name'), 'trim|required|max_length[255]');
        $this->form_validation->set_rules('slug', lang('slug'), 'trim|required|alpha_dash|max_length[255]');
        $this->form_validation->set_rules('type', lang('type'), 'trim|required|in_list[item,service,subscription]');
        $this->form_validation->set_rules('description', lang('description'), 'trim');
        $this->form_validation->set_rules('icon', lang('icon'), 'trim|max_length[255]');
        $this->form_validation->set_rules('sort_order', lang('sort_order'), 'trim|is_natural');
        $this->form_validation->set_rules('is_active', lang('status'), 'trim|in_list[0,1]');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            $this->shop_model->insert_category([
                'name'        => $this->input->post('name'),
                'slug'        => $this->input->post('slug'),
                'description' => $this->input->post('description'),
                'icon'        => $this->input->post('icon'),
                'type'        => $this->input->post('type'),
                'sort_order'  => $this->input->post('sort_order') ?: 0,
                'is_active'   => $this->input->post('is_active') ?: 1
            ]);

            $this->log_model->create('shop', 'add', 'Added shop category: ' . $this->input->post('name'));
            $this->session->set_flashdata('success', lang('alert_category_added'));
            redirect(site_url('shop/admin/categories'));
        } else {
            $this->template->build('admin/add_category');
        }
    }

    /**
     * Edit category
     *
     * @param int $id
     * @return void
     */
    public function edit_category($id)
    {
        require_permission('edit.shop.category', 'shop');

        $category = $this->shop_model->get_category($id);

        if (empty($category)) {
            show_404();
        }

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('name', lang('name'), 'trim|required|max_length[255]');
        $this->form_validation->set_rules('slug', lang('slug'), 'trim|required|alpha_dash|max_length[255]');
        $this->form_validation->set_rules('type', lang('type'), 'trim|required|in_list[item,service,subscription]');
        $this->form_validation->set_rules('description', lang('description'), 'trim');
        $this->form_validation->set_rules('icon', lang('icon'), 'trim|max_length[255]');
        $this->form_validation->set_rules('sort_order', lang('sort_order'), 'trim|is_natural');
        $this->form_validation->set_rules('is_active', lang('status'), 'trim|in_list[0,1]');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            $this->shop_model->update_category([
                'name'        => $this->input->post('name'),
                'slug'        => $this->input->post('slug'),
                'description' => $this->input->post('description'),
                'icon'        => $this->input->post('icon'),
                'type'        => $this->input->post('type'),
                'sort_order'  => $this->input->post('sort_order') ?: 0,
                'is_active'   => $this->input->post('is_active') ?: 1
            ], $id);

            $this->log_model->create('shop', 'edit', 'Edited shop category: ' . $this->input->post('name'));
            $this->session->set_flashdata('success', lang('alert_category_updated'));
            redirect(site_url('shop/admin/categories'));
        } else {
            $data = ['category' => $category];
            $this->template->build('admin/edit_category', $data);
        }
    }

    /**
     * Delete category
     *
     * @param int $id
     * @return void
     */
    public function delete_category($id)
    {
        require_permission('delete.shop.category', 'shop');

        $category = $this->shop_model->get_category($id);

        if (empty($category)) {
            show_404();
        }

        $this->shop_model->delete_category($id);
        $this->log_model->create('shop', 'delete', 'Deleted shop category: ' . $category->name);
        $this->session->set_flashdata('success', lang('alert_category_deleted'));
        redirect(site_url('shop/admin/categories'));
    }

    /**
     * Items management
     *
     * @return void
     */
    public function items()
    {
        $data = [
            'items' => $this->shop_model->get_all_items()
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));
        $this->template->build('admin/items', $data);
    }

    /**
     * Add item
     *
     * @return void
     */
    public function add_item()
    {
        require_permission('add.shop.item', 'shop');

        $data = [
            'categories' => $this->shop_model->get_categories('item'),
            'realms'     => $this->realm_model->find_all()
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('name', lang('name'), 'trim|required|max_length[255]');
        $this->form_validation->set_rules('category_id', lang('category'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('item_id', lang('shop_item_id'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('item_count', lang('shop_item_count'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('price_dp', lang('shop_price_dp'), 'trim|numeric');
        $this->form_validation->set_rules('price_vp', lang('shop_price_vp'), 'trim|is_natural');
        $this->form_validation->set_rules('price_money', lang('shop_price_money'), 'trim|numeric');
        $this->form_validation->set_rules('stock', lang('shop_stock'), 'trim|integer');
        $this->form_validation->set_rules('max_per_user', lang('shop_max_per_user'), 'trim|is_natural');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            $this->shop_model->insert_item([
                'category_id'  => $this->input->post('category_id'),
                'name'         => $this->input->post('name'),
                'description'  => $this->input->post('description'),
                'item_id'      => $this->input->post('item_id'),
                'item_count'   => $this->input->post('item_count') ?: 1,
                'price_dp'     => $this->input->post('price_dp') ?: 0,
                'price_vp'     => $this->input->post('price_vp') ?: 0,
                'price_money'  => $this->input->post('price_money') ?: 0,
                'currency'     => config_item('shop_currency') ?? 'USD',
                'image'        => $this->input->post('image'),
                'featured'     => $this->input->post('featured') ? 1 : 0,
                'stock'        => $this->input->post('stock') ?? -1,
                'max_per_user' => $this->input->post('max_per_user') ?: 0,
                'realm_id'     => $this->input->post('realm_id') ?: 0,
                'is_active'    => $this->input->post('is_active') ? 1 : 0
            ]);

            $this->log_model->create('shop', 'add', 'Added shop item: ' . $this->input->post('name'));
            $this->session->set_flashdata('success', lang('alert_item_added'));
            redirect(site_url('shop/admin/items'));
        } else {
            $this->template->build('admin/add_item', $data);
        }
    }

    /**
     * Edit item
     *
     * @param int $id
     * @return void
     */
    public function edit_item($id)
    {
        require_permission('edit.shop.item', 'shop');

        $item = $this->shop_model->get_item($id);

        if (empty($item)) {
            show_404();
        }

        $data = [
            'item'       => $item,
            'categories' => $this->shop_model->get_categories('item'),
            'realms'     => $this->realm_model->find_all()
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('name', lang('name'), 'trim|required|max_length[255]');
        $this->form_validation->set_rules('category_id', lang('category'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('item_id', lang('shop_item_id'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('item_count', lang('shop_item_count'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('price_dp', lang('shop_price_dp'), 'trim|numeric');
        $this->form_validation->set_rules('price_vp', lang('shop_price_vp'), 'trim|is_natural');
        $this->form_validation->set_rules('price_money', lang('shop_price_money'), 'trim|numeric');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            $this->shop_model->update_item([
                'category_id'  => $this->input->post('category_id'),
                'name'         => $this->input->post('name'),
                'description'  => $this->input->post('description'),
                'item_id'      => $this->input->post('item_id'),
                'item_count'   => $this->input->post('item_count') ?: 1,
                'price_dp'     => $this->input->post('price_dp') ?: 0,
                'price_vp'     => $this->input->post('price_vp') ?: 0,
                'price_money'  => $this->input->post('price_money') ?: 0,
                'image'        => $this->input->post('image'),
                'featured'     => $this->input->post('featured') ? 1 : 0,
                'stock'        => $this->input->post('stock') ?? -1,
                'max_per_user' => $this->input->post('max_per_user') ?: 0,
                'realm_id'     => $this->input->post('realm_id') ?: 0,
                'is_active'    => $this->input->post('is_active') ? 1 : 0
            ], $id);

            $this->log_model->create('shop', 'edit', 'Edited shop item: ' . $this->input->post('name'));
            $this->session->set_flashdata('success', lang('alert_item_updated'));
            redirect(site_url('shop/admin/items'));
        } else {
            $this->template->build('admin/edit_item', $data);
        }
    }

    /**
     * Delete item
     *
     * @param int $id
     * @return void
     */
    public function delete_item($id)
    {
        require_permission('delete.shop.item', 'shop');

        $item = $this->shop_model->get_item($id);

        if (empty($item)) {
            show_404();
        }

        $this->shop_model->delete_item($id);
        $this->log_model->create('shop', 'delete', 'Deleted shop item: ' . $item->name);
        $this->session->set_flashdata('success', lang('alert_item_deleted'));
        redirect(site_url('shop/admin/items'));
    }

    /**
     * Services management
     *
     * @return void
     */
    public function services()
    {
        $data = [
            'services' => $this->shop_model->get_all_services()
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));
        $this->template->build('admin/services', $data);
    }

    /**
     * Add service
     *
     * @return void
     */
    public function add_service()
    {
        require_permission('add.shop.service', 'shop');

        $data = [
            'categories'    => $this->shop_model->get_categories('service'),
            'realms'        => $this->realm_model->find_all(),
            'service_types' => ['rename', 'customize', 'race_change', 'faction_change', 'level_boost', 'profession_boost', 'gold', 'custom']
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('name', lang('name'), 'trim|required|max_length[255]');
        $this->form_validation->set_rules('category_id', lang('category'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('service_type', lang('shop_service_type'), 'trim|required');
        $this->form_validation->set_rules('price_dp', lang('shop_price_dp'), 'trim|numeric');
        $this->form_validation->set_rules('price_vp', lang('shop_price_vp'), 'trim|is_natural');
        $this->form_validation->set_rules('price_money', lang('shop_price_money'), 'trim|numeric');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            $this->shop_model->insert_service([
                'category_id'        => $this->input->post('category_id'),
                'name'               => $this->input->post('name'),
                'description'        => $this->input->post('description'),
                'service_type'       => $this->input->post('service_type'),
                'service_value'      => $this->input->post('service_value'),
                'price_dp'           => $this->input->post('price_dp') ?: 0,
                'price_vp'           => $this->input->post('price_vp') ?: 0,
                'price_money'        => $this->input->post('price_money') ?: 0,
                'currency'           => config_item('shop_currency') ?? 'USD',
                'image'              => $this->input->post('image'),
                'icon'               => $this->input->post('icon'),
                'requires_character' => $this->input->post('requires_character') ? 1 : 0,
                'realm_id'           => $this->input->post('realm_id') ?: 0,
                'is_active'          => $this->input->post('is_active') ? 1 : 0
            ]);

            $this->log_model->create('shop', 'add', 'Added shop service: ' . $this->input->post('name'));
            $this->session->set_flashdata('success', lang('alert_service_added'));
            redirect(site_url('shop/admin/services'));
        } else {
            $this->template->build('admin/add_service', $data);
        }
    }

    /**
     * Edit service
     *
     * @param int $id
     * @return void
     */
    public function edit_service($id)
    {
        require_permission('edit.shop.service', 'shop');

        $service = $this->shop_model->get_service($id);

        if (empty($service)) {
            show_404();
        }

        $data = [
            'service'       => $service,
            'categories'    => $this->shop_model->get_categories('service'),
            'realms'        => $this->realm_model->find_all(),
            'service_types' => ['rename', 'customize', 'race_change', 'faction_change', 'level_boost', 'profession_boost', 'gold', 'custom']
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('name', lang('name'), 'trim|required|max_length[255]');
        $this->form_validation->set_rules('category_id', lang('category'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('service_type', lang('shop_service_type'), 'trim|required');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            $this->shop_model->update_service([
                'category_id'        => $this->input->post('category_id'),
                'name'               => $this->input->post('name'),
                'description'        => $this->input->post('description'),
                'service_type'       => $this->input->post('service_type'),
                'service_value'      => $this->input->post('service_value'),
                'price_dp'           => $this->input->post('price_dp') ?: 0,
                'price_vp'           => $this->input->post('price_vp') ?: 0,
                'price_money'        => $this->input->post('price_money') ?: 0,
                'image'              => $this->input->post('image'),
                'icon'               => $this->input->post('icon'),
                'requires_character' => $this->input->post('requires_character') ? 1 : 0,
                'realm_id'           => $this->input->post('realm_id') ?: 0,
                'is_active'          => $this->input->post('is_active') ? 1 : 0
            ], $id);

            $this->log_model->create('shop', 'edit', 'Edited shop service: ' . $this->input->post('name'));
            $this->session->set_flashdata('success', lang('alert_service_updated'));
            redirect(site_url('shop/admin/services'));
        } else {
            $this->template->build('admin/edit_service', $data);
        }
    }

    /**
     * Delete service
     *
     * @param int $id
     * @return void
     */
    public function delete_service($id)
    {
        require_permission('delete.shop.service', 'shop');

        $service = $this->shop_model->get_service($id);

        if (empty($service)) {
            show_404();
        }

        $this->shop_model->delete_service($id);
        $this->log_model->create('shop', 'delete', 'Deleted shop service: ' . $service->name);
        $this->session->set_flashdata('success', lang('alert_service_deleted'));
        redirect(site_url('shop/admin/services'));
    }

    /**
     * Subscriptions management
     *
     * @return void
     */
    public function subscriptions()
    {
        $data = [
            'subscriptions' => $this->shop_model->get_all_subscription_plans()
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));
        $this->template->build('admin/subscriptions', $data);
    }

    /**
     * Add subscription plan
     *
     * @return void
     */
    public function add_subscription()
    {
        require_permission('add.shop.subscription', 'shop');

        $data = [
            'categories'         => $this->shop_model->get_categories('subscription'),
            'subscription_types' => ['vip', 'premium', 'item_delivery', 'service_access', 'custom'],
            'interval_types'     => ['daily', 'weekly', 'monthly', 'yearly']
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('name', lang('name'), 'trim|required|max_length[255]');
        $this->form_validation->set_rules('category_id', lang('category'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('subscription_type', lang('shop_subscription_type'), 'trim|required');
        $this->form_validation->set_rules('interval_type', lang('shop_interval_type'), 'trim|required');
        $this->form_validation->set_rules('interval_count', lang('shop_interval_count'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('price_dp', lang('shop_price_dp'), 'trim|numeric');
        $this->form_validation->set_rules('price_vp', lang('shop_price_vp'), 'trim|is_natural');
        $this->form_validation->set_rules('price_money', lang('shop_price_money'), 'trim|numeric');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            $this->shop_model->insert_subscription_plan([
                'category_id'       => $this->input->post('category_id'),
                'name'              => $this->input->post('name'),
                'description'       => $this->input->post('description'),
                'subscription_type' => $this->input->post('subscription_type'),
                'benefits'          => $this->input->post('benefits'),
                'interval_type'     => $this->input->post('interval_type'),
                'interval_count'    => $this->input->post('interval_count') ?: 1,
                'price_dp'          => $this->input->post('price_dp') ?: 0,
                'price_vp'          => $this->input->post('price_vp') ?: 0,
                'price_money'       => $this->input->post('price_money') ?: 0,
                'currency'          => config_item('shop_currency') ?? 'USD',
                'image'             => $this->input->post('image'),
                'icon'              => $this->input->post('icon'),
                'delivery_items'    => $this->input->post('delivery_items'),
                'is_active'         => $this->input->post('is_active') ? 1 : 0
            ]);

            $this->log_model->create('shop', 'add', 'Added subscription plan: ' . $this->input->post('name'));
            $this->session->set_flashdata('success', lang('alert_subscription_added'));
            redirect(site_url('shop/admin/subscriptions'));
        } else {
            $this->template->build('admin/add_subscription', $data);
        }
    }

    /**
     * Edit subscription plan
     *
     * @param int $id
     * @return void
     */
    public function edit_subscription($id)
    {
        require_permission('edit.shop.subscription', 'shop');

        $subscription = $this->shop_model->get_subscription($id);

        if (empty($subscription)) {
            show_404();
        }

        $data = [
            'subscription'       => $subscription,
            'categories'         => $this->shop_model->get_categories('subscription'),
            'subscription_types' => ['vip', 'premium', 'item_delivery', 'service_access', 'custom'],
            'interval_types'     => ['daily', 'weekly', 'monthly', 'yearly']
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('name', lang('name'), 'trim|required|max_length[255]');
        $this->form_validation->set_rules('category_id', lang('category'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('subscription_type', lang('shop_subscription_type'), 'trim|required');
        $this->form_validation->set_rules('interval_type', lang('shop_interval_type'), 'trim|required');
        $this->form_validation->set_rules('interval_count', lang('shop_interval_count'), 'trim|required|is_natural_no_zero');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            $this->shop_model->update_subscription_plan([
                'category_id'       => $this->input->post('category_id'),
                'name'              => $this->input->post('name'),
                'description'       => $this->input->post('description'),
                'subscription_type' => $this->input->post('subscription_type'),
                'benefits'          => $this->input->post('benefits'),
                'interval_type'     => $this->input->post('interval_type'),
                'interval_count'    => $this->input->post('interval_count') ?: 1,
                'price_dp'          => $this->input->post('price_dp') ?: 0,
                'price_vp'          => $this->input->post('price_vp') ?: 0,
                'price_money'       => $this->input->post('price_money') ?: 0,
                'image'             => $this->input->post('image'),
                'icon'              => $this->input->post('icon'),
                'delivery_items'    => $this->input->post('delivery_items'),
                'is_active'         => $this->input->post('is_active') ? 1 : 0
            ], $id);

            $this->log_model->create('shop', 'edit', 'Edited subscription plan: ' . $this->input->post('name'));
            $this->session->set_flashdata('success', lang('alert_subscription_updated'));
            redirect(site_url('shop/admin/subscriptions'));
        } else {
            $this->template->build('admin/edit_subscription', $data);
        }
    }

    /**
     * Delete subscription plan
     *
     * @param int $id
     * @return void
     */
    public function delete_subscription($id)
    {
        require_permission('delete.shop.subscription', 'shop');

        $subscription = $this->shop_model->get_subscription($id);

        if (empty($subscription)) {
            show_404();
        }

        $this->shop_model->delete_subscription_plan($id);
        $this->log_model->create('shop', 'delete', 'Deleted subscription plan: ' . $subscription->name);
        $this->session->set_flashdata('success', lang('alert_subscription_deleted'));
        redirect(site_url('shop/admin/subscriptions'));
    }

    /**
     * Orders management
     *
     * @return void
     */
    public function orders()
    {
        $per_page = 20;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $per_page;

        $filters = [
            'status' => $this->input->get('status'),
            'search' => $this->input->get('search')
        ];

        $data = [
            'orders'       => $this->order_model->get_all_orders($per_page, $offset, $filters),
            'total_orders' => $this->order_model->count_all_orders($filters),
            'per_page'     => $per_page,
            'current_page' => $page,
            'filters'      => $filters
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));
        $this->template->build('admin/orders', $data);
    }

    /**
     * View order details
     *
     * @param int $id
     * @return void
     */
    public function order_detail($id)
    {
        $order = $this->order_model->get_order($id);

        if (empty($order)) {
            show_404();
        }

        $data = [
            'order'        => $order,
            'items'        => $this->order_model->get_order_items($id),
            'payment_logs' => $this->order_model->get_payment_logs($id),
            'user'         => $this->user_model->find(['id' => $order->user_id])
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));
        $this->template->build('admin/order_detail', $data);
    }

    /**
     * Process/complete an order manually
     *
     * @param int $id
     * @return void
     */
    public function process_order($id)
    {
        require_permission('process.shop.order', 'shop');

        $order = $this->order_model->get_order($id);

        if (empty($order)) {
            show_404();
        }

        $action = $this->input->post('action');

        switch ($action) {
            case 'complete':
                $this->order_model->update_status($id, 'completed');
                // Process order items
                $items = $this->order_model->get_order_items($id);
                foreach ($items as $item) {
                    $this->order_model->update_item_status($item->id, 'delivered');
                }
                $this->session->set_flashdata('success', lang('alert_order_completed'));
                break;

            case 'cancel':
                $this->order_model->update_status($id, 'cancelled');
                // Refund points if payment was made with points
                if (in_array($order->payment_method, ['dp', 'vp', 'mixed'])) {
                    $user = $this->user_model->find(['id' => $order->user_id]);
                    if ($order->total_dp > 0) {
                        $this->user_model->update(['dp' => $user->dp + $order->total_dp], ['id' => $order->user_id]);
                    }
                    if ($order->total_vp > 0) {
                        $this->user_model->update(['vp' => $user->vp + $order->total_vp], ['id' => $order->user_id]);
                    }
                }
                $this->session->set_flashdata('success', lang('alert_order_cancelled'));
                break;

            case 'refund':
                $this->order_model->update_status($id, 'refunded');
                // Refund points
                $user = $this->user_model->find(['id' => $order->user_id]);
                if ($order->total_dp > 0) {
                    $this->user_model->update(['dp' => $user->dp + $order->total_dp], ['id' => $order->user_id]);
                }
                if ($order->total_vp > 0) {
                    $this->user_model->update(['vp' => $user->vp + $order->total_vp], ['id' => $order->user_id]);
                }
                $this->session->set_flashdata('success', lang('alert_order_refunded'));
                break;
        }

        $this->log_model->create('shop', $action, 'Order #' . $order->order_number . ' - ' . $action);
        redirect(site_url('shop/admin/orders/' . $id));
    }

    /**
     * Payment logs
     *
     * @return void
     */
    public function payments()
    {
        $per_page = 50;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $per_page;

        $data = [
            'payments' => $this->db->from('shop_payment_logs')
                ->order_by('created_at', 'DESC')
                ->limit($per_page, $offset)
                ->get()
                ->result(),
            'total' => $this->db->count_all_results('shop_payment_logs'),
            'per_page' => $per_page,
            'current_page' => $page
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));
        $this->template->build('admin/payments', $data);
    }
}
