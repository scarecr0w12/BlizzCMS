<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('api_response');
        $this->load->library('api_auth');
        $this->load->model('user_model');
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if (!$username || !$password) {
            return $this->api_response->error('Username and password required', 400);
        }

        $user = $this->user_model->find(['username' => $username]);

        if (!$user || !password_verify($password, $user->password)) {
            return $this->api_response->error('Invalid credentials', 401);
        }

        $token = $this->api_auth->generate_token($user->id);

        $this->api_response->success([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ],
        ], 'Login successful');
    }

    public function get_token()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if (!$username || !$password) {
            return $this->api_response->error('Username and password required', 400);
        }

        $user = $this->user_model->find(['username' => $username]);

        if (!$user || !password_verify($password, $user->password)) {
            return $this->api_response->error('Invalid credentials', 401);
        }

        $token = $this->api_auth->generate_token($user->id, 604800); // 7 days

        $this->api_response->success([
            'token' => $token,
            'expires_in' => 604800,
        ]);
    }

    public function logout()
    {
        $this->api_response->success(null, 'Logged out successfully');
    }
}
