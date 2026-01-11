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
    </style>
</head>
<body>
    <div class="analytics-container">
        <h1><?php echo $page_title; ?></h1>
        
        <div class="nav-tabs">
            <a href="<?php echo base_url('analytics'); ?>" class="active">Overview</a>
            <a href="<?php echo base_url('analytics/dashboard'); ?>">Dashboard</a>
            <a href="<?php echo base_url('analytics/users'); ?>">Users</a>
            <a href="<?php echo base_url('analytics/revenue'); ?>">Revenue</a>
            <a href="<?php echo base_url('analytics/engagement'); ?>">Engagement</a>
            <a href="<?php echo base_url('analytics/server'); ?>">Server</a>
        </div>

        <h2>Key Metrics</h2>
        <div class="metrics-grid">
            <div class="metric-card">
                <h3>Total Users</h3>
                <div class="metric-value"><?php echo number_format($user_metrics['total_users']); ?></div>
                <div class="metric-label">All registered users</div>
            </div>
            <div class="metric-card">
                <h3>New Users (30d)</h3>
                <div class="metric-value"><?php echo number_format($user_metrics['new_users']); ?></div>
                <div class="metric-label">Last 30 days</div>
            </div>
            <div class="metric-card">
                <h3>Active Users (30d)</h3>
                <div class="metric-value"><?php echo number_format($user_metrics['active_users']); ?></div>
                <div class="metric-label">Last 30 days</div>
            </div>
            <div class="metric-card">
                <h3>Total Revenue (30d)</h3>
                <div class="metric-value">$<?php echo number_format($revenue_metrics['total_revenue'], 2); ?></div>
                <div class="metric-label">Last 30 days</div>
            </div>
            <div class="metric-card">
                <h3>Total Orders (30d)</h3>
                <div class="metric-value"><?php echo number_format($revenue_metrics['total_orders']); ?></div>
                <div class="metric-label">Last 30 days</div>
            </div>
            <div class="metric-card">
                <h3>Avg Order Value</h3>
                <div class="metric-value">$<?php echo number_format($revenue_metrics['avg_order_value'], 2); ?></div>
                <div class="metric-label">Last 30 days</div>
            </div>
            <div class="metric-card">
                <h3>Total Logins (30d)</h3>
                <div class="metric-value"><?php echo number_format($engagement_metrics['total_logins']); ?></div>
                <div class="metric-label">Last 30 days</div>
            </div>
            <div class="metric-card">
                <h3>Total Characters</h3>
                <div class="metric-value"><?php echo number_format($server_metrics['total_characters']); ?></div>
                <div class="metric-label">All characters</div>
            </div>
        </div>

        <div class="chart-container">
            <div class="chart-title">Daily New Users (30 Days)</div>
            <canvas id="dailyUsersChart"></canvas>
        </div>

        <div class="chart-container">
            <div class="chart-title">Daily Logins (30 Days)</div>
            <canvas id="dailyLoginsChart"></canvas>
        </div>

        <div class="chart-container">
            <div class="chart-title">Daily Revenue (30 Days)</div>
            <canvas id="dailyRevenueChart"></canvas>
        </div>
    </div>

    <script>
        const dailyStats = <?php echo json_encode($daily_stats); ?>;
        
        const labels = dailyStats.map(stat => stat.date);
        const users = dailyStats.map(stat => stat.users);
        const logins = dailyStats.map(stat => stat.logins);
        const revenue = dailyStats.map(stat => stat.revenue);

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
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(document.getElementById('dailyLoginsChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Logins',
                    data: logins,
                    borderColor: '#2ecc71',
                    backgroundColor: 'rgba(46, 204, 113, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(document.getElementById('dailyRevenueChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue ($)',
                    data: revenue,
                    borderColor: '#f39c12',
                    backgroundColor: 'rgba(243, 156, 18, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
