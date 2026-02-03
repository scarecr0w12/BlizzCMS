<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pvpstats extends BS_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->language('pvpstats');
        $this->load->model('pvpstats_battleground_model');
        $this->load->model('pvpstats_player_model');
        $this->load->helper('wow');
    }

    /**
     * PvP stats index page
     */
    public function index()
    {
        $data = [
            'top_players'     => $this->pvpstats_battleground_model->get_top_players(20, 'all'),
            'top_guilds'      => $this->pvpstats_battleground_model->get_top_guilds(5, 'all'),
            'faction_stats'   => $this->pvpstats_battleground_model->get_faction_statistics('all'),
            'bg_stats'        => $this->pvpstats_battleground_model->get_statistics('all'),
            'today_players'   => $this->pvpstats_battleground_model->get_top_players(10, 'today'),
            'today_stats'     => $this->pvpstats_battleground_model->get_statistics('today')
        ];

        $this->template->title(lang('pvpstats'), config_item('app_name'));
        $this->template->build('index', $data);
    }

    /**
     * Battlegrounds list page
     */
    public function battlegrounds()
    {
        $page = $this->input->get('page', true) ?: 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $filters = [
            'type'       => $this->input->get('type', true),
            'bracket_id' => $this->input->get('bracket', true),
            'start_date' => $this->input->get('start_date', true),
            'end_date'   => $this->input->get('end_date', true)
        ];

        $battlegrounds = $this->pvpstats_battleground_model->get_battlegrounds($limit, $offset, $filters);
        $total = $this->pvpstats_battleground_model->count_battlegrounds($filters);

        $data = [
            'battlegrounds' => $battlegrounds,
            'total'         => $total,
            'page'          => $page,
            'limit'         => $limit,
            'filters'       => $filters
        ];

        $this->template->title(lang('pvpstats_battlegrounds'), config_item('app_name'));
        $this->template->build('battlegrounds', $data);
    }

    /**
     * Battleground detail page
     */
    public function battleground_detail($battleground_id)
    {
        $battleground = $this->pvpstats_battleground_model->get_battleground_detail($battleground_id);

        if (!$battleground) {
            show_404();
        }

        $players = $this->pvpstats_battleground_model->get_battleground_players($battleground_id);

        $data = [
            'battleground' => $battleground,
            'players'      => $players
        ];

        $this->template->title(lang('pvpstats_battleground_detail'), config_item('app_name'));
        $this->template->build('battleground_detail', $data);
    }

    /**
     * Players statistics page
     */
    public function players()
    {
        $page = $this->input->get('page', true) ?: 1;
        $limit = 50;
        $offset = ($page - 1) * $limit;

        $top_players = $this->pvpstats_battleground_model->get_top_players($limit, 'all');

        $data = [
            'players' => $top_players,
            'page'    => $page,
            'limit'   => $limit
        ];

        $this->template->title(lang('pvpstats_players'), config_item('app_name'));
        $this->template->build('players', $data);
    }

    /**
     * Player statistics page
     */
    public function player_stats($player_name)
    {
        $player_name = urldecode($player_name);
        $player_stats = $this->pvpstats_player_model->get_player_stats($player_name);

        if (!$player_stats) {
            show_404();
        }

        $page = $this->input->get('page', true) ?: 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $history = $this->pvpstats_player_model->get_player_history($player_name, $limit, $offset);
        $history_count = $this->pvpstats_player_model->count_player_history($player_name);
        $stats_by_type = $this->pvpstats_player_model->get_player_stats_by_type($player_name);
        $win_rate = $this->pvpstats_player_model->get_player_win_rate($player_name);

        $data = [
            'player'        => $player_stats,
            'history'       => $history,
            'history_count' => $history_count,
            'stats_by_type' => $stats_by_type,
            'win_rate'      => $win_rate,
            'page'          => $page,
            'limit'         => $limit
        ];

        $this->template->title($player_name . ' - ' . lang('pvpstats_player_stats'), config_item('app_name'));
        $this->template->build('player_stats', $data);
    }

    /**
     * Guilds statistics page
     */
    public function guilds()
    {
        $top_guilds = $this->pvpstats_battleground_model->get_top_guilds(50, 'all');

        $data = [
            'guilds' => $top_guilds
        ];

        $this->template->title(lang('pvpstats_guilds'), config_item('app_name'));
        $this->template->build('guilds', $data);
    }

    /**
     * Statistics page
     */
    public function statistics()
    {
        $time_period = $this->input->get('period', true) ?: 'all';

        $data = [
            'bg_stats'      => $this->pvpstats_battleground_model->get_statistics($time_period),
            'faction_stats' => $this->pvpstats_battleground_model->get_faction_statistics($time_period),
            'top_players'   => $this->pvpstats_battleground_model->get_top_players(20, $time_period),
            'top_guilds'    => $this->pvpstats_battleground_model->get_top_guilds(5, $time_period),
            'time_period'   => $time_period
        ];

        $this->template->title(lang('pvpstats_statistics'), config_item('app_name'));
        $this->template->build('statistics', $data);
    }

    /**
     * API endpoint for battlegrounds
     */
    public function api_battlegrounds()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $limit = $this->input->get('limit', true) ?: 20;
        $offset = $this->input->get('offset', true) ?: 0;

        $battlegrounds = $this->pvpstats_battleground_model->get_battlegrounds($limit, $offset);
        $total = $this->pvpstats_battleground_model->count_battlegrounds();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success'       => true,
                'battlegrounds' => $battlegrounds,
                'total'         => $total
            ]));
    }

    /**
     * API endpoint for player statistics
     */
    public function api_player_stats($player_name)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $player_name = urldecode($player_name);
        $player_stats = $this->pvpstats_player_model->get_player_stats($player_name);

        if (!$player_stats) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Player not found'
                ]));
            return;
        }

        $win_rate = $this->pvpstats_player_model->get_player_win_rate($player_name);
        $stats_by_type = $this->pvpstats_player_model->get_player_stats_by_type($player_name);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success'       => true,
                'player'        => $player_stats,
                'win_rate'      => $win_rate,
                'stats_by_type' => $stats_by_type
            ]));
    }
}
