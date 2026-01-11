<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_auth
{
    private $CI;
    private $secret_key = 'blizzcms_secret_key_change_in_production';

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function generate_token($user_id, $expires_in = 86400)
    {
        $payload = [
            'user_id' => $user_id,
            'iat' => time(),
            'exp' => time() + $expires_in,
        ];

        return $this->encode_jwt($payload);
    }

    public function verify_token($token)
    {
        try {
            $payload = $this->decode_jwt($token);
            
            if ($payload['exp'] < time()) {
                return false;
            }

            return $payload;
        } catch (Exception $e) {
            return false;
        }
    }

    public function get_token_from_header()
    {
        $headers = $this->CI->input->request_headers();
        
        if (isset($headers['Authorization'])) {
            $parts = explode(' ', $headers['Authorization']);
            if (count($parts) === 2 && $parts[0] === 'Bearer') {
                return $parts[1];
            }
        }

        return null;
    }

    private function encode_jwt($payload)
    {
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $payload_json = json_encode($payload);

        $header_encoded = $this->base64url_encode($header);
        $payload_encoded = $this->base64url_encode($payload_json);

        $signature = hash_hmac('sha256', "$header_encoded.$payload_encoded", $this->secret_key, true);
        $signature_encoded = $this->base64url_encode($signature);

        return "$header_encoded.$payload_encoded.$signature_encoded";
    }

    private function decode_jwt($token)
    {
        $parts = explode('.', $token);
        
        if (count($parts) !== 3) {
            throw new Exception('Invalid token format');
        }

        $header = json_decode($this->base64url_decode($parts[0]), true);
        $payload = json_decode($this->base64url_decode($parts[1]), true);
        $signature = $this->base64url_decode($parts[2]);

        $expected_signature = hash_hmac('sha256', "{$parts[0]}.{$parts[1]}", $this->secret_key, true);

        if (!hash_equals($signature, $expected_signature)) {
            throw new Exception('Invalid signature');
        }

        return $payload;
    }

    private function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64url_decode($data)
    {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 4 - strlen($data) % 4));
    }
}
