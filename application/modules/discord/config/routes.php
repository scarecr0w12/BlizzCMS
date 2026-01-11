<?php
/**
 * BlizzCMS - Discord Module Routes
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$route['discord'] = 'discord/index';
$route['discord/auth'] = 'discord/auth';
$route['discord/callback'] = 'discord/callback';
$route['discord/link'] = 'discord/link';
$route['discord/unlink'] = 'discord/unlink';
$route['discord/widget'] = 'discord/widget';
$route['discord/admin'] = 'admin/index';
$route['discord/admin/settings'] = 'admin/settings';
$route['discord/admin/webhooks'] = 'admin/webhooks';
