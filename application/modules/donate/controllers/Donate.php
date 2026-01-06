<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Donate extends BS_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_module_installed('donate', true);

        $this->load->language('donate/donate');
        $this->load->model('donate/donate_model');

        // Settings are loaded via hook after constructor, so check directly from model
        if ($this->setting_model->get_value('donate_enabled') !== true) {
            show_error(lang('donate_disabled'), 403, lang('error'));
        }
    }

    /**
     * Donate index page
     *
     * @return void
     */
    public function index()
    {
        $data = [
            'featured_packages' => $this->donate_model->get_featured_packages(4),
            'packages'          => $this->donate_model->get_packages(12, 0),
            'gateways'          => $this->donate_model->get_gateways(),
            'top_donators'      => $this->donate_model->get_top_donators(5)
        ];

        $this->template->title(lang('donate'), config_item('app_name'));
        $this->template->build('index', $data);
    }

    /**
     * All packages page
     *
     * @return void
     */
    public function packages()
    {
        $per_page = 12;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $per_page;

        $data = [
            'packages'     => $this->donate_model->get_packages($per_page, $offset),
            'total'        => $this->donate_model->count_packages(),
            'per_page'     => $per_page,
            'current_page' => $page
        ];

        $this->template->title(lang('donate_packages'), config_item('app_name'));
        $this->template->build('packages', $data);
    }

    /**
     * Single package view
     *
     * @param int $id
     * @return void
     */
    public function package($id)
    {
        $package = $this->donate_model->get_package($id);

        if (empty($package) || !$package->is_active) {
            show_404();
        }

        $data = [
            'package'  => $package,
            'gateways' => $this->donate_model->get_gateways()
        ];

        $this->template->title($package->name, lang('donate'), config_item('app_name'));
        $this->template->build('package', $data);
    }

    /**
     * Process donation
     *
     * @param int $id
     * @return void
     */
    public function process($id)
    {
        require_login();

        $package = $this->donate_model->get_package($id);

        if (empty($package) || !$package->is_active) {
            show_404();
        }

        $gateway_name = $this->input->post('gateway');
        $gateway = $this->donate_model->get_gateway($gateway_name);

        if (empty($gateway) || !$gateway->is_active) {
            $this->session->set_flashdata('error', lang('donate_invalid_gateway'));
            redirect('donate/package/' . $id);
            return;
        }

        // Create pending donation log
        $log_id = $this->donate_model->create_log([
            'user_id'    => $this->session->userdata('id'),
            'package_id' => $package->id,
            'gateway'    => $gateway_name,
            'amount'     => $package->price,
            'currency'   => $package->currency,
            'dp_awarded' => $package->dp_amount + $package->bonus_dp,
            'status'     => 'pending',
            'ip_address' => $this->input->ip_address()
        ]);

        if (!$log_id) {
            $this->session->set_flashdata('error', lang('donate_process_error'));
            redirect('donate/package/' . $id);
            return;
        }

        // Store log ID in session for callback
        $this->session->set_userdata('donate_log_id', $log_id);

        // Redirect to payment gateway
        $this->_redirect_to_gateway($gateway, $package, $log_id);
    }

    /**
     * Redirect to payment gateway
     *
     * @param object $gateway
     * @param object $package
     * @param int $log_id
     * @return void
     */
    private function _redirect_to_gateway($gateway, $package, $log_id)
    {
        $config = json_decode($gateway->config, true);

        switch ($gateway->name) {
            case 'paypal':
                $this->_process_paypal($config, $package, $log_id, $gateway->is_sandbox);
                break;
            case 'stripe':
                $this->_process_stripe($config, $package, $log_id);
                break;
            default:
                $this->session->set_flashdata('error', lang('donate_gateway_not_supported'));
                redirect('donate');
        }
    }

    /**
     * Process PayPal payment
     *
     * @param array $config
     * @param object $package
     * @param int $log_id
     * @param bool $sandbox
     * @return void
     */
    private function _process_paypal($config, $package, $log_id, $sandbox = true)
    {
        $paypal_url = $sandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

        $return_url = site_url('donate/callback/paypal?log_id=' . $log_id);
        $cancel_url = site_url('donate/cancel');
        $notify_url = site_url('donate/callback/paypal');

        // Simple PayPal form redirect
        $data = [
            'paypal_url' => $paypal_url,
            'business'   => $config['client_id'], // For simple integration, use PayPal email
            'item_name'  => $package->name,
            'amount'     => $package->price,
            'currency'   => $package->currency,
            'custom'     => $log_id,
            'return_url' => $return_url,
            'cancel_url' => $cancel_url,
            'notify_url' => $notify_url
        ];

        $this->template->build('gateways/paypal_redirect', $data);
    }

    /**
     * Process Stripe payment
     *
     * @param array $config
     * @param object $package
     * @param int $log_id
     * @return void
     */
    private function _process_stripe($config, $package, $log_id)
    {
        $data = [
            'publishable_key' => $config['publishable_key'],
            'package'         => $package,
            'log_id'          => $log_id,
            'success_url'     => site_url('donate/callback/stripe?session_id={CHECKOUT_SESSION_ID}&log_id=' . $log_id),
            'cancel_url'      => site_url('donate/cancel')
        ];

        $this->template->build('gateways/stripe_checkout', $data);
    }

    /**
     * Donation success page
     *
     * @return void
     */
    public function success()
    {
        require_login();

        $data = [
            'message' => $this->session->flashdata('success') ?? lang('donate_success')
        ];

        $this->template->title(lang('donate_success_title'), config_item('app_name'));
        $this->template->build('success', $data);
    }

    /**
     * Donation cancelled page
     *
     * @return void
     */
    public function cancel()
    {
        $log_id = $this->session->userdata('donate_log_id');

        if ($log_id) {
            $this->donate_model->update_log($log_id, ['status' => 'cancelled']);
            $this->session->unset_userdata('donate_log_id');
        }

        $this->template->title(lang('donate_cancelled'), config_item('app_name'));
        $this->template->build('cancel');
    }

    /**
     * Donation history page
     *
     * @return void
     */
    public function history()
    {
        require_login();

        $per_page = 20;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $per_page;

        $user_id = $this->session->userdata('id');

        $data = [
            'logs'         => $this->donate_model->get_user_logs($user_id, $per_page, $offset),
            'total'        => $this->donate_model->count_user_logs($user_id),
            'per_page'     => $per_page,
            'current_page' => $page
        ];

        $this->template->title(lang('donate_history'), config_item('app_name'));
        $this->template->build('history', $data);
    }

    /**
     * Top donators page
     *
     * @return void
     */
    public function top_donators()
    {
        $data = [
            'donators' => $this->donate_model->get_top_donators(50)
        ];

        $this->template->title(lang('donate_top_donators'), config_item('app_name'));
        $this->template->build('top_donators', $data);
    }
}
