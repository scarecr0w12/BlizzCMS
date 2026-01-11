<div class="container mt-4">
    <h1 class="mb-4"><?= lang('leaderboards_arena') ?></h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('leaderboards') ?>">Leaderboards</a></li>
            <li class="breadcrumb-item active">Arena Rankings</li>
        </ol>
    </nav>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link <?= $type === '2v2' ? 'active' : '' ?>" href="<?= site_url('leaderboards/arena?type=2v2') ?>">
                <?= lang('leaderboards_2v2') ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $type === '3v3' ? 'active' : '' ?>" href="<?= site_url('leaderboards/arena?type=3v3') ?>">
                <?= lang('leaderboards_3v3') ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $type === '5v5' ? 'active' : '' ?>" href="<?= site_url('leaderboards/arena?type=5v5') ?>">
                <?= lang('leaderboards_5v5') ?>
            </a>
        </li>
    </ul>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><?= lang('leaderboards_rank') ?></th>
                            <th>Team Name</th>
                            <th><?= lang('leaderboards_rating') ?></th>
                            <th><?= lang('leaderboards_games') ?></th>
                            <th><?= lang('leaderboards_wins') ?></th>
                            <th>Win Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (empty($rankings)): 
                        ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <?= lang('leaderboards_no_data') ?>
                            </td>
                        </tr>
                        <?php else:
                        $rank = $offset + 1;
                        foreach ($rankings as $team): 
                            $win_rate = $team->seasonGames > 0 ? round(($team->seasonWins / $team->seasonGames) * 100, 1) : 0;
                        ?>
                        <tr>
                            <td><strong>#<?= $rank++ ?></strong></td>
                            <td><?= htmlspecialchars($team->name) ?></td>
                            <td><strong><?= $team->rating ?></strong></td>
                            <td><?= $team->seasonGames ?></td>
                            <td><?= $team->seasonWins ?></td>
                            <td><?= $win_rate ?>%</td>
                        </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($total > $per_page): ?>
            <nav>
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= ceil($total / $per_page); $i++): ?>
                    <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                        <a class="page-link" href="<?= site_url("leaderboards/arena?type={$type}&page={$i}") ?>">
                            <?= $i ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </div>
</div>
