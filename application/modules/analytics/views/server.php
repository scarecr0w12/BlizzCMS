<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Analytics</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/default.css'); ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .analytics-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .metric-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .metric-card h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .metric-value {
            font-size: 32px;
            font-weight: bold;
            color: #1abc9c;
        }
        .metric-label {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }
        .chart-container {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .chart-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }
        .nav-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
        }
        .nav-tabs a {
            padding: 10px 20px;
            text-decoration: none;
            color: #666;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }
        .nav-tabs a:hover,
        .nav-tabs a.active {
            color: #3498db;
            border-bottom-color: #3498db;
        }
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        .status-online {
            background: #2ecc71;
        }
        .status-offline {
            background: #e74c3c;
        }
        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        @media (max-width: 768px) {
            .two-column {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="analytics-container">
        <h1><?php echo $page_title; ?></h1>
        
        <div class="nav-tabs">
            <a href="<?php echo base_url('analytics'); ?>">Overview</a>
            <a href="<?php echo base_url('analytics/dashboard'); ?>">Dashboard</a>
            <a href="<?php echo base_url('analytics/users'); ?>">Users</a>
            <a href="<?php echo base_url('analytics/revenue'); ?>">Revenue</a>
            <a href="<?php echo base_url('analytics/engagement'); ?>">Engagement</a>
            <a href="<?php echo base_url('analytics/server'); ?>" class="active">Server</a>
        </div>

        <h2>Server Metrics</h2>
        <div class="metrics-grid">
            <div class="metric-card">
                <h3>Total Characters</h3>
                <div class="metric-value"><?php echo number_format($server_metrics['total_characters']); ?></div>
                <div class="metric-label">All characters</div>
            </div>
            <div class="metric-card">
                <h3>Online Players</h3>
                <div class="metric-value">
                    <span class="status-indicator status-online"></span>
                    <?php echo number_format($server_metrics['online_players']); ?>
                </div>
                <div class="metric-label">Currently online</div>
            </div>
            <div class="metric-card">
                <h3>Total Guilds</h3>
                <div class="metric-value"><?php echo number_format($server_metrics['total_guilds']); ?></div>
                <div class="metric-label">All guilds</div>
            </div>
            <div class="metric-card">
                <h3>Average Level</h3>
                <div class="metric-value"><?php echo number_format($server_metrics['avg_level'], 1); ?></div>
                <div class="metric-label">Average character level</div>
            </div>
        </div>

        <div class="two-column">
            <div class="chart-container">
                <div class="chart-title">Server Overview</div>
                <canvas id="serverOverviewChart"></canvas>
            </div>

            <div class="chart-container">
                <div class="chart-title">Player Status</div>
                <canvas id="playerStatusChart"></canvas>
            </div>
        </div>

        <div class="chart-container">
            <div class="chart-title">Server Statistics</div>
            <canvas id="serverStatsChart"></canvas>
        </div>
    </div>

    <script>
        const serverMetrics = <?php echo json_encode($server_metrics); ?>;

        new Chart(document.getElementById('serverOverviewChart'), {
            type: 'bar',
            data: {
                labels: ['Total Characters', 'Online Players', 'Total Guilds'],
                datasets: [{
                    label: 'Count',
                    data: [
                        serverMetrics.total_characters,
                        serverMetrics.online_players,
                        serverMetrics.total_guilds
                    ],
                    backgroundColor: ['#3498db', '#2ecc71', '#9b59b6']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, position: 'top' }
                },
                scales: { y: { beginAtZero: true } }
            }
        });

        new Chart(document.getElementById('playerStatusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Online', 'Offline'],
                datasets: [{
                    data: [
                        serverMetrics.online_players,
                        serverMetrics.total_characters - serverMetrics.online_players
                    ],
                    backgroundColor: ['#2ecc71', '#95a5a6']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, position: 'bottom' }
                }
            }
        });

        new Chart(document.getElementById('serverStatsChart'), {
            type: 'radar',
            data: {
                labels: ['Characters', 'Online Players', 'Guilds'],
                datasets: [{
                    label: 'Server Stats',
                    data: [
                        (serverMetrics.total_characters / 1000) * 100,
                        (serverMetrics.online_players / serverMetrics.total_characters) * 100,
                        (serverMetrics.total_guilds / 100) * 100
                    ],
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.2)',
                    pointBackgroundColor: '#3498db'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, position: 'top' }
                },
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
</body>
</html>
