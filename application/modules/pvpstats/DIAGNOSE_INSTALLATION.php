<?php
/**
 * PvP Stats Module - Installation Diagnostic
 * 
 * Run this script from your browser to diagnose installation issues:
 * http://your-site.com/application/modules/pvpstats/DIAGNOSE_INSTALLATION.php
 */

echo "<!DOCTYPE html>
<html>
<head>
    <title>PvP Stats - Installation Diagnostic</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; }
        h1 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        h2 { color: #555; margin-top: 30px; }
        .check { margin: 15px 0; padding: 10px; border-left: 4px solid #ddd; }
        .pass { border-left-color: #28a745; background: #f0fff4; }
        .fail { border-left-color: #dc3545; background: #fff5f5; }
        .warn { border-left-color: #ffc107; background: #fffbf0; }
        .status { font-weight: bold; }
        .pass .status { color: #28a745; }
        .fail .status { color: #dc3545; }
        .warn .status { color: #ff9800; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
        .details { margin-top: 10px; padding: 10px; background: #f9f9f9; border-radius: 3px; font-size: 12px; }
    </style>
</head>
<body>
<div class='container'>
    <h1>PvP Stats Module - Installation Diagnostic</h1>
    <p>This script checks for common installation issues.</p>
";

$checks = [];

// 1. Check if module directory exists
$module_dir = __DIR__;
$checks[] = [
    'name' => 'Module Directory',
    'path' => $module_dir,
    'pass' => is_dir($module_dir),
    'message' => is_dir($module_dir) ? 'Module directory exists' : 'Module directory not found'
];

// 2. Check config files
$config_files = ['config/module.php', 'config/routes.php'];
foreach ($config_files as $file) {
    $path = $module_dir . '/' . $file;
    $checks[] = [
        'name' => 'Config: ' . basename($file),
        'path' => $path,
        'pass' => file_exists($path),
        'message' => file_exists($path) ? 'File exists' : 'File missing'
    ];
}

// 3. Check controllers
$controller_files = ['controllers/Pvpstats.php', 'controllers/Admin.php'];
foreach ($controller_files as $file) {
    $path = $module_dir . '/' . $file;
    $checks[] = [
        'name' => 'Controller: ' . basename($file),
        'path' => $path,
        'pass' => file_exists($path),
        'message' => file_exists($path) ? 'File exists' : 'File missing'
    ];
}

// 4. Check models
$model_files = ['models/Pvpstats_battleground_model.php', 'models/Pvpstats_player_model.php'];
foreach ($model_files as $file) {
    $path = $module_dir . '/' . $file;
    $checks[] = [
        'name' => 'Model: ' . basename($file),
        'path' => $path,
        'pass' => file_exists($path),
        'message' => file_exists($path) ? 'File exists' : 'File missing'
    ];
}

// 5. Check views
$view_files = ['views/index.php', 'views/battlegrounds.php', 'views/players.php', 'views/guilds.php', 'views/statistics.php'];
foreach ($view_files as $file) {
    $path = $module_dir . '/' . $file;
    $checks[] = [
        'name' => 'View: ' . basename($file),
        'path' => $path,
        'pass' => file_exists($path),
        'message' => file_exists($path) ? 'File exists' : 'File missing'
    ];
}

// 6. Check language files
$lang_file = $module_dir . '/language/english/pvpstats_lang.php';
$checks[] = [
    'name' => 'Language File',
    'path' => $lang_file,
    'pass' => file_exists($lang_file),
    'message' => file_exists($lang_file) ? 'File exists' : 'File missing'
];

// 7. Check migration file
$migration_file = dirname(dirname(dirname(__DIR__))) . '/migrations/20260202170900_create_pvpstats_tables.php';
$checks[] = [
    'name' => 'Migration File',
    'path' => $migration_file,
    'pass' => file_exists($migration_file),
    'message' => file_exists($migration_file) ? 'File exists' : 'File missing'
];

// 8. Check PHP syntax of key files
$syntax_files = [
    'controllers/Pvpstats.php',
    'models/Pvpstats_battleground_model.php',
    'models/Pvpstats_player_model.php'
];

foreach ($syntax_files as $file) {
    $path = $module_dir . '/' . $file;
    if (file_exists($path)) {
        $output = [];
        $return = 0;
        exec('php -l ' . escapeshellarg($path), $output, $return);
        $pass = $return === 0;
        $checks[] = [
            'name' => 'PHP Syntax: ' . basename($file),
            'path' => $path,
            'pass' => $pass,
            'message' => $pass ? 'Valid PHP syntax' : 'Syntax error detected'
        ];
    }
}

// 9. Check file permissions
$checks[] = [
    'name' => 'Module Directory Readable',
    'path' => $module_dir,
    'pass' => is_readable($module_dir),
    'message' => is_readable($module_dir) ? 'Readable' : 'Not readable'
];

// 10. Check if database tables exist (if DB connection available)
if (function_exists('get_instance')) {
    $CI = get_instance();
    if (isset($CI->db)) {
        $tables = ['pvpstats_battlegrounds', 'pvpstats_players', 'pvpstats_settings'];
        foreach ($tables as $table) {
            $exists = $CI->db->table_exists($table);
            $checks[] = [
                'name' => 'Database Table: ' . $table,
                'path' => 'Database',
                'pass' => $exists,
                'message' => $exists ? 'Table exists' : 'Table missing - run migration',
                'warn' => !$exists
            ];
        }
    }
}

// Display results
echo "<h2>Installation Checks</h2>";
$pass_count = 0;
$fail_count = 0;
$warn_count = 0;

foreach ($checks as $check) {
    $class = $check['pass'] ? 'pass' : ($check['warn'] ?? false ? 'warn' : 'fail');
    $status = $check['pass'] ? '✓ PASS' : ($check['warn'] ?? false ? '⚠ WARNING' : '✗ FAIL');
    
    if ($check['pass']) $pass_count++;
    elseif ($check['warn'] ?? false) $warn_count++;
    else $fail_count++;
    
    echo "<div class='check $class'>";
    echo "<span class='status'>$status</span> - {$check['name']}<br>";
    echo "<div class='details'>{$check['message']}</div>";
    echo "</div>";
}

echo "<h2>Summary</h2>";
echo "<div class='check pass'><strong>Passed:</strong> $pass_count</div>";
if ($warn_count > 0) {
    echo "<div class='check warn'><strong>Warnings:</strong> $warn_count</div>";
}
if ($fail_count > 0) {
    echo "<div class='check fail'><strong>Failed:</strong> $fail_count</div>";
}

echo "<h2>Next Steps</h2>";
if ($fail_count > 0) {
    echo "<p><strong>Issues Found:</strong> Please fix the failed checks above.</p>";
}
if ($warn_count > 0 || in_array(true, array_column($checks, 'warn'))) {
    echo "<p><strong>Warnings:</strong> Run the database migration to create tables:</p>";
    echo "<code>php spark migrate</code>";
}
if ($fail_count === 0 && $warn_count === 0) {
    echo "<p><strong>✓ All checks passed!</strong> The module is properly installed.</p>";
}

echo "</div></body></html>";
?>
