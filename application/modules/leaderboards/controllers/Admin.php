<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('leaderboards_model');
    }

    public function index()
    {
        $data = [
            'total_players' => 0,
            'total_guilds' => 0,
        ];

        $this->template->title('Leaderboards Administration');
        $this->template->build('admin/index', $data);
    }

    public function settings()
    {
        if ($this->input->post()) {
            $settings = [
                'enable_pvp_rankings' => $this->input->post('enable_pvp_rankings'),
                'enable_honor_kills' => $this->input->post('enable_honor_kills'),
                'enable_arena_rankings' => $this->input->post('enable_arena_rankings'),
                'enable_achievements' => $this->input->post('enable_achievements'),
                'enable_professions' => $this->input->post('enable_professions'),
                'enable_guild_rankings' => $this->input->post('enable_guild_rankings'),
                'items_per_page' => $this->input->post('items_per_page'),
                'cache_duration' => $this->input->post('cache_duration'),
            ];

            foreach ($settings as $key => $value) {
                $this->leaderboards_model->update_setting($key, $value);
            }

            $this->session->set_flashdata('success', 'Settings saved successfully');
            redirect('leaderboards/admin/settings');
        }

        $data = [
            'settings' => $this->leaderboards_model->get_all_settings(),
        ];

        $this->template->title('Leaderboards Settings');
        $this->template->build('admin/settings', $data);
    }
}
