<?php
/**
 * BlizzCMS - Enhanced Profile Routes
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$route['profile_enhanced/admin/settings'] = 'admin/settings';
$route['profile_enhanced/admin'] = 'admin/index';
$route['profile']['get'] = 'profile_enhanced/index';
$route['profile/(:any)'] = 'profile_enhanced/view/$1';
