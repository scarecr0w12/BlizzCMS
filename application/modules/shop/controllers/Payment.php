<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends BS_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_module_installed('shop', true);

        $this->load->language('shop/shop');
        $this->load->model([
            'shop_model',
            'order_model',
            'user_subscription_model'
        ]);
    }

    /**
     * PayPal IPN callback
     *
     * @return void
     */
    public function paypal_callback()
    {
        // Verify PayPal IPN
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
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

        // Post back to PayPal to validate
        $sandbox = config_item('shop_paypal_sandbox');
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
        
        $res = curl_exec($ch);
        curl_close($ch);

        if (strcmp($res, 'VERIFIED') !== 0) {
            log_message('error', 'PayPal IPN verification failed');
            return;
        }

        // Process the payment
        $payment_status = $this->input->post('payment_status');
        $custom = $this->input->post('custom'); // Order ID
        $txn_id = $this->input->post('txn_id');
        $mc_gross = $this->input->post('mc_gross');

        $order = $this->order_model->get_order($custom);

        if (empty($order)) {
            log_message('error', 'PayPal IPN: Order not found - ' . $custom);
            return;
        }

        // Log payment
        $this->order_model->log_payment([
            'order_id'         => $order->id,
            'payment_method'   => 'paypal',
            'transaction_id'   => $txn_id,
            'amount'           => $mc_gross,
            'currency'         => $this->input->post('mc_currency'),
            'status'           => strtolower($payment_status),
            'gateway_response' => json_encode($_POST)
        ]);

        if ($payment_status === 'Completed') {
            // Verify amount
            if ((float)$mc_gross >= (float)$order->total_money) {
                $this->order_model->set_transaction($order->id, $txn_id, json_encode($_POST));
                $this->order_model->update_status($order->id, 'completed');
                
                // Process order items
                $this->_process_order_items($order->id);

                log_message('info', 'PayPal payment completed for order #' . $order->id);
            } else {
                log_message('error', 'PayPal IPN: Amount mismatch for order #' . $order->id);
            }
        } elseif ($payment_status === 'Refunded') {
            $this->order_model->update_status($order->id, 'refunded');
            log_message('info', 'PayPal refund for order #' . $order->id);
        }
    }

    /**
     * Stripe webhook callback
     *
     * @return void
     */
    public function stripe_callback()
    {
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
        $webhook_secret = config_item('shop_stripe_webhook_secret');

        // Verify Stripe signature
        $event = null;

        try {
            // Simple signature verification (you may want to use Stripe SDK)
            $timestamp = null;
            $signature = null;
            
            $elements = explode(',', $sig_header);
            foreach ($elements as $element) {
                $parts = explode('=', $element);
                if ($parts[0] === 't') {
                    $timestamp = $parts[1];
                } elseif ($parts[0] === 'v1') {
                    $signature = $parts[1];
                }
            }

            $signed_payload = $timestamp . '.' . $payload;
            $expected_signature = hash_hmac('sha256', $signed_payload, $webhook_secret);

            if (! hash_equals($expected_signature, $signature)) {
                http_response_code(400);
                exit();
            }

            $event = json_decode($payload);
        } catch (Exception $e) {
            log_message('error', 'Stripe webhook error: ' . $e->getMessage());
            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $order_id = $session->metadata->order_id ?? null;
                
                if ($order_id) {
                    $order = $this->order_model->get_order($order_id);
                    
                    if ($order) {
                        $this->order_model->log_payment([
                            'order_id'         => $order->id,
                            'payment_method'   => 'stripe',
                            'transaction_id'   => $session->payment_intent,
                            'amount'           => $session->amount_total / 100,
                            'currency'         => strtoupper($session->currency),
                            'status'           => 'completed',
                            'gateway_response' => json_encode($session)
                        ]);

                        $this->order_model->set_transaction($order->id, $session->payment_intent, json_encode($session));
                        $this->order_model->update_status($order->id, 'completed');
                        $this->_process_order_items($order->id);
                    }
                }
                break;

            case 'invoice.paid':
                // Handle subscription renewal
                $invoice = $event->data->object;
                $subscription_id = $invoice->subscription;
                
                $user_sub = $this->db->where('external_subscription_id', $subscription_id)
                    ->get('shop_user_subscriptions')
                    ->row();
                
                if ($user_sub) {
                    $plan = $this->shop_model->get_subscription($user_sub->subscription_id);
                    if ($plan) {
                        $this->user_subscription_model->renew(
                            $user_sub->id,
                            $plan->interval_type,
                            $plan->interval_count
                        );
                    }
                }
                break;

            case 'customer.subscription.deleted':
                // Handle subscription cancellation
                $subscription = $event->data->object;
                
                $user_sub = $this->db->where('external_subscription_id', $subscription->id)
                    ->get('shop_user_subscriptions')
                    ->row();
                
                if ($user_sub) {
                    $this->user_subscription_model->cancel($user_sub->id);
                }
                break;

            case 'charge.refunded':
                $charge = $event->data->object;
                // Handle refund logic
                break;
        }

        http_response_code(200);
    }

    /**
     * Process order items after payment
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

        // TODO: Implement actual item delivery
        $this->order_model->update_item_status($order_item->id, 'delivered');
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
        // TODO: Implement service application
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

        $order = $this->order_model->get_order($order_item->order_id);

        $period_end = $this->user_subscription_model->calculate_next_billing_date(
            $subscription->interval_type,
            $subscription->interval_count
        );

        $this->user_subscription_model->create([
            'user_id'              => $order->user_id,
            'subscription_id'      => $subscription->id,
            'order_id'             => $order_item->order_id,
            'status'               => 'active',
            'payment_method'       => $order->payment_method,
            'realm_id'             => $order_item->realm_id ?: 0,
            'character_id'         => $order_item->character_id,
            'current_period_start' => current_date(),
            'current_period_end'   => $period_end
        ]);

        $this->order_model->update_item_status($order_item->id, 'delivered');

        return true;
    }
}
