<?php
/**
 * PvP Stats Module - Setup Verification Script
 * 
 * This script verifies that the PvP Stats module is properly installed and configured.
 * Run this from your browser: http://your-site.com/pvpstats/SETUP_VERIFICATION.php
 * 
 * NOTE: Delete this file after verification for security purposes.
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

$checks = [];
$all_passed = true;

// Check 1: Module files exist
$checks['module_files'] = [
    'name' => 'Module Files',
    'passed' => true,
    'details' => []
];

$required_files = [
    'config/module.php',
    'config/routes.php',
    'config/migration.php',
    'controllers/Pvpstats.php',
    'controllers/Admin.php',
    'models/Pvpstats_battleground_model.php',
    'models/Pvpstats_player_model.php',
    'views/index.php',
    'views/battlegrounds.php',
    'views/battleground_detail.php',
    'views/players.php',
    'views/player_stats.php',
    'views/guilds.php',
    'views/statistics.php',
    'views/admin/index.php',
    'views/admin/settings.php',
    'language/english/pvpstats_lang.php',
    'README.md',
    'INSTALLATION.md'
];

$module_path = dirname(__FILE__);
foreach ($required_files as $file) {
    $file_path = $module_path . '/' . $file;
    $exists = file_exists($file_path);
    $checks['module_files']['details'][] = [
        'file' => $file,
        'exists' => $exists
    ];
    if (!$exists) {
        $checks['module_files']['passed'] = false;
        $all_passed = false;
    }
}

// Check 2: Module configuration
$checks['module_config'] = [
    'name' => 'Module Configuration',
    'passed' => true,
    'details' => []
];

$config_file = $module_path . '/config/module.php';
if (file_exists($config_file)) {
    $config = include($config_file);
    $required_config = ['name', 'description', 'version', 'author', 'dashboard'];
    foreach ($required_config as $key) {
        $exists = isset($config[$key]);
        $checks['module_config']['details'][] = [
            'key' => $key,
            'exists' => $exists,
            'value' => $exists ? $config[$key] : 'N/A'
        ];
        if (!$exists) {
            $checks['module_config']['passed'] = false;
            $all_passed = false;
        }
    }
} else {
    $checks['module_config']['passed'] = false;
    $all_passed = false;
    $checks['module_config']['details'][] = ['error' => 'Module configuration file not found'];
}

// Check 3: Directory permissions
$checks['permissions'] = [
    'name' => 'Directory Permissions',
    'passed' => true,
    'details' => []
];

$directories = [
    'config',
    'controllers',
    'models',
    'views',
    'language',
    'language/english'
];

foreach ($directories as $dir) {
    $dir_path = $module_path . '/' . $dir;
    $is_readable = is_readable($dir_path);
    $is_writable = is_writable($dir_path);
    $checks['permissions']['details'][] = [
        'directory' => $dir,
        'readable' => $is_readable,
        'writable' => $is_writable
    ];
    if (!$is_readable) {
        $checks['permissions']['passed'] = false;
        $all_passed = false;
    }
}

// Display results
?>
<!DOCTYPE html>
<html>
<head>
    <title>PvP Stats Module - Setup Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        h2 {
            color: #555;
            margin-top: 30px;
            font-size: 18px;
        }
        .check {
            margin: 20px 0;
            padding: 15px;
            border-left: 4px solid #ddd;
            background-color: #f9f9f9;
        }
        .check.passed {
            border-left-color: #28a745;
            background-color: #f0f8f5;
        }
        .check.failed {
            border-left-color: #dc3545;
            background-color: #fdf5f5;
        }
        .status {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .status.passed {
            color: #28a745;
        }
        .status.failed {
            color: #dc3545;
        }
        .details {
            margin-left: 20px;
            font-size: 14px;
        }
        .detail-item {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-item:last-child {
            border-bottom: none;
        }
        .success {
            color: #28a745;
        }
        .error {
            color: #dc3545;
        }
        .warning {
            color: #ffc107;
        }
        .summary {
            margin-top: 30px;
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
        }
        .summary.all-passed {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .summary.has-errors {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .next-steps {
            margin-top: 30px;
            padding: 15px;
            background-color: #e7f3ff;
            border-left: 4px solid #007bff;
            border-radius: 3px;
        }
        .next-steps h3 {
            color: #004085;
            margin-top: 0;
        }
        .next-steps ol {
            color: #004085;
        }
        .next-steps li {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PvP Stats Module - Setup Verification</h1>
        
        <?php foreach ($checks as $check_key => $check): ?>
            <div class="check <?php echo $check['passed'] ? 'passed' : 'failed'; ?>">
                <div class="status <?php echo $check['passed'] ? 'passed' : 'failed'; ?>">
                    <?php echo $check['passed'] ? '✓' : '✗'; ?> <?php echo $check['name']; ?>
                </div>
                <div class="details">
                    <?php if ($check_key === 'module_files'): ?>
                        <?php foreach ($check['details'] as $detail): ?>
                            <div class="detail-item">
                                <span class="<?php echo $detail['exists'] ? 'success' : 'error'; ?>">
                                    <?php echo $detail['exists'] ? '✓' : '✗'; ?>
                                </span>
                                <?php echo $detail['file']; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php elseif ($check_key === 'module_config'): ?>
                        <?php foreach ($check['details'] as $detail): ?>
                            <div class="detail-item">
                                <?php if (isset($detail['error'])): ?>
                                    <span class="error">✗ <?php echo $detail['error']; ?></span>
                                <?php else: ?>
                                    <span class="<?php echo $detail['exists'] ? 'success' : 'error'; ?>">
                                        <?php echo $detail['exists'] ? '✓' : '✗'; ?>
                                    </span>
                                    <strong><?php echo $detail['key']; ?>:</strong> 
                                    <?php echo is_array($detail['value']) ? json_encode($detail['value']) : $detail['value']; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php elseif ($check_key === 'permissions'): ?>
                        <?php foreach ($check['details'] as $detail): ?>
                            <div class="detail-item">
                                <strong><?php echo $detail['directory']; ?>:</strong>
                                <span class="<?php echo $detail['readable'] ? 'success' : 'error'; ?>">
                                    Readable: <?php echo $detail['readable'] ? '✓' : '✗'; ?>
                                </span>
                                <span class="<?php echo $detail['writable'] ? 'success' : 'warning'; ?>">
                                    Writable: <?php echo $detail['writable'] ? '✓' : '✗'; ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="summary <?php echo $all_passed ? 'all-passed' : 'has-errors'; ?>">
            <?php if ($all_passed): ?>
                ✓ All checks passed! The PvP Stats module is properly installed.
            <?php else: ?>
                ✗ Some checks failed. Please review the errors above and fix them before proceeding.
            <?php endif; ?>
        </div>

        <?php if ($all_passed): ?>
            <div class="next-steps">
                <h3>Next Steps:</h3>
                <ol>
                    <li><strong>Run Database Migration:</strong> Execute the migration to create database tables:
                        <pre>php spark migrate</pre>
                        Or access your admin panel and run the migration through the UI.
                    </li>
                    <li><strong>Configure AzerothCore/TrinityCore:</strong> Add this to your worldserver.conf:
                        <pre>Battleground.StoreStatistics.Enable = 1</pre>
                        Then restart your world server.
                    </li>
                    <li><strong>Access the Module:</strong> Navigate to:
                        <ul>
                            <li>Public: <code>http://your-site.com/pvpstats</code></li>
                            <li>Admin: <code>http://your-site.com/pvpstats/admin</code> (admin only)</li>
                        </ul>
                    </li>
                    <li><strong>Delete this file:</strong> Remove <code>SETUP_VERIFICATION.php</code> for security.</li>
                    <li><strong>Complete Battlegrounds:</strong> Play battleground matches on your server to populate statistics.</li>
                </ol>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
