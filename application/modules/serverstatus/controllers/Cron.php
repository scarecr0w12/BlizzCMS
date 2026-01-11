<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('serverstatus_model');
        $this->load->model('realm_model');
    }

    public function record_stats()
    {
        $realms = $this->realm_model->find_all();
        
        if (empty($realms)) {
            return;
        }

        foreach ($realms as $realm) {
            $online_count = $this->serverstatus_model->get_online_count($realm->id);
            $faction_balance = $this->serverstatus_model->get_faction_balance($realm->id);
            
            $data = [
                'online_players' => $online_count,
                'alliance_count' => $faction_balance['alliance'] ?? 0,
                'horde_count' => $faction_balance['horde'] ?? 0,
                'uptime_seconds' => 0,
            ];

            $this->serverstatus_model->record_stats($realm->id, $data);
        }

        log_message('info', 'Serverstatus: Statistics recorded for ' . count($realms) . ' realm(s)');
    }
}
