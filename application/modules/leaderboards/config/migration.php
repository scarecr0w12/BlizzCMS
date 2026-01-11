<?php
/**
 * BlizzCMS - Leaderboards Module Migration Config
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$config['migration_enabled'] = TRUE;
$config['migration_type'] = 'timestamp';
$config['migration_table'] = 'migrations_leaderboards';
$config['migration_path'] = APPPATH.'modules/leaderboards/migrations/';
