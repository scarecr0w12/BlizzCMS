<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-bell text-warning"></i> <?= lang('notifications_title') ?>
        </h2>
        <div>
            <a href="<?= site_url('notifications/preferences') ?>" class="btn btn-secondary mr-2">
                <i class="fas fa-cog"></i> Preferences
            </a>
            <?php if ($unread_count > 0): ?>
            <a href="<?= site_url('notifications/mark_all_read') ?>" class="btn btn-primary">
                <i class="fas fa-check-double"></i> <?= lang('notifications_mark_all_read') ?>
            </a>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-inbox"></i> All Notifications
                    </h6>
                    <span class="badge badge-warning"><?= $unread_count ?> Unread</span>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($notifications)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-bell-slash fa-3x mb-3"></i>
                        <p><?= lang('notifications_empty') ?></p>
                    </div>
                    <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($notifications as $notification): ?>
                        <div class="list-group-item list-group-item-action <?= $notification->is_read ? '' : 'list-group-item-light font-weight-bold' ?>">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas <?= $notification->icon ?> fa-2x text-primary mr-3"></i>
                                        <div>
                                            <h6 class="mb-1"><?= htmlspecialchars($notification->title) ?></h6>
                                            <small class="text-muted">
                                                <i class="fas fa-clock"></i> 
                                                <?= timespan(strtotime($notification->created_at), time(), 2) ?> ago
                                            </small>
                                        </div>
                                    </div>
                                    <?php if ($notification->message): ?>
                                    <p class="mb-2"><?= htmlspecialchars($notification->message) ?></p>
                                    <?php endif; ?>
                                    <?php if ($notification->link): ?>
                                    <a href="<?= $notification->link ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt"></i> View Details
                                    </a>
                                    <?php endif; ?>
                                </div>
                                <div class="ml-3">
                                    <?php if (!$notification->is_read): ?>
                                    <a href="<?= site_url('notifications/mark_read/' . $notification->id) ?>" 
                                       class="btn btn-sm btn-success mb-1" title="Mark as read">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <?php endif; ?>
                                    <a href="<?= site_url('notifications/delete/' . $notification->id) ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Delete this notification?')" 
                                       title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>
