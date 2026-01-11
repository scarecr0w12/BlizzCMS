<div class="container mt-4">
    <h1 class="mb-4"><?= lang('leaderboards_pvp') ?></h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('leaderboards') ?>">Leaderboards</a></li>
            <li class="breadcrumb-item active">PvP Rankings</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><?= lang('leaderboards_rank') ?></th>
                            <th><?= lang('leaderboards_character') ?></th>
                            <th><?= lang('leaderboards_level') ?></th>
                            <th><?= lang('leaderboards_kills') ?></th>
                            <th><?= lang('leaderboards_honor_points') ?></th>
                            <th><?= lang('leaderboards_arena_points') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $rank = $offset + 1;
                        foreach ($rankings as $character): 
                        ?>
                        <tr>
                            <td><strong>#<?= $rank++ ?></strong></td>
                            <td>
                                <a href="<?= site_url("armory/character/{$character->name}") ?>">
                                    <?= htmlspecialchars($character->name) ?>
                                </a>
                            </td>
                            <td><?= $character->level ?></td>
                            <td><?= number_format($character->totalKills) ?></td>
                            <td><?= number_format($character->totalHonorPoints) ?></td>
                            <td><?= number_format($character->arenaPoints) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($total > $per_page): ?>
            <nav>
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= ceil($total / $per_page); $i++): ?>
                    <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                        <a class="page-link" href="<?= site_url("leaderboards/pvp?page={$i}") ?>">
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
