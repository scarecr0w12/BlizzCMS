<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('profile_enhanced_model');
        $this->load->language('profile_enhanced');
    }

    public function index()
    {
        $data = [
            'statistics' => $this->profile_enhanced_model->get_module_statistics(),
            'recent_activities' => $this->profile_enhanced_model->get_recent_activities(10),
            'settings' => $this->profile_enhanced_model->get_all_settings(),
        ];

        $this->template->title('Profile Enhanced Administration');
        $this->template->build('admin/index', $data);
    }

    public function settings()
    {
        if ($this->input->post()) {
            $settings = [
                'enable_timeline' => $this->input->post('enable_timeline'),
                'enable_achievements' => $this->input->post('enable_achievements'),
                'enable_character_gallery' => $this->input->post('enable_character_gallery'),
                'enable_profile_visits' => $this->input->post('enable_profile_visits'),
                'enable_social_links' => $this->input->post('enable_social_links'),
                'max_showcase_achievements' => $this->input->post('max_showcase_achievements'),
                'default_profile_visibility' => $this->input->post('default_profile_visibility'),
                'require_bio_approval' => $this->input->post('require_bio_approval'),
                'max_bio_length' => $this->input->post('max_bio_length'),
                'enable_profile_themes' => $this->input->post('enable_profile_themes'),
            ];

            foreach ($settings as $key => $value) {
                $this->profile_enhanced_model->update_setting($key, $value);
            }

            $this->session->set_flashdata('success', 'Settings saved successfully');
            redirect('profile_enhanced/admin/settings');
        }

        $data = [
            'settings' => $this->profile_enhanced_model->get_all_settings(),
        ];

        $this->template->title('Profile Enhanced Settings');
        $this->template->build('admin/settings', $data);
    }
}
