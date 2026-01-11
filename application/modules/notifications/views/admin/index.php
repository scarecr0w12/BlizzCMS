<div class="notification-admin-wrapper">
    <div class="admin-header">
        <div class="header-content">
            <h2 class="admin-title">
                <i class="fas fa-bell"></i> Notifications Administration
            </h2>
            <div class="header-actions">
                <a href="<?= site_url('notifications/admin/send') ?>" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Send Notification
                </a>
                <a href="<?= site_url('notifications/admin/settings') ?>" class="btn btn-secondary">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card stat-card-primary">
            <div class="stat-content">
                <div class="stat-info">
                    <div class="stat-label">Total Sent</div>
                    <div class="stat-value"><?= number_format($statistics['total_sent']) ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-paper-plane"></i>
                </div>
            </div>
        </div>
        <div class="stat-card stat-card-success">
            <div class="stat-content">
                <div class="stat-info">
                    <div class="stat-label">Read</div>
                    <div class="stat-value"><?= number_format($statistics['total_read']) ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="stat-card stat-card-warning">
            <div class="stat-content">
                <div class="stat-info">
                    <div class="stat-label">Unread</div>
                    <div class="stat-value"><?= number_format($statistics['total_unread']) ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
            </div>
        </div>
        <div class="stat-card stat-card-info">
            <div class="stat-content">
                <div class="stat-info">
                    <div class="stat-label">Active Users</div>
                    <div class="stat-value"><?= number_format($statistics['users_with_notifications']) ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar"></i> Notification Types
                </h3>
            </div>
            <div class="card-body">
                <div class="notification-types-list">
                    <div class="type-item">
                        <span class="type-name"><i class="fas fa-coins" style="color: #f6c23e;"></i> Donations</span>
                        <span class="type-badge badge-auto">Auto</span>
                    </div>
                    <div class="type-item">
                        <span class="type-name"><i class="fas fa-shopping-cart" style="color: #4e73df;"></i> Shop Purchases</span>
                        <span class="type-badge badge-auto">Auto</span>
                    </div>
                    <div class="type-item">
                        <span class="type-name"><i class="fas fa-thumbs-up" style="color: #1cc88a;"></i> Votes</span>
                        <span class="type-badge badge-auto">Auto</span>
                    </div>
                    <div class="type-item">
                        <span class="type-name"><i class="fas fa-newspaper" style="color: #36b9cc;"></i> News Posts</span>
                        <span class="type-badge badge-auto">Auto</span>
                    </div>
                    <div class="type-item">
                        <span class="type-name"><i class="fas fa-calendar" style="color: #e74a3b;"></i> Events</span>
                        <span class="type-badge badge-auto">Auto</span>
                    </div>
                    <div class="type-item">
                        <span class="type-name"><i class="fas fa-bell" style="color: #858796;"></i> System</span>
                        <span class="type-badge badge-manual">Manual</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Module Information
                </h3>
            </div>
            <div class="card-body">
                <div class="info-section">
                    <h4 class="info-title">Notification System</h4>
                    <p class="info-description">Keep users engaged with real-time notifications for important events.</p>
                </div>
                
                <div class="info-divider"></div>
                
                <div class="info-section">
                    <h4 class="info-title">Features:</h4>
                    <ul class="info-list">
                        <li>In-app notification center</li>
                        <li>Email notifications</li>
                        <li>Browser push notifications</li>
                        <li>User preferences management</li>
                        <li>Bulk notifications</li>
                        <li>Automatic cleanup</li>
                    </ul>
                </div>
                
                <div class="info-divider"></div>
                
                <div class="info-section">
                    <h4 class="info-title">Integration:</h4>
                    <p class="info-description">
                        Notifications can be triggered from any module using the notifications model.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Main Wrapper */
.notification-admin-wrapper {
    padding: 20px;
    background-color: #f8f9fc;
    min-height: 100vh;
}

/* Header Section */
.admin-header {
    margin-bottom: 30px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.admin-title {
    margin: 0;
    font-size: 28px;
    font-weight: 700;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 12px;
}

.admin-title i {
    color: #f6c23e;
    font-size: 32px;
}

.header-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: #6c757d;
    color: #fff;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: #fff;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    border-left: 4px solid;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.stat-card-primary {
    border-left-color: #4e73df;
}

.stat-card-success {
    border-left-color: #1cc88a;
}

.stat-card-warning {
    border-left-color: #f6c23e;
}

.stat-card-info {
    border-left-color: #36b9cc;
}

.stat-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stat-info {
    flex: 1;
}

.stat-label {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    color: #858796;
    margin-bottom: 8px;
    letter-spacing: 0.5px;
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: #5a5c69;
}

.stat-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(0,0,0,0.02);
}

.stat-icon i {
    font-size: 28px;
    color: #dddfeb;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

.content-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
    transition: all 0.3s ease;
}

.content-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px;
    border-bottom: 1px solid #e3e6f0;
}

.card-title {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-body {
    padding: 25px;
}

/* Notification Types List */
.notification-types-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.type-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background: #f8f9fc;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.type-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.type-name {
    font-size: 15px;
    font-weight: 600;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 10px;
}

.type-name i {
    font-size: 18px;
}

.type-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
}

.badge-auto {
    background: #4e73df;
    color: #fff;
}

.badge-manual {
    background: #1cc88a;
    color: #fff;
}

/* Info Sections */
.info-section {
    margin-bottom: 20px;
}

.info-section:last-child {
    margin-bottom: 0;
}

.info-title {
    font-size: 16px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
}

.info-description {
    font-size: 14px;
    color: #858796;
    line-height: 1.6;
    margin: 0;
}

.info-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-list li {
    padding: 8px 0;
    padding-left: 25px;
    position: relative;
    font-size: 14px;
    color: #858796;
    line-height: 1.5;
}

.info-list li:before {
    content: "✓";
    position: absolute;
    left: 0;
    color: #1cc88a;
    font-weight: 700;
    font-size: 16px;
}

.info-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, #e3e6f0, transparent);
    margin: 20px 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .header-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .admin-title {
        font-size: 22px;
    }
    
    .stat-value {
        font-size: 26px;
    }
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card, .content-card {
    animation: fadeIn 0.5s ease-out;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }
</style>
