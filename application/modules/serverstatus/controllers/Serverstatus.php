<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Serverstatus extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('serverstatus_model');
        $this->load->model('realm_model');
    }

    public function index()
    {
        $realms = $this->serverstatus_model->get_realms_with_stats();
        
        $faction_balance = [];
        $peak_players = [];
        $uptime_stats = [];
        
        foreach ($realms as $realm) {
            $faction_balance[$realm->id] = $this->serverstatus_model->get_faction_balance($realm->id);
            $peak_players[$realm->id] = $this->serverstatus_model->get_peak_players_today($realm->id);
            $uptime_stats[$realm->id] = $this->serverstatus_model->get_uptime_statistics(7, $realm->id);
        }
        
        $data = [
            'realms' => $realms,
            'faction_balance' => $faction_balance,
            'class_distribution' => !empty($realms) ? $this->serverstatus_model->get_class_distribution($realms[0]->id) : [],
            'level_distribution' => !empty($realms) ? $this->serverstatus_model->get_level_distribution($realms[0]->id) : [],
            'peak_players' => $peak_players,
            'uptime_stats' => $uptime_stats,
        ];

        $this->template->title(lang('serverstatus_title'));
        $this->template->build('index', $data);
    }

    public function api_stats()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $realm_id = $this->input->get('realm_id');
        
        $data = [
            'online_players' => $this->serverstatus_model->get_online_count($realm_id),
            'faction_balance' => $this->serverstatus_model->get_faction_balance($realm_id),
            'uptime' => $this->serverstatus_model->get_current_uptime($realm_id),
            'timestamp' => time(),
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function widget()
    {
        $realm_id = $this->input->get('realm_id');
        $data = [
            'realm' => $this->serverstatus_model->get_realm_stats($realm_id),
        ];

        $this->load->view('widget', $data);
    }
}
