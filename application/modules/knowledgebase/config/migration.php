<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['migration_enabled'] = true;
$config['migration_type'] = 'timestamp';
$config['migration_table'] = 'knowledgebase_migrations';
$config['migration_auto_latest'] = false;
$config['migration_version'] = 0;
$config['migration_path'] = APPPATH . 'modules/knowledgebase/migrations/';
