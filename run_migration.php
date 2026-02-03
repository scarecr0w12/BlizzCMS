<?php
define('BASEPATH', __DIR__ . '/');
define('APPPATH', __DIR__ . '/application/');
define('ENVIRONMENT', 'production');

// Load CodeIgniter
require_once APPPATH . 'config/database.php';
require_once APPPATH . 'core/CodeIgniter.php';

// Get CI instance
$CI = &get_instance();

// Load migration library
$CI->load->library('migration');

// Run migration
if ($CI->migration->current() === FALSE) {
    echo "Migration failed: " . $CI->migration->error_string();
    exit(1);
} else {
    echo "Migration completed successfully!";
    exit(0);
}
