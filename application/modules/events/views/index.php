<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h2 class="mb-2">
                    <i class="fas fa-calendar-alt text-success"></i> Events Calendar
                </h2>
                <div class="mb-2">
                    <a href="<?= site_url('events/calendar') ?>" class="btn btn-info mr-2">
                        <i class="fas fa-calendar-grid"></i> Calendar View
                    </a>
                    <?php if ($this->session->userdata('user_id')): ?>
                    <a href="<?= site_url('events/my-events') ?>" class="btn btn-primary">
                        <i class="fas fa-star"></i> My Events
                    </a>
                    <?php endif; ?>
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

    <?php if (!empty($featured_events)): ?>
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-3">
                <i class="fas fa-star text-warning"></i> Featured Events
            </h4>
        </div>
        <?php foreach ($featured_events as $event): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card shadow h-100 border-left-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0"><?= htmlspecialchars($event->title) ?></h5>
                        <span class="badge badge-warning">Featured</span>
                    </div>
                    <p class="text-muted small mb-2">
                        <i class="fas fa-tag"></i> <?= ucfirst($event->event_type) ?>
                    </p>
                    <p class="card-text text-muted small"><?= substr(htmlspecialchars($event->description), 0, 100) ?>...</p>
                    <div class="mt-3">
                        <p class="mb-2">
                            <i class="fas fa-clock text-info"></i>
                            <strong><?= date('M d, Y H:i', strtotime($event->start_date)) ?></strong>
                        </p>
                        <?php if ($event->location): ?>
                        <p class="mb-2">
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            <?= htmlspecialchars($event->location) ?>
                        </p>
                        <?php endif; ?>
                        <?php if ($event->max_participants): ?>
                        <p class="mb-3">
                            <i class="fas fa-users text-success"></i>
                            <strong><?php 
                                $rsvp_count = $this->db->where('event_id', $event->id)->where('status', 'attending')->count_all_results('event_rsvps');
                                echo $rsvp_count . ' / ' . $event->max_participants;
                            ?></strong> Participants
                        </p>
                        <?php endif; ?>
                    </div>
                    <a href="<?= site_url('events/view/' . $event->id) ?>" class="btn btn-warning btn-sm btn-block">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-3">
                <i class="fas fa-calendar-check text-success"></i> Upcoming Events
            </h4>
        </div>
    </div>

    <?php if (empty($events)): ?>
    <div class="row">
        <div class="col-12">
            <div class="card shadow text-center py-5">
                <div class="card-body">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No upcoming events scheduled.</p>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="row">
        <?php foreach ($events as $event): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0"><?= htmlspecialchars($event->title) ?></h5>
                        <span class="badge badge-<?= $event->event_type === 'raid' ? 'danger' : ($event->event_type === 'pvp' ? 'warning' : 'info') ?>">
                            <?= ucfirst($event->event_type) ?>
                        </span>
                    </div>
                    <p class="card-text text-muted small"><?= substr(htmlspecialchars($event->description), 0, 100) ?>...</p>
                    <div class="mt-3">
                        <p class="mb-2">
                            <i class="fas fa-clock text-info"></i>
                            <strong><?= date('M d, Y H:i', strtotime($event->start_date)) ?></strong>
                        </p>
                        <?php if ($event->location): ?>
                        <p class="mb-2">
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            <?= htmlspecialchars($event->location) ?>
                        </p>
                        <?php endif; ?>
                        <?php if ($event->max_participants): ?>
                        <p class="mb-3">
                            <i class="fas fa-users text-success"></i>
                            <strong><?php 
                                $rsvp_count = $this->db->where('event_id', $event->id)->where('status', 'attending')->count_all_results('event_rsvps');
                                echo $rsvp_count . ' / ' . $event->max_participants;
                            ?></strong> Participants
                        </p>
                        <?php endif; ?>
                    </div>
                    <a href="<?= site_url('events/view/' . $event->id) ?>" class="btn btn-primary btn-sm btn-block">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if ($total_pages > 1): ?>
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="<?= site_url('events?page=1') ?>">First</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= site_url('events?page=' . ($page - 1)) ?>">Previous</a>
            </li>
            <?php endif; ?>

            <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link" href="<?= site_url('events?page=' . $i) ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="<?= site_url('events?page=' . ($page + 1)) ?>">Next</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= site_url('events?page=' . $total_pages) ?>">Last</a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
    <?php endif; ?>
</div>

<style>
.border-left-warning { border-left: 4px solid #f6c23e !important; }
.shadow { box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15) !important; }
</style>
