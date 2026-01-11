<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discord extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('discord_model');
        $this->load->library('discord_oauth');
    }

    public function index()
    {
        $data = [
            'settings' => $this->discord_model->get_all_settings(),
            'linked' => false,
            'discord_user' => null,
        ];

        if ($this->session->userdata('logged_in')) {
            $user_id = $this->session->userdata('user_id');
            $discord_link = $this->discord_model->get_user_link($user_id);
            
            if ($discord_link) {
                $data['linked'] = true;
                $data['discord_user'] = $discord_link;
            }
        }

        $this->template->title(lang('discord_title'));
        $this->template->build('index', $data);
    }

    public function auth()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
            return;
        }

        $state = bin2hex(random_bytes(16));
        $this->session->set_userdata('discord_state', $state);

        $auth_url = $this->discord_oauth->get_authorization_url($state);
        redirect($auth_url);
    }

    public function callback()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
            return;
        }

        $code = $this->input->get('code');
        $state = $this->input->get('state');
        $stored_state = $this->session->userdata('discord_state');

        if (!$code || !$state || $state !== $stored_state) {
            $this->session->set_flashdata('error', lang('discord_auth_failed'));
            redirect('discord');
            return;
        }

        $token_data = $this->discord_oauth->exchange_code($code);
        
        if (!$token_data) {
            $this->session->set_flashdata('error', lang('discord_token_failed'));
            redirect('discord');
            return;
        }

        $user_info = $this->discord_oauth->get_user_info($token_data['access_token']);
        
        if (!$user_info) {
            $this->session->set_flashdata('error', lang('discord_user_failed'));
            redirect('discord');
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $link_data = [
            'user_id' => $user_id,
            'discord_id' => $user_info['id'],
            'discord_username' => $user_info['username'],
            'discord_discriminator' => $user_info['discriminator'] ?? '0',
            'discord_avatar' => $user_info['avatar'] ?? null,
            'access_token' => $token_data['access_token'],
            'refresh_token' => $token_data['refresh_token'] ?? null,
            'expires_at' => date('Y-m-d H:i:s', time() + ($token_data['expires_in'] ?? 604800)),
        ];

        if ($this->discord_model->link_account($link_data)) {
            $this->session->set_flashdata('success', lang('discord_link_success'));
        } else {
            $this->session->set_flashdata('error', lang('discord_link_failed'));
        }

        $this->session->unset_userdata('discord_state');
        redirect('discord');
    }

    public function unlink()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
            return;
        }

        $user_id = $this->session->userdata('user_id');
        
        if ($this->discord_model->unlink_account($user_id)) {
            $this->session->set_flashdata('success', lang('discord_unlink_success'));
        } else {
            $this->session->set_flashdata('error', lang('discord_unlink_failed'));
        }

        redirect('discord');
    }

    public function widget()
    {
        $settings = $this->discord_model->get_all_settings();
        
        if (!isset($settings['widget_enabled']) || $settings['widget_enabled'] != '1') {
            show_404();
            return;
        }

        $data = [
            'guild_id' => $settings['guild_id'] ?? '',
        ];

        $this->load->view('widget', $data);
    }
}
