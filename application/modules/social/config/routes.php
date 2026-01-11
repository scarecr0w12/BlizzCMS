<?php
/**
 * BlizzCMS - Social Routes
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$route['social/friends'] = 'social/friends';
$route['social/friends/add/(:num)'] = 'social/add_friend/$1';
$route['social/friends/remove/(:num)'] = 'social/remove_friend/$1';
$route['social/messages'] = 'social/messages';
$route['social/messages/send'] = 'social/send_message';
$route['social/messages/(:num)'] = 'social/view_message/$1';
$route['social/guilds'] = 'social/guilds';
$route['social/guilds/(:num)'] = 'social/view_guild/$1';
$route['social/guilds/(:num)/members'] = 'social/guild_members/$1';
$route['social/feed'] = 'social/feed';
$route['social/admin'] = 'admin/index';
$route['social/admin/settings'] = 'admin/settings';
