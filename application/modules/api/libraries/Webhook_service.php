<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webhook_service
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
    }

    public function register_webhook($user_id, $event_type, $webhook_url, $secret = null)
    {
        if (!$secret) {
            $secret = bin2hex(random_bytes(32));
        }

        return $this->CI->db->insert('webhooks', [
            'user_id' => $user_id,
            'event_type' => $event_type,
            'webhook_url' => $webhook_url,
            'secret' => $secret,
            'active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function trigger_webhook($event_type, $data)
    {
        $webhooks = $this->CI->db->where('event_type', $event_type)
            ->where('active', 1)
            ->get('webhooks')
            ->result();

        $success_count = 0;

        foreach ($webhooks as $webhook) {
            if ($this->send_webhook($webhook, $data)) {
                $success_count++;
            }
        }

        return $success_count;
    }

    public function send_webhook($webhook, $data)
    {
        $payload = json_encode([
            'event' => $webhook->event_type,
            'timestamp' => time(),
            'data' => $data,
        ]);

        $signature = hash_hmac('sha256', $payload, $webhook->secret);

        $headers = [
            'Content-Type: application/json',
            'X-Webhook-Signature: ' . $signature,
            'X-Webhook-Event: ' . $webhook->event_type,
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $webhook->webhook_url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $success = $http_code >= 200 && $http_code < 300;

        $this->log_webhook_delivery($webhook->id, $http_code, $success);

        return $success;
    }

    public function get_user_webhooks($user_id)
    {
        return $this->CI->db->where('user_id', $user_id)
            ->get('webhooks')
            ->result();
    }

    public function delete_webhook($webhook_id, $user_id)
    {
        return $this->CI->db->where('id', $webhook_id)
            ->where('user_id', $user_id)
            ->delete('webhooks');
    }

    public function toggle_webhook($webhook_id, $user_id, $active)
    {
        return $this->CI->db->where('id', $webhook_id)
            ->where('user_id', $user_id)
            ->update('webhooks', ['active' => $active ? 1 : 0]);
    }

    private function log_webhook_delivery($webhook_id, $http_code, $success)
    {
        $this->CI->db->insert('webhook_logs', [
            'webhook_id' => $webhook_id,
            'http_code' => $http_code,
            'success' => $success ? 1 : 0,
            'delivered_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function get_webhook_logs($webhook_id, $limit = 50)
    {
        return $this->CI->db->where('webhook_id', $webhook_id)
            ->order_by('delivered_at', 'DESC')
            ->limit($limit)
            ->get('webhook_logs')
            ->result();
    }
}
