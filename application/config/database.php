<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'cms';
$query_builder = true;

$db['cms'] = [
	'dsn'      => '',
	'hostname' => 'localhost',
	'username' => 'blizzcms',
	'password' => '!rpHfo@Bihnv10IK',
	'database' => 'blizzcms',
	'port'     => 3306,
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => false,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => false,
	'cachedir' => '',
	'char_set' => 'utf8mb4',
	'dbcollat' => 'utf8mb4_unicode_ci',
	'swap_pre' => '',
	'encrypt'  => false,
	'compress' => false,
	'stricton' => false,
	'failover' => [],
	'save_queries' => true,
];

$db['auth'] = [
	'dsn'      => '',
	'hostname' => 'localhost',
	'username' => 'acore',
	'password' => 'acore',
	'database' => 'acore_auth',
	'port'     => 3306,
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => false,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => false,
	'cachedir' => '',
	'char_set' => 'utf8mb4',
	'dbcollat' => 'utf8mb4_unicode_ci',
	'swap_pre' => '',
	'encrypt'  => false,
	'compress' => false,
	'stricton' => false,
	'failover' => [],
	'save_queries' => true,
];