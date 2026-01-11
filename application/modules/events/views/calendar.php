<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h2 class="mb-2">
                    <i class="fas fa-calendar-grid text-primary"></i> Events Calendar - <?= $current_month ?>
                </h2>
                <div class="mb-2">
                    <a href="<?= site_url('events/calendar?month=' . ($month > 1 ? $month - 1 : 12) . '&year=' . ($month > 1 ? $year : $year - 1)) ?>" class="btn btn-secondary mr-2">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                    <a href="<?= site_url('events') ?>" class="btn btn-info mr-2">
                        <i class="fas fa-list"></i> List View
                    </a>
                    <a href="<?= site_url('events/calendar?month=' . ($month < 12 ? $month + 1 : 1) . '&year=' . ($month < 12 ? $year : $year + 1)) ?>" class="btn btn-secondary">
                        <i class="fas fa-chevron-right"></i> Next
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0" style="table-layout: fixed;">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" style="width: 14.28%;">Sunday</th>
                            <th class="text-center" style="width: 14.28%;">Monday</th>
                            <th class="text-center" style="width: 14.28%;">Tuesday</th>
                            <th class="text-center" style="width: 14.28%;">Wednesday</th>
                            <th class="text-center" style="width: 14.28%;">Thursday</th>
                            <th class="text-center" style="width: 14.28%;">Friday</th>
                            <th class="text-center" style="width: 14.28%;">Saturday</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($calendar_days as $week): ?>
                        <tr>
                            <?php foreach ($week as $day_data): ?>
                            <td style="height: 120px; vertical-align: top; background-color: <?= $day_data['day'] ? '#fff' : '#f8f9fa' ?>;">
                                <?php if ($day_data['day']): ?>
                                <div class="mb-2">
                                    <strong class="text-muted"><?= $day_data['day'] ?></strong>
                                </div>
                                <div style="max-height: 90px; overflow-y: auto;">
                                    <?php foreach ($day_data['events'] as $event): ?>
                                    <a href="<?= site_url('events/view/' . $event->id) ?>" class="badge badge-<?= $event->event_type === 'raid' ? 'danger' : ($event->event_type === 'pvp' ? 'warning' : 'info') ?> d-block mb-1 text-truncate" title="<?= htmlspecialchars($event->title) ?>">
                                        <?= htmlspecialchars(substr($event->title, 0, 20)) ?>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if (!empty($events)): ?>
    <div class="card shadow mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list"></i> Events in <?= $current_month ?>
            </h6>
        </div>
        <div class="card-body">
            <div class="list-group">
                <?php foreach ($events as $event): ?>
                <a href="<?= site_url('events/view/' . $event->id) ?>" class="list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="mb-1"><?= htmlspecialchars($event->title) ?></h6>
                            <p class="mb-1 text-muted small">
                                <i class="fas fa-clock"></i> <?= date('M d, Y H:i', strtotime($event->start_date)) ?>
                                <span class="badge badge-<?= $event->event_type === 'raid' ? 'danger' : ($event->event_type === 'pvp' ? 'warning' : 'info') ?> ml-2">
                                    <?= ucfirst($event->event_type) ?>
                                </span>
                            </p>
                            <?php if ($event->location): ?>
                            <p class="mb-0 text-muted small">
                                <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($event->location) ?>
                            </p>
                            <?php endif; ?>
                        </div>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="card shadow mt-4 text-center py-5">
        <div class="card-body">
            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
            <p class="text-muted">No events scheduled for <?= $current_month ?></p>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.shadow { box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15) !important; }
</style>
