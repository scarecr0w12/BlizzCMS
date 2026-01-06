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

        require_permission('view.donate', 'donate');

        $this->load->language('donate/donate');
        $this->load->model('donate/donate_model');
    }

    /**
     * Admin dashboard
     *
     * @return void
     */
    public function index()
    {
        require_permission('view.donate', 'donate');

        $data = [
            'statistics' => $this->donate_model->get_statistics(),
            'recent_logs' => $this->donate_model->get_all_logs(10, 0),
            'packages' => $this->donate_model->get_all_packages(5, 0),
            'gateways' => $this->donate_model->get_all_gateways()
        ];

        $this->template->title(lang('donate'), lang('admin_panel'));
        $this->template->build('admin/index', $data);
    }

    /**
     * Manage packages
     *
     * @return void
     */
    public function packages()
    {
        require_permission('view.donate', 'donate');

        $per_page = 20;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $per_page;

        $data = [
            'packages'     => $this->donate_model->get_all_packages($per_page, $offset),
            'total'        => $this->donate_model->count_all_packages(),
            'per_page'     => $per_page,
            'current_page' => $page
        ];

        $this->template->title(lang('donate_packages'), lang('admin_panel'));
        $this->template->build('admin/packages', $data);
    }

    /**
     * Add package
     *
     * @return void
     */
    public function add_package()
    {
        require_permission('add.donate', 'donate');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', lang('name'), 'trim|required');
        $this->form_validation->set_rules('price', lang('price'), 'trim|required|decimal');
        $this->form_validation->set_rules('dp_amount', lang('donate_dp_amount'), 'trim|required|is_natural');
        $this->form_validation->set_rules('bonus_dp', lang('donate_bonus_dp'), 'trim|is_natural');

        if ($this->form_validation->run()) {
            $data = [
                'name'        => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'price'       => $this->input->post('price'),
                'currency'    => $this->input->post('currency') ?? 'USD',
                'dp_amount'   => $this->input->post('dp_amount'),
                'bonus_dp'    => $this->input->post('bonus_dp') ?? 0,
                'image'       => $this->input->post('image') ?? '',
                'featured'    => $this->input->post('featured') ? 1 : 0,
                'sort_order'  => $this->input->post('sort_order') ?? 0,
                'is_active'   => $this->input->post('is_active') ? 1 : 0
            ];

            if ($this->donate_model->insert($data)) {
                $this->session->set_flashdata('success', lang('donate_package_added'));
                redirect('donate/admin/packages');
            }

            $this->session->set_flashdata('error', lang('donate_package_add_error'));
        }

        $this->template->title(lang('add'), lang('donate_packages'), lang('admin_panel'));
        $this->template->build('admin/add_package');
    }

    /**
     * Edit package
     *
     * @param int $id
     * @return void
     */
    public function edit_package($id)
    {
        require_permission('edit.donate', 'donate');

        $package = $this->donate_model->get_package($id);

        if (empty($package)) {
            show_404();
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', lang('name'), 'trim|required');
        $this->form_validation->set_rules('price', lang('price'), 'trim|required|decimal');
        $this->form_validation->set_rules('dp_amount', lang('donate_dp_amount'), 'trim|required|is_natural');
        $this->form_validation->set_rules('bonus_dp', lang('donate_bonus_dp'), 'trim|is_natural');

        if ($this->form_validation->run()) {
            $data = [
                'name'        => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'price'       => $this->input->post('price'),
                'currency'    => $this->input->post('currency') ?? 'USD',
                'dp_amount'   => $this->input->post('dp_amount'),
                'bonus_dp'    => $this->input->post('bonus_dp') ?? 0,
                'image'       => $this->input->post('image') ?? '',
                'featured'    => $this->input->post('featured') ? 1 : 0,
                'sort_order'  => $this->input->post('sort_order') ?? 0,
                'is_active'   => $this->input->post('is_active') ? 1 : 0
            ];

            if ($this->donate_model->update($data, ['id' => $id])) {
                $this->session->set_flashdata('success', lang('donate_package_updated'));
                redirect('donate/admin/packages');
            }

            $this->session->set_flashdata('error', lang('donate_package_update_error'));
        }

        $data = [
            'package' => $package
        ];

        $this->template->title(lang('edit'), lang('donate_packages'), lang('admin_panel'));
        $this->template->build('admin/edit_package', $data);
    }

    /**
     * Delete package
     *
     * @param int $id
     * @return void
     */
    public function delete_package($id)
    {
        require_permission('delete.donate', 'donate');

        $package = $this->donate_model->get_package($id);

        if (empty($package)) {
            show_404();
        }

        if ($this->donate_model->delete(['id' => $id])) {
            $this->session->set_flashdata('success', lang('donate_package_deleted'));
        } else {
            $this->session->set_flashdata('error', lang('donate_package_delete_error'));
        }

        redirect('donate/admin/packages');
    }

    /**
     * Manage gateways
     *
     * @return void
     */
    public function gateways()
    {
        require_permission('view.donate', 'donate');

        $data = [
            'gateways' => $this->donate_model->get_all_gateways()
        ];

        $this->template->title(lang('donate_gateways'), lang('admin_panel'));
        $this->template->build('admin/gateways', $data);
    }

    /**
     * Edit gateway
     *
     * @param string $name
     * @return void
     */
    public function edit_gateway($name)
    {
        require_permission('edit.donate', 'donate');

        $gateway = $this->donate_model->get_gateway($name);

        if (empty($gateway)) {
            show_404();
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('display_name', lang('name'), 'trim|required');

        if ($this->form_validation->run()) {
            $config = json_decode($gateway->config, true) ?? [];

            // Update config based on gateway type
            switch ($name) {
                case 'paypal':
                    $config['client_id'] = $this->input->post('client_id');
                    $config['client_secret'] = $this->input->post('client_secret');
                    break;
                case 'stripe':
                    $config['publishable_key'] = $this->input->post('publishable_key');
                    $config['secret_key'] = $this->input->post('secret_key');
                    $config['webhook_secret'] = $this->input->post('webhook_secret');
                    break;
            }

            $data = [
                'display_name' => $this->input->post('display_name'),
                'description'  => $this->input->post('description'),
                'config'       => json_encode($config),
                'sort_order'   => $this->input->post('sort_order') ?? 0,
                'is_active'    => $this->input->post('is_active') ? 1 : 0,
                'is_sandbox'   => $this->input->post('is_sandbox') ? 1 : 0
            ];

            if ($this->donate_model->update_gateway($name, $data)) {
                $this->session->set_flashdata('success', lang('donate_gateway_updated'));
                redirect('donate/admin/gateways');
            }

            $this->session->set_flashdata('error', lang('donate_gateway_update_error'));
        }

        $data = [
            'gateway' => $gateway,
            'config'  => json_decode($gateway->config, true) ?? []
        ];

        $this->template->title(lang('edit'), $gateway->display_name, lang('admin_panel'));
        $this->template->build('admin/edit_gateway', $data);
    }

    /**
     * View donation logs
     *
     * @return void
     */
    public function logs()
    {
        require_permission('view.donate', 'donate');

        $per_page = 30;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $per_page;

        $filters = [
            'status'  => $this->input->get('status'),
            'gateway' => $this->input->get('gateway'),
            'search'  => $this->input->get('search')
        ];

        $data = [
            'logs'         => $this->donate_model->get_all_logs($per_page, $offset, $filters),
            'total'        => $this->donate_model->count_all_logs($filters),
            'per_page'     => $per_page,
            'current_page' => $page,
            'filters'      => $filters,
            'gateways'     => $this->donate_model->get_all_gateways()
        ];

        $this->template->title(lang('donate_logs'), lang('admin_panel'));
        $this->template->build('admin/logs', $data);
    }

    /**
     * View single log detail
     *
     * @param int $id
     * @return void
     */
    public function log_detail($id)
    {
        require_permission('view.donate', 'donate');

        $log = $this->donate_model->get_log($id);

        if (empty($log)) {
            show_404();
        }

        // Get associated user and package
        $this->load->model('user_model');
        $user = $this->user_model->find(['id' => $log->user_id]);
        $package = $this->donate_model->get_package($log->package_id);

        $data = [
            'log'     => $log,
            'user'    => $user,
            'package' => $package
        ];

        $this->template->title(lang('details'), lang('donate_logs'), lang('admin_panel'));
        $this->template->build('admin/log_detail', $data);
    }

    /**
     * Module settings
     *
     * @return void
     */
    public function settings()
    {
        require_permission('edit.donate', 'donate');

        $this->load->library('form_validation');
        $this->load->model('setting_model');

        if ($this->input->method() === 'post') {
            $settings = [
                'donate_enabled'    => $this->input->post('donate_enabled') ? '1' : '0',
                'donate_currency'   => $this->input->post('donate_currency'),
                'donate_min_amount' => $this->input->post('donate_min_amount'),
                'donate_max_amount' => $this->input->post('donate_max_amount')
            ];

            foreach ($settings as $key => $value) {
                $this->setting_model->update(['value' => $value], ['key' => $key]);
            }

            $this->cache->delete('settings');
            $this->session->set_flashdata('success', lang('settings_updated'));
            redirect('donate/admin/settings');
        }

        $this->template->title(lang('settings'), lang('donate'), lang('admin_panel'));
        $this->template->build('admin/settings');
    }
}
