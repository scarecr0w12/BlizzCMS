<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Character extends BS_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->language('armory');
        $this->load->model('armory_character_model');
        $this->load->model('armory_guild_model');
        $this->load->helper('wow');
    }

    /**
     * Character profile page
     *
     * @param int $realm
     * @param string $name
     * @return void
     */
    public function profile($realm, $name)
    {
        $name = urldecode($name);

        if (! $this->realm_model->exists($realm)) {
            show_404();
        }

        $character = $this->armory_character_model->get_character_by_name($realm, $name);

        if (empty($character)) {
            show_404();
        }

        // Get additional character data
        $equipment = $this->armory_character_model->get_equipment($realm, $character->guid);
        $stats     = $this->armory_character_model->get_stats($realm, $character->guid);
        $guild     = $this->armory_guild_model->get_character_guild($realm, $character->guid);

        $realm_info = $this->realm_model->find(['id' => $realm]);

        $data = [
            'character'  => $character,
            'equipment'  => $equipment,
            'stats'      => $stats,
            'guild'      => $guild,
            'realm'      => $realm_info,
            'realm_id'   => $realm
        ];

        $this->template->title($character->name, lang('armory'), config_item('app_name'));

        $this->template->build('character/profile', $data);
    }

    /**
     * Character talents page
     *
     * @param int $realm
     * @param string $name
     * @return void
     */
    public function talents($realm, $name)
    {
        $name = urldecode($name);

        if (! $this->realm_model->exists($realm)) {
            show_404();
        }

        $character = $this->armory_character_model->get_character_by_name($realm, $name);

        if (empty($character)) {
            show_404();
        }

        $talents     = $this->armory_character_model->get_talents($realm, $character->guid);
        $glyphs      = $this->armory_character_model->get_glyphs($realm, $character->guid);
        $realm_info  = $this->realm_model->find(['id' => $realm]);

        $data = [
            'character' => $character,
            'talents'   => $talents,
            'glyphs'    => $glyphs,
            'realm'     => $realm_info,
            'realm_id'  => $realm
        ];

        $this->template->title($character->name, lang('talents'), lang('armory'), config_item('app_name'));

        $this->template->build('character/talents', $data);
    }

    /**
     * Character achievements page
     *
     * @param int $realm
     * @param string $name
     * @return void
     */
    public function achievements($realm, $name)
    {
        $name = urldecode($name);

        if (! $this->realm_model->exists($realm)) {
            show_404();
        }

        $character = $this->armory_character_model->get_character_by_name($realm, $name);

        if (empty($character)) {
            show_404();
        }

        $achievements = $this->armory_character_model->get_achievements($realm, $character->guid);
        $realm_info   = $this->realm_model->find(['id' => $realm]);

        $data = [
            'character'    => $character,
            'achievements' => $achievements,
            'realm'        => $realm_info,
            'realm_id'     => $realm
        ];

        $this->template->title($character->name, lang('achievements'), lang('armory'), config_item('app_name'));

        $this->template->build('character/achievements', $data);
    }

    /**
     * Character PvP page
     *
     * @param int $realm
     * @param string $name
     * @return void
     */
    public function pvp($realm, $name)
    {
        $name = urldecode($name);

        if (! $this->realm_model->exists($realm)) {
            show_404();
        }

        $character = $this->armory_character_model->get_character_by_name($realm, $name);

        if (empty($character)) {
            show_404();
        }

        $arena_teams = $this->armory_character_model->get_arena_teams($realm, $character->guid);
        $pvp_stats   = $this->armory_character_model->get_pvp_stats($realm, $character->guid);
        $realm_info  = $this->realm_model->find(['id' => $realm]);

        $data = [
            'character'   => $character,
            'arena_teams' => $arena_teams,
            'pvp_stats'   => $pvp_stats,
            'realm'       => $realm_info,
            'realm_id'    => $realm
        ];

        $this->template->title($character->name, lang('pvp'), lang('armory'), config_item('app_name'));

        $this->template->build('character/pvp', $data);
    }

    /**
     * API endpoint for character data
     *
     * @param int $realm
     * @param int $guid
     * @return void
     */
    public function api_character($realm, $guid)
    {
        if (! $this->input->is_ajax_request()) {
            show_404();
        }

        $character = $this->armory_character_model->get_character($realm, $guid);

        if (empty($character)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'error' => 'Character not found']));
            return;
        }

        $equipment = $this->armory_character_model->get_equipment($realm, $guid);
        $guild     = $this->armory_guild_model->get_character_guild($realm, $guid);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success'   => true,
                'character' => [
                    'guid'       => $character->guid,
                    'name'       => $character->name,
                    'level'      => $character->level,
                    'race'       => $character->race,
                    'race_name'  => race_name($character->race),
                    'class'      => $character->class,
                    'class_name' => class_name($character->class),
                    'gender'     => $character->gender,
                    'online'     => $character->online
                ],
                'equipment' => $equipment,
                'guild'     => $guild
            ]));
    }
}
