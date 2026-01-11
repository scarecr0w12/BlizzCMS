<div class="container mt-4">
    <h1 class="mb-4"><?= lang('leaderboards_guilds') ?></h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('leaderboards') ?>">Leaderboards</a></li>
            <li class="breadcrumb-item active">Guild Rankings</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><?= lang('leaderboards_rank') ?></th>
                            <th><?= lang('leaderboards_guild_name') ?></th>
                            <th><?= lang('leaderboards_members') ?></th>
                            <th><?= lang('leaderboards_total_levels') ?></th>
                            <th>Average Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (empty($rankings)): 
                        ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <?= lang('leaderboards_no_data') ?>
                            </td>
                        </tr>
                        <?php else:
                        $rank = $offset + 1;
                        foreach ($rankings as $guild): 
                            $avg_level = $guild->member_count > 0 ? round($guild->total_levels / $guild->member_count, 1) : 0;
                        ?>
                        <tr>
                            <td><strong>#<?= $rank++ ?></strong></td>
                            <td>
                                <a href="<?= site_url("armory/guild/{$guild->name}") ?>">
                                    <?= htmlspecialchars($guild->name) ?>
                                </a>
                            </td>
                            <td><?= $guild->member_count ?></td>
                            <td><?= number_format($guild->total_levels) ?></td>
                            <td><?= $avg_level ?></td>
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
                        <a class="page-link" href="<?= site_url("leaderboards/guilds?page={$i}") ?>">
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
