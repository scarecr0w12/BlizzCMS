<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_enhanced extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('profile_enhanced_model');
        $this->load->language('profile_enhanced');
    }

    public function index()
    {
        if (!is_logged_in()) {
            redirect('login');
        }

        $username = $this->session->userdata('username');
        redirect('profile/' . $username);
    }

    public function view($username = null)
    {
        $this->db->where('username', $username);
        $user = $this->db->get('users')->row();

        if (!$user) {
            show_404();
        }

        $settings = $this->profile_enhanced_model->get_all_settings();
        $profile = $this->profile_enhanced_model->get_profile($user->id);
        $statistics = $this->profile_enhanced_model->get_user_statistics($user->id);

        if ($settings['enable_profile_visits'] ?? 1) {
            $visitor_id = $this->session->userdata('user_id');
            $this->profile_enhanced_model->track_visit($user->id, $visitor_id);
        }

        $data = [
            'user' => $user,
            'profile' => $profile,
            'statistics' => $statistics,
            'settings' => $settings,
            'timeline' => [],
            'showcased_achievements' => [],
            'recent_visitors' => [],
            'characters' => [],
        ];

        if ($settings['enable_timeline'] ?? 1) {
            $data['timeline'] = $this->profile_enhanced_model->get_user_timeline($user->id);
        }

        if ($settings['enable_achievements'] ?? 1) {
            $data['showcased_achievements'] = $this->profile_enhanced_model->get_showcased_achievements($user->id);
        }

        if ($settings['enable_profile_visits'] ?? 1) {
            $data['recent_visitors'] = $this->profile_enhanced_model->get_recent_visitors($user->id, 5);
        }

        if ($settings['enable_character_gallery'] ?? 1) {
            $this->load->helper('wow');
            $data['characters'] = $this->profile_enhanced_model->get_user_characters($user->username, 12);
        }

        $this->template->title($user->username . ' - Profile');
        $this->template->build('profile/view', $data);
    }

}
