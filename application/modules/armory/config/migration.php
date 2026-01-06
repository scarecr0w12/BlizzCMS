<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Enable/Disable Migrations
|--------------------------------------------------------------------------
|
| Migrations are disabled by default for security reasons.
| You should enable migrations whenever you intend to do a schema migration
| and disable it back when you're done.
|
*/
$config['migration_enabled'] = true;

/*
|--------------------------------------------------------------------------
| Migration Type
|--------------------------------------------------------------------------
|
| Migration file names may be based on a sequential identifier or on
| a timestamp. Options are:
|
|   'sequential' = Sequential migration naming (001_add_blog.php)
|   'timestamp'  = Timestamp migration naming (20121031104401_add_blog.php)
|                  Use timestamp format YYYYMMDDHHIISS.
|
*/
$config['migration_type'] = 'timestamp';

/*
|--------------------------------------------------------------------------
| Migrations table
|--------------------------------------------------------------------------
|
| This is the name of the table that will store the current migrations state.
|
*/
$config['migration_table'] = 'migrations';

/*
|--------------------------------------------------------------------------
| Migrations Path
|--------------------------------------------------------------------------
|
| Path to the migrations folder for this module (relative to config folder).
|
*/
$config['migration_path'] = '../migrations';

/*
|--------------------------------------------------------------------------
| Migration Auto Latest
|--------------------------------------------------------------------------
|
| If set to true, when migrations is loaded it will automatically run to
| the latest migration.
|
*/
$config['migration_auto_latest'] = false;

/*
|--------------------------------------------------------------------------
| Migration Version
|--------------------------------------------------------------------------
|
| This is used to set migration version that the file system should be on.
|
*/
$config['migration_version'] = 0;
