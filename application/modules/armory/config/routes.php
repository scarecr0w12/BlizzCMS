<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Admin routes
$route['armory/admin'] = 'admin/index';
$route['armory/admin/display'] = 'admin/display';
$route['armory/admin/features'] = 'admin/features';

// Main armory routes
$route['armory'] = 'armory/index';
$route['armory/search'] = 'armory/search';

// Character routes
$route['armory/character/(:num)/(:any)']['get'] = 'character/profile/$1/$2';
$route['armory/character/(:num)/(:any)/talents']['get'] = 'character/talents/$1/$2';
$route['armory/character/(:num)/(:any)/achievements']['get'] = 'character/achievements/$1/$2';
$route['armory/character/(:num)/(:any)/pvp']['get'] = 'character/pvp/$1/$2';

// Guild routes
$route['armory/guild/(:num)/(:any)']['get'] = 'guild/profile/$1/$2';
$route['armory/guild/(:num)/(:any)/members']['get'] = 'guild/members/$1/$2';

// Arena routes
$route['armory/arena/(:num)']['get'] = 'arena/ladder/$1';
$route['armory/arena/(:num)/team/(:num)']['get'] = 'arena/team/$1/$2';

// API routes for AJAX
$route['armory/api/search']['post'] = 'armory/api_search';
$route['armory/api/character/(:num)/(:num)']['get'] = 'character/api_character/$1/$2';
