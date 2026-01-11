<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h2 class="mb-2">
                    <i class="fas fa-calendar-alt text-success"></i> Events Calendar Administration
                </h2>
                <div class="mb-2">
                    <a href="<?= site_url('events') ?>" class="btn btn-info mr-2" target="_blank">
                        <i class="fas fa-eye"></i> View Public
                    </a>
                    <a href="<?= site_url('events/admin/create') ?>" class="btn btn-success mr-2">
                        <i class="fas fa-plus"></i> Create Event
                    </a>
                    <a href="<?= site_url('events/admin/settings') ?>" class="btn btn-primary">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </div>
            </div>
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

    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Events</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['total_events']) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Upcoming Events</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['upcoming_events']) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Past Events</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['past_events']) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-history fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total RSVPs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['total_rsvps']) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-calendar-check"></i> Upcoming Events
                    </h6>
                    <span class="badge badge-success"><?= count($upcoming_events) ?> Events</span>
                </div>
                <div class="card-body">
                    <?php if (empty($upcoming_events)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-calendar-times fa-3x mb-3"></i>
                        <p>No upcoming events scheduled.</p>
                        <a href="<?= site_url('events/admin/create') ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Create First Event
                        </a>
                    </div>
                    <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($upcoming_events as $event): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1"><?= htmlspecialchars($event->title) ?></h6>
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> <?= date('M d, Y H:i', strtotime($event->start_date)) ?>
                                </small>
                                <br>
                                <span class="badge badge-<?= $event->event_type === 'raid' ? 'danger' : ($event->event_type === 'pvp' ? 'warning' : 'info') ?>">
                                    <?= ucfirst($event->event_type) ?>
                                </span>
                                <?php if ($event->featured): ?>
                                <span class="badge badge-primary">Featured</span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <a href="<?= site_url('events/admin/edit/' . $event->id) ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Module Information
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-3"><strong>Event Calendar Management</strong></p>
                    <p class="text-muted small">Manage server events including raids, dungeons, PvP tournaments, and guild activities. Track RSVPs and participant details.</p>
                    
                    <hr>
                    
                    <p class="mb-2"><strong>Features:</strong></p>
                    <ul class="small text-muted mb-3">
                        <li>RSVP system with character tracking</li>
                        <li>Multiple event types support</li>
                        <li>Participant limits and management</li>
                        <li>Featured events highlighting</li>
                        <li>Realm-specific event filtering</li>
                        <li>Email reminder notifications</li>
                    </ul>
                    
                    <hr>
                    
                    <p class="mb-2"><strong>Event Types:</strong></p>
                    <div class="d-flex flex-wrap">
                        <span class="badge badge-danger mr-1 mb-1">Raid</span>
                        <span class="badge badge-primary mr-1 mb-1">Dungeon</span>
                        <span class="badge badge-warning mr-1 mb-1">PvP</span>
                        <span class="badge badge-info mr-1 mb-1">Tournament</span>
                        <span class="badge badge-success mr-1 mb-1">Guild</span>
                        <span class="badge badge-secondary mr-1 mb-1">Other</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($recent_events)): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list"></i> Recently Created Events
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th><i class="fas fa-hashtag"></i> ID</th>
                            <th><i class="fas fa-text-width"></i> Title</th>
                            <th><i class="fas fa-tag"></i> Type</th>
                            <th><i class="fas fa-calendar"></i> Start Date</th>
                            <th><i class="fas fa-check-circle"></i> Status</th>
                            <th class="text-right"><i class="fas fa-tools"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_events as $event): ?>
                        <tr>
                            <td><span class="badge badge-secondary"><?= $event->id ?></span></td>
                            <td>
                                <strong><?= htmlspecialchars($event->title) ?></strong>
                                <?php if ($event->featured): ?>
                                <span class="badge badge-primary badge-sm">Featured</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge badge-<?= $event->event_type === 'raid' ? 'danger' : ($event->event_type === 'pvp' ? 'warning' : 'info') ?>">
                                    <?= ucfirst($event->event_type) ?>
                                </span>
                            </td>
                            <td><?= date('M d, Y H:i', strtotime($event->start_date)) ?></td>
                            <td>
                                <?php if (strtotime($event->start_date) > time()): ?>
                                <span class="badge badge-success">Upcoming</span>
                                <?php else: ?>
                                <span class="badge badge-secondary">Past</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-right">
                                <a href="<?= site_url('events/admin/edit/' . $event->id) ?>" class="btn btn-sm btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= site_url('events/admin/delete/' . $event->id) ?>" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this event?')" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
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

<style>
.border-left-primary { border-left: 4px solid #4e73df !important; }
.border-left-success { border-left: 4px solid #1cc88a !important; }
.border-left-info { border-left: 4px solid #36b9cc !important; }
.border-left-warning { border-left: 4px solid #f6c23e !important; }
.shadow { box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15) !important; }
.text-gray-800 { color: #5a5c69 !important; }
.text-gray-300 { color: #dddfeb !important; }
.text-xs { font-size: 0.7rem; }
</style>
