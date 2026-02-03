<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->language('pvpstats');
        $this->load->model('pvpstats_battleground_model');
    }

    /**
     * Admin dashboard
     */
    public function index()
    {
        $data = [
            'total_battlegrounds' => $this->pvpstats_battleground_model->count_battlegrounds(),
            'today_battlegrounds' => $this->pvpstats_battleground_model->count_battlegrounds(['start_date' => date('Y-m-d')]),
            'top_players'         => $this->pvpstats_battleground_model->get_top_players(10, 'all'),
            'recent_battlegrounds' => $this->pvpstats_battleground_model->get_battlegrounds(10, 0)
        ];

        $this->template->title(lang('pvpstats_admin'), config_item('app_name'));
        $this->template->build('admin/index', $data);
    }

    /**
     * Settings page
     */
    public function settings()
    {
        if ($this->input->method() === 'post') {
            $settings = [
                'pvpstats_enabled'         => $this->input->post('pvpstats_enabled', true) ? 1 : 0,
                'pvpstats_show_details'    => $this->input->post('pvpstats_show_details', true) ? 1 : 0,
                'pvpstats_top_players_limit' => (int)$this->input->post('pvpstats_top_players_limit', true) ?: 20,
                'pvpstats_top_guilds_limit'  => (int)$this->input->post('pvpstats_top_guilds_limit', true) ?: 5
            ];

            foreach ($settings as $key => $value) {
                $this->db->where('setting_key', $key)
                         ->update('pvpstats_settings', ['setting_value' => $value]);
            }

            $this->session->set_flashdata('success', lang('settings_saved'));
            redirect('pvpstats/admin/settings');
        }

        $settings = $this->db->get('pvpstats_settings')->result_array();
        $settings_array = [];
        foreach ($settings as $setting) {
            $settings_array[$setting['setting_key']] = $setting['setting_value'];
        }

        $data = [
            'settings' => $settings_array
        ];

        $this->template->title(lang('pvpstats_settings'), config_item('app_name'));
        $this->template->build('admin/settings', $data);
    }
}
