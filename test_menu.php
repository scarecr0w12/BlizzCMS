<?php
/**
 * Menu Debug Script
 * Access this at: http://yoursite.com/test_menu.php
 */

define('BASEPATH', true);
define('ENVIRONMENT', 'development');

// Load CodeIgniter bootstrap
require_once 'index.php';

$CI =& get_instance();
$CI->load->model('menu_model');

echo "<h1>Menu Debug Information</h1>";

// Test menu display
$menu_items = $CI->menu_model->display('main');

echo "<h2>Menu Items Returned:</h2>";
echo "<pre>";
print_r($menu_items);
echo "</pre>";

echo "<h2>Current User Role:</h2>";
if (function_exists('is_logged_in') && is_logged_in()) {
    echo "Logged in as role: " . (function_exists('user') ? user('role') : 'unknown') . "<br>";
} else {
    echo "Not logged in (Guest - role 1)<br>";
}

// Check permissions directly
$CI->load->model('permission_model');
$role_id = (function_exists('is_logged_in') && is_logged_in() && function_exists('user')) ? user('role') : 1;

echo "<h2>Permissions for Role $role_id:</h2>";
$keys = $CI->permission_model->permissions_keys($role_id, ':menu-item:');
echo "Menu item IDs this role can see: ";
echo "<pre>";
print_r($keys);
echo "</pre>";

echo "<h2>All Menu Items in Database:</h2>";
$CI->load->model('menu_item_model');
$all_items = $CI->menu_item_model->find_all(['menu_id' => 1]);
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Name</th><th>URL</th><th>Type</th><th>Parent</th><th>Sort</th></tr>";
foreach ($all_items as $item) {
    echo "<tr>";
    echo "<td>{$item->id}</td>";
    echo "<td>{$item->name}</td>";
    echo "<td>{$item->url}</td>";
    echo "<td>{$item->type}</td>";
    echo "<td>{$item->parent}</td>";
    echo "<td>{$item->sort}</td>";
    echo "</tr>";
}
echo "</table>";

echo "<h2>Constants:</h2>";
echo "ITEM_LINK = " . ITEM_LINK . "<br>";
echo "ITEM_DROPDOWN = " . ITEM_DROPDOWN . "<br>";
