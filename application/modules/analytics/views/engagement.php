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
            color: #9b59b6;
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
            <a href="<?php echo base_url('analytics/users'); ?>">Users</a>
            <a href="<?php echo base_url('analytics/revenue'); ?>">Revenue</a>
            <a href="<?php echo base_url('analytics/engagement'); ?>" class="active">Engagement</a>
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

        <h2>Engagement Metrics</h2>
        <div class="metrics-grid">
            <div class="metric-card">
                <h3>Total Logins</h3>
                <div class="metric-value"><?php echo number_format($engagement_metrics['total_logins']); ?></div>
                <div class="metric-label">Last <?php echo $days; ?> days</div>
            </div>
            <div class="metric-card">
                <h3>Avg Session Time</h3>
                <div class="metric-value"><?php echo number_format($engagement_metrics['avg_session_time']); ?>s</div>
                <div class="metric-label">Last <?php echo $days; ?> days</div>
            </div>
            <div class="metric-card">
                <h3>Total Events</h3>
                <div class="metric-value"><?php echo number_format($engagement_metrics['total_events']); ?></div>
                <div class="metric-label">Last <?php echo $days; ?> days</div>
            </div>
            <div class="metric-card">
                <h3>Event Attendance</h3>
                <div class="metric-value"><?php echo number_format($engagement_metrics['event_attendance']); ?></div>
                <div class="metric-label">Last <?php echo $days; ?> days</div>
            </div>
            <div class="metric-card">
                <h3>Shop Users</h3>
                <div class="metric-value"><?php echo number_format($feature_usage['shop_users']); ?></div>
                <div class="metric-label">Unique shop users</div>
            </div>
            <div class="metric-card">
                <h3>Event Participants</h3>
                <div class="metric-value"><?php echo number_format($feature_usage['event_participants']); ?></div>
                <div class="metric-label">Total participants</div>
            </div>
        </div>

        <div class="two-column">
            <div class="chart-container">
                <div class="chart-title">Daily Logins</div>
                <canvas id="dailyLoginsChart"></canvas>
            </div>

            <div class="chart-container">
                <div class="chart-title">Feature Usage</div>
                <canvas id="featureUsageChart"></canvas>
            </div>
        </div>

        <div class="chart-container">
            <div class="chart-title">Engagement Overview</div>
            <canvas id="engagementChart"></canvas>
        </div>
    </div>

    <script>
        const dailyStats = <?php echo json_encode($daily_stats); ?>;
        const featureUsage = <?php echo json_encode($feature_usage); ?>;
        const engagementMetrics = <?php echo json_encode($engagement_metrics); ?>;
        
        const labels = dailyStats.map(stat => stat.date);
        const logins = dailyStats.map(stat => stat.logins);

        new Chart(document.getElementById('dailyLoginsChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Logins',
                    data: logins,
                    borderColor: '#9b59b6',
                    backgroundColor: 'rgba(155, 89, 182, 0.1)',
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

        new Chart(document.getElementById('featureUsageChart'), {
            type: 'doughnut',
            data: {
                labels: ['Shop Users', 'Event Participants', 'Profile Visits', 'Notifications'],
                datasets: [{
                    data: [
                        featureUsage.shop_users,
                        featureUsage.event_participants,
                        featureUsage.profile_visits,
                        featureUsage.notifications_sent
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

        new Chart(document.getElementById('engagementChart'), {
            type: 'bar',
            data: {
                labels: ['Logins', 'Events', 'Event Attendance'],
                datasets: [{
                    label: 'Count',
                    data: [
                        engagementMetrics.total_logins,
                        engagementMetrics.total_events,
                        engagementMetrics.event_attendance
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
    </script>
</body>
</html>
