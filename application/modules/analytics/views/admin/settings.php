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
    <style>
        .admin-container {
            max-width: 1000px;
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
        .settings-form {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .form-group input[type="text"]:focus,
        .form-group input[type="number"]:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }
        .form-group input[type="checkbox"] {
            margin-right: 8px;
            cursor: pointer;
        }
        .form-group .checkbox-label {
            display: flex;
            align-items: center;
            font-weight: normal;
            margin-bottom: 0;
        }
        .form-group .description {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-primary {
            background: #3498db;
            color: white;
        }
        .btn-primary:hover {
            background: #2980b9;
        }
        .btn-secondary {
            background: #95a5a6;
            color: white;
        }
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .settings-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .settings-section:last-child {
            border-bottom: none;
        }
        .settings-section h3 {
            margin: 0 0 20px 0;
            color: #333;
            font-size: 16px;
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
            <a href="<?php echo base_url('analytics/admin'); ?>">Dashboard</a>
            <a href="<?php echo base_url('analytics/admin/settings'); ?>" class="active">Settings</a>
        </div>

        <?php if (isset($success)): ?>
        <div class="alert alert-success">
            <?php echo $success; ?>
        </div>
        <?php endif; ?>

        <?php if (isset($errors)): ?>
        <div class="alert alert-error">
            <?php echo $errors; ?>
        </div>
        <?php endif; ?>

        <form method="post" action="" class="settings-form">
            <div class="settings-section">
                <h3>Analytics Tracking</h3>
                
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="enable_analytics" value="1" 
                            <?php echo (isset($settings['enable_analytics']) && $settings['enable_analytics'] == 1) ? 'checked' : ''; ?>>
                        Enable Analytics
                    </label>
                    <div class="description">
                        Enable or disable analytics tracking across the system
                    </div>
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="track_sessions" value="1" 
                            <?php echo (isset($settings['track_sessions']) && $settings['track_sessions'] == 1) ? 'checked' : ''; ?>>
                        Track User Sessions
                    </label>
                    <div class="description">
                        Track user session duration and activity
                    </div>
                </div>
            </div>

            <div class="settings-section">
                <h3>Data Retention</h3>
                
                <div class="form-group">
                    <label for="retention_days">Retention Period (Days)</label>
                    <input type="number" id="retention_days" name="retention_days" 
                        value="<?php echo isset($settings['retention_days']) ? htmlspecialchars($settings['retention_days']) : '90'; ?>" 
                        min="1" max="365">
                    <div class="description">
                        Number of days to retain analytics data before automatic cleanup
                    </div>
                </div>
            </div>

            <div class="settings-section">
                <h3>Display Settings</h3>
                
                <div class="form-group">
                    <label for="chart_refresh_interval">Chart Refresh Interval (Seconds)</label>
                    <input type="number" id="chart_refresh_interval" name="chart_refresh_interval" 
                        value="<?php echo isset($settings['chart_refresh_interval']) ? htmlspecialchars($settings['chart_refresh_interval']) : '300'; ?>" 
                        min="10" max="3600">
                    <div class="description">
                        How often to refresh analytics charts (in seconds)
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Settings</button>
                <a href="<?php echo base_url('analytics/admin'); ?>" class="btn btn-secondary" style="text-decoration: none; display: inline-block;">Cancel</a>
            </div>
        </form>

        <div style="margin-top: 40px; padding: 20px; background: #f5f5f5; border-radius: 8px;">
            <h3 style="margin-top: 0;">Analytics Information</h3>
            <p>
                The Analytics module tracks user behavior, engagement metrics, revenue data, and server statistics. 
                These settings control how analytics data is collected and displayed throughout the system.
            </p>
            <ul style="color: #666; font-size: 14px;">
                <li><strong>Enable Analytics:</strong> Controls whether analytics tracking is active</li>
                <li><strong>Track Sessions:</strong> Enables detailed user session tracking</li>
                <li><strong>Retention Period:</strong> Older data will be automatically cleaned up after this period</li>
                <li><strong>Chart Refresh Interval:</strong> Controls how frequently dashboard charts update</li>
            </ul>
        </div>
    </div>
</body>
</html>
