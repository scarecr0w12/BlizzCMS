<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        require_permission('view.settings');
    }

    public function index()
    {
        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('welcome_title', lang('welcome_title'), 'required');
        $this->form_validation->set_rules('welcome_description', lang('welcome_description'), 'required');
        $this->form_validation->set_rules('welcome_subtitle', lang('welcome_subtitle'), 'required');
        $this->form_validation->set_rules('spec_expansion', lang('expansion'), 'required');
        $this->form_validation->set_rules('spec_exp_rate', lang('experience_rate'), 'required');
        $this->form_validation->set_rules('spec_realms', lang('player_count'), 'required');
        $this->form_validation->set_rules('spec_security', lang('security'), 'required');
        $this->form_validation->set_rules('spec_support', lang('support'), 'required');
        $this->form_validation->set_rules('spec_community', lang('community'), 'required');

        if ($this->input->method() === 'post') {
            if (! $this->form_validation->run()) {
                // Validation failed, show errors
                $this->template->build('welcome/index', [
                    'welcome_title' => $this->input->post('welcome_title') ?? config_item('welcome_title') ?? lang('welcome'),
                    'welcome_description' => $this->input->post('welcome_description') ?? config_item('welcome_description') ?? 'Join thousands of players in an epic adventure.',
                    'welcome_subtitle' => $this->input->post('welcome_subtitle') ?? config_item('welcome_subtitle') ?? 'Experience the ultimate gaming community with our carefully crafted realm.',
                    'spec_expansion' => $this->input->post('spec_expansion') ?? config_item('welcome_spec_expansion') ?? 'World of Warcraft',
                    'spec_exp_rate' => $this->input->post('spec_exp_rate') ?? config_item('welcome_spec_exp_rate') ?? '1x - 10x',
                    'spec_realms' => $this->input->post('spec_realms') ?? config_item('welcome_spec_realms') ?? 'Multiple Realms',
                    'spec_security' => $this->input->post('spec_security') ?? config_item('welcome_spec_security') ?? lang('secure_and_stable'),
                    'spec_support' => $this->input->post('spec_support') ?? config_item('welcome_spec_support') ?? lang('24_7_support'),
                    'spec_community' => $this->input->post('spec_community') ?? config_item('welcome_spec_community') ?? lang('active_and_friendly')
                ]);
                return;
            }

            if (! has_permission('edit.settings', 'admin')) {
                $this->session->set_flashdata('error', lang('exception_no_action_permission'));
                redirect(site_url('admin/welcome'));
            }

            try {
                // Save each setting individually using direct database operations
                $settings_data = [
                    ['key' => 'welcome_title', 'value' => $this->input->post('welcome_title')],
                    ['key' => 'welcome_description', 'value' => $this->input->post('welcome_description')],
                    ['key' => 'welcome_subtitle', 'value' => $this->input->post('welcome_subtitle')],
                    ['key' => 'welcome_spec_expansion', 'value' => $this->input->post('spec_expansion')],
                    ['key' => 'welcome_spec_exp_rate', 'value' => $this->input->post('spec_exp_rate')],
                    ['key' => 'welcome_spec_realms', 'value' => $this->input->post('spec_realms')],
                    ['key' => 'welcome_spec_security', 'value' => $this->input->post('spec_security')],
                    ['key' => 'welcome_spec_support', 'value' => $this->input->post('spec_support')],
                    ['key' => 'welcome_spec_community', 'value' => $this->input->post('spec_community')]
                ];

                foreach ($settings_data as $setting) {
                    $this->db->where('key', $setting['key'])->delete('settings');
                    $this->db->insert('settings', $setting);
                }

                // Clear the config cache to reload settings from database
                $this->config->load('config', true);

                $this->log_model->create('welcome', 'edit', 'Edited the welcome section settings');

                $this->session->set_flashdata('success', lang('settings_updated_successfully'));
                redirect(site_url('admin/welcome'));
            } catch (Exception $e) {
                $this->session->set_flashdata('error', 'Error saving settings: ' . $e->getMessage());
                redirect(site_url('admin/welcome'));
            }
        }

        // Load settings from database to ensure fresh data
        $settings = $this->db->get('settings')->result_array();
        $settings_map = [];
        foreach ($settings as $setting) {
            $settings_map[$setting['key']] = $setting['value'];
        }

        $this->template->build('welcome/index', [
            'welcome_title' => $settings_map['welcome_title'] ?? config_item('welcome_title') ?? lang('welcome'),
            'welcome_description' => $settings_map['welcome_description'] ?? config_item('welcome_description') ?? 'Join thousands of players in an epic adventure.',
            'welcome_subtitle' => $settings_map['welcome_subtitle'] ?? config_item('welcome_subtitle') ?? 'Experience the ultimate gaming community with our carefully crafted realm.',
            'spec_expansion' => $settings_map['welcome_spec_expansion'] ?? config_item('welcome_spec_expansion') ?? 'World of Warcraft',
            'spec_exp_rate' => $settings_map['welcome_spec_exp_rate'] ?? config_item('welcome_spec_exp_rate') ?? '1x - 10x',
            'spec_realms' => $settings_map['welcome_spec_realms'] ?? config_item('welcome_spec_realms') ?? 'Multiple Realms',
            'spec_security' => $settings_map['welcome_spec_security'] ?? config_item('welcome_spec_security') ?? lang('secure_and_stable'),
            'spec_support' => $settings_map['welcome_spec_support'] ?? config_item('welcome_spec_support') ?? lang('24_7_support'),
            'spec_community' => $settings_map['welcome_spec_community'] ?? config_item('welcome_spec_community') ?? lang('active_and_friendly')
        ]);
    }

    public function upload_image()
    {
        if (! $this->input->is_ajax_request()) {
            http_response_code(403);
            echo json_encode(['error' => 'Forbidden']);
            exit;
        }

        if (! has_permission('edit.settings', 'admin')) {
            http_response_code(403);
            echo json_encode(['error' => 'Permission denied']);
            exit;
        }

        if (! isset($_FILES['file'])) {
            http_response_code(400);
            echo json_encode(['error' => 'No file provided']);
            exit;
        }

        $upload_dir = FCPATH . 'uploads/welcome/';
        if (! is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file = $_FILES['file'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (! in_array($file['type'], $allowed_types)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid file type']);
            exit;
        }

        $max_size = 5 * 1024 * 1024; // 5MB
        if ($file['size'] > $max_size) {
            http_response_code(400);
            echo json_encode(['error' => 'File too large']);
            exit;
        }

        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file['name']);
        $filepath = $upload_dir . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            $this->log_model->create('welcome', 'upload', 'Uploaded image: ' . $filename);
            echo json_encode(['location' => base_url('uploads/welcome/' . $filename)]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Upload failed']);
        }
        exit;
    }
}
