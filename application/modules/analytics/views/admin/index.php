<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Admin</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/default.css'); ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 15px;
        }
        .admin-nav {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .admin-nav a {
            padding: 10px 20px;
            background: #f5f5f5;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
            transition: all 0.3s;
        }
        .admin-nav a:hover,
        .admin-nav a.active {
            background: #3498db;
            color: white;
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
        .top-items-table {
            width: 100%;
            border-collapse: collapse;
        }
        .top-items-table th,
        .top-items-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .top-items-table th {
            background: #f5f5f5;
            font-weight: bold;
            color: #333;
        }
        .top-items-table tr:hover {
            background: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1><?php echo $page_title; ?></h1>
            <a href="<?php echo base_url('admin'); ?>" style="text-decoration: none; color: #3498db;">← Back to Admin</a>
        </div>
        
        <div class="admin-nav">
            <a href="<?php echo base_url('analytics/admin'); ?>" class="active">Dashboard</a>
            <a href="<?php echo base_url('analytics/admin/settings'); ?>">Settings</a>
        </div>

        <h2>System Overview</h2>
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
                <h3>Total Logins (30d)</h3>
                <div class="metric-value"><?php echo number_format($engagement_metrics['total_logins']); ?></div>
                <div class="metric-label">Last 30 days</div>
            </div>
            <div class="metric-card">
                <h3>Total Characters</h3>
                <div class="metric-value"><?php echo number_format($server_metrics['total_characters']); ?></div>
                <div class="metric-label">All characters</div>
            </div>
            <div class="metric-card">
                <h3>Online Players</h3>
                <div class="metric-value"><?php echo number_format($server_metrics['online_players']); ?></div>
                <div class="metric-label">Currently online</div>
            </div>
        </div>

        <div class="two-column">
            <div class="chart-container">
                <div class="chart-title">Daily New Users (30 Days)</div>
                <canvas id="dailyUsersChart"></canvas>
            </div>

            <div class="chart-container">
                <div class="chart-title">Daily Revenue (30 Days)</div>
                <canvas id="dailyRevenueChart"></canvas>
            </div>
        </div>

        <div class="two-column">
            <div class="chart-container">
                <div class="chart-title">Daily Logins (30 Days)</div>
                <canvas id="dailyLoginsChart"></canvas>
            </div>

            <div class="chart-container">
                <div class="chart-title">User Metrics Overview</div>
                <canvas id="userMetricsChart"></canvas>
            </div>
        </div>

        <div class="chart-container">
            <div class="chart-title">Top 10 Items by Sales</div>
            <canvas id="topItemsChart"></canvas>
        </div>

        <div class="chart-container">
            <div class="chart-title">Top Selling Items Details</div>
            <table class="top-items-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Sales</th>
                        <th>Total Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($top_items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item->name ?? 'N/A'); ?></td>
                        <td>$<?php echo number_format($item->price ?? 0, 2); ?></td>
                        <td><?php echo number_format($item->sales ?? 0); ?></td>
                        <td>$<?php echo number_format(($item->price ?? 0) * ($item->sales ?? 0), 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const dailyStats = <?php echo json_encode($daily_stats); ?>;
        const topItems = <?php echo json_encode($top_items); ?>;
        const userMetrics = <?php echo json_encode($user_metrics); ?>;
        
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
                    legend: { display: true, position: 'top' }
                },
                scales: { y: { beginAtZero: true } }
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
                    legend: { display: true, position: 'top' }
                },
                scales: { y: { beginAtZero: true } }
            }
        });

        new Chart(document.getElementById('dailyLoginsChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Logins',
                    data: logins,
                    backgroundColor: '#2ecc71'
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

        new Chart(document.getElementById('userMetricsChart'), {
            type: 'doughnut',
            data: {
                labels: ['Total Users', 'New Users', 'Active Users', 'Banned Users'],
                datasets: [{
                    data: [
                        userMetrics.total_users,
                        userMetrics.new_users,
                        userMetrics.active_users,
                        userMetrics.banned_users
                    ],
                    backgroundColor: ['#3498db', '#2ecc71', '#f39c12', '#e74c3c']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, position: 'bottom' }
                }
            }
        });

        new Chart(document.getElementById('topItemsChart'), {
            type: 'bar',
            data: {
                labels: topItems.map(item => item.name),
                datasets: [{
                    label: 'Sales',
                    data: topItems.map(item => item.sales),
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
