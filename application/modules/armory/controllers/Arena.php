<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Arena extends BS_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->language('armory');
        $this->load->model('armory_arena_model');
        $this->load->helper('wow');
    }

    /**
     * Arena ladder page
     *
     * @param int $realm
     * @return void
     */
    public function ladder($realm)
    {
        if (! $this->realm_model->exists($realm)) {
            show_404();
        }

        $type = $this->input->get('type', true) ?: '2v2';
        
        // Map type to arena type value
        $arena_types = [
            '2v2' => 2,
            '3v3' => 3,
            '5v5' => 5
        ];

        $arena_type = $arena_types[$type] ?? 2;

        $teams      = $this->armory_arena_model->get_top_teams($realm, $arena_type, 100);
        $realm_info = $this->realm_model->find(['id' => $realm]);
        $all_realms = $this->realm_model->find_all();

        $data = [
            'teams'       => $teams,
            'realm'       => $realm_info,
            'realm_id'    => $realm,
            'arena_type'  => $type,
            'arena_types' => array_keys($arena_types),
            'all_realms'  => $all_realms
        ];

        $this->template->title(lang('arena_ladder'), lang('armory'), config_item('app_name'));

        $this->template->build('arena/ladder', $data);
    }

    /**
     * Arena team page
     *
     * @param int $realm
     * @param int $team_id
     * @return void
     */
    public function team($realm, $team_id)
    {
        if (! $this->realm_model->exists($realm)) {
            show_404();
        }

        $team = $this->armory_arena_model->get_team($realm, $team_id);

        if (empty($team)) {
            show_404();
        }

        $members    = $this->armory_arena_model->get_team_members($realm, $team_id);
        $realm_info = $this->realm_model->find(['id' => $realm]);

        $data = [
            'team'     => $team,
            'members'  => $members,
            'realm'    => $realm_info,
            'realm_id' => $realm
        ];

        $this->template->title($team->name, lang('arena_team'), lang('armory'), config_item('app_name'));

        $this->template->build('arena/team', $data);
    }
}
