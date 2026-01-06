<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends BS_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_module_installed('shop', true);

        if (config_item('shop_enabled') !== true) {
            show_error(lang('shop_disabled'), 403, lang('error'));
        }

        $this->load->language('shop/shop');
        $this->load->model([
            'shop_model',
            'order_model',
            'user_subscription_model'
        ]);
        $this->load->library('cart');
    }

    /**
     * Shop index page
     *
     * @return void
     */
    public function index()
    {
        $per_page = config_item('shop_items_per_page') ?? 12;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $per_page;

        $filters = [
            'search' => $this->input->get('search'),
            'featured' => $this->input->get('featured')
        ];

        $data = [
            'categories'     => $this->shop_model->get_categories(),
            'featured_items' => $this->shop_model->get_featured_items(8),
            'items'          => $this->shop_model->get_items($per_page, $offset, $filters),
            'total_items'    => $this->shop_model->count_items($filters),
            'services'       => $this->shop_model->get_services(6, 0),
            'subscriptions'  => $this->shop_model->get_subscriptions(4, 0),
            'per_page'       => $per_page,
            'current_page'   => $page,
            'cart_count'     => $this->cart->total_items()
        ];

        $this->template->title(lang('shop'), config_item('app_name'));
        $this->template->build('index', $data);
    }

    /**
     * Category page
     *
     * @param int $category_id
     * @return void
     */
    public function category($category_id)
    {
        $category = $this->shop_model->get_category($category_id);

        if (empty($category) || ! $category->is_active) {
            show_404();
        }

        $per_page = config_item('shop_items_per_page') ?? 12;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $per_page;

        $filters = [
            'category_id' => $category_id,
            'search' => $this->input->get('search')
        ];

        $data = [
            'category'   => $category,
            'categories' => $this->shop_model->get_categories(),
            'per_page'   => $per_page,
            'current_page' => $page,
            'cart_count' => $this->cart->total_items()
        ];

        // Load different content based on category type
        switch ($category->type) {
            case 'service':
                $data['services'] = $this->shop_model->get_services($per_page, $offset, $filters);
                $data['total_items'] = $this->shop_model->count_services($filters);
                break;
            case 'subscription':
                $data['subscriptions'] = $this->shop_model->get_subscriptions($per_page, $offset, $filters);
                $data['total_items'] = $this->shop_model->count_subscriptions($filters);
                break;
            default:
                $data['items'] = $this->shop_model->get_items($per_page, $offset, $filters);
                $data['total_items'] = $this->shop_model->count_items($filters);
        }

        $this->template->title($category->name, lang('shop'), config_item('app_name'));
        $this->template->build('category', $data);
    }

    /**
     * Item detail page
     *
     * @param int $id
     * @return void
     */
    public function item($id)
    {
        $item = $this->shop_model->get_item($id);

        if (empty($item) || ! $item->is_active) {
            show_404();
        }

        $data = [
            'item'       => $item,
            'category'   => $this->shop_model->get_category($item->category_id),
            'categories' => $this->shop_model->get_categories(),
            'realms'     => $this->realm_model->find_all(),
            'cart_count' => $this->cart->total_items()
        ];

        $this->template->title($item->name, lang('shop'), config_item('app_name'));
        $this->template->build('item', $data);
    }

    /**
     * Service detail page
     *
     * @param int $id
     * @return void
     */
    public function service($id)
    {
        $service = $this->shop_model->get_service($id);

        if (empty($service) || ! $service->is_active) {
            show_404();
        }

        $data = [
            'service'    => $service,
            'category'   => $this->shop_model->get_category($service->category_id),
            'categories' => $this->shop_model->get_categories(),
            'realms'     => $this->realm_model->find_all(),
            'cart_count' => $this->cart->total_items()
        ];

        // If service requires character, load user's characters
        if (is_logged_in() && $service->requires_character) {
            $data['characters'] = $this->_get_user_characters();
        }

        $this->template->title($service->name, lang('shop'), config_item('app_name'));
        $this->template->build('service', $data);
    }

    /**
     * Cart page
     *
     * @return void
     */
    public function cart()
    {
        require_login();

        $data = [
            'cart_items' => $this->cart->contents(),
            'total_dp'   => $this->cart->total_dp(),
            'total_vp'   => $this->cart->total_vp(),
            'categories' => $this->shop_model->get_categories(),
            'user'       => user()
        ];

        $this->template->title(lang('shop_cart'), lang('shop'), config_item('app_name'));
        $this->template->build('cart', $data);
    }

    /**
     * Add item to cart
     *
     * @return void
     */
    public function add_to_cart()
    {
        require_login();

        $product_type = $this->input->post('product_type') ?? 'item';
        $product_id = (int)$this->input->post('product_id');
        $quantity = max(1, (int)$this->input->post('quantity'));
        $realm_id = (int)$this->input->post('realm_id');
        $character_id = (int)$this->input->post('character_id');

        // Get product details
        switch ($product_type) {
            case 'service':
                $product = $this->shop_model->get_service($product_id);
                break;
            case 'subscription':
                $product = $this->shop_model->get_subscription($product_id);
                $quantity = 1; // Subscriptions can only be added once
                break;
            default:
                $product = $this->shop_model->get_item($product_id);
        }

        if (empty($product) || ! $product->is_active) {
            $this->session->set_flashdata('error', lang('shop_item_not_found'));
            redirect(site_url('shop'));
        }

        // Check stock for items
        if ($product_type === 'item' && ! $this->shop_model->check_stock($product_id, $quantity)) {
            $this->session->set_flashdata('error', lang('shop_item_out_of_stock'));
            redirect(site_url('shop/item/' . $product_id));
        }

        // Check purchase limit for items
        if ($product_type === 'item' && $product->max_per_user > 0) {
            if (! $this->shop_model->check_purchase_limit(user_id(), $product_id, $product->max_per_user)) {
                $this->session->set_flashdata('error', lang('shop_purchase_limit_reached'));
                redirect(site_url('shop/item/' . $product_id));
            }
        }

        // Check if already subscribed
        if ($product_type === 'subscription') {
            if ($this->user_subscription_model->has_active_subscription(user_id(), $product_id)) {
                $this->session->set_flashdata('error', lang('shop_already_subscribed'));
                redirect(site_url('shop/subscriptions'));
            }
        }

        // Add to cart
        $cart_data = [
            'id'           => $product_type . '_' . $product_id,
            'qty'          => $quantity,
            'name'         => $product->name,
            'dp'           => $product->price_dp ?? 0,
            'vp'           => $product->price_vp ?? 0,
            'price_money'  => $product->price_money ?? 0,
            'options'      => [
                'product_type'  => $product_type,
                'product_id'    => $product_id,
                'realm_id'      => $realm_id,
                'character_id'  => $character_id,
                'image'         => $product->image ?? ''
            ]
        ];

        if ($this->cart->insert($cart_data)) {
            $this->session->set_flashdata('success', lang('shop_item_added_to_cart'));
        } else {
            $this->session->set_flashdata('error', lang('shop_cart_add_error'));
        }

        redirect(site_url('shop/cart'));
    }

    /**
     * Update cart item
     *
     * @return void
     */
    public function update_cart()
    {
        require_login();

        $rowid = $this->input->post('rowid');
        $qty = max(0, (int)$this->input->post('qty'));

        $this->cart->update(['rowid' => $rowid, 'qty' => $qty]);

        $this->session->set_flashdata('success', lang('shop_cart_updated'));
        redirect(site_url('shop/cart'));
    }

    /**
     * Remove item from cart
     *
     * @param string $rowid
     * @return void
     */
    public function remove_from_cart($rowid)
    {
        require_login();

        $this->cart->remove($rowid);

        $this->session->set_flashdata('success', lang('shop_item_removed_from_cart'));
        redirect(site_url('shop/cart'));
    }

    /**
     * Clear cart
     *
     * @return void
     */
    public function clear_cart()
    {
        require_login();

        $this->cart->destroy();

        $this->session->set_flashdata('success', lang('shop_cart_cleared'));
        redirect(site_url('shop'));
    }

    /**
     * Checkout page
     *
     * @return void
     */
    public function checkout()
    {
        require_login();

        if ($this->cart->total_items() === 0) {
            $this->session->set_flashdata('error', lang('shop_cart_empty'));
            redirect(site_url('shop'));
        }

        $user = user();
        $cart_items = $this->cart->contents();
        $total_dp = $this->cart->total_dp();
        $total_vp = $this->cart->total_vp();

        // Calculate total money
        $total_money = 0;
        foreach ($cart_items as $item) {
            $total_money += ($item['price_money'] ?? 0) * $item['qty'];
        }

        $can_pay_with_points = (
            ($total_dp <= 0 || (config_item('shop_allow_dp_payment') && $user->dp >= $total_dp))
            &&
            ($total_vp <= 0 || (config_item('shop_allow_vp_payment') && $user->vp >= $total_vp))
        );

        $data = [
            'cart_items'          => $cart_items,
            'total_dp'            => $total_dp,
            'total_vp'            => $total_vp,
            'total_money'         => $total_money,
            'user'                => $user,
            'can_pay_with_points' => $can_pay_with_points,
            'allow_dp_payment'    => config_item('shop_allow_dp_payment'),
            'allow_vp_payment'    => config_item('shop_allow_vp_payment'),
            'allow_money_payment' => config_item('shop_allow_money_payment'),
            'paypal_enabled'      => config_item('shop_paypal_enabled'),
            'stripe_enabled'      => config_item('shop_stripe_enabled'),
            'currency'            => config_item('shop_currency') ?? 'USD',
            'realms'              => $this->realm_model->find_all()
        ];

        $this->template->title(lang('shop_checkout'), lang('shop'), config_item('app_name'));
        $this->template->build('checkout', $data);
    }

    public function checkout_characters($realm_id)
    {
        require_login();

        if (! $this->input->is_ajax_request()) {
            show_404();
        }

        $realm_id = (int) $realm_id;

        $this->load->model('server_characters_model');

        $rows = $this->server_characters_model->all_characters($realm_id, user_id());
        $characters = [];

        foreach ($rows as $row) {
            $characters[] = [
                'guid'  => (int) ($row->guid ?? 0),
                'name'  => (string) ($row->name ?? ''),
                'level' => (int) ($row->level ?? 0)
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['characters' => $characters]));
    }

    /**
     * Process checkout
     *
     * @return void
     */
    public function process_checkout()
    {
        require_login();

        if ($this->cart->total_items() === 0) {
            $this->session->set_flashdata('error', lang('shop_cart_empty'));
            redirect(site_url('shop'));
        }

        $payment_method = $this->input->post('payment_method');
        $realm_id = (int) $this->input->post('realm_id');
        $character_id = (int) $this->input->post('character_id');
        $user = user();
        $cart_items = $this->cart->contents();

        $total_dp = $this->cart->total_dp();
        $total_vp = $this->cart->total_vp();
        $total_money = 0;

        foreach ($cart_items as $item) {
            $total_money += ($item['price_money'] ?? 0) * $item['qty'];
        }

        // Validate payment method
        switch ($payment_method) {
            case 'points':
                if ($total_dp > 0) {
                    if (! config_item('shop_allow_dp_payment')) {
                        $this->session->set_flashdata('error', lang('shop_payment_method_disabled'));
                        redirect(site_url('shop/checkout'));
                    }
                    if ($user->dp < $total_dp) {
                        $this->session->set_flashdata('error', lang('shop_insufficient_dp'));
                        redirect(site_url('shop/checkout'));
                    }
                }

                if ($total_vp > 0) {
                    if (! config_item('shop_allow_vp_payment')) {
                        $this->session->set_flashdata('error', lang('shop_payment_method_disabled'));
                        redirect(site_url('shop/checkout'));
                    }
                    if ($user->vp < $total_vp) {
                        $this->session->set_flashdata('error', lang('shop_insufficient_vp'));
                        redirect(site_url('shop/checkout'));
                    }
                }
                break;

            case 'paypal':
                if (! config_item('shop_paypal_enabled')) {
                    $this->session->set_flashdata('error', lang('shop_payment_method_disabled'));
                    redirect(site_url('shop/checkout'));
                }
                $this->_process_paypal_checkout($total_money);
                return;

            case 'stripe':
                if (! config_item('shop_stripe_enabled')) {
                    $this->session->set_flashdata('error', lang('shop_payment_method_disabled'));
                    redirect(site_url('shop/checkout'));
                }
                $this->_process_stripe_checkout($total_money);
                return;

            default:
                $this->session->set_flashdata('error', lang('shop_invalid_payment_method'));
                redirect(site_url('shop/checkout'));
        }

        $order_payment_method = 'dp';
        if ($payment_method === 'points') {
            if ($total_dp > 0 && $total_vp > 0) {
                $order_payment_method = 'mixed';
            } elseif ($total_vp > 0) {
                $order_payment_method = 'vp';
            } else {
                $order_payment_method = 'dp';
            }
        }

        // Create order
        $order_id = $this->order_model->create_order([
            'user_id'        => user_id(),
            'status'         => 'processing',
            'payment_method' => $order_payment_method,
            'total_dp'       => $payment_method === 'points' ? $total_dp : 0,
            'total_vp'       => $payment_method === 'points' ? $total_vp : 0,
            'total_money'    => 0,
            'currency'       => config_item('shop_currency') ?? 'USD'
        ]);

        if (! $order_id) {
            $this->session->set_flashdata('error', lang('shop_order_create_error'));
            redirect(site_url('shop/checkout'));
        }

        // Add order items
        foreach ($cart_items as $item) {
            $this->order_model->add_order_item($order_id, [
                'product_type'   => $item['options']['product_type'],
                'product_id'     => $item['options']['product_id'],
                'product_name'   => $item['name'],
                'quantity'       => $item['qty'],
                'price_dp'       => $item['dp'],
                'price_vp'       => $item['vp'],
                'price_money'    => $item['price_money'] ?? 0,
                'realm_id'       => $realm_id ?: ($item['options']['realm_id'] ?? 0),
                'character_id'   => $character_id ?: ($item['options']['character_id'] ?? null),
                'status'         => 'pending',
                'product_data'   => json_encode($item)
            ]);
        }

        // Deduct points
        if ($payment_method === 'points') {
            if ($total_dp > 0) {
                $this->user_model->update(['dp' => $user->dp - $total_dp], ['id' => user_id()]);
            }
            if ($total_vp > 0) {
                $this->user_model->update(['vp' => $user->vp - $total_vp], ['id' => user_id()]);
            }
        }

        // Log payment
        if ($payment_method === 'points') {
            if ($total_dp > 0) {
                $this->order_model->log_payment([
                    'order_id'       => $order_id,
                    'payment_method' => 'dp',
                    'amount'         => $total_dp,
                    'currency'       => 'DP',
                    'status'         => 'completed'
                ]);
            }

            if ($total_vp > 0) {
                $this->order_model->log_payment([
                    'order_id'       => $order_id,
                    'payment_method' => 'vp',
                    'amount'         => $total_vp,
                    'currency'       => 'VP',
                    'status'         => 'completed'
                ]);
            }
        }

        // Process order items (deliver items, apply services)
        $this->_process_order_items($order_id);

        // Clear cart
        $this->cart->destroy();

        // Update order status
        $this->order_model->update_status($order_id, 'completed');

        // Log action
        $this->log_model->create('shop', 'purchase', 'Completed order #' . $order_id);

        $this->session->set_flashdata('success', lang('shop_order_completed'));
        redirect(site_url('shop/history/' . $order_id));
    }

    /**
     * Order history
     *
     * @return void
     */
    public function history()
    {
        require_login();

        $per_page = 10;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $per_page;

        $data = [
            'orders'       => $this->order_model->get_user_orders(user_id(), $per_page, $offset),
            'total_orders' => $this->order_model->count_user_orders(user_id()),
            'per_page'     => $per_page,
            'current_page' => $page,
            'categories'   => $this->shop_model->get_categories()
        ];

        $this->template->title(lang('shop_order_history'), lang('shop'), config_item('app_name'));
        $this->template->build('history', $data);
    }

    /**
     * Order detail
     *
     * @param int $order_id
     * @return void
     */
    public function order_detail($order_id)
    {
        require_login();

        $order = $this->order_model->get_order($order_id);

        if (empty($order) || $order->user_id != user_id()) {
            show_404();
        }

        $data = [
            'order'      => $order,
            'items'      => $this->order_model->get_order_items($order_id),
            'categories' => $this->shop_model->get_categories()
        ];

        $this->template->title(lang('shop_order') . ' #' . $order->order_number, lang('shop'), config_item('app_name'));
        $this->template->build('order_detail', $data);
    }

    /**
     * Checkout success page
     *
     * @return void
     */
    public function checkout_success()
    {
        require_login();

        $data = [
            'categories' => $this->shop_model->get_categories()
        ];

        $this->template->title(lang('shop_checkout_success'), lang('shop'), config_item('app_name'));
        $this->template->build('checkout_success', $data);
    }

    /**
     * Checkout cancel page
     *
     * @return void
     */
    public function checkout_cancel()
    {
        require_login();

        $data = [
            'categories' => $this->shop_model->get_categories()
        ];

        $this->template->title(lang('shop_checkout_cancelled'), lang('shop'), config_item('app_name'));
        $this->template->build('checkout_cancel', $data);
    }

    /**
     * Process order items (deliver in-game)
     *
     * @param int $order_id
     * @return void
     */
    private function _process_order_items($order_id)
    {
        $items = $this->order_model->get_order_items($order_id);

        foreach ($items as $item) {
            switch ($item->product_type) {
                case 'item':
                    $this->_deliver_item($item);
                    break;
                case 'service':
                    $this->_apply_service($item);
                    break;
                case 'subscription':
                    $this->_activate_subscription($item);
                    break;
            }
        }
    }

    /**
     * Deliver in-game item
     *
     * @param object $order_item
     * @return bool
     */
    private function _deliver_item($order_item)
    {
        $product = $this->shop_model->get_item($order_item->product_id);
        
        if (empty($product)) {
            return false;
        }

        // Get realm connection
        $realm_id = $order_item->realm_id ?: 1;
        
        // TODO: Implement actual item delivery via SOAP or direct DB
        // This depends on your emulator (TrinityCore, AzerothCore, etc.)
        // Example for AzerothCore using soap:
        // $this->_send_mail($order_item->character_id, $product->item_id, $product->item_count * $order_item->quantity);

        // For now, mark as delivered
        $this->order_model->update_item_status($order_item->id, 'delivered');
        
        // Reduce stock
        $this->shop_model->reduce_stock($product->id, $order_item->quantity);

        return true;
    }

    /**
     * Apply character service
     *
     * @param object $order_item
     * @return bool
     */
    private function _apply_service($order_item)
    {
        $service = $this->shop_model->get_service($order_item->product_id);
        
        if (empty($service)) {
            return false;
        }

        // TODO: Implement service application based on service_type
        // Examples:
        // - rename: Set character at_login flag for rename
        // - race_change: Set at_login flag for race change
        // - faction_change: Set at_login flag for faction change
        // - level_boost: Update character level directly
        // - gold: Send gold via mail

        $this->order_model->update_item_status($order_item->id, 'delivered');

        return true;
    }

    /**
     * Activate subscription
     *
     * @param object $order_item
     * @return bool
     */
    private function _activate_subscription($order_item)
    {
        $subscription = $this->shop_model->get_subscription($order_item->product_id);
        
        if (empty($subscription)) {
            return false;
        }

        $period_end = $this->user_subscription_model->calculate_next_billing_date(
            $subscription->interval_type,
            $subscription->interval_count
        );

        $this->user_subscription_model->create([
            'user_id'              => user_id(),
            'subscription_id'      => $subscription->id,
            'order_id'             => $order_item->order_id,
            'status'               => 'active',
            'payment_method'       => 'dp', // or vp based on order
            'realm_id'             => $order_item->realm_id ?: 0,
            'character_id'         => $order_item->character_id,
            'current_period_start' => current_date(),
            'current_period_end'   => $period_end
        ]);

        $this->order_model->update_item_status($order_item->id, 'delivered');

        return true;
    }

    /**
     * Process PayPal checkout
     *
     * @param float $amount
     * @return void
     */
    private function _process_paypal_checkout($amount)
    {
        // TODO: Implement PayPal integration
        // Store cart in session and redirect to PayPal
        $this->session->set_flashdata('error', lang('shop_paypal_not_configured'));
        redirect(site_url('shop/checkout'));
    }

    /**
     * Process Stripe checkout
     *
     * @param float $amount
     * @return void
     */
    private function _process_stripe_checkout($amount)
    {
        // TODO: Implement Stripe integration
        $this->session->set_flashdata('error', lang('shop_stripe_not_configured'));
        redirect(site_url('shop/checkout'));
    }

}
