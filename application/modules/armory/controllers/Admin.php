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

        require_permission('view.armory.settings', 'armory');

        $this->load->language('armory/armory');
    }

    /**
     * Armory settings index page
     *
     * @return void
     */
    public function index()
    {
        $data = [
            'realms' => $this->realm_model->find_all()
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('enabled', lang('armory_enabled'), 'trim|required|in_list[true,false]');
        $this->form_validation->set_rules('cache_time', lang('armory_cache_time'), 'trim|required|is_natural');
        $this->form_validation->set_rules('items_per_page', lang('armory_items_per_page'), 'trim|required|is_natural|greater_than[0]');
        $this->form_validation->set_rules('search_min_chars', lang('armory_search_min_chars'), 'trim|required|is_natural|greater_than[0]');
        $this->form_validation->set_rules('arena_min_games', lang('armory_arena_min_games'), 'trim|required|is_natural');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            if (! has_permission('edit.armory.settings', 'armory')) {
                $this->session->set_flashdata('error', lang('exception_no_action_permission'));
                redirect(site_url('armory/admin'));
            }

            $this->setting_model->update_batch([
                [
                    'key'   => 'armory_enabled',
                    'value' => $this->input->post('enabled')
                ],
                [
                    'key'   => 'armory_cache_time',
                    'value' => $this->input->post('cache_time')
                ],
                [
                    'key'   => 'armory_items_per_page',
                    'value' => $this->input->post('items_per_page')
                ],
                [
                    'key'   => 'armory_search_min_chars',
                    'value' => $this->input->post('search_min_chars')
                ],
                [
                    'key'   => 'armory_arena_min_games',
                    'value' => $this->input->post('arena_min_games')
                ]
            ], 'key');

            $this->log_model->create('armory', 'edit', 'Edited armory general settings');

            $this->cache->delete('settings');

            $this->session->set_flashdata('success', lang('alert_settings_updated'));
            redirect(site_url('armory/admin'));
        } else {
            $this->template->build('admin/index', $data);
        }
    }

    /**
     * Armory display settings page
     *
     * @return void
     */
    public function display()
    {
        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('show_offline', lang('armory_show_offline'), 'trim|required|in_list[true,false]');
        $this->form_validation->set_rules('show_guild', lang('armory_show_guild'), 'trim|required|in_list[true,false]');
        $this->form_validation->set_rules('show_arena', lang('armory_show_arena'), 'trim|required|in_list[true,false]');
        $this->form_validation->set_rules('show_achievements', lang('armory_show_achievements'), 'trim|required|in_list[true,false]');
        $this->form_validation->set_rules('show_talents', lang('armory_show_talents'), 'trim|required|in_list[true,false]');
        $this->form_validation->set_rules('show_pvp', lang('armory_show_pvp'), 'trim|required|in_list[true,false]');
        $this->form_validation->set_rules('hide_gms', lang('armory_hide_gms'), 'trim|required|in_list[true,false]');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            if (! has_permission('edit.armory.settings', 'armory')) {
                $this->session->set_flashdata('error', lang('exception_no_action_permission'));
                redirect(site_url('armory/admin/display'));
            }

            $this->setting_model->update_batch([
                [
                    'key'   => 'armory_show_offline',
                    'value' => $this->input->post('show_offline')
                ],
                [
                    'key'   => 'armory_show_guild',
                    'value' => $this->input->post('show_guild')
                ],
                [
                    'key'   => 'armory_show_arena',
                    'value' => $this->input->post('show_arena')
                ],
                [
                    'key'   => 'armory_show_achievements',
                    'value' => $this->input->post('show_achievements')
                ],
                [
                    'key'   => 'armory_show_talents',
                    'value' => $this->input->post('show_talents')
                ],
                [
                    'key'   => 'armory_show_pvp',
                    'value' => $this->input->post('show_pvp')
                ],
                [
                    'key'   => 'armory_hide_gms',
                    'value' => $this->input->post('hide_gms')
                ]
            ], 'key');

            $this->log_model->create('armory', 'edit', 'Edited armory display settings');

            $this->cache->delete('settings');

            $this->session->set_flashdata('success', lang('alert_settings_updated'));
            redirect(site_url('armory/admin/display'));
        } else {
            $this->template->build('admin/display');
        }
    }

    /**
     * Armory features settings page
     *
     * @return void
     */
    public function features()
    {
        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('enable_search', lang('armory_enable_search'), 'trim|required|in_list[true,false]');
        $this->form_validation->set_rules('enable_ladder', lang('armory_enable_ladder'), 'trim|required|in_list[true,false]');
        $this->form_validation->set_rules('enable_guilds', lang('armory_enable_guilds'), 'trim|required|in_list[true,false]');
        $this->form_validation->set_rules('wowhead_tooltips', lang('armory_wowhead_tooltips'), 'trim|required|in_list[true,false]');
        $this->form_validation->set_rules('enable_3d_models', lang('armory_3d_models'), 'trim|required|in_list[true,false]');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            if (! has_permission('edit.armory.settings', 'armory')) {
                $this->session->set_flashdata('error', lang('exception_no_action_permission'));
                redirect(site_url('armory/admin/features'));
            }

            $this->setting_model->update_batch([
                [
                    'key'   => 'armory_enable_search',
                    'value' => $this->input->post('enable_search')
                ],
                [
                    'key'   => 'armory_enable_ladder',
                    'value' => $this->input->post('enable_ladder')
                ],
                [
                    'key'   => 'armory_enable_guilds',
                    'value' => $this->input->post('enable_guilds')
                ],
                [
                    'key'   => 'armory_wowhead_tooltips',
                    'value' => $this->input->post('wowhead_tooltips')
                ],
                [
                    'key'   => 'armory_3d_models',
                    'value' => $this->input->post('enable_3d_models')
                ]
            ], 'key');

            $this->log_model->create('armory', 'edit', 'Edited armory features settings');

            $this->cache->delete('settings');

            $this->session->set_flashdata('success', lang('alert_settings_updated'));
            redirect(site_url('armory/admin/features'));
        } else {
            $this->template->build('admin/features');
        }
    }
}
