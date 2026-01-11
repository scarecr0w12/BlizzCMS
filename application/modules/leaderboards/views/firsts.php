<div class="container mt-4">
    <h1 class="mb-4"><?= lang('leaderboards_firsts') ?></h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('leaderboards') ?>">Leaderboards</a></li>
            <li class="breadcrumb-item active">Server Firsts</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?= lang('leaderboards_first_max') ?></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Character</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($first_80s as $first): ?>
                                <tr>
                                    <td>
                                        <a href="<?= site_url("armory/character/{$first->achievement_value}") ?>">
                                            <?= htmlspecialchars($first->achievement_value) ?>
                                        </a>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($first->achievement_date)) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?= lang('leaderboards_first_kills') ?></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Boss</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($first_kills as $kill): ?>
                                <tr>
                                    <td><?= htmlspecialchars($kill->achievement_value) ?></td>
                                    <td><?= date('M d, Y', strtotime($kill->achievement_date)) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?= lang('leaderboards_first_achievements') ?></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Achievement</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($first_achievements as $achievement): ?>
                                <tr>
                                    <td><?= htmlspecialchars($achievement->achievement_value) ?></td>
                                    <td><?= date('M d, Y', strtotime($achievement->achievement_date)) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
