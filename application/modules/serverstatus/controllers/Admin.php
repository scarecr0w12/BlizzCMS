<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('serverstatus_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        if (!$this->db->table_exists('serverstatus_history')) {
            $data = [
                'stats_overview' => ['total_records' => 0, 'realms_tracked' => 0],
                'recent_history' => [],
                'table_missing' => true,
            ];
        } else {
            $data = [
                'stats_overview' => $this->serverstatus_model->get_admin_overview(),
                'recent_history' => $this->serverstatus_model->get_recent_history(24),
                'table_missing' => false,
            ];
        }

        $this->template->title(lang('serverstatus_admin_title'));
        $this->template->build('admin/index', $data);
    }

    public function settings()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('enable_realtime_updates', 'Enable Real-time Updates', 'required');
            $this->form_validation->set_rules('update_interval', 'Update Interval', 'required|numeric');
            
            if ($this->form_validation->run()) {
                $settings = [
                    'enable_realtime_updates' => $this->input->post('enable_realtime_updates'),
                    'update_interval' => $this->input->post('update_interval'),
                    'show_faction_balance' => $this->input->post('show_faction_balance'),
                    'show_class_distribution' => $this->input->post('show_class_distribution'),
                    'show_level_distribution' => $this->input->post('show_level_distribution'),
                    'track_uptime' => $this->input->post('track_uptime'),
                ];

                foreach ($settings as $key => $value) {
                    $this->serverstatus_model->update_setting($key, $value);
                }

                $this->session->set_flashdata('success', lang('serverstatus_settings_saved'));
                redirect('serverstatus/admin/settings');
            }
        }

        $data = [
            'settings' => $this->serverstatus_model->get_all_settings(),
        ];

        $this->template->title(lang('serverstatus_settings_title'));
        $this->template->build('admin/settings', $data);
    }
}
