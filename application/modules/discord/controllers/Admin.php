<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('discord_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = [
            'linked_count' => $this->discord_model->get_linked_users_count(),
            'recent_links' => $this->discord_model->get_recent_links(10),
            'webhooks_count' => count($this->discord_model->get_all_webhooks()),
        ];

        $this->template->title(lang('discord_admin_title'));
        $this->template->build('admin/index', $data);
    }

    public function settings()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('enable_oauth', 'Enable OAuth', 'required');
            $this->form_validation->set_rules('client_id', 'Client ID', 'trim');
            $this->form_validation->set_rules('client_secret', 'Client Secret', 'trim');
            
            if ($this->form_validation->run()) {
                $settings = [
                    'enable_oauth' => $this->input->post('enable_oauth'),
                    'client_id' => $this->input->post('client_id'),
                    'client_secret' => $this->input->post('client_secret'),
                    'redirect_uri' => $this->input->post('redirect_uri'),
                    'guild_id' => $this->input->post('guild_id'),
                    'widget_enabled' => $this->input->post('widget_enabled'),
                    'bot_token' => $this->input->post('bot_token'),
                    'webhook_url' => $this->input->post('webhook_url'),
                    'webhook_enabled' => $this->input->post('webhook_enabled'),
                ];

                foreach ($settings as $key => $value) {
                    $this->discord_model->update_setting($key, $value);
                }

                $this->session->set_flashdata('success', lang('discord_settings_saved'));
                redirect('discord/admin/settings');
            }
        }

        $data = [
            'settings' => $this->discord_model->get_all_settings(),
        ];

        $this->template->title(lang('discord_settings'));
        $this->template->build('admin/settings', $data);
    }

    public function webhooks()
    {
        if ($this->input->post('action') === 'add') {
            $this->form_validation->set_rules('webhook_name', 'Webhook Name', 'required|trim');
            $this->form_validation->set_rules('webhook_url', 'Webhook URL', 'required|trim');
            $this->form_validation->set_rules('event_type', 'Event Type', 'required');
            
            if ($this->form_validation->run()) {
                $webhook_data = [
                    'webhook_name' => $this->input->post('webhook_name'),
                    'webhook_url' => $this->input->post('webhook_url'),
                    'event_type' => $this->input->post('event_type'),
                    'enabled' => $this->input->post('enabled') ? 1 : 0,
                ];

                if ($this->discord_model->add_webhook($webhook_data)) {
                    $this->session->set_flashdata('success', lang('discord_webhook_created'));
                }
                
                redirect('discord/admin/webhooks');
            }
        }

        if ($this->input->get('delete')) {
            $id = $this->input->get('delete');
            if ($this->discord_model->delete_webhook($id)) {
                $this->session->set_flashdata('success', lang('discord_webhook_deleted'));
            }
            redirect('discord/admin/webhooks');
        }

        $data = [
            'webhooks' => $this->discord_model->get_all_webhooks(),
        ];

        $this->template->title(lang('discord_webhooks'));
        $this->template->build('admin/webhooks', $data);
    }
}
