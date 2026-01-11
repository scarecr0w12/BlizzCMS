<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('analytics/Analytics_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['page_title'] = 'Analytics Dashboard';
        $data['user_metrics'] = $this->Analytics_model->get_user_metrics(30);
        $data['revenue_metrics'] = $this->Analytics_model->get_revenue_metrics(30);
        $data['engagement_metrics'] = $this->Analytics_model->get_engagement_metrics(30);
        $data['server_metrics'] = $this->Analytics_model->get_server_metrics();
        $data['daily_stats'] = $this->Analytics_model->get_daily_stats(30);
        
        $this->load->view('analytics/index', $data);
    }

    public function dashboard()
    {
        $data['page_title'] = 'Analytics Dashboard';
        $data['user_metrics'] = $this->Analytics_model->get_user_metrics(30);
        $data['revenue_metrics'] = $this->Analytics_model->get_revenue_metrics(30);
        $data['engagement_metrics'] = $this->Analytics_model->get_engagement_metrics(30);
        $data['server_metrics'] = $this->Analytics_model->get_server_metrics();
        $data['daily_stats'] = $this->Analytics_model->get_daily_stats(30);
        $data['top_items'] = $this->Analytics_model->get_top_items(10);
        $data['retention'] = $this->Analytics_model->get_user_retention(30);
        
        $this->load->view('analytics/dashboard', $data);
    }

    public function users()
    {
        $days = $this->input->get('days') ?? 30;
        $data['page_title'] = 'User Analytics';
        $data['user_metrics'] = $this->Analytics_model->get_user_metrics($days);
        $data['daily_stats'] = $this->Analytics_model->get_daily_stats($days);
        $data['retention'] = $this->Analytics_model->get_user_retention($days);
        $data['days'] = $days;
        
        $this->load->view('analytics/users', $data);
    }

    public function revenue()
    {
        $days = $this->input->get('days') ?? 30;
        $data['page_title'] = 'Revenue Analytics';
        $data['revenue_metrics'] = $this->Analytics_model->get_revenue_metrics($days);
        $data['daily_stats'] = $this->Analytics_model->get_daily_stats($days);
        $data['top_items'] = $this->Analytics_model->get_top_items(10);
        $data['days'] = $days;
        
        $this->load->view('analytics/revenue', $data);
    }

    public function engagement()
    {
        $days = $this->input->get('days') ?? 30;
        $data['page_title'] = 'Engagement Analytics';
        $data['engagement_metrics'] = $this->Analytics_model->get_engagement_metrics($days);
        $data['feature_usage'] = $this->Analytics_model->get_feature_usage();
        $data['daily_stats'] = $this->Analytics_model->get_daily_stats($days);
        $data['days'] = $days;
        
        $this->load->view('analytics/engagement', $data);
    }

    public function server()
    {
        $data['page_title'] = 'Server Analytics';
        $data['server_metrics'] = $this->Analytics_model->get_server_metrics();
        
        $this->load->view('analytics/server', $data);
    }
}
