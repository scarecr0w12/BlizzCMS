<div class="notification-settings-wrapper">
    <div class="settings-header">
        <div class="header-content">
            <h2 class="settings-title">
                <i class="fas fa-cog"></i> Notification Settings
            </h2>
            <a href="<?= site_url('notifications/admin') ?>" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert-box alert-success">
        <div class="alert-content">
            <i class="fas fa-check-circle"></i>
            <span><?= $this->session->flashdata('success') ?></span>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert-box alert-error">
        <div class="alert-content">
            <i class="fas fa-exclamation-circle"></i>
            <span><?= $this->session->flashdata('error') ?></span>
        </div>
    </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('notifications/admin/settings') ?>" class="settings-form">
        <div class="settings-grid">
            <div class="settings-main">
                <div class="settings-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-sliders-h"></i> General Settings
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-field">
                            <label class="field-label">
                                <i class="fas fa-envelope" style="color: #36b9cc;"></i>
                                Enable Email Notifications
                            </label>
                            <select name="enable_email" id="enable_email" class="field-input">
                                <option value="1" <?= isset($settings['enable_email']) && $settings['enable_email'] == '1' ? 'selected' : '' ?>>Enabled</option>
                                <option value="0" <?= isset($settings['enable_email']) && $settings['enable_email'] == '0' ? 'selected' : '' ?>>Disabled</option>
                            </select>
                            <small class="field-help">Send notifications via email to users.</small>
                        </div>

                        <div class="form-field">
                            <label class="field-label">
                                <i class="fas fa-bell" style="color: #f6c23e;"></i>
                                Enable Browser Push Notifications
                            </label>
                            <select name="enable_browser_push" id="enable_browser_push" class="field-input">
                                <option value="1" <?= isset($settings['enable_browser_push']) && $settings['enable_browser_push'] == '1' ? 'selected' : '' ?>>Enabled</option>
                                <option value="0" <?= isset($settings['enable_browser_push']) && $settings['enable_browser_push'] == '0' ? 'selected' : '' ?>>Disabled</option>
                            </select>
                            <small class="field-help">Allow browser push notifications for real-time alerts.</small>
                        </div>

                        <div class="form-field">
                            <label class="field-label">
                                <i class="fas fa-calendar-times" style="color: #e74a3b;"></i>
                                Retention Days
                            </label>
                            <input type="number" name="retention_days" id="retention_days" 
                                   class="field-input" 
                                   value="<?= isset($settings['retention_days']) ? $settings['retention_days'] : '30' ?>" 
                                   min="1" max="365" required>
                            <small class="field-help">Number of days to keep old notifications before automatic deletion (1-365).</small>
                        </div>

                        <div class="section-divider"></div>

                        <h4 class="section-title">
                            <i class="fas fa-mail-bulk"></i> Email Configuration
                        </h4>

                        <div class="form-field">
                            <label class="field-label">
                                <i class="fas fa-at" style="color: #4e73df;"></i>
                                From Email Address
                            </label>
                            <input type="email" name="from_email" id="from_email" 
                                   class="field-input" 
                                   value="<?= isset($settings['from_email']) ? $settings['from_email'] : '' ?>" 
                                   placeholder="noreply@yourserver.com">
                            <small class="field-help">Email address that notifications will be sent from.</small>
                        </div>

                        <div class="form-field">
                            <label class="field-label">
                                <i class="fas fa-signature" style="color: #1cc88a;"></i>
                                From Name
                            </label>
                            <input type="text" name="from_name" id="from_name" 
                                   class="field-input" 
                                   value="<?= isset($settings['from_name']) ? $settings['from_name'] : '' ?>" 
                                   placeholder="BlizzCMS Notifications">
                            <small class="field-help">Display name for notification emails.</small>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-save">
                                <i class="fas fa-save"></i> Save Settings
                            </button>
                            <a href="<?= site_url('notifications/admin') ?>" class="btn-cancel">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="settings-sidebar">
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h3 class="sidebar-title">
                            <i class="fas fa-info-circle"></i> Configuration Help
                        </h3>
                    </div>
                    <div class="sidebar-body">
                        <div class="help-section">
                            <h4 class="help-title">Email Notifications</h4>
                            <p class="help-text">Sends notification copies to user email addresses for important events.</p>
                        </div>
                        
                        <div class="help-divider"></div>
                        
                        <div class="help-section">
                            <h4 class="help-title">Browser Push</h4>
                            <p class="help-text">Delivers real-time browser notifications when users have an active session.</p>
                        </div>
                        
                        <div class="help-divider"></div>
                        
                        <div class="help-section">
                            <h4 class="help-title">Retention Period</h4>
                            <p class="help-text">Automatically removes old notifications to maintain database performance. Users can still see notifications within this period.</p>
                        </div>
                        
                        <div class="help-divider"></div>
                        
                        <div class="help-section">
                            <h4 class="help-title">Email Settings</h4>
                            <p class="help-text">Configure the sender information for outgoing notification emails. Make sure your email server is properly configured.</p>
                        </div>
                    </div>
                </div>

                <div class="sidebar-card sidebar-warning">
                    <div class="sidebar-header">
                        <h3 class="sidebar-title">
                            <i class="fas fa-exclamation-triangle"></i> Important Notes
                        </h3>
                    </div>
                    <div class="sidebar-body">
                        <ul class="notes-list">
                            <li>Email notifications require proper SMTP configuration</li>
                            <li>Browser push requires HTTPS in production</li>
                            <li>Lower retention periods improve performance</li>
                            <li>Settings apply to all notification types</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
