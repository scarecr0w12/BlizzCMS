<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('analytics/Analytics_model');
        $this->load->helper('url');
        
        if (!$this->session->userdata('id') || !$this->session->logged_in) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['page_title'] = 'Analytics Admin Dashboard';
        $data['user_metrics'] = $this->Analytics_model->get_user_metrics(30);
        $data['revenue_metrics'] = $this->Analytics_model->get_revenue_metrics(30);
        $data['engagement_metrics'] = $this->Analytics_model->get_engagement_metrics(30);
        $data['server_metrics'] = $this->Analytics_model->get_server_metrics();
        $data['daily_stats'] = $this->Analytics_model->get_daily_stats(30);
        $data['top_items'] = $this->Analytics_model->get_top_items(10);
        
        $this->load->view('analytics/admin/index', $data);
    }

    public function settings()
    {
        $this->load->library('form_validation');
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('enable_analytics', 'Enable Analytics', 'required');
            $this->form_validation->set_rules('track_sessions', 'Track Sessions', 'required');
            $this->form_validation->set_rules('retention_days', 'Retention Days', 'required|numeric');
            $this->form_validation->set_rules('chart_refresh_interval', 'Chart Refresh Interval', 'required|numeric');
            
            if ($this->form_validation->run() === FALSE) {
                $data['errors'] = validation_errors();
            } else {
                $this->Analytics_model->update_setting('enable_analytics', $this->input->post('enable_analytics'));
                $this->Analytics_model->update_setting('track_sessions', $this->input->post('track_sessions'));
                $this->Analytics_model->update_setting('retention_days', $this->input->post('retention_days'));
                $this->Analytics_model->update_setting('chart_refresh_interval', $this->input->post('chart_refresh_interval'));
                
                $data['success'] = 'Settings updated successfully!';
            }
        }
        
        $data['page_title'] = 'Analytics Settings';
        $data['settings'] = $this->Analytics_model->get_all_settings();
        
        $this->load->view('analytics/admin/settings', $data);
    }
}
