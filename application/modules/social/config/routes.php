<?php
/**
 * BlizzCMS - Social Routes
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$route['social'] = 'social/dashboard';
$route['social/dashboard'] = 'social/dashboard';
$route['social/friends'] = 'social/friends';
$route['social/friends/add/(:num)'] = 'social/add_friend/$1';
$route['social/friends/accept/(:num)'] = 'social/accept_friend/$1';
$route['social/friends/remove/(:num)'] = 'social/remove_friend/$1';
$route['social/messages'] = 'social/messages';
$route['social/messages/send'] = 'social/send_message';
$route['social/messages/sent'] = 'social/sent_messages';
$route['social/messages/delete/(:num)'] = 'social/delete_message/$1';
$route['social/messages/(:num)'] = 'social/view_message/$1';
$route['social/search'] = 'social/search';
$route['social/profile/(:num)'] = 'social/profile/$1';
$route['social/guilds'] = 'social/guilds';
$route['social/guilds/(:num)'] = 'social/view_guild/$1';
$route['social/guilds/(:num)/members'] = 'social/guild_members/$1';
$route['social/feed'] = 'social/feed';
$route['social/admin'] = 'admin/index';
$route['social/admin/settings'] = 'admin/settings';
