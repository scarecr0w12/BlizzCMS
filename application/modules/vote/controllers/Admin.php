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

        require_permission('view.vote', 'vote');

        $this->load->language('vote/vote');
        $this->load->model('vote/vote_model');
    }

    /**
     * Admin dashboard
     *
     * @return void
     */
    public function index()
    {
        require_permission('view.vote', 'vote');

        $data = [
            'statistics'  => $this->vote_model->get_statistics(),
            'recent_logs' => $this->vote_model->get_all_logs(10, 0),
            'sites'       => $this->vote_model->get_all_sites(5, 0),
            'top_voters'  => $this->vote_model->get_top_voters(10)
        ];

        $this->template->title(lang('vote'), lang('admin_panel'));
        $this->template->build('admin/index', $data);
    }

    /**
     * Manage vote sites
     *
     * @return void
     */
    public function sites()
    {
        require_permission('view.vote', 'vote');

        $per_page = 20;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $per_page;

        $data = [
            'sites'        => $this->vote_model->get_all_sites($per_page, $offset),
            'total'        => $this->vote_model->count_all_sites(),
            'per_page'     => $per_page,
            'current_page' => $page
        ];

        $this->template->title(lang('vote_sites'), lang('admin_panel'));
        $this->template->build('admin/sites', $data);
    }

    /**
     * Add vote site
     *
     * @return void
     */
    public function add_site()
    {
        require_permission('add.vote', 'vote');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', lang('name'), 'trim|required');
        $this->form_validation->set_rules('url', lang('url'), 'trim|required');
        $this->form_validation->set_rules('vp_reward', lang('vote_vp_reward'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('cooldown_hours', lang('vote_cooldown'), 'trim|required|is_natural_no_zero');

        if ($this->form_validation->run()) {
            $data = [
                'name'           => $this->input->post('name'),
                'description'    => $this->input->post('description'),
                'url'            => $this->input->post('url'),
                'callback_url'   => $this->input->post('callback_url'),
                'image'          => $this->input->post('image') ?? '',
                'vp_reward'      => $this->input->post('vp_reward'),
                'cooldown_hours' => $this->input->post('cooldown_hours'),
                'sort_order'     => $this->input->post('sort_order') ?? 0,
                'is_active'      => $this->input->post('is_active') ? 1 : 0
            ];

            if ($this->vote_model->insert($data)) {
                $this->session->set_flashdata('success', lang('vote_site_added'));
                redirect('vote/admin/sites');
            }

            $this->session->set_flashdata('error', lang('vote_site_add_error'));
        }

        $this->template->title(lang('add'), lang('vote_sites'), lang('admin_panel'));
        $this->template->build('admin/add_site');
    }

    /**
     * Edit vote site
     *
     * @param int $id
     * @return void
     */
    public function edit_site($id)
    {
        require_permission('edit.vote', 'vote');

        $site = $this->vote_model->get_site($id);

        if (empty($site)) {
            show_404();
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', lang('name'), 'trim|required');
        $this->form_validation->set_rules('url', lang('url'), 'trim|required');
        $this->form_validation->set_rules('vp_reward', lang('vote_vp_reward'), 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('cooldown_hours', lang('vote_cooldown'), 'trim|required|is_natural_no_zero');

        if ($this->form_validation->run()) {
            $data = [
                'name'           => $this->input->post('name'),
                'description'    => $this->input->post('description'),
                'url'            => $this->input->post('url'),
                'callback_url'   => $this->input->post('callback_url'),
                'image'          => $this->input->post('image') ?? '',
                'vp_reward'      => $this->input->post('vp_reward'),
                'cooldown_hours' => $this->input->post('cooldown_hours'),
                'sort_order'     => $this->input->post('sort_order') ?? 0,
                'is_active'      => $this->input->post('is_active') ? 1 : 0
            ];

            if ($this->vote_model->update($data, ['id' => $id])) {
                $this->session->set_flashdata('success', lang('vote_site_updated'));
                redirect('vote/admin/sites');
            }

            $this->session->set_flashdata('error', lang('vote_site_update_error'));
        }

        $data = [
            'site' => $site
        ];

        $this->template->title(lang('edit'), lang('vote_sites'), lang('admin_panel'));
        $this->template->build('admin/edit_site', $data);
    }

    /**
     * Delete vote site
     *
     * @param int $id
     * @return void
     */
    public function delete_site($id)
    {
        require_permission('delete.vote', 'vote');

        $site = $this->vote_model->get_site($id);

        if (empty($site)) {
            show_404();
        }

        if ($this->vote_model->delete(['id' => $id])) {
            $this->session->set_flashdata('success', lang('vote_site_deleted'));
        } else {
            $this->session->set_flashdata('error', lang('vote_site_delete_error'));
        }

        redirect('vote/admin/sites');
    }

    /**
     * View vote logs
     *
     * @return void
     */
    public function logs()
    {
        require_permission('view.vote', 'vote');

        $per_page = 30;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $per_page;

        $filters = [
            'site_id' => $this->input->get('site_id'),
            'search'  => $this->input->get('search')
        ];

        $data = [
            'logs'         => $this->vote_model->get_all_logs($per_page, $offset, $filters),
            'total'        => $this->vote_model->count_all_logs($filters),
            'per_page'     => $per_page,
            'current_page' => $page,
            'filters'      => $filters,
            'sites'        => $this->vote_model->get_all_sites(100, 0)
        ];

        $this->template->title(lang('vote_logs'), lang('admin_panel'));
        $this->template->build('admin/logs', $data);
    }

    /**
     * Module settings
     *
     * @return void
     */
    public function settings()
    {
        require_permission('edit.vote', 'vote');

        $this->load->library('form_validation');
        $this->load->model('setting_model');

        if ($this->input->method() === 'post') {
            $settings = [
                'vote_enabled'        => $this->input->post('vote_enabled') ? '1' : '0',
                'vote_points_per_vote' => $this->input->post('vote_points_per_vote'),
                'vote_cooldown_hours' => $this->input->post('vote_cooldown_hours')
            ];

            foreach ($settings as $key => $value) {
                $this->setting_model->update(['value' => $value], ['key' => $key]);
            }

            $this->cache->delete('settings');
            $this->session->set_flashdata('success', lang('settings_updated'));
            redirect('vote/admin/settings');
        }

        $this->template->title(lang('settings'), lang('vote'), lang('admin_panel'));
        $this->template->build('admin/settings');
    }
}
