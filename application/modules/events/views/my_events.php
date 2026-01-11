<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h2 class="mb-2">
                    <i class="fas fa-star text-primary"></i> My Events
                </h2>
                <a href="<?= site_url('events') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Events
                </a>
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

    <?php if (empty($events)): ?>
    <div class="card shadow text-center py-5">
        <div class="card-body">
            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
            <p class="text-muted mb-3">You haven't RSVPed to any upcoming events yet.</p>
            <a href="<?= site_url('events') ?>" class="btn btn-primary">
                <i class="fas fa-calendar-alt"></i> Browse Events
            </a>
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
                    
                    <div class="mb-3">
                        <span class="badge badge-<?= $event->status === 'attending' ? 'success' : ($event->status === 'tentative' ? 'warning' : 'secondary') ?>">
                            <i class="fas fa-check-circle"></i> <?= ucfirst($event->status) ?>
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
                    </div>
                    
                    <div class="d-flex gap-2 mt-3">
                        <a href="<?= site_url('events/view/' . $event->id) ?>" class="btn btn-primary btn-sm flex-grow-1">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="<?= site_url('events/cancel_rsvp/' . $event->id) ?>" class="btn btn-danger btn-sm" 
                           onclick="return confirm('Are you sure you want to cancel your RSVP?')" title="Cancel RSVP">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<style>
.shadow { box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15) !important; }
.gap-2 { gap: 0.5rem; }
</style>
