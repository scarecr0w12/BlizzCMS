<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h2 class="mb-2">
                    <i class="fas fa-search text-primary"></i> Search Events
                </h2>
                <a href="<?= site_url('events') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Events
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?= form_open('events/search', ['method' => 'get', 'class' => 'form-inline']) ?>
            <div class="form-group mr-2 flex-grow-1">
                <input type="text" class="form-control w-100" name="q" placeholder="Search events..." 
                       value="<?= htmlspecialchars($query) ?>">
            </div>
            <div class="form-group mr-2">
                <select class="form-control" name="type">
                    <option value="all" <?= $type === 'all' ? 'selected' : '' ?>>All Types</option>
                    <option value="raid" <?= $type === 'raid' ? 'selected' : '' ?>>Raid</option>
                    <option value="dungeon" <?= $type === 'dungeon' ? 'selected' : '' ?>>Dungeon</option>
                    <option value="pvp" <?= $type === 'pvp' ? 'selected' : '' ?>>PvP</option>
                    <option value="tournament" <?= $type === 'tournament' ? 'selected' : '' ?>>Tournament</option>
                    <option value="guild" <?= $type === 'guild' ? 'selected' : '' ?>>Guild</option>
                    <option value="other" <?= $type === 'other' ? 'selected' : '' ?>>Other</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Search
            </button>
            <?= form_close() ?>
        </div>
    </div>

    <?php if ($query): ?>
    <div class="mb-3">
        <p class="text-muted">
            Found <strong><?= count($events) ?></strong> event<?= count($events) !== 1 ? 's' : '' ?> 
            matching "<strong><?= htmlspecialchars($query) ?></strong>"
            <?php if ($type !== 'all'): ?>
            in category "<strong><?= ucfirst($type) ?></strong>"
            <?php endif; ?>
        </p>
    </div>

    <?php if (empty($events)): ?>
    <div class="card shadow text-center py-5">
        <div class="card-body">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <p class="text-muted">No events found matching your search criteria.</p>
            <p class="text-muted small">Try different keywords or browse all events.</p>
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
                    </div>
                    <a href="<?= site_url('events/view/' . $event->id) ?>" class="btn btn-primary btn-sm btn-block mt-3">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php else: ?>
    <div class="card shadow text-center py-5">
        <div class="card-body">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <p class="text-muted">Enter a search term to find events.</p>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.shadow { box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15) !important; }
</style>
