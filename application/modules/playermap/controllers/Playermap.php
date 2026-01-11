<?php
/**
 * BlizzCMS - Playermap Module
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Playermap extends BS_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_module_installed('playermap', true);

        $this->load->config('playermap/playermap');
        $this->load->language('playermap/playermap');
        $this->load->model('playermap_model');
        $this->load->helper('wow');
    }

    /**
     * Playermap index page
     *
     * @return void
     */
    public function index()
    {
        $realm_id = $this->input->get('realm', true) ?: $this->config->item('playermap_default_realm');
        
        $realms = $this->realm_model->find_all();
        
        if (empty($realms)) {
            show_error(lang('playermap_no_realms_configured'));
        }

        $selected_realm = null;
        foreach ($realms as $realm) {
            if ($realm->id == $realm_id) {
                $selected_realm = $realm;
                break;
            }
        }

        if (empty($selected_realm)) {
            $selected_realm = $realms[0];
            $realm_id = $selected_realm->id;
        }

        $data = [
            'realms'         => $realms,
            'selected_realm' => $selected_realm,
            'realm_id'       => $realm_id
        ];

        $this->template->title(lang('playermap_title'), config_item('app_name'));
        $this->template->build('index', $data);
    }

    /**
     * Get player data via AJAX
     *
     * @return void
     */
    public function get_players()
    {
        $this->output->set_content_type('application/json');

        $realm_id = $this->input->get('realm', true);

        if (empty($realm_id)) {
            $this->output->set_output(json_encode(['error' => 'No realm specified', 'online' => null]));
            return;
        }

        $realm = $this->realm_model->find(['id' => $realm_id]);

        if (empty($realm)) {
            $this->output->set_output(json_encode(['error' => 'Invalid realm', 'online' => null]));
            return;
        }

        try {
            $result = $this->playermap_model->get_online_players($realm_id);
            $status = $this->playermap_model->get_server_status($realm_id);

            $output = [
                'online' => $result,
                'status' => $status,
                'error' => null
            ];

            $this->output->set_output(json_encode($output));
        } catch (Exception $e) {
            log_message('error', 'Playermap get_players error: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
            
            $this->output->set_output(json_encode([
                'error' => $e->getMessage(),
                'online' => [],
                'status' => null,
                'debug' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ]));
        }
    }
}
