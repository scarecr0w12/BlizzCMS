<?php
/**
 * BlizzCMS - Notifications Module Routes
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$route['notifications'] = 'notifications/index';
$route['notifications/mark_read/(:num)'] = 'notifications/mark_read/$1';
$route['notifications/mark_all_read'] = 'notifications/mark_all_read';
$route['notifications/delete/(:num)'] = 'notifications/delete/$1';
$route['notifications/api/count'] = 'notifications/get_count';
$route['notifications/api/recent'] = 'notifications/get_recent';
$route['notifications/preferences'] = 'notifications/preferences';
$route['notifications/admin'] = 'admin/index';
$route['notifications/admin/settings'] = 'admin/settings';
$route['notifications/admin/send'] = 'admin/send';
