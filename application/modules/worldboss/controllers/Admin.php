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

        require_permission('view.worldboss.settings', 'worldboss');

        $this->load->language('worldboss/worldboss');
    }

    /**
     * World Boss settings index page
     *
     * @return void
     */
    public function index()
    {
        $data = [
            'realms' => $this->realm_model->find_all()
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('enabled', lang('worldboss_enabled'), 'trim|required|in_list[true,false]');
        $this->form_validation->set_rules('entries_per_page', lang('worldboss_entries_per_page'), 'trim|required|is_natural|greater_than[0]');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            if (! has_permission('edit.worldboss.settings', 'worldboss')) {
                $this->session->set_flashdata('error', lang('exception_no_action_permission'));
                redirect(site_url('worldboss/admin'));
            }

            $this->setting_model->update_batch([
                [
                    'key'   => 'worldboss_enabled',
                    'value' => $this->input->post('enabled')
                ],
                [
                    'key'   => 'worldboss_entries_per_page',
                    'value' => $this->input->post('entries_per_page')
                ]
            ], 'key');

            $this->log_model->create('worldboss', 'edit', 'Edited world boss general settings');

            $this->cache->delete('settings');

            $this->session->set_flashdata('success', lang('alert_settings_updated'));
            redirect(site_url('worldboss/admin'));
        } else {
            $this->template->build('admin/index', $data);
        }
    }

    /**
     * World Boss bosses configuration page
     *
     * @return void
     */
    public function bosses()
    {
        $this->load->model('worldboss_model');

        $data = [
            'bosses' => $this->worldboss_model->get_bosses()
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->template->build('admin/bosses', $data);
    }
}
