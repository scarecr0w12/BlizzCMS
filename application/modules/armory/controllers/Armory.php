<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Armory extends BS_Controller
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
     * Armory index/search page
     *
     * @return void
     */
    public function index()
    {
        $realms = $this->realm_model->find_all();

        $data = [
            'realms'        => $realms,
            'results'       => [],
            'guild_results' => [],
            'query'         => '',
            'search_type'   => 'character'
        ];

        $this->template->title(lang('armory'), config_item('app_name'));

        $this->template->build('index', $data);
    }

    /**
     * Search characters and guilds
     *
     * @return void
     */
    public function search()
    {
        $realms      = $this->realm_model->find_all();
        $query       = $this->input->get('q', true);
        $realm       = $this->input->get('realm', true);
        $search_type = $this->input->get('type', true) ?: 'character';

        $results       = [];
        $guild_results = [];

        if (! empty($query) && strlen($query) >= 2) {
            if ($search_type === 'guild' || $search_type === 'all') {
                // Search guilds
                if (! empty($realm) && $realm !== 'all') {
                    $realm_guilds = $this->armory_guild_model->search_guilds($realm, $query);
                    $realm_row = $this->realm_model->find(['id' => $realm]);
                    foreach ($realm_guilds as $guild) {
                        $guild->realm_id   = $realm;
                        $guild->realm_name = $realm_row->realm_name ?? '';
                        $guild->member_count = $this->armory_guild_model->count_members($realm, $guild->guildid);
                        $guild_results[] = $guild;
                    }
                } else {
                    foreach ($realms as $r) {
                        $realm_guilds = $this->armory_guild_model->search_guilds($r->id, $query);
                        foreach ($realm_guilds as $guild) {
                            $guild->realm_id   = $r->id;
                            $guild->realm_name = $r->realm_name;
                            $guild->member_count = $this->armory_guild_model->count_members($r->id, $guild->guildid);
                            $guild_results[] = $guild;
                        }
                    }
                }
            }

            if ($search_type === 'character' || $search_type === 'all') {
                // Search characters
                if (! empty($realm) && $realm !== 'all') {
                    $results = $this->armory_character_model->search_characters($realm, $query);
                    $realm_row = $this->realm_model->find(['id' => $realm]);
                    foreach ($results as &$char) {
                        $char->realm_id   = $realm;
                        $char->realm_name = $realm_row->realm_name ?? '';
                    }
                } else {
                    foreach ($realms as $r) {
                        $realm_results = $this->armory_character_model->search_characters($r->id, $query);
                        foreach ($realm_results as $char) {
                            $char->realm_id   = $r->id;
                            $char->realm_name = $r->realm_name;
                            $results[]        = $char;
                        }
                    }
                }
            }
        }

        $data = [
            'realms'         => $realms,
            'results'        => $results,
            'guild_results'  => $guild_results,
            'query'          => $query,
            'selected_realm' => $realm,
            'search_type'    => $search_type
        ];

        $this->template->title(lang('armory_search'), config_item('app_name'));

        $this->template->build('index', $data);
    }

    /**
     * API endpoint for AJAX search
     *
     * @return void
     */
    public function api_search()
    {
        if (! $this->input->is_ajax_request()) {
            show_404();
        }

        $query       = $this->input->post('query', true);
        $realm       = $this->input->post('realm', true);
        $search_type = $this->input->post('type', true) ?: 'character';

        $results       = [];
        $guild_results = [];

        if (! empty($query) && strlen($query) >= 2) {
            if ($search_type === 'character' || $search_type === 'all') {
                if (! empty($realm) && $realm !== 'all') {
                    $char_results = $this->armory_character_model->search_characters($realm, $query, 10);
                    $realm_row = $this->realm_model->find(['id' => $realm]);
                    foreach ($char_results as &$char) {
                        $char->realm_id   = $realm;
                        $char->realm_name = $realm_row->realm_name ?? '';
                    }
                    $results = $char_results;
                } else {
                    $realms = $this->realm_model->find_all();
                    foreach ($realms as $r) {
                        $realm_results = $this->armory_character_model->search_characters($r->id, $query, 5);
                        foreach ($realm_results as $char) {
                            $char->realm_id   = $r->id;
                            $char->realm_name = $r->realm_name;
                            $results[]        = $char;
                        }
                    }
                }
            }

            if ($search_type === 'guild' || $search_type === 'all') {
                if (! empty($realm) && $realm !== 'all') {
                    $g_results = $this->armory_guild_model->search_guilds($realm, $query, 10);
                    $realm_row = $this->realm_model->find(['id' => $realm]);
                    foreach ($g_results as $guild) {
                        $guild->realm_id   = $realm;
                        $guild->realm_name = $realm_row->realm_name ?? '';
                        $guild_results[] = $guild;
                    }
                } else {
                    $realms = $this->realm_model->find_all();
                    foreach ($realms as $r) {
                        $g_results = $this->armory_guild_model->search_guilds($r->id, $query, 5);
                        foreach ($g_results as $guild) {
                            $guild->realm_id   = $r->id;
                            $guild->realm_name = $r->realm_name;
                            $guild_results[] = $guild;
                        }
                    }
                }
            }
        }

        // Format character results for JSON response
        $formatted_chars = [];
        foreach ($results as $char) {
            $formatted_chars[] = [
                'guid'       => $char->guid,
                'name'       => $char->name,
                'level'      => $char->level,
                'race'       => $char->race,
                'race_name'  => race_name($char->race),
                'class'      => $char->class,
                'class_name' => class_name($char->class),
                'gender'     => $char->gender,
                'realm_id'   => $char->realm_id,
                'realm_name' => $char->realm_name,
                'online'     => $char->online ?? 0,
                'url'        => site_url('armory/character/' . $char->realm_id . '/' . urlencode($char->name))
            ];
        }

        // Format guild results for JSON response
        $formatted_guilds = [];
        foreach ($guild_results as $guild) {
            $formatted_guilds[] = [
                'guildid'    => $guild->guildid,
                'name'       => $guild->name,
                'realm_id'   => $guild->realm_id,
                'realm_name' => $guild->realm_name,
                'url'        => site_url('armory/guild/' . $guild->realm_id . '/' . urlencode($guild->name))
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success'      => true,
                'characters'   => $formatted_chars,
                'guilds'       => $formatted_guilds
            ]));
    }
}
