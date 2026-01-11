<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('database_viewer_model');
        $this->load->language('database_viewer');
        
        if (!$this->user->is_admin()) {
            redirect('user/login');
        }
    }

    public function index()
    {
        $data = [
            'page_title' => lang('database_admin_settings'),
        ];

        $this->template->title(lang('database_admin_settings'));
        $this->template->build('admin/index', $data);
    }

    public function settings()
    {
        if ($this->input->method() === 'post') {
            $enabled = $this->input->post('enabled') ? 1 : 0;
            $items_per_page = (int) $this->input->post('items_per_page') ?: 50;
            $show_quality_colors = $this->input->post('show_quality_colors') ? 1 : 0;
            $enable_tooltips = $this->input->post('enable_tooltips') ? 1 : 0;

            $this->database_viewer_model->update_setting('database_viewer_enabled', $enabled);
            $this->database_viewer_model->update_setting('database_viewer_items_per_page', $items_per_page);
            $this->database_viewer_model->update_setting('database_viewer_show_quality_colors', $show_quality_colors);
            $this->database_viewer_model->update_setting('database_viewer_enable_tooltips', $enable_tooltips);

            $this->session->set_flashdata('success', 'Settings updated successfully');
            redirect('database_viewer/admin/settings');
        }

        $data = [
            'enabled' => $this->database_viewer_model->get_setting('database_viewer_enabled', 1),
            'items_per_page' => $this->database_viewer_model->get_setting('database_viewer_items_per_page', 50),
            'show_quality_colors' => $this->database_viewer_model->get_setting('database_viewer_show_quality_colors', 1),
            'enable_tooltips' => $this->database_viewer_model->get_setting('database_viewer_enable_tooltips', 1),
        ];

        $this->template->title(lang('database_admin_settings'));
        $this->template->build('admin/settings', $data);
    }
}
