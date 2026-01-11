<?php
/**
 * BlizzCMS - Playermap Module Admin
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

        require_permission('view.playermap', 'playermap');

        $this->load->config('playermap/playermap');
        $this->load->language('playermap/playermap');
        $this->load->language('admin/admin'); // Load core admin language
        $this->load->model('playermap_model');
    }

    /**
     * Admin playermap dashboard
     *
     * @return void
     */
    public function index()
    {
        $realms = $this->realm_model->find_all();
        
        // Get statistics for all realms
        $stats = [];
        foreach ($realms as $realm) {
            try {
                $players = $this->playermap_model->get_online_players($realm->id);
                
                // Count players by removing the first 3 entries (map counts)
                $player_count = count($players) - 3;
                
                // Get faction counts (first 3 entries are [alliance, horde] for each map)
                $alliance_total = 0;
                $horde_total = 0;
                for ($i = 0; $i < 3; $i++) {
                    if (isset($players[$i])) {
                        $alliance_total += $players[$i][0];
                        $horde_total += $players[$i][1];
                    }
                }
                
                $stats[$realm->id] = [
                    'realm_name' => $realm->realm_name,
                    'total_online' => $alliance_total + $horde_total,
                    'alliance' => $alliance_total,
                    'horde' => $horde_total
                ];
            } catch (Exception $e) {
                $stats[$realm->id] = [
                    'realm_name' => $realm->realm_name,
                    'total_online' => 0,
                    'alliance' => 0,
                    'horde' => 0,
                    'error' => $e->getMessage()
                ];
            }
        }

        $data = [
            'stats' => $stats,
            'realms' => $realms
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));
        $this->template->build('admin/index', $data);
    }

    /**
     * Settings page
     *
     * @return void
     */
    public function settings()
    {
        require_permission('manage.playermap.settings', 'playermap');

        $this->load->helper('file');

        $config_file = APPPATH . 'modules/playermap/config/playermap.php';
        
        $this->form_validation->set_rules('server_type', lang('playermap_server_type'), 'required|in_list[0,1]');
        $this->form_validation->set_rules('gm_show_online', lang('playermap_gm_show_online'), 'in_list[0,1]');
        $this->form_validation->set_rules('gm_include_count', lang('playermap_gm_include_count'), 'in_list[0,1]');
        $this->form_validation->set_rules('update_interval', lang('playermap_update_interval'), 'required|integer|greater_than_equal_to[0]');

        if ($this->input->method() === 'post' && $this->form_validation->run()) {
            // Read current config
            $config_content = read_file($config_file);
            
            // Update values
            $config_content = preg_replace(
                "/\\\$config\['playermap_server_type'\] = \d+;/",
                "\$config['playermap_server_type'] = " . $this->input->post('server_type') . ";",
                $config_content
            );
            
            $config_content = preg_replace(
                "/\\\$config\['playermap_gm_show_online'\] = (true|false);/",
                "\$config['playermap_gm_show_online'] = " . ($this->input->post('gm_show_online') ? 'true' : 'false') . ";",
                $config_content
            );
            
            $config_content = preg_replace(
                "/\\\$config\['playermap_gm_include_count'\] = (true|false);/",
                "\$config['playermap_gm_include_count'] = " . ($this->input->post('gm_include_count') ? 'true' : 'false') . ";",
                $config_content
            );
            
            $config_content = preg_replace(
                "/\\\$config\['playermap_time'\] = \d+;/",
                "\$config['playermap_time'] = " . $this->input->post('update_interval') . ";",
                $config_content
            );

            if (write_file($config_file, $config_content)) {
                $this->log_model->create('playermap', 'settings', 'Updated playermap settings');
                $this->session->set_flashdata('success', lang('alert_settings_updated'));
            } else {
                $this->session->set_flashdata('error', lang('alert_settings_update_error'));
            }
            
            redirect(site_url('playermap/admin/settings'));
        }

        $data = [
            'config' => [
                'server_type' => config_item('playermap_server_type'),
                'gm_show_online' => config_item('playermap_gm_show_online'),
                'gm_include_count' => config_item('playermap_gm_include_count'),
                'gm_only_gmoff' => config_item('playermap_gm_only_gmoff'),
                'gm_only_gmvisible' => config_item('playermap_gm_only_gmvisible'),
                'gm_add_suffix' => config_item('playermap_gm_add_suffix'),
                'show_status' => config_item('playermap_show_status'),
                'show_time' => config_item('playermap_show_time'),
                'update_interval' => config_item('playermap_time'),
            ]
        ];

        $this->template->title(lang('admin_panel'), config_item('app_name'));
        $this->template->build('admin/settings', $data);
    }
}
