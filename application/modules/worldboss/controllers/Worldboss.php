<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Worldboss extends BS_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_module_installed('worldboss', true);

        $this->load->language('worldboss');
        $this->load->model('worldboss_model');
        $this->load->helper('wow');
    }

    /**
     * World Boss Rankings index page
     *
     * @return void
     */
    public function index()
    {
        // Get the first available realm
        $realms = $this->realm_model->find_all();
        $realm_id = ! empty($realms) ? $realms[0]->id : 1;

        // Get boss list
        $bosses = $this->worldboss_model->get_bosses();
        $default_boss = ! empty($bosses) ? $bosses[0]['id'] : null;

        // Get encounters for the default boss
        $encounters = [];
        $stats = (object)['total_encounters' => 0, 'horde_count' => 0, 'alliance_count' => 0];

        if ($default_boss !== null) {
            $encounters = $this->worldboss_model->get_encounters($realm_id, $default_boss);
            $stats = $this->worldboss_model->get_stats($realm_id, $default_boss);
        }

        $data = [
            'bosses'           => $bosses,
            'selected_boss'    => $default_boss,
            'selected_boss_name' => $this->worldboss_model->get_boss_name($default_boss),
            'encounters'       => $encounters,
            'stats'            => $stats,
            'realm_id'         => $realm_id,
            'realms'           => $realms
        ];

        $this->template->title(lang('worldboss'), config_item('app_name'));

        $this->template->build('index', $data);
    }

    /**
     * World Boss Rankings for a specific boss
     *
     * @param int $boss_id
     * @return void
     */
    public function boss($boss_id)
    {
        // Get the first available realm
        $realms = $this->realm_model->find_all();
        $realm_id = ! empty($realms) ? $realms[0]->id : 1;

        // Validate boss ID
        $boss_name = $this->worldboss_model->get_boss_name($boss_id);

        if ($boss_name === null) {
            show_404();
        }

        // Get boss list
        $bosses = $this->worldboss_model->get_bosses();

        // Get encounters for the selected boss
        $encounters = $this->worldboss_model->get_encounters($realm_id, $boss_id);
        $stats = $this->worldboss_model->get_stats($realm_id, $boss_id);

        $data = [
            'bosses'           => $bosses,
            'selected_boss'    => $boss_id,
            'selected_boss_name' => $boss_name,
            'encounters'       => $encounters,
            'stats'            => $stats,
            'realm_id'         => $realm_id,
            'realms'           => $realms
        ];

        $this->template->title($boss_name, lang('worldboss'), config_item('app_name'));

        $this->template->build('index', $data);
    }

    /**
     * API endpoint to get encounters for a boss (AJAX)
     *
     * @param int $boss_id
     * @return void
     */
    public function api_encounters($boss_id)
    {
        // Get realm from query parameter or use default
        $realm_id = $this->input->get('realm') ?? 1;

        $boss_name = $this->worldboss_model->get_boss_name($boss_id);

        if ($boss_name === null) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'error' => 'Invalid boss ID'
                ]));
            return;
        }

        $encounters = $this->worldboss_model->get_encounters($realm_id, $boss_id);
        $stats = $this->worldboss_model->get_stats($realm_id, $boss_id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => true,
                'boss_name' => $boss_name,
                'encounters' => $encounters,
                'stats' => $stats
            ]));
    }
}
