<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <a href="<?= site_url('events') ?>" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Back to Events
            </a>
        </div>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h2 class="mb-2"><?= htmlspecialchars($event->title) ?></h2>
                            <span class="badge badge-<?= $event->event_type === 'raid' ? 'danger' : ($event->event_type === 'pvp' ? 'warning' : 'info') ?> mr-2">
                                <?= ucfirst($event->event_type) ?>
                            </span>
                            <?php if ($event->featured): ?>
                            <span class="badge badge-warning">
                                <i class="fas fa-star"></i> Featured
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="fas fa-calendar-day text-info"></i> Start Date & Time</strong>
                                <br>
                                <span class="text-muted"><?= date('F d, Y \a\t H:i', strtotime($event->start_date)) ?></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <?php if ($event->end_date): ?>
                            <p class="mb-2">
                                <strong><i class="fas fa-calendar-check text-success"></i> End Date & Time</strong>
                                <br>
                                <span class="text-muted"><?= date('F d, Y \a\t H:i', strtotime($event->end_date)) ?></span>
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($event->location): ?>
                    <p class="mb-3">
                        <strong><i class="fas fa-map-marker-alt text-danger"></i> Location</strong>
                        <br>
                        <span class="text-muted"><?= htmlspecialchars($event->location) ?></span>
                    </p>
                    <?php endif; ?>

                    <hr>

                    <h5 class="mb-3">
                        <i class="fas fa-align-left"></i> Description
                    </h5>
                    <p class="text-muted"><?= nl2br(htmlspecialchars($event->description)) ?></p>
                </div>
            </div>

            <?php if (!empty($rsvps)): ?>
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-users"></i> Participants (<?= count($rsvps) ?>)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th><i class="fas fa-user"></i> Character</th>
                                    <th><i class="fas fa-shield-alt"></i> Class</th>
                                    <th><i class="fas fa-check-circle"></i> Status</th>
                                    <th><i class="fas fa-comment"></i> Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rsvps as $rsvp): ?>
                                <tr>
                                    <td>
                                        <?php if ($rsvp->character_name): ?>
                                        <strong><?= htmlspecialchars($rsvp->character_name) ?></strong>
                                        <?php else: ?>
                                        <span class="text-muted">User #<?= $rsvp->user_id ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($rsvp->character_class): ?>
                                        <span class="badge badge-secondary"><?= htmlspecialchars($rsvp->character_class) ?></span>
                                        <?php else: ?>
                                        <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?= $rsvp->status === 'attending' ? 'success' : ($rsvp->status === 'tentative' ? 'warning' : 'secondary') ?>">
                                            <?= ucfirst($rsvp->status) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($rsvp->notes): ?>
                                        <small class="text-muted"><?= htmlspecialchars(substr($rsvp->notes, 0, 50)) ?></small>
                                        <?php else: ?>
                                        <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Event Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong><i class="fas fa-hashtag"></i> Event ID</strong>
                        <br>
                        <span class="badge badge-secondary"><?= $event->id ?></span>
                    </div>

                    <?php if ($event->max_participants): ?>
                    <div class="mb-3">
                        <strong><i class="fas fa-users"></i> Capacity</strong>
                        <br>
                        <div class="progress" style="height: 20px;">
                            <?php 
                                $percentage = ($rsvp_count / $event->max_participants) * 100;
                                $color = $percentage >= 100 ? 'danger' : ($percentage >= 75 ? 'warning' : 'success');
                            ?>
                            <div class="progress-bar bg-<?= $color ?>" role="progressbar" style="width: <?= min($percentage, 100) ?>%;" aria-valuenow="<?= $rsvp_count ?>" aria-valuemin="0" aria-valuemax="<?= $event->max_participants ?>">
                                <?= $rsvp_count ?> / <?= $event->max_participants ?>
                            </div>
                        </div>
                        <?php if ($rsvp_count >= $event->max_participants): ?>
                        <small class="text-danger"><i class="fas fa-exclamation-circle"></i> Event is full</small>
                        <?php else: ?>
                        <small class="text-success"><i class="fas fa-check-circle"></i> <?= $event->max_participants - $rsvp_count ?> slots available</small>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <hr>

                    <?php if ($is_logged_in): ?>
                    <div class="card bg-light border mb-3">
                        <div class="card-body">
                            <h6 class="card-title"><i class="fas fa-check-square"></i> Your RSVP</h6>
                            
                            <?php if ($user_rsvp): ?>
                            <div class="mb-3">
                                <p class="mb-2">
                                    <strong>Status:</strong>
                                    <span class="badge badge-<?= $user_rsvp->status === 'attending' ? 'success' : ($user_rsvp->status === 'tentative' ? 'warning' : 'secondary') ?>">
                                        <?= ucfirst($user_rsvp->status) ?>
                                    </span>
                                </p>
                                <?php if ($user_rsvp->character_name): ?>
                                <p class="mb-2">
                                    <strong>Character:</strong> <?= htmlspecialchars($user_rsvp->character_name) ?>
                                </p>
                                <?php endif; ?>
                                <?php if ($user_rsvp->character_class): ?>
                                <p class="mb-2">
                                    <strong>Class:</strong> <?= htmlspecialchars($user_rsvp->character_class) ?>
                                </p>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#rsvpModal">
                                    <i class="fas fa-edit"></i> Update RSVP
                                </button>
                                <a href="<?= site_url('events/cancel_rsvp/' . $event->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel your RSVP?')">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                            <?php else: ?>
                            <p class="text-muted small mb-3">You haven't RSVPed to this event yet.</p>
                            <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#rsvpModal">
                                <i class="fas fa-check"></i> RSVP Now
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <a href="<?= site_url('login') ?>">Log in</a> to RSVP to this event.
                    </div>
                    <?php endif; ?>

                    <hr>

                    <p class="text-muted small">
                        <strong><i class="fas fa-user-circle"></i> Created by:</strong>
                        <br>
                        User #<?= $event->created_by ?>
                    </p>

                    <p class="text-muted small">
                        <strong><i class="fas fa-calendar"></i> Created:</strong>
                        <br>
                        <?= date('M d, Y H:i', strtotime($event->created_at)) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($is_logged_in): ?>
