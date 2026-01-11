<?php
/**
 * BlizzCMS - Server Status Module Migration Config
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$config['migration_enabled'] = TRUE;
$config['migration_type'] = 'timestamp';
$config['migration_table'] = 'migrations_serverstatus';
$config['migration_path'] = APPPATH.'modules/serverstatus/migrations/';
