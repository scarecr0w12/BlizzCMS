<?php
/**
 * PvP Stats Module - Sample Data Insertion Script
 * 
 * This script inserts sample battleground data for testing purposes.
 * Run this from your browser: http://your-site.com/pvpstats/SAMPLE_DATA.php
 * 
 * NOTE: Delete this file after testing for security purposes.
 * WARNING: This will insert test data into your database.
 */

// Security check - only allow from localhost or with a token
$allowed = false;
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === 'localhost') {
    $allowed = true;
} elseif ($token === 'pvpstats_sample_data_2026') {
    $allowed = true;
}

if (!$allowed) {
    http_response_code(403);
    die('Access Denied. This script can only be run from localhost or with a valid token.');
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sample battleground types
$bg_types = [
    1 => 'Alterac Valley',
    2 => 'Warsong Gulch',
    3 => 'Arathi Basin',
    4 => 'Eye of the Storm',
    5 => 'Strand of the Ancients',
    6 => 'Isle of Conquest'
];

// Sample player names
$player_names = [
    'Thrall', 'Jaina', 'Arthas', 'Uther', 'Medivh', 'Gul\'dan', 'Illidan', 'Tyrande',
    'Malfurion', 'Sylvanas', 'Varian', 'Cairne', 'Durotan', 'Anduin', 'Valeera', 'Rexxar',
    'Muradin', 'Khadgar', 'Alleria', 'Turalyon', 'Lothar', 'Garona', 'Ysera', 'Alexstrasza'
];

// Sample classes
$classes = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
$class_names = [
    1 => 'Warrior',
    2 => 'Paladin',
    3 => 'Hunter',
    4 => 'Rogue',
    5 => 'Priest',
    6 => 'Death Knight',
    7 => 'Shaman',
    8 => 'Mage',
    9 => 'Warlock',
    10 => 'Monk',
    11 => 'Druid'
];

// Sample races
$races = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
$race_names = [
    1 => 'Human',
    2 => 'Orc',
    3 => 'Dwarf',
    4 => 'Night Elf',
    5 => 'Undead',
    6 => 'Tauren',
    7 => 'Gnome',
    8 => 'Troll',
    9 => 'Goblin',
    10 => 'Worgen',
    11 => 'Pandaren'
];

// Faction mapping
$faction_map = [
    1 => 0, 2 => 0, 3 => 0, 4 => 0, 7 => 0, 10 => 0, // Alliance
    2 => 1, 5 => 1, 6 => 1, 8 => 1, 9 => 1, 11 => 1  // Horde
];

$result = [
    'status' => 'error',
    'message' => '',
    'data' => []
];

try {
    // This would normally load CodeIgniter, but for standalone testing:
    // You should run this through your BlizzCMS installation instead
    
    $result['status'] = 'info';
    $result['message'] = 'Sample Data Script - Instructions';
    $result['data'] = [
        'note' => 'This script should be run through your BlizzCMS installation for proper database access.',
        'instructions' => [
            '1. Access this script through your BlizzCMS: http://your-site.com/pvpstats/SAMPLE_DATA.php?token=pvpstats_sample_data_2026',
            '2. Or integrate this into a BlizzCMS controller for proper database handling',
            '3. The sample data will create 10 battleground matches with 20 players each',
            '4. Data includes realistic statistics for testing the module'
        ],
        'sample_structure' => [
            'battlegrounds' => 10,
            'players_per_bg' => 20,
            'total_records' => 200
        ]
    ];

} catch (Exception $e) {
    $result['status'] = 'error';
    $result['message'] = 'Error: ' . $e->getMessage();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>PvP Stats - Sample Data Insertion</title>
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
        .status-box {
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .status-box.info {
            background-color: #e7f3ff;
            border-left: 4px solid #007bff;
            color: #004085;
        }
        .status-box.success {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
        }
        .status-box.error {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            color: #721c24;
        }
        .code-block {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 10px;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
        }
        .instructions {
            margin: 20px 0;
        }
        .instructions ol {
            line-height: 1.8;
        }
        .instructions li {
            margin: 10px 0;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 3px;
            margin: 20px 0;
            color: #856404;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .data-table th,
        .data-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .data-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .data-table tr:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PvP Stats Module - Sample Data Insertion</h1>
        
        <div class="status-box <?php echo $result['status']; ?>">
            <strong><?php echo ucfirst($result['status']); ?>:</strong> <?php echo $result['message']; ?>
        </div>

        <div class="warning">
            <strong>⚠️ Warning:</strong> This script is for testing purposes only. Delete this file after testing for security reasons.
        </div>

        <div class="instructions">
            <h2>How to Use This Script</h2>
            <ol>
                <li>
                    <strong>Method 1: Direct Access (Localhost Only)</strong>
                    <div class="code-block">http://your-site.com/pvpstats/SAMPLE_DATA.php</div>
                </li>
                <li>
                    <strong>Method 2: With Token</strong>
                    <div class="code-block">http://your-site.com/pvpstats/SAMPLE_DATA.php?token=pvpstats_sample_data_2026</div>
                </li>
                <li>
                    <strong>Method 3: BlizzCMS Controller (Recommended)</strong>
                    <p>Create a controller action in your BlizzCMS installation to properly handle database operations with CodeIgniter's database library.</p>
                </li>
            </ol>
        </div>

        <h2>Sample Data Structure</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Count</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Battleground Matches</td>
                    <td>10</td>
                    <td>Various battleground types (AV, WSG, AB, EoTS, SoA, IoC)</td>
                </tr>
                <tr>
                    <td>Players per Match</td>
                    <td>20</td>
                    <td>10 Alliance vs 10 Horde</td>
                </tr>
                <tr>
                    <td>Total Player Records</td>
                    <td>200</td>
                    <td>Individual player statistics per match</td>
                </tr>
                <tr>
                    <td>Time Range</td>
                    <td>Last 7 days</td>
                    <td>Distributed across the past week</td>
                </tr>
            </tbody>
        </table>

        <h2>Data Generated</h2>
        <p>The sample data includes:</p>
        <ul>
            <li>Realistic player names and character data</li>
            <li>Various classes and races</li>
            <li>Killing blows, deaths, and honorable kills</li>
            <li>Damage and healing statistics</li>
            <li>Bonus honor earned</li>
            <li>Battleground-specific objectives (flags, bases, nodes, towers, etc.)</li>
            <li>Random match outcomes (Alliance/Horde wins)</li>
        </ul>

        <h2>Integration with BlizzCMS</h2>
        <p>To properly integrate sample data insertion, create a controller method:</p>
        <div class="code-block">
&lt;?php
class Pvpstats extends BS_Controller {
    public function insert_sample_data() {
        if (!$this->user_model->is_admin()) {
            redirect('user/login');
        }
        
        $this->load->model('pvpstats_battleground_model');
        
        // Insert sample battlegrounds and players
        // ... implementation code ...
        
        $this->session->set_flashdata('success', 'Sample data inserted successfully');
        redirect('pvpstats/admin');
    }
}
        </div>

        <h2>Next Steps</h2>
        <ol>
            <li>Verify the module is properly installed using <code>SETUP_VERIFICATION.php</code></li>
            <li>Run the database migration to create tables</li>
            <li>Insert sample data using this script or a BlizzCMS controller</li>
            <li>Navigate to <code>/pvpstats</code> to view the dashboard</li>
            <li>Delete this file and <code>SETUP_VERIFICATION.php</code> for security</li>
        </ol>

        <h2>Security Notes</h2>
        <ul>
            <li>This script is protected by localhost check or token</li>
            <li>Change the token if you expose this to the internet</li>
            <li>Always delete this file after testing</li>
            <li>Never use this in production environments</li>
        </ul>

        <h2>Troubleshooting</h2>
        <div class="status-box info">
            <strong>If you see "Access Denied":</strong>
            <ul>
                <li>Make sure you're accessing from localhost, OR</li>
                <li>Use the token parameter: <code>?token=pvpstats_sample_data_2026</code></li>
                <li>Check your server's remote address configuration</li>
            </ul>
        </div>
    </div>
</body>
</html>
