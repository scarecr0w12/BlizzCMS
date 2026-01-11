<?php
/**
 * BlizzCMS - Server Status Module Routes
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$route['serverstatus'] = 'serverstatus/index';
$route['serverstatus/api/stats'] = 'serverstatus/api_stats';
$route['serverstatus/admin'] = 'admin/index';
$route['serverstatus/admin/settings'] = 'admin/settings';
