<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-cog"></i> <?= lang('notifications_preferences') ?>
        </h2>
        <a href="<?= site_url('notifications') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Notification Preferences</h5>
                </div>
                <div class="card-body">
                    <?= form_open('notifications/preferences') ?>
                    
                    <h6 class="mb-3">General Settings</h6>
                    
                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input" id="emailNotif" 
                               name="email_notifications" value="1" 
                               <?= $preferences->email_notifications ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="emailNotif">
                            <i class="fas fa-envelope"></i> <?= lang('notifications_pref_email') ?>
                        </label>
                        <small class="form-text text-muted">Receive notifications via email</small>
                    </div>

                    <div class="custom-control custom-switch mb-4">
                        <input type="checkbox" class="custom-control-input" id="browserNotif" 
                               name="browser_notifications" value="1" 
                               <?= $preferences->browser_notifications ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="browserNotif">
                            <i class="fas fa-desktop"></i> <?= lang('notifications_pref_browser') ?>
                        </label>
                        <small class="form-text text-muted">Receive browser push notifications</small>
                    </div>

                    <hr>

                    <h6 class="mb-3">Notification Types</h6>

                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input" id="notifyDonations" 
                               name="notify_donations" value="1" 
                               <?= $preferences->notify_donations ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="notifyDonations">
                            <i class="fas fa-coins text-warning"></i> <?= lang('notifications_pref_donations') ?>
                        </label>
                    </div>

                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input" id="notifyShop" 
                               name="notify_shop" value="1" 
                               <?= $preferences->notify_shop ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="notifyShop">
                            <i class="fas fa-shopping-cart text-primary"></i> <?= lang('notifications_pref_shop') ?>
                        </label>
                    </div>

                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input" id="notifyVotes" 
                               name="notify_votes" value="1" 
                               <?= $preferences->notify_votes ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="notifyVotes">
                            <i class="fas fa-thumbs-up text-success"></i> <?= lang('notifications_pref_votes') ?>
                        </label>
                    </div>

                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input" id="notifyNews" 
                               name="notify_news" value="1" 
                               <?= $preferences->notify_news ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="notifyNews">
                            <i class="fas fa-newspaper text-info"></i> <?= lang('notifications_pref_news') ?>
                        </label>
                    </div>

                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input" id="notifyEvents" 
                               name="notify_events" value="1" 
                               <?= $preferences->notify_events ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="notifyEvents">
                            <i class="fas fa-calendar text-danger"></i> <?= lang('notifications_pref_events') ?>
                        </label>
                    </div>

                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input" id="notifySystem" 
                               name="notify_system" value="1" 
                               <?= $preferences->notify_system ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="notifySystem">
                            <i class="fas fa-bell text-secondary"></i> <?= lang('notifications_pref_system') ?>
                        </label>
                    </div>

                    <hr>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Preferences
                    </button>
                    
                    <?= form_close() ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">About Notifications</h5>
                </div>
                <div class="card-body">
                    <p class="small text-muted">
                        Control how and when you receive notifications from the server.
                    </p>
                    <hr>
                    <p class="small text-muted mb-2">
                        <strong>Email Notifications:</strong> Sent to your registered email address
                    </p>
                    <p class="small text-muted mb-2">
                        <strong>Browser Notifications:</strong> Real-time desktop notifications
                    </p>
                    <p class="small text-muted mb-0">
                        <strong>In-App:</strong> Always visible in your notification center
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
