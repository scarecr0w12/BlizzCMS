<?php
/**
 * BlizzCMS - Database Viewer Module Routes
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$route['database/admin/settings'] = 'admin/settings';
$route['database/admin'] = 'admin/index';
$route['database/search'] = 'database/search';
$route['database/item/(:num)'] = 'database/item/$1';
$route['database/items'] = 'database/items';
$route['database/spell/(:num)'] = 'database/spell/$1';
$route['database/spells'] = 'database/spells';
$route['database/quest/(:num)'] = 'database/quest/$1';
$route['database/quests'] = 'database/quests';
$route['database/creature/(:num)'] = 'database/creature/$1';
$route['database/creatures'] = 'database/creatures';
$route['database/zone/(:num)'] = 'database/zone/$1';
$route['database/zones'] = 'database/zones';
$route['database/npc/(:num)'] = 'database/npc/$1';
$route['database/npcs'] = 'database/npcs';
$route['database/object/(:num)'] = 'database/object/$1';
$route['database/objects'] = 'database/objects';
$route['database'] = 'database/index';
