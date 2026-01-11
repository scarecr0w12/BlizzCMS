<div class="container mt-4">
    <h1 class="mb-4"><?= lang('leaderboards_title') ?></h1>

    <div class="row">
        <?php foreach ($categories as $key => $name): ?>
        <div class="col-md-4 mb-3">
            <a href="<?= site_url("leaderboards/{$key}") ?>" class="card text-decoration-none">
                <div class="card-body text-center">
                    <h3><?= $name ?></h3>
                    <i class="fas fa-trophy fa-3x text-warning mt-2"></i>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?= lang('leaderboards_firsts') ?></h5>
                </div>
                <div class="card-body">
                    <a href="<?= site_url('leaderboards/firsts') ?>" class="btn btn-primary">
                        View Server Firsts
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}
</style>
