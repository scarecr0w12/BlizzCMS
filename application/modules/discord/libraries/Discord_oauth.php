<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discord_oauth
{
    protected $ci;
    protected $client_id;
    protected $client_secret;
    protected $redirect_uri;
    protected $api_endpoint = 'https://discord.com/api/v10';

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->model('discord/discord_model');
        
        $settings = $this->ci->discord_model->get_all_settings();
        $this->client_id = $settings['client_id'] ?? '';
        $this->client_secret = $settings['client_secret'] ?? '';
        $this->redirect_uri = $settings['redirect_uri'] ?? '';
    }

    public function get_authorization_url($state = null)
    {
        $params = [
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'response_type' => 'code',
            'scope' => 'identify email guilds',
        ];

        if ($state) {
            $params['state'] = $state;
        }

        return $this->api_endpoint . '/oauth2/authorize?' . http_build_query($params);
    }

    public function exchange_code($code)
    {
        $data = [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->redirect_uri,
        ];

        $ch = curl_init($this->api_endpoint . '/oauth2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200) {
            return json_decode($response, true);
        }

        return false;
    }

    public function get_user_info($access_token)
    {
        $ch = curl_init($this->api_endpoint . '/users/@me');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $access_token
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200) {
            return json_decode($response, true);
        }

        return false;
    }

    public function refresh_token($refresh_token)
    {
        $data = [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
        ];

        $ch = curl_init($this->api_endpoint . '/oauth2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200) {
            return json_decode($response, true);
        }

        return false;
    }

    public function send_webhook($webhook_url, $message, $username = null, $avatar_url = null)
    {
        $data = [
            'content' => $message,
        ];

        if ($username) {
            $data['username'] = $username;
        }

        if ($avatar_url) {
            $data['avatar_url'] = $avatar_url;
        }

        $ch = curl_init($webhook_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $http_code === 204 || $http_code === 200;
    }

    public function send_embed_webhook($webhook_url, $embed_data, $username = null)
    {
        $data = [
            'embeds' => [$embed_data]
        ];

        if ($username) {
            $data['username'] = $username;
        }

        $ch = curl_init($webhook_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $http_code === 204 || $http_code === 200;
    }
}
