<?php
/**
 * CLI script to run shop_enhanced module migrations
 */

define('BASEPATH', __DIR__ . '/system/');
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

require_once __DIR__ . '/index.php';

$CI =& get_instance();
$CI->load->library('migration');

echo "Running shop_enhanced module migrations...\n";

if (!$CI->migration->init_module('shop_enhanced')) {
    echo "Error: Could not initialize shop_enhanced module\n";
    exit(1);
}

if ($CI->migration->latest() === FALSE) {
    echo "Error: " . $CI->migration->error_string() . "\n";
    exit(1);
}

echo "Migrations completed successfully!\n";

$version = $CI->migration->module_version('shop_enhanced');
echo "Current version: " . $version . "\n";

exit(0);
