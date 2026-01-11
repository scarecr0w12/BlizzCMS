<?php
/**
 * BlizzCMS - Enhanced Shop Routes (Admin Only)
 */
defined('BASEPATH') OR exit('No direct script access allowed');

// Admin routes only - frontend functionality is handled by main shop module
$route['shop_enhanced/admin'] = 'admin/index';
$route['shop_enhanced/admin/settings'] = 'admin/settings';
