<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leaderboards extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('leaderboards_model');
    }

    public function index()
    {
        $this->load->model('realm_model');
        $realms = $this->realm_model->find_all();
        
        $data = [
            'categories' => [
                'pvp' => lang('leaderboards_pvp'),
                'honor' => lang('leaderboards_honor'),
                'arena' => lang('leaderboards_arena'),
                'achievements' => lang('leaderboards_achievements'),
                'professions' => lang('leaderboards_professions'),
                'guilds' => lang('leaderboards_guilds'),
            ],
            'has_realms' => !empty($realms)
        ];

        $this->template->title(lang('leaderboards_title'));
        $this->template->build('index', $data);
    }

    public function pvp()
    {
        $page = $this->input->get('page') ?: 1;
        $per_page = 50;
        $offset = ($page - 1) * $per_page;

        $data = [
            'rankings' => $this->leaderboards_model->get_pvp_rankings($per_page, $offset),
            'total' => $this->leaderboards_model->count_pvp_players(),
            'current_page' => $page,
            'per_page' => $per_page,
            'offset' => $offset,
        ];

        $this->template->title(lang('leaderboards_pvp'));
        $this->template->build('pvp', $data);
    }

    public function honor()
    {
        $page = $this->input->get('page') ?: 1;
        $per_page = 50;
        $offset = ($page - 1) * $per_page;

        $data = [
            'rankings' => $this->leaderboards_model->get_honor_rankings($per_page, $offset),
            'total' => $this->leaderboards_model->count_honor_players(),
            'current_page' => $page,
            'per_page' => $per_page,
            'offset' => $offset,
        ];

        $this->template->title(lang('leaderboards_honor'));
        $this->template->build('honor', $data);
    }

    public function arena()
    {
        $type = $this->input->get('type') ?: '2v2';
        $page = $this->input->get('page') ?: 1;
        $per_page = 50;
        $offset = ($page - 1) * $per_page;

        $data = [
            'rankings' => $this->leaderboards_model->get_arena_rankings($type, $per_page, $offset),
            'total' => $this->leaderboards_model->count_arena_teams($type),
            'current_page' => $page,
            'per_page' => $per_page,
            'type' => $type,
            'offset' => $offset,
        ];

        $this->template->title(lang('leaderboards_arena'));
        $this->template->build('arena', $data);
    }

    public function achievements()
    {
        $page = $this->input->get('page') ?: 1;
        $per_page = 50;
        $offset = ($page - 1) * $per_page;

        $data = [
            'rankings' => $this->leaderboards_model->get_achievement_rankings($per_page, $offset),
            'total' => $this->leaderboards_model->count_achievement_players(),
            'current_page' => $page,
            'per_page' => $per_page,
            'offset' => $offset,
        ];

        $this->template->title(lang('leaderboards_achievements'));
        $this->template->build('achievements', $data);
    }

    public function professions()
    {
        $profession = $this->input->get('profession') ?: 'all';
        $page = $this->input->get('page') ?: 1;
        $per_page = 50;
        $offset = ($page - 1) * $per_page;

        $data = [
            'rankings' => $this->leaderboards_model->get_profession_rankings($profession, $per_page, $offset),
            'total' => $this->leaderboards_model->count_profession_players($profession),
            'current_page' => $page,
            'per_page' => $per_page,
            'profession' => $profession,
            'profession_list' => $this->leaderboards_model->get_profession_list(),
            'offset' => $offset,
        ];

        $this->template->title(lang('leaderboards_professions'));
        $this->template->build('professions', $data);
    }

    public function guilds()
    {
        $page = $this->input->get('page') ?: 1;
        $per_page = 50;
        $offset = ($page - 1) * $per_page;

        $data = [
            'rankings' => $this->leaderboards_model->get_guild_rankings($per_page, $offset),
            'total' => $this->leaderboards_model->count_guilds(),
            'current_page' => $page,
            'per_page' => $per_page,
            'offset' => $offset,
        ];

        $this->template->title(lang('leaderboards_guilds'));
        $this->template->build('guilds', $data);
    }

    public function firsts()
    {
        $data = [
            'first_80s' => $this->leaderboards_model->get_first_max_levels(),
            'first_kills' => $this->leaderboards_model->get_first_boss_kills(),
            'first_achievements' => $this->leaderboards_model->get_first_achievements(),
        ];

        $this->template->title(lang('leaderboards_firsts'));
        $this->template->build('firsts', $data);
    }
}
