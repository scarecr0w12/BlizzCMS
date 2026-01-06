<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Public vote routes
$route['vote']['get'] = 'vote/index';
$route['vote/site/(:num)']['get'] = 'vote/site/$1';
$route['vote/callback/(:num)']['get'] = 'vote/callback/$1';
$route['vote/history']['get'] = 'vote/history';
$route['vote/top']['get'] = 'vote/top_voters';

// Admin routes
$route['vote/admin'] = 'admin/index';
$route['vote/admin/sites'] = 'admin/sites';
$route['vote/admin/sites/add']['get'] = 'admin/add_site';
$route['vote/admin/sites/add']['post'] = 'admin/add_site';
$route['vote/admin/sites/edit/(:num)']['get'] = 'admin/edit_site/$1';
$route['vote/admin/sites/edit/(:num)']['post'] = 'admin/edit_site/$1';
$route['vote/admin/sites/delete/(:num)']['post'] = 'admin/delete_site/$1';

$route['vote/admin/logs'] = 'admin/logs';
$route['vote/admin/settings']['get'] = 'admin/settings';
$route['vote/admin/settings']['post'] = 'admin/settings';
