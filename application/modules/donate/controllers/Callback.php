<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Callback extends BS_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_module_installed('donate', true);

        $this->load->language('donate/donate');
        $this->load->model(['donate/donate_model', 'user_model']);
    }

    /**
     * PayPal IPN callback
     *
     * @return void
     */
    public function paypal()
    {
        // Handle PayPal IPN
        $raw_post = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post);
        $myPost = [];

        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }

        $req = 'cmd=_notify-validate';
        foreach ($myPost as $key => $value) {
            $req .= "&$key=" . urlencode($value);
        }

        // Get gateway config
        $gateway = $this->donate_model->get_gateway('paypal');
        if (!$gateway) {
            log_message('error', 'PayPal IPN: Gateway not found');
            return;
        }

        $config = json_decode($gateway->config, true);
        $sandbox = $gateway->is_sandbox;

        // Verify with PayPal
        $paypal_url = $sandbox ? 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr' : 'https://ipnpb.paypal.com/cgi-bin/webscr';

        $ch = curl_init($paypal_url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Connection: Close']);

        $response = curl_exec($ch);
        curl_close($ch);

        if (strcmp($response, 'VERIFIED') == 0) {
            $payment_status = $this->input->post('payment_status');
            $txn_id = $this->input->post('txn_id');
            $custom = $this->input->post('custom'); // log_id

            $log = $this->donate_model->get_log($custom);

            if (!$log) {
                log_message('error', 'PayPal IPN: Log not found for ID ' . $custom);
                return;
            }

            if ($payment_status == 'Completed') {
                // Verify amount and currency
                $mc_gross = $this->input->post('mc_gross');
                $mc_currency = $this->input->post('mc_currency');

                if ($mc_gross != $log->amount || $mc_currency != $log->currency) {
                    log_message('error', 'PayPal IPN: Amount/Currency mismatch');
                    $this->donate_model->update_log($log->id, [
                        'status' => 'failed',
                        'gateway_response' => json_encode($myPost)
                    ]);
                    return;
                }

                // Check for duplicate transaction
                $existing = $this->donate_model->get_log_by_transaction($txn_id);
                if ($existing) {
                    log_message('error', 'PayPal IPN: Duplicate transaction ' . $txn_id);
                    return;
                }

                // Update log and award points
                $this->donate_model->update_log($log->id, [
                    'transaction_id' => $txn_id,
                    'status' => 'completed',
                    'gateway_response' => json_encode($myPost)
                ]);

                // Award DP to user
                $user = $this->user_model->find(['id' => $log->user_id]);
                if ($user) {
                    $new_dp = $user->dp + $log->dp_awarded;
                    $this->user_model->update(['dp' => $new_dp], ['id' => $log->user_id]);
                }

                log_message('info', 'PayPal IPN: Payment completed for log ' . $log->id);
            }
        } else {
            log_message('error', 'PayPal IPN: Invalid response');
        }
    }

    /**
     * PayPal return URL handler
     *
     * @return void
     */
    public function paypal_return()
    {
        $log_id = $this->input->get('log_id');

        if ($log_id) {
            $log = $this->donate_model->get_log($log_id);

            if ($log && $log->status == 'completed') {
                $this->session->set_flashdata('success', lang('donate_payment_success'));
                redirect('donate/success');
            }
        }

        // Payment pending or processing
        $this->session->set_flashdata('info', lang('donate_payment_pending'));
        redirect('donate/success');
    }

    /**
     * Stripe webhook callback
     *
     * @return void
     */
    public function stripe()
    {
        $gateway = $this->donate_model->get_gateway('stripe');
        if (!$gateway) {
            http_response_code(400);
            return;
        }

        $config = json_decode($gateway->config, true);
        $endpoint_secret = $config['webhook_secret'] ?? '';

        $payload = file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';

        // Verify webhook signature if secret is set
        if (!empty($endpoint_secret)) {
            $elements = explode(',', $sig_header);
            $timestamp = null;
            $signature = null;

            foreach ($elements as $element) {
                $parts = explode('=', $element, 2);
                if ($parts[0] === 't') {
                    $timestamp = $parts[1];
                } elseif ($parts[0] === 'v1') {
                    $signature = $parts[1];
                }
            }

            $signed_payload = $timestamp . '.' . $payload;
            $expected_signature = hash_hmac('sha256', $signed_payload, $endpoint_secret);

            if (!hash_equals($expected_signature, $signature)) {
                log_message('error', 'Stripe webhook: Invalid signature');
                http_response_code(400);
                return;
            }
        }

        $event = json_decode($payload, true);

        if ($event['type'] === 'checkout.session.completed') {
            $session = $event['data']['object'];
            $log_id = $session['metadata']['log_id'] ?? null;

            if ($log_id) {
                $log = $this->donate_model->get_log($log_id);

                if ($log && $log->status === 'pending') {
                    // Update log
                    $this->donate_model->update_log($log->id, [
                        'transaction_id' => $session['payment_intent'] ?? $session['id'],
                        'status' => 'completed',
                        'gateway_response' => json_encode($session)
                    ]);

                    // Award DP to user
                    $user = $this->user_model->find(['id' => $log->user_id]);
                    if ($user) {
                        $new_dp = $user->dp + $log->dp_awarded;
                        $this->user_model->update(['dp' => $new_dp], ['id' => $log->user_id]);
                    }

                    log_message('info', 'Stripe webhook: Payment completed for log ' . $log->id);
                }
            }
        }

        http_response_code(200);
    }

    /**
     * Stripe return URL handler
     *
     * @return void
     */
    public function stripe_return()
    {
        $log_id = $this->input->get('log_id');

        if ($log_id) {
            $log = $this->donate_model->get_log($log_id);

            if ($log) {
                if ($log->status == 'completed') {
                    $this->session->set_flashdata('success', lang('donate_payment_success'));
                } else {
                    $this->session->set_flashdata('info', lang('donate_payment_pending'));
                }
            }
        }

        redirect('donate/success');
    }
}
