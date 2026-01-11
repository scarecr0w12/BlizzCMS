<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-cog text-primary"></i> Events Calendar Settings
        </h2>
        <a href="<?= site_url('events/admin') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-sliders-h"></i> Module Configuration
                    </h6>
                </div>
                <div class="card-body">
                    <?= form_open('events/admin/settings') ?>
                    
                    <div class="card bg-light border mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><i class="fas fa-check-square"></i> RSVP Settings</h5>
                            <p class="text-muted small">Configure how the RSVP system behaves for events.</p>
                            
                            <div class="custom-control custom-switch mb-3">
                                <input type="checkbox" class="custom-control-input" id="enable_rsvp" 
                                       name="enable_rsvp" value="1" 
                                       <?= isset($settings['enable_rsvp']) && $settings['enable_rsvp'] == '1' ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="enable_rsvp">
                                    <strong>Enable RSVP System</strong>
                                    <br><small class="text-muted">Allow users to RSVP to events</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-light border mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-success"><i class="fas fa-bell"></i> Reminder Settings</h5>
                            <p class="text-muted small">Configure event reminder notifications sent to participants.</p>
                            
                            <div class="custom-control custom-switch mb-3">
                                <input type="checkbox" class="custom-control-input" id="enable_reminders" 
                                       name="enable_reminders" value="1" 
                                       <?= isset($settings['enable_reminders']) && $settings['enable_reminders'] == '1' ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="enable_reminders">
                                    <strong>Enable Email Reminders</strong>
                                    <br><small class="text-muted">Send reminder emails before events start</small>
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="reminder_hours"><i class="fas fa-clock"></i> Reminder Time (Hours Before)</label>
                                <input type="number" class="form-control" id="reminder_hours" name="reminder_hours" 
                                       value="<?= isset($settings['reminder_hours']) ? $settings['reminder_hours'] : '24' ?>" 
                                       min="1" max="168" step="1">
                                <small class="form-text text-muted">How many hours before the event should reminders be sent (1-168)</small>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-light border mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-info"><i class="fas fa-calendar"></i> Event Display Settings</h5>
                            <p class="text-muted small">Control how events are displayed to users.</p>
                            
                            <div class="form-group">
                                <label for="default_event_length"><i class="fas fa-hourglass-half"></i> Default Event Length (Hours)</label>
                                <input type="number" class="form-control" id="default_event_length" name="default_event_length" 
                                       value="<?= isset($settings['default_event_length']) ? $settings['default_event_length'] : '2' ?>" 
                                       min="1" max="24" step="1">
                                <small class="form-text text-muted">Default duration for events when creating new ones (1-24 hours)</small>
                            </div>

                            <div class="form-group mb-0">
                                <label for="events_per_page"><i class="fas fa-list"></i> Events Per Page</label>
                                <input type="number" class="form-control" id="events_per_page" name="events_per_page" 
                                       value="<?= isset($settings['events_per_page']) ? $settings['events_per_page'] : '12' ?>" 
                                       min="6" max="50" step="6">
                                <small class="form-text text-muted">Number of events to display per page (6-50)</small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="<?= site_url('events/admin') ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Save Settings
                        </button>
                    </div>

                    <?= form_close() ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4 border-left-info">
                <div class="card-body">
                    <h5 class="text-info"><i class="fas fa-info-circle"></i> Settings Information</h5>
                    <hr>
                    
                    <h6 class="text-primary mt-3">RSVP System</h6>
                    <p class="small text-muted">When enabled, users can RSVP to events and specify their character details. Admins can track attendance and manage participant lists.</p>
                    
                    <h6 class="text-success mt-3">Email Reminders</h6>
                    <p class="small text-muted">Automatically sends email notifications to RSVPed participants before events start. Configure the timing to suit your server's needs.</p>
                    
                    <h6 class="text-info mt-3">Display Settings</h6>
                    <p class="small text-muted">Control default behaviors for event creation and how many events appear in calendar views.</p>
                </div>
            </div>

            <div class="card shadow border-left-warning">
                <div class="card-body">
                    <h5 class="text-warning"><i class="fas fa-exclamation-triangle"></i> Important Notes</h5>
                    <hr>
                    <ul class="small text-muted mb-0">
                        <li>Changes take effect immediately after saving</li>
                        <li>Email reminders require proper email configuration in BlizzCMS</li>
                        <li>Disabling RSVP won't delete existing RSVPs</li>
                        <li>Reminder hours apply to all future events</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-secondary">
                <i class="fas fa-database"></i> Current Settings Overview
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center mb-3">
                    <div class="p-3 bg-light rounded">
                        <i class="fas fa-check-square fa-2x text-<?= isset($settings['enable_rsvp']) && $settings['enable_rsvp'] == '1' ? 'success' : 'secondary' ?> mb-2"></i>
                        <h6 class="mb-1">RSVP System</h6>
                        <span class="badge badge-<?= isset($settings['enable_rsvp']) && $settings['enable_rsvp'] == '1' ? 'success' : 'secondary' ?>">
                            <?= isset($settings['enable_rsvp']) && $settings['enable_rsvp'] == '1' ? 'Enabled' : 'Disabled' ?>
                        </span>
                    </div>
                </div>
                <div class="col-md-3 text-center mb-3">
                    <div class="p-3 bg-light rounded">
                        <i class="fas fa-bell fa-2x text-<?= isset($settings['enable_reminders']) && $settings['enable_reminders'] == '1' ? 'success' : 'secondary' ?> mb-2"></i>
                        <h6 class="mb-1">Reminders</h6>
                        <span class="badge badge-<?= isset($settings['enable_reminders']) && $settings['enable_reminders'] == '1' ? 'success' : 'secondary' ?>">
                            <?= isset($settings['enable_reminders']) && $settings['enable_reminders'] == '1' ? 'Enabled' : 'Disabled' ?>
                        </span>
                    </div>
                </div>
                <div class="col-md-3 text-center mb-3">
                    <div class="p-3 bg-light rounded">
                        <i class="fas fa-clock fa-2x text-info mb-2"></i>
                        <h6 class="mb-1">Reminder Time</h6>
                        <span class="badge badge-info">
                            <?= isset($settings['reminder_hours']) ? $settings['reminder_hours'] : '24' ?> Hours
                        </span>
                    </div>
                </div>
                <div class="col-md-3 text-center mb-3">
                    <div class="p-3 bg-light rounded">
                        <i class="fas fa-list fa-2x text-primary mb-2"></i>
                        <h6 class="mb-1">Per Page</h6>
                        <span class="badge badge-primary">
                            <?= isset($settings['events_per_page']) ? $settings['events_per_page'] : '12' ?> Events
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.shadow { box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15) !important; }
.border-left-info { border-left: 4px solid #36b9cc !important; }
.border-left-warning { border-left: 4px solid #f6c23e !important; }
</style>
