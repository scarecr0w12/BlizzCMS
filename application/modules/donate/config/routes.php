<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Public donation routes
$route['donate']['get'] = 'donate/index';
$route['donate/packages']['get'] = 'donate/packages';
$route['donate/package/(:num)']['get'] = 'donate/package/$1';
$route['donate/process/(:num)']['post'] = 'donate/process/$1';
$route['donate/history']['get'] = 'donate/history';
$route['donate/success']['get'] = 'donate/success';
$route['donate/cancel']['get'] = 'donate/cancel';

// Payment gateway callbacks
$route['donate/callback/paypal']['post'] = 'callback/paypal';
$route['donate/callback/stripe']['post'] = 'callback/stripe';
$route['donate/callback/paypal']['get'] = 'callback/paypal_return';
$route['donate/callback/stripe']['get'] = 'callback/stripe_return';

// Top donators
$route['donate/top']['get'] = 'donate/top_donators';

// Admin routes
$route['donate/admin'] = 'admin/index';
$route['donate/admin/packages'] = 'admin/packages';
$route['donate/admin/packages/add']['get'] = 'admin/add_package';
$route['donate/admin/packages/add']['post'] = 'admin/add_package';
$route['donate/admin/packages/edit/(:num)']['get'] = 'admin/edit_package/$1';
$route['donate/admin/packages/edit/(:num)']['post'] = 'admin/edit_package/$1';
$route['donate/admin/packages/delete/(:num)']['post'] = 'admin/delete_package/$1';

$route['donate/admin/gateways'] = 'admin/gateways';
$route['donate/admin/gateways/edit/(:any)']['get'] = 'admin/edit_gateway/$1';
$route['donate/admin/gateways/edit/(:any)']['post'] = 'admin/edit_gateway/$1';

$route['donate/admin/logs'] = 'admin/logs';
$route['donate/admin/logs/(:num)']['get'] = 'admin/log_detail/$1';

$route['donate/admin/settings']['get'] = 'admin/settings';
$route['donate/admin/settings']['post'] = 'admin/settings';