<div class="modal fade" id="rsvpModal" tabindex="-1" role="dialog" aria-labelledby="rsvpModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rsvpModalLabel">
                    <i class="fas fa-check-square"></i> RSVP to Event
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('events/rsvp/' . $event->id) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="status"><i class="fas fa-check-circle"></i> Your Status <span class="text-danger">*</span></label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="">-- Select Status --</option>
                        <option value="attending" <?= $user_rsvp && $user_rsvp->status === 'attending' ? 'selected' : '' ?>>
                            <i class="fas fa-check"></i> Attending
                        </option>
                        <option value="tentative" <?= $user_rsvp && $user_rsvp->status === 'tentative' ? 'selected' : '' ?>>
                            <i class="fas fa-question"></i> Tentative
                        </option>
                        <option value="declined" <?= $user_rsvp && $user_rsvp->status === 'declined' ? 'selected' : '' ?>>
                            <i class="fas fa-times"></i> Declined
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="character_name"><i class="fas fa-user"></i> Character Name</label>
                    <input type="text" class="form-control" id="character_name" name="character_name" 
                           value="<?= $user_rsvp ? htmlspecialchars($user_rsvp->character_name) : '' ?>" 
                           maxlength="100" placeholder="Your character name">
                </div>

                <div class="form-group">
                    <label for="character_class"><i class="fas fa-shield-alt"></i> Character Class</label>
                    <select class="form-control" id="character_class" name="character_class">
                        <option value="">-- Select Class --</option>
                        <option value="Warrior" <?= $user_rsvp && $user_rsvp->character_class === 'Warrior' ? 'selected' : '' ?>>Warrior</option>
                        <option value="Paladin" <?= $user_rsvp && $user_rsvp->character_class === 'Paladin' ? 'selected' : '' ?>>Paladin</option>
                        <option value="Hunter" <?= $user_rsvp && $user_rsvp->character_class === 'Hunter' ? 'selected' : '' ?>>Hunter</option>
                        <option value="Rogue" <?= $user_rsvp && $user_rsvp->character_class === 'Rogue' ? 'selected' : '' ?>>Rogue</option>
                        <option value="Priest" <?= $user_rsvp && $user_rsvp->character_class === 'Priest' ? 'selected' : '' ?>>Priest</option>
                        <option value="Death Knight" <?= $user_rsvp && $user_rsvp->character_class === 'Death Knight' ? 'selected' : '' ?>>Death Knight</option>
                        <option value="Shaman" <?= $user_rsvp && $user_rsvp->character_class === 'Shaman' ? 'selected' : '' ?>>Shaman</option>
                        <option value="Mage" <?= $user_rsvp && $user_rsvp->character_class === 'Mage' ? 'selected' : '' ?>>Mage</option>
                        <option value="Warlock" <?= $user_rsvp && $user_rsvp->character_class === 'Warlock' ? 'selected' : '' ?>>Warlock</option>
                        <option value="Druid" <?= $user_rsvp && $user_rsvp->character_class === 'Druid' ? 'selected' : '' ?>>Druid</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="notes"><i class="fas fa-comment"></i> Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3" 
                              maxlength="500" placeholder="Any additional notes or comments"><?= $user_rsvp ? htmlspecialchars($user_rsvp->notes) : '' ?></textarea>
                    <small class="form-text text-muted">Max 500 characters</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Submit RSVP
                </button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?php endif; ?>

<style>
.shadow { box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15) !important; }
.gap-2 { gap: 0.5rem; }
</style>
