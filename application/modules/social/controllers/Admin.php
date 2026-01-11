<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('social/Social_model');
        $this->load->library('session');
        
        if (!$this->session->userdata('user_id') || !$this->session->userdata('is_admin')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['page_title'] = 'Social Features Admin';
        $data['settings'] = $this->Social_model->get_all_settings();
        
        $this->load->view('social/admin/index', $data);
    }

    public function settings()
    {
        if ($this->input->method() === 'post') {
            $enable_friends = $this->input->post('enable_friends') ? '1' : '0';
            $enable_messaging = $this->input->post('enable_messaging') ? '1' : '0';
            $enable_guild_features = $this->input->post('enable_guild_features') ? '1' : '0';
            $max_friends = $this->input->post('max_friends');
            $message_retention_days = $this->input->post('message_retention_days');
            
            $this->Social_model->update_setting('enable_friends', $enable_friends);
            $this->Social_model->update_setting('enable_messaging', $enable_messaging);
            $this->Social_model->update_setting('enable_guild_features', $enable_guild_features);
            $this->Social_model->update_setting('max_friends', $max_friends);
            $this->Social_model->update_setting('message_retention_days', $message_retention_days);
            
            $this->session->set_flashdata('success', 'Settings updated successfully!');
            redirect('social/admin/settings');
        }
        
        $data['page_title'] = 'Social Settings';
        $data['settings'] = $this->Social_model->get_all_settings();
        
        $this->load->view('social/admin/settings', $data);
    }
}
