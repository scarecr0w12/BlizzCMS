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
            color: #f39c12;
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
    <div class="analytics-container">
        <h1><?php echo $page_title; ?></h1>
        
        <div class="nav-tabs">
            <a href="<?php echo base_url('analytics'); ?>">Overview</a>
            <a href="<?php echo base_url('analytics/dashboard'); ?>">Dashboard</a>
            <a href="<?php echo base_url('analytics/users'); ?>">Users</a>
            <a href="<?php echo base_url('analytics/revenue'); ?>" class="active">Revenue</a>
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

        <h2>Revenue Metrics</h2>
        <div class="metrics-grid">
            <div class="metric-card">
                <h3>Total Revenue</h3>
                <div class="metric-value">$<?php echo number_format($revenue_metrics['total_revenue'], 2); ?></div>
                <div class="metric-label">Last <?php echo $days; ?> days</div>
            </div>
            <div class="metric-card">
                <h3>Total Orders</h3>
                <div class="metric-value"><?php echo number_format($revenue_metrics['total_orders']); ?></div>
                <div class="metric-label">Last <?php echo $days; ?> days</div>
            </div>
            <div class="metric-card">
                <h3>Average Order Value</h3>
                <div class="metric-value">$<?php echo number_format($revenue_metrics['avg_order_value'], 2); ?></div>
                <div class="metric-label">Last <?php echo $days; ?> days</div>
            </div>
        </div>

        <div class="two-column">
            <div class="chart-container">
                <div class="chart-title">Daily Revenue</div>
                <canvas id="dailyRevenueChart"></canvas>
            </div>

            <div class="chart-container">
                <div class="chart-title">Daily Orders</div>
                <canvas id="dailyOrdersChart"></canvas>
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
        
        const labels = dailyStats.map(stat => stat.date);
        const revenue = dailyStats.map(stat => stat.revenue);
        const orders = dailyStats.map(stat => {
            return stat.revenue > 0 ? Math.ceil(stat.revenue / 50) : 0;
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

        new Chart(document.getElementById('dailyOrdersChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Orders',
                    data: orders,
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

        new Chart(document.getElementById('topItemsChart'), {
            type: 'bar',
            data: {
                labels: topItems.map(item => item.name),
                datasets: [{
                    label: 'Sales',
                    data: topItems.map(item => item.sales),
                    backgroundColor: '#f39c12'
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                plugins: {
                    legend: { display: true, position: 'top' }
                },
                scales: { x: { beginAtZero: true } }
            }
        });
    </script>
</body>
</html>
