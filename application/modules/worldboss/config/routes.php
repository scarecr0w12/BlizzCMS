<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Admin routes
$route['worldboss/admin'] = 'admin/index';
$route['worldboss/admin/bosses'] = 'admin/bosses';

// Main worldboss routes
$route['worldboss'] = 'worldboss/index';
$route['worldboss/boss/(:num)']['get'] = 'worldboss/boss/$1';

// API routes for AJAX
$route['worldboss/api/encounters/(:num)']['get'] = 'worldboss/api_encounters/$1';
