<?php
/**
 * BlizzCMS - Events Module Routes
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$route['events'] = 'events/index';
$route['events/calendar'] = 'events/calendar';
$route['events/view/(:num)'] = 'events/view/$1';
$route['events/rsvp/(:num)'] = 'events/rsvp/$1';
$route['events/my-events'] = 'events/my_events';
$route['events/admin'] = 'admin/index';
$route['events/admin/create'] = 'admin/create';
$route['events/admin/edit/(:num)'] = 'admin/edit/$1';
$route['events/admin/delete/(:num)'] = 'admin/delete/$1';
$route['events/admin/settings'] = 'admin/settings';
