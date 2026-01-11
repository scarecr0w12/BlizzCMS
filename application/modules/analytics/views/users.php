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
            color: #3498db;
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
        .filter-controls {
            margin-bottom: 20px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 8px;
        }
        .filter-controls label {
            margin-right: 10px;
            font-weight: bold;
        }
        .filter-controls select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }
        .filter-controls button {
            padding: 8px 16px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .filter-controls button:hover {
            background: #2980b9;
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
            <a href="<?php echo base_url('analytics/users'); ?>" class="active">Users</a>
            <a href="<?php echo base_url('analytics/revenue'); ?>">Revenue</a>
            <a href="<?php echo base_url('analytics/engagement'); ?>">Engagement</a>
            <a href="<?php echo base_url('analytics/server'); ?>">Server</a>
        </div>

        <div class="filter-controls">
            <form method="get" action="">
                <label for="days">Time Period:</label>
                <select name="days" id="days">
                    <option value="7" <?php echo $days == 7 ? 'selected' : ''; ?>>Last 7 Days</option>
                    <option value="30" <?php echo $days == 30 ? 'selected' : ''; ?>>Last 30 Days</option>
                    <option value="60" <?php echo $days == 60 ? 'selected' : ''; ?>>Last 60 Days</option>
                    <option value="90" <?php echo $days == 90 ? 'selected' : ''; ?>>Last 90 Days</option>
                </select>
                <button type="submit">Update</button>
            </form>
        </div>

        <h2>User Metrics</h2>
        <div class="metrics-grid">
            <div class="metric-card">
                <h3>Total Users</h3>
                <div class="metric-value"><?php echo number_format($user_metrics['total_users']); ?></div>
                <div class="metric-label">All registered users</div>
            </div>
            <div class="metric-card">
                <h3>New Users</h3>
                <div class="metric-value"><?php echo number_format($user_metrics['new_users']); ?></div>
                <div class="metric-label">Last <?php echo $days; ?> days</div>
            </div>
            <div class="metric-card">
                <h3>Active Users</h3>
                <div class="metric-value"><?php echo number_format($user_metrics['active_users']); ?></div>
                <div class="metric-label">Last <?php echo $days; ?> days</div>
            </div>
            <div class="metric-card">
                <h3>Banned Users</h3>
                <div class="metric-value"><?php echo number_format($user_metrics['banned_users']); ?></div>
                <div class="metric-label">Total banned</div>
            </div>
            <div class="metric-card">
                <h3>Retention Rate</h3>
                <div class="metric-value"><?php echo $retention['retention_rate']; ?>%</div>
                <div class="metric-label"><?php echo $days; ?>-day cohort</div>
            </div>
            <div class="metric-card">
                <h3>Retained Users</h3>
                <div class="metric-value"><?php echo number_format($retention['retained']); ?></div>
                <div class="metric-label">Out of <?php echo number_format($retention['cohort_size']); ?></div>
            </div>
        </div>

        <div class="two-column">
            <div class="chart-container">
                <div class="chart-title">Daily New Users</div>
                <canvas id="dailyUsersChart"></canvas>
            </div>

            <div class="chart-container">
                <div class="chart-title">User Distribution</div>
                <canvas id="userDistributionChart"></canvas>
            </div>
        </div>

        <div class="chart-container">
            <div class="chart-title">Daily Logins</div>
            <canvas id="dailyLoginsChart"></canvas>
        </div>
    </div>

    <script>
        const dailyStats = <?php echo json_encode($daily_stats); ?>;
        const userMetrics = <?php echo json_encode($user_metrics); ?>;
        
        const labels = dailyStats.map(stat => stat.date);
        const users = dailyStats.map(stat => stat.users);
        const logins = dailyStats.map(stat => stat.logins);

        new Chart(document.getElementById('dailyUsersChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'New Users',
                    data: users,
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    tension: 0.4,
                    fill: true
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

        new Chart(document.getElementById('userDistributionChart'), {
            type: 'doughnut',
            data: {
                labels: ['Active Users', 'Inactive Users', 'Banned Users'],
                datasets: [{
                    data: [
                        userMetrics.active_users,
                        userMetrics.total_users - userMetrics.active_users - userMetrics.banned_users,
                        userMetrics.banned_users
                    ],
                    backgroundColor: ['#2ecc71', '#95a5a6', '#e74c3c']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, position: 'bottom' }
                }
            }
        });

        new Chart(document.getElementById('dailyLoginsChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Logins',
                    data: logins,
                    backgroundColor: '#3498db'
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
    </script>
</body>
</html>