/* Settings Wrapper */
.notification-settings-wrapper {
    padding: 20px;
    background-color: #f8f9fc;
    min-height: 100vh;
}

/* Header Section */
.settings-header {
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

.settings-title {
    margin: 0;
    font-size: 28px;
    font-weight: 700;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 12px;
}

.settings-title i {
    color: #667eea;
    font-size: 32px;
}

.btn-back {
    padding: 10px 20px;
    background: #6c757d;
    color: #fff;
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

.btn-back:hover {
    background: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    color: #fff;
    text-decoration: none;
}

/* Alert Boxes */
.alert-box {
    margin-bottom: 20px;
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.alert-success {
    background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
    color: #fff;
}

.alert-error {
    background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%);
    color: #fff;
}

.alert-content {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 500;
}

.alert-content i {
    font-size: 20px;
}

/* Settings Grid */
.settings-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 25px;
}

/* Main Settings Card */
.settings-main {
    min-width: 0;
}

.settings-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px;
}

.card-title {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-body {
    padding: 30px;
}

/* Form Fields */
.form-field {
    margin-bottom: 25px;
}

.field-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
}

.field-label i {
    font-size: 18px;
}

.field-input {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e3e6f0;
    border-radius: 6px;
    font-size: 15px;
    color: #2c3e50;
    background: #fff;
    transition: all 0.3s ease;
}

.field-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.field-help {
    display: block;
    margin-top: 8px;
    font-size: 13px;
    color: #858796;
    line-height: 1.5;
}

/* Section Divider */
.section-divider {
    height: 2px;
    background: linear-gradient(90deg, transparent, #e3e6f0, transparent);
    margin: 30px 0;
}

.section-title {
    font-size: 18px;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
    flex-wrap: wrap;
}

.btn-save {
    padding: 12px 30px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border: none;
    border-radius: 6px;
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
}

.btn-cancel {
    padding: 12px 30px;
    background: #6c757d;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-weight: 700;
    font-size: 15px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-cancel:hover {
    background: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(108, 117, 125, 0.3);
    color: #fff;
    text-decoration: none;
}

/* Sidebar */
.settings-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.sidebar-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
}

.sidebar-header {
    background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
    padding: 15px 20px;
}

.sidebar-warning .sidebar-header {
    background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
}

.sidebar-title {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 8px;
}

.sidebar-body {
    padding: 20px;
}

/* Help Sections */
.help-section {
    margin-bottom: 15px;
}

.help-section:last-child {
    margin-bottom: 0;
}

.help-title {
    font-size: 15px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 8px;
}

.help-text {
    font-size: 13px;
    color: #858796;
    line-height: 1.6;
    margin: 0;
}

.help-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, #e3e6f0, transparent);
    margin: 15px 0;
}

/* Notes List */
.notes-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.notes-list li {
    padding: 8px 0;
    padding-left: 25px;
    position: relative;
    font-size: 13px;
    color: #2c3e50;
    line-height: 1.5;
}

.notes-list li:before {
    content: "⚠";
    position: absolute;
    left: 0;
    color: #f6c23e;
    font-weight: 700;
    font-size: 16px;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .settings-grid {
        grid-template-columns: 1fr;
    }
    
    .settings-sidebar {
        order: -1;
    }
}

@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-back {
        width: 100%;
        justify-content: center;
    }
    
    .settings-title {
        font-size: 22px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-save,
    .btn-cancel {
        width: 100%;
        justify-content: center;
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

.settings-card,
.sidebar-card {
    animation: fadeIn 0.5s ease-out;
}
</style>
