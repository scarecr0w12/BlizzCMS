<?php
/**
 * BlizzCMS - API Routes
 */
defined('BASEPATH') OR exit('No direct script access allowed');

// API v1 routes
$route['api/v1/auth/login'] = 'api/auth/login';
$route['api/v1/auth/logout'] = 'api/auth/logout';
$route['api/v1/auth/token'] = 'api/auth/get_token';

// Notifications API
$route['api/v1/notifications'] = 'api/notifications/index';
$route['api/v1/notifications/unread'] = 'api/notifications/unread';
$route['api/v1/notifications/(:num)'] = 'api/notifications/get/$1';
$route['api/v1/notifications/(:num)/read'] = 'api/notifications/mark_read/$1';
$route['api/v1/notifications/read-all'] = 'api/notifications/mark_all_read';

// Events API
$route['api/v1/events'] = 'api/events/index';
$route['api/v1/events/upcoming'] = 'api/events/upcoming';
$route['api/v1/events/(:num)'] = 'api/events/get/$1';
$route['api/v1/events/(:num)/rsvp'] = 'api/events/rsvp/$1';

// Leaderboards API
$route['api/v1/leaderboards/pvp'] = 'api/leaderboards/pvp';
$route['api/v1/leaderboards/honor'] = 'api/leaderboards/honor';
$route['api/v1/leaderboards/arena'] = 'api/leaderboards/arena';
$route['api/v1/leaderboards/guilds'] = 'api/leaderboards/guilds';

// Server Status API
$route['api/v1/server/status'] = 'api/server/status';
$route['api/v1/server/statistics'] = 'api/server/statistics';

// Shop API
$route['api/v1/shop/items'] = 'api/shop/items';
$route['api/v1/shop/cart'] = 'api/shop/cart';
$route['api/v1/shop/cart/add'] = 'api/shop/add_to_cart';
$route['api/v1/shop/wishlist'] = 'api/shop/wishlist';

// Profile API
$route['api/v1/profile/(:any)'] = 'api/profile/get/$1';
$route['api/v1/profile/(:any)/timeline'] = 'api/profile/timeline/$1';
$route['api/v1/profile/(:any)/achievements'] = 'api/profile/achievements/$1';

// Search API
$route['api/v1/search'] = 'api/search/index';
