<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-edit text-primary"></i> Edit Event
        </h2>
        <a href="<?= site_url('events/admin') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Events
        </a>
    </div>

    <?php if (validation_errors()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> <strong>Validation Error:</strong>
        <?= validation_errors() ?>
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
                        <i class="fas fa-calendar-alt"></i> Event Details
                    </h6>
                </div>
                <div class="card-body">
                    <?= form_open('events/admin/edit/' . $event->id, ['class' => 'needs-validation']) ?>
                    
                    <div class="form-group">
                        <label for="title"><i class="fas fa-heading"></i> Event Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?= set_value('title', $event->title) ?>" required maxlength="255"
                               placeholder="Enter event title">
                    </div>

                    <div class="form-group">
                        <label for="description"><i class="fas fa-align-left"></i> Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="6" 
                                  required placeholder="Enter event description"><?= set_value('description', $event->description) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_type"><i class="fas fa-tag"></i> Event Type <span class="text-danger">*</span></label>
                                <select class="form-control" id="event_type" name="event_type" required>
                                    <option value="">-- Select Type --</option>
                                    <?php foreach ($event_types as $type): ?>
                                    <option value="<?= $type ?>" <?= set_select('event_type', $type, $event->event_type == $type) ?>>
                                        <?= ucfirst($type) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="realm_id"><i class="fas fa-server"></i> Realm</label>
                                <select class="form-control" id="realm_id" name="realm_id">
                                    <option value="">-- All Realms --</option>
                                    <?php if (!empty($realms)): ?>
                                        <?php foreach ($realms as $realm): ?>
                                        <option value="<?= $realm->id ?>" <?= set_select('realm_id', $realm->id, $event->realm_id == $realm->id) ?>>
                                            <?= htmlspecialchars($realm->name) ?>
                                        </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="location"><i class="fas fa-map-marker-alt"></i> Location</label>
                        <input type="text" class="form-control" id="location" name="location" 
                               value="<?= set_value('location', $event->location) ?>" maxlength="255"
                               placeholder="e.g., Orgrimmar, Ironforge">
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date"><i class="fas fa-calendar-day"></i> Start Date & Time <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" id="start_date" name="start_date" 
                                       value="<?= set_value('start_date', date('Y-m-d\TH:i', strtotime($event->start_date))) ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date"><i class="fas fa-calendar-check"></i> End Date & Time</label>
                                <input type="datetime-local" class="form-control" id="end_date" name="end_date" 
                                       value="<?= set_value('end_date', $event->end_date ? date('Y-m-d\TH:i', strtotime($event->end_date)) : '') ?>">
                                <small class="form-text text-muted">Optional - leave blank for single-time events</small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label for="max_participants"><i class="fas fa-users"></i> Max Participants</label>
                        <input type="number" class="form-control" id="max_participants" name="max_participants" 
                               value="<?= set_value('max_participants', $event->max_participants) ?>" min="1" max="1000"
                               placeholder="Leave empty for unlimited">
                        <small class="form-text text-muted">Set a limit for event participants (e.g., 10, 25, 40)</small>
                    </div>

                    <div class="card bg-light border mb-3">
                        <div class="card-body">
                            <h6 class="card-title"><i class="fas fa-cog"></i> Event Options</h6>
                            
                            <div class="custom-control custom-switch mb-2">
                                <input type="checkbox" class="custom-control-input" id="require_rsvp" 
                                       name="require_rsvp" value="1" <?= set_checkbox('require_rsvp', '1', $event->require_rsvp) ?>>
                                <label class="custom-control-label" for="require_rsvp">
                                    <i class="fas fa-check-square"></i> Require RSVP
                                </label>
                            </div>

                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="featured" 
                                       name="featured" value="1" <?= set_checkbox('featured', '1', $event->featured) ?>>
                                <label class="custom-control-label" for="featured">
                                    <i class="fas fa-star"></i> Featured Event
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="<?= site_url('events/admin') ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Update Event
                        </button>
                    </div>

                    <?= form_close() ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle"></i> Event Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong><i class="fas fa-hashtag"></i> Event ID:</strong>
                        <span class="badge badge-secondary"><?= $event->id ?></span>
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-clock"></i> Created:</strong><br>
                        <small class="text-muted"><?= date('M d, Y H:i', strtotime($event->created_at)) ?></small>
                    </div>
                    <?php if ($event->updated_at): ?>
                    <div class="mb-3">
                        <strong><i class="fas fa-edit"></i> Last Updated:</strong><br>
                        <small class="text-muted"><?= date('M d, Y H:i', strtotime($event->updated_at)) ?></small>
                    </div>
                    <?php endif; ?>
                    <hr>
                    <div class="mb-2">
                        <strong><i class="fas fa-users"></i> RSVPs:</strong>
                        <span class="badge badge-primary"><?= count($rsvps) ?></span>
                    </div>
                    <?php if ($event->max_participants): ?>
                    <div class="mb-2">
                        <strong><i class="fas fa-percentage"></i> Capacity:</strong>
                        <span class="badge badge-<?= count($rsvps) >= $event->max_participants ? 'danger' : 'success' ?>">
                            <?= count($rsvps) ?> / <?= $event->max_participants ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($rsvps)): ?>
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-users"></i> RSVPs (<?= count($rsvps) ?>)
                    </h6>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <div class="list-group list-group-flush">
                        <?php foreach ($rsvps as $rsvp): ?>
                        <div class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <?php if ($rsvp->character_name): ?>
                                    <strong><?= htmlspecialchars($rsvp->character_name) ?></strong>
                                    <?php if ($rsvp->character_class): ?>
                                    <br><small class="text-muted"><?= htmlspecialchars($rsvp->character_class) ?></small>
                                    <?php endif; ?>
                                    <?php else: ?>
                                    <strong>User #<?= $rsvp->user_id ?></strong>
                                    <?php endif; ?>
                                </div>
                                <span class="badge badge-<?= $rsvp->status === 'attending' ? 'success' : 'secondary' ?>">
                                    <?= ucfirst($rsvp->status) ?>
                                </span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.shadow { box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15) !important; }
</style>
