<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Head_scripts extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        require_permission('view.settings');
        $this->load->library('head_scripts_manager');
        
        if (file_exists(APPPATH . 'config/head_scripts.php')) {
            $this->config->load('head_scripts', true);
        }
    }

    public function index()
    {
        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $configured = $this->config->item('head_scripts', 'head_scripts') ?: [];
        $scripts = is_array($configured) ? $configured : [];

        $data = [
            'scripts' => $scripts,
            'analytics_types' => [
                'google_analytics' => 'Google Analytics',
                'google_tag_manager' => 'Google Tag Manager',
                'facebook_pixel' => 'Facebook Pixel',
                'custom' => 'Custom Analytics',
            ],
            'script_types' => [
                'script' => 'JavaScript',
                'tag' => 'HTML Tag',
                'analytics' => 'Analytics',
            ],
        ];

        $this->template->build('head_scripts/index', $data);
    }

    public function edit($key = null)
    {
        if (empty($key)) {
            show_404();
        }

        require_permission('edit.settings', 'admin');

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $configured = $this->config->item('head_scripts', 'head_scripts') ?: [];
        $script = isset($configured[$key]) ? $configured[$key] : null;

        if ($script === null) {
            $this->session->set_flashdata('error', 'Script not found');
            redirect(site_url('admin/head_scripts'));
        }

        $this->form_validation->set_rules('enabled', 'Enabled', 'trim');
        $this->form_validation->set_rules('type', 'Type', 'trim|required|in_list[script,tag,analytics]');
        $this->form_validation->set_rules('src', 'Source URL', 'trim');
        $this->form_validation->set_rules('script_content', 'Script Content', 'trim');
        $this->form_validation->set_rules('tag_content', 'Tag Content', 'trim');
        $this->form_validation->set_rules('analytics_content', 'Analytics Content', 'trim');
        $this->form_validation->set_rules('async', 'Async', 'trim');
        $this->form_validation->set_rules('defer', 'Defer', 'trim');
        $this->form_validation->set_rules('analytics_type', 'Analytics Type', 'trim');
        $this->form_validation->set_rules('script_type', 'Script Type', 'trim');

        if ($this->input->method() === 'post') {
            if ($this->form_validation->run()) {
                $this->_save_script($key);
                return;
            } else {
                $this->session->set_flashdata('error', 'Please fix the validation errors below');
            }
        }

        $data = [
            'key' => $key,
            'script' => $script,
            'analytics_types' => [
                'google_analytics' => 'Google Analytics',
                'google_tag_manager' => 'Google Tag Manager',
                'facebook_pixel' => 'Facebook Pixel',
                'custom' => 'Custom Analytics',
            ],
            'script_types' => [
                'script' => 'JavaScript',
                'tag' => 'HTML Tag',
                'analytics' => 'Analytics',
            ],
        ];

        $this->template->build('head_scripts/edit', $data);
    }

    public function create()
    {
        require_permission('edit.settings', 'admin');

        $this->template->title(lang('admin_panel'), config_item('app_name'));

        $this->form_validation->set_rules('key', 'Script Key', 'trim|required|alpha_dash');
        $this->form_validation->set_rules('enabled', 'Enabled', 'trim');
        $this->form_validation->set_rules('type', 'Type', 'trim|required|in_list[script,tag,analytics]');
        $this->form_validation->set_rules('src', 'Source URL', 'trim');
        $this->form_validation->set_rules('script_content', 'Script Content', 'trim');
        $this->form_validation->set_rules('tag_content', 'Tag Content', 'trim');
        $this->form_validation->set_rules('analytics_content', 'Analytics Content', 'trim');
        $this->form_validation->set_rules('async', 'Async', 'trim');
        $this->form_validation->set_rules('defer', 'Defer', 'trim');
        $this->form_validation->set_rules('analytics_type', 'Analytics Type', 'trim');
        $this->form_validation->set_rules('script_type', 'Script Type', 'trim');

        if ($this->input->method() === 'post') {
            if ($this->form_validation->run()) {
                $key = $this->input->post('key', true);

                $configured = $this->config->item('head_scripts', 'head_scripts') ?: [];
                if (isset($configured[$key])) {
                    $this->session->set_flashdata('error', 'Script key already exists');
                    redirect(site_url('admin/head_scripts/create'));
                    return;
                }

                $this->_save_script($key);
                return;
            } else {
                $this->session->set_flashdata('error', 'Please fix the validation errors below');
            }
        }

        $data = [
            'key' => null,
            'script' => null,
            'analytics_types' => [
                'google_analytics' => 'Google Analytics',
                'google_tag_manager' => 'Google Tag Manager',
                'facebook_pixel' => 'Facebook Pixel',
                'custom' => 'Custom Analytics',
            ],
            'script_types' => [
                'script' => 'JavaScript',
                'tag' => 'HTML Tag',
                'analytics' => 'Analytics',
            ],
        ];

        $this->template->build('head_scripts/edit', $data);
    }

    public function delete($key = null)
    {
        require_permission('edit.settings', 'admin');

        if (empty($key)) {
            show_404();
        }

        $this->_delete_script($key);
        $this->session->set_flashdata('success', 'Script deleted successfully');
        redirect(site_url('admin/head_scripts'));
    }

    public function toggle($key = null)
    {
        require_permission('edit.settings', 'admin');

        if (empty($key) || !$this->input->is_ajax_request()) {
            show_404();
        }

        $configured = $this->config->item('head_scripts', 'head_scripts') ?: [];
        if (!isset($configured[$key])) {
            echo json_encode(['success' => false, 'message' => 'Script not found']);
            return;
        }

        $script = $configured[$key];
        $script['enabled'] = !($script['enabled'] ?? false);

        $this->_update_config($key, $script);

        echo json_encode(['success' => true, 'enabled' => $script['enabled']]);
    }

    private function _save_script($key)
    {
        $type = $this->input->post('type', true);
        $script = [
            'enabled' => (bool) $this->input->post('enabled'),
            'type' => $type,
        ];

        if ($type === 'script') {
            $script['src'] = $this->input->post('src', true);
            $script['content'] = $this->input->post('script_content', true);
            $script['async'] = (bool) $this->input->post('async');
            $script['defer'] = (bool) $this->input->post('defer');
            $script['script_type'] = $this->input->post('script_type', true) ?: 'text/javascript';
        } elseif ($type === 'tag') {
            $script['content'] = $this->input->post('tag_content', true);
        } elseif ($type === 'analytics') {
            $script['analytics_type'] = $this->input->post('analytics_type', true);
            $script['content'] = $this->input->post('analytics_content', true);
        }

        $this->_update_config($key, $script);

        $this->session->set_flashdata('success', 'Script saved successfully');
        redirect(site_url('admin/head_scripts'));
    }

    private function _update_config($key, $script)
    {
        $config_file = APPPATH . 'config/head_scripts.php';
        $configured = $this->config->item('head_scripts', 'head_scripts') ?: [];

        $configured[$key] = $script;

        $config_content = "<?php\ndefined('BASEPATH') OR exit('No direct script access allowed');\n\n";
        $config_content .= "\$config['head_scripts'] = " . var_export($configured, true) . ";\n";

        file_put_contents($config_file, $config_content);

        $this->config->set_item('head_scripts', $configured, 'head_scripts');
    }

    private function _delete_script($key)
    {
        $config_file = APPPATH . 'config/head_scripts.php';
        $configured = $this->config->item('head_scripts', 'head_scripts') ?: [];

        if (!isset($configured[$key])) {
            return;
        }

        unset($configured[$key]);

        $config_content = "<?php\ndefined('BASEPATH') OR exit('No direct script access allowed');\n\n";
        $config_content .= "\$config['head_scripts'] = " . var_export($configured, true) . ";\n";

        file_put_contents($config_file, $config_content);

        $this->config->set_item('head_scripts', $configured, 'head_scripts');
    }
}
