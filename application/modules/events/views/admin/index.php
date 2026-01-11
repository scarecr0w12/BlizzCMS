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
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Events</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['total_events']) ?></div>
                        </div>
                        <div class="text-right">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card border-left-success shadow h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Upcoming Events</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['upcoming_events']) ?></div>
                        </div>
                        <div class="text-right">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card border-left-info shadow h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Past Events</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['past_events']) ?></div>
                        </div>
                        <div class="text-right">
                            <i class="fas fa-history fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total RSVPs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['total_rsvps']) ?></div>
                        </div>
                        <div class="text-right">
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
/* Border utilities */
.border-left-primary { border-left: 4px solid #4e73df !important; }
.border-left-success { border-left: 4px solid #1cc88a !important; }
.border-left-info { border-left: 4px solid #36b9cc !important; }
.border-left-warning { border-left: 4px solid #f6c23e !important; }

/* Shadow and spacing */
.shadow { box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important; }
.h-100 { height: 100% !important; }

/* Text utilities */
.text-gray-800 { color: #5a5c69 !important; }
.text-gray-300 { color: #dddfeb !important; }
.text-xs { font-size: 0.75rem !important; }
.text-uppercase { text-transform: uppercase !important; }
.text-right { text-align: right !important; }
.text-center { text-align: center !important; }
.text-muted { color: #6c757d !important; }
.font-weight-bold { font-weight: 700 !important; }

/* Card utilities */
.card { border: 1px solid #e3e6f0; }
.card-body { padding: 1.25rem; }
.card-body.p-3 { padding: 0.75rem !important; }
.card-header { padding: 0.75rem 1.25rem; background-color: #f8f9fa; }

/* Typography */
.h5 { font-size: 1.25rem !important; }
.h6 { font-size: 1rem !important; margin-bottom: 0.5rem; }

/* Flexbox utilities */
.d-flex { display: flex !important; }
.align-items-center { align-items: center !important; }
.align-items-start { align-items: flex-start !important; }
.justify-content-between { justify-content: space-between !important; }
.justify-content-center { justify-content: center !important; }
.flex-grow-1 { flex-grow: 1 !important; }
.flex-wrap { flex-wrap: wrap !important; }

/* Margin utilities */
.m-0 { margin: 0 !important; }
.mb-0 { margin-bottom: 0 !important; }
.mb-1 { margin-bottom: 0.25rem !important; }
.mb-2 { margin-bottom: 0.5rem !important; }
.mb-3 { margin-bottom: 1rem !important; }
.mb-4 { margin-bottom: 1.5rem !important; }
.mr-1 { margin-right: 0.25rem !important; }
.mr-2 { margin-right: 0.5rem !important; }

/* Padding utilities */
.p-3 { padding: 0.75rem !important; }
.py-3 { padding-top: 0.75rem !important; padding-bottom: 0.75rem !important; }
.py-5 { padding-top: 3rem !important; padding-bottom: 3rem !important; }

/* Grid utilities */
.col { flex-basis: 0; flex-grow: 1; max-width: 100%; }
.col-auto { flex: 0 0 auto; width: auto; }
.no-gutters { margin-right: 0; margin-left: 0; }
.no-gutters > .col,
.no-gutters > [class*="col-"] { padding-right: 0; padding-left: 0; }

/* Badge utilities */
.badge { display: inline-block; padding: 0.25rem 0.6rem; font-size: 0.75rem; font-weight: 700; line-height: 1; border-radius: 0.25rem; }
.badge-primary { background-color: #4e73df; color: white; }
.badge-success { background-color: #1cc88a; color: white; }
.badge-danger { background-color: #e74c3c; color: white; }
.badge-warning { background-color: #f6c23e; color: #333; }
.badge-info { background-color: #36b9cc; color: white; }
.badge-secondary { background-color: #858796; color: white; }

/* Button utilities */
.btn { display: inline-block; padding: 0.375rem 0.75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; border-radius: 0.25rem; border: 1px solid transparent; cursor: pointer; }
.btn-sm { padding: 0.25rem 0.5rem; font-size: 0.875rem; }
.btn-primary { background-color: #4e73df; color: white; border-color: #4e73df; }
.btn-success { background-color: #1cc88a; color: white; border-color: #1cc88a; }
.btn-danger { background-color: #e74c3c; color: white; border-color: #e74c3c; }
.btn-info { background-color: #36b9cc; color: white; border-color: #36b9cc; }
.btn-secondary { background-color: #858796; color: white; border-color: #858796; }

/* List group utilities */
.list-group { display: flex; flex-direction: column; padding-left: 0; margin-bottom: 0; border: 1px solid #e3e6f0; border-radius: 0.25rem; }
.list-group-item { position: relative; display: block; padding: 0.75rem 1.25rem; background-color: #fff; border: 1px solid #e3e6f0; }
.list-group-item:first-child { border-top-left-radius: 0.25rem; border-top-right-radius: 0.25rem; }
.list-group-item:last-child { border-bottom-left-radius: 0.25rem; border-bottom-right-radius: 0.25rem; }
.list-group-flush { border-radius: 0; }
.list-group-flush > .list-group-item { border-width: 0 0 1px 0; }
.list-group-flush > .list-group-item:last-child { border-bottom-width: 0; }

/* Table utilities */
.table { width: 100%; margin-bottom: 1rem; border-collapse: collapse; }
.table th, .table td { padding: 0.75rem; border-bottom: 1px solid #dee2e6; }
.table thead th { border-bottom: 2px solid #dee2e6; background-color: #f8f9fa; font-weight: 700; }
.table-hover tbody tr:hover { background-color: #f5f5f5; }
.table-sm th, .table-sm td { padding: 0.3rem 0.6rem; }
.thead-light thead th { background-color: #f8f9fa; border-color: #dee2e6; }

/* Alert utilities */
.alert { position: relative; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.25rem; }
.alert-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
.alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
.alert-dismissible { padding-right: 4rem; }
.alert-dismissible .close { position: absolute; right: 0; top: 0; padding: 0.75rem 1.25rem; color: inherit; }

/* Responsive utilities */
@media (max-width: 576px) {
  .col-12 { flex: 0 0 100%; max-width: 100%; }
}
@media (min-width: 576px) {
  .col-sm-6 { flex: 0 0 50%; max-width: 50%; }
}
@media (min-width: 992px) {
  .col-lg-3 { flex: 0 0 25%; max-width: 25%; }
  .col-lg-6 { flex: 0 0 50%; max-width: 50%; }
}
</style>
