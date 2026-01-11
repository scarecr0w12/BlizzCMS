<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Playermap Configuration
|--------------------------------------------------------------------------
*/

// Server Type (0 = MaNGOS, 1 = AzerothCore/TrinityCore)
$config['playermap_server_type'] = 1;

// Default realm to show
$config['playermap_default_realm'] = 1;

// GM Display Options
$config['playermap_gm_show_online'] = true;
$config['playermap_gm_include_count'] = true;
$config['playermap_gm_only_gmoff'] = true;
$config['playermap_gm_only_gmvisible'] = true;
$config['playermap_gm_add_suffix'] = true;

// Status Window Options
$config['playermap_show_status'] = true;
$config['playermap_show_time'] = true;
$config['playermap_time'] = 10; // Auto-update time in seconds (0 = no auto-update)

// Status display times (in milliseconds)
$config['playermap_time_to_show_uptime'] = 3000;
$config['playermap_time_to_show_maxonline'] = 3000;
$config['playermap_time_to_show_gmonline'] = 3000;
