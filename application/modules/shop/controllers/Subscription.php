<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends BS_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_module_installed('shop', true);
        require_login();

        $this->load->language('shop/shop');
        $this->load->model([
            'shop_model',
            'order_model',
            'user_subscription_model'
        ]);
    }

    /**
     * User subscriptions page
     *
     * @return void
     */
    public function index()
    {
        $data = [
            'active_subscriptions'    => $this->user_subscription_model->get_user_subscriptions(user_id(), 'active'),
            'cancelled_subscriptions' => $this->user_subscription_model->get_user_subscriptions(user_id(), 'cancelled'),
            'expired_subscriptions'   => $this->user_subscription_model->get_user_subscriptions(user_id(), 'expired'),
            'available_subscriptions' => $this->shop_model->get_subscriptions(100, 0),
            'categories'              => $this->shop_model->get_categories(),
            'user'                    => user()
        ];

        $this->template->title(lang('shop_my_subscriptions'), lang('shop'), config_item('app_name'));
        $this->template->build('subscriptions/index', $data);
    }

    /**
     * View subscription details
     *
     * @param int $id
     * @return void
     */
    public function view($id)
    {
        $subscription = $this->user_subscription_model->get($id);

        if (empty($subscription) || $subscription->user_id != user_id()) {
            show_404();
        }

        $data = [
            'subscription' => $subscription,
            'categories'   => $this->shop_model->get_categories(),
            'user'         => user()
        ];

        $this->template->title($subscription->name, lang('shop_my_subscriptions'), config_item('app_name'));
        $this->template->build('subscriptions/view', $data);
    }

    /**
     * Subscribe to a plan (quick subscribe with points)
     *
     * @param int $subscription_id
     * @return void
     */
    public function subscribe($subscription_id)
    {
        $plan = $this->shop_model->get_subscription($subscription_id);

        if (empty($plan) || ! $plan->is_active) {
            $this->session->set_flashdata('error', lang('shop_subscription_not_found'));
            redirect(site_url('shop/subscriptions'));
        }

        // Check if already subscribed
        if ($this->user_subscription_model->has_active_subscription(user_id(), $subscription_id)) {
            $this->session->set_flashdata('error', lang('shop_already_subscribed'));
            redirect(site_url('shop/subscriptions'));
        }

        $payment_method = $this->input->post('payment_method');
        $user = user();

        if ($payment_method === 'points') {
            if ($plan->price_dp > 0 && $plan->price_vp > 0) {
                $this->session->set_flashdata('error', lang('shop_invalid_payment_method'));
                redirect(site_url('shop/subscriptions'));
            }

            $payment_method = ($plan->price_vp > 0) ? 'vp' : 'dp';
        }

        // Validate payment
        switch ($payment_method) {
            case 'dp':
                if (! config_item('shop_allow_dp_payment') || $user->dp < $plan->price_dp) {
                    $this->session->set_flashdata('error', lang('shop_insufficient_dp'));
                    redirect(site_url('shop/subscriptions'));
                }
                $this->user_model->update(['dp' => $user->dp - $plan->price_dp], ['id' => user_id()]);
                break;

            case 'vp':
                if (! config_item('shop_allow_vp_payment') || $user->vp < $plan->price_vp) {
                    $this->session->set_flashdata('error', lang('shop_insufficient_vp'));
                    redirect(site_url('shop/subscriptions'));
                }
                $this->user_model->update(['vp' => $user->vp - $plan->price_vp], ['id' => user_id()]);
                break;

            default:
                $this->session->set_flashdata('error', lang('shop_invalid_payment_method'));
                redirect(site_url('shop/subscriptions'));
        }

        // Calculate period
        $period_end = $this->user_subscription_model->calculate_next_billing_date(
            $plan->interval_type,
            $plan->interval_count
        );

        // Create subscription
        $sub_id = $this->user_subscription_model->create([
            'user_id'              => user_id(),
            'subscription_id'      => $subscription_id,
            'status'               => 'active',
            'payment_method'       => $payment_method,
            'realm_id'             => $this->input->post('realm_id') ?: 0,
            'character_id'         => $this->input->post('character_id') ?: null,
            'current_period_start' => current_date(),
            'current_period_end'   => $period_end
        ]);

        if ($sub_id) {
            $this->log_model->create('shop', 'subscribe', 'Subscribed to ' . $plan->name);
            $this->session->set_flashdata('success', lang('shop_subscription_activated'));
        } else {
            $this->session->set_flashdata('error', lang('shop_subscription_error'));
        }

        redirect(site_url('shop/subscriptions'));
    }

    /**
     * Cancel subscription
     *
     * @param int $id
     * @return void
     */
    public function cancel($id)
    {
        $subscription = $this->user_subscription_model->get($id);

        if (empty($subscription) || $subscription->user_id != user_id()) {
            $this->session->set_flashdata('error', lang('shop_subscription_not_found'));
            redirect(site_url('shop/subscriptions'));
        }

        if ($subscription->status !== 'active') {
            $this->session->set_flashdata('error', lang('shop_subscription_not_active'));
            redirect(site_url('shop/subscriptions'));
        }

        // If it's a gateway subscription, cancel with the gateway
        if (! empty($subscription->external_subscription_id)) {
            $cancel_result = false;
            
            if ($subscription->payment_method === 'paypal') {
                $cancel_result = $this->_cancel_paypal_subscription($subscription->external_subscription_id);
            } elseif ($subscription->payment_method === 'stripe') {
                $cancel_result = $this->_cancel_stripe_subscription($subscription->external_subscription_id);
            }

            if (!$cancel_result) {
                $this->session->set_flashdata('error', lang('shop_subscription_gateway_cancel_error'));
                redirect(site_url('shop/subscriptions'));
                return;
            }
        }

        if ($this->user_subscription_model->cancel($id)) {
            $this->log_model->create('shop', 'cancel_subscription', 'Cancelled subscription #' . $id);
            $this->session->set_flashdata('success', lang('shop_subscription_cancelled'));
        } else {
            $this->session->set_flashdata('error', lang('shop_subscription_cancel_error'));
        }

        redirect(site_url('shop/subscriptions'));
    }

    /**
     * Cancel PayPal subscription
     *
     * @param string $subscription_id
     * @return bool
     */
    private function _cancel_paypal_subscription($subscription_id)
    {
        $paypal_config = [
            'mode' => config_item('paypal_mode') ?? 'sandbox',
            'client_id' => config_item('paypal_client_id'),
            'secret' => config_item('paypal_secret'),
        ];

        if (empty($paypal_config['client_id']) || empty($paypal_config['secret'])) {
            return false;
        }

        try {
            $token = $this->_get_paypal_access_token($paypal_config);
            if (!$token) {
                return false;
            }

            $api_url = 'https://api.' . ($paypal_config['mode'] === 'sandbox' ? 'sandbox.' : '') . 
                       'paypal.com/v1/billing/subscriptions/' . $subscription_id . '/cancel';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['reason' => 'User requested cancellation']));

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return in_array($http_code, [200, 204]);

        } catch (Exception $e) {
            log_message('error', 'PayPal subscription cancellation error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Cancel Stripe subscription
     *
     * @param string $subscription_id
     * @return bool
     */
    private function _cancel_stripe_subscription($subscription_id)
    {
        $stripe_secret = config_item('stripe_secret_key');

        if (empty($stripe_secret)) {
            return false;
        }

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/subscriptions/' . $subscription_id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_USERPWD, $stripe_secret . ':');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded'
            ]);

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return in_array($http_code, [200, 204]);

        } catch (Exception $e) {
            log_message('error', 'Stripe subscription cancellation error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get PayPal access token
     *
     * @param array $config
     * @return string|false
     */
    private function _get_paypal_access_token($config)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.' . ($config['mode'] === 'sandbox' ? 'sandbox.' : '') . 'paypal.com/v1/oauth2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $config['client_id'] . ':' . $config['secret']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');

        $response = curl_exec($ch);
        curl_close($ch);

        $token_data = json_decode($response, true);
        
        return $token_data['access_token'] ?? false;
    }

    /**
     * Renew subscription manually
     *
     * @param int $id
     * @return void
     */
    public function renew($id)
    {
        $subscription = $this->user_subscription_model->get($id);

        if (empty($subscription) || $subscription->user_id != user_id()) {
            $this->session->set_flashdata('error', lang('shop_subscription_not_found'));
            redirect(site_url('shop/subscriptions'));
        }

        $plan = $this->shop_model->get_subscription($subscription->subscription_id);

        if (empty($plan) || ! $plan->is_active) {
            $this->session->set_flashdata('error', lang('shop_subscription_plan_inactive'));
            redirect(site_url('shop/subscriptions'));
        }

        $payment_method = $this->input->post('payment_method');
        $user = user();

        if ($payment_method === 'points') {
            if ($plan->price_dp > 0 && $plan->price_vp > 0) {
                $this->session->set_flashdata('error', lang('shop_invalid_payment_method'));
                redirect(site_url('shop/subscriptions/' . $id));
            }

            $payment_method = ($plan->price_vp > 0) ? 'vp' : 'dp';
        }

        // Validate payment
        switch ($payment_method) {
            case 'dp':
                if ($user->dp < $plan->price_dp) {
                    $this->session->set_flashdata('error', lang('shop_insufficient_dp'));
                    redirect(site_url('shop/subscriptions/' . $id));
                }
                $this->user_model->update(['dp' => $user->dp - $plan->price_dp], ['id' => user_id()]);
                break;

            case 'vp':
                if ($user->vp < $plan->price_vp) {
                    $this->session->set_flashdata('error', lang('shop_insufficient_vp'));
                    redirect(site_url('shop/subscriptions/' . $id));
                }
                $this->user_model->update(['vp' => $user->vp - $plan->price_vp], ['id' => user_id()]);
                break;

            default:
                $this->session->set_flashdata('error', lang('shop_invalid_payment_method'));
                redirect(site_url('shop/subscriptions/' . $id));
        }

        if ($this->user_subscription_model->renew($id, $plan->interval_type, $plan->interval_count)) {
            $this->log_model->create('shop', 'renew_subscription', 'Renewed subscription #' . $id);
            $this->session->set_flashdata('success', lang('shop_subscription_renewed'));
        } else {
            $this->session->set_flashdata('error', lang('shop_subscription_renew_error'));
        }

        redirect(site_url('shop/subscriptions'));
    }
}
