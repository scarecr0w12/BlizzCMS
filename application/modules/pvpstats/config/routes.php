<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Admin routes
$route['pvpstats/admin'] = 'admin/index';
$route['pvpstats/admin/settings'] = 'admin/settings';

// Main PvP stats routes
$route['pvpstats'] = 'pvpstats/index';
$route['pvpstats/battlegrounds'] = 'pvpstats/battlegrounds';
$route['pvpstats/battleground/(:num)'] = 'pvpstats/battleground_detail/$1';
$route['pvpstats/players'] = 'pvpstats/players';
$route['pvpstats/player/(:any)'] = 'pvpstats/player_stats/$1';
$route['pvpstats/guilds'] = 'pvpstats/guilds';
$route['pvpstats/statistics'] = 'pvpstats/statistics';

// API routes
$route['pvpstats/api/battlegrounds']['get'] = 'pvpstats/api_battlegrounds';
$route['pvpstats/api/player/(:any)'] = 'pvpstats/api_player_stats/$1';
