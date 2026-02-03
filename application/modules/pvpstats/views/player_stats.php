<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo $player->name; ?> - <?php echo lang('pvpstats_player_stats'); ?></h1>
            <hr>
        </div>
    </div>

    <!-- Player Info Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $player->name; ?></h5>
                    <p class="card-text">
                        <strong><?php echo lang('class'); ?>:</strong> <?php echo class_name($player->class); ?><br>
                        <strong><?php echo lang('race'); ?>:</strong> <?php echo race_name($player->race); ?><br>
                        <strong><?php echo lang('level'); ?>:</strong> <?php echo $player->level; ?><br>
                        <strong><?php echo lang('faction'); ?>:</strong> <?php echo ($player->faction == 0) ? lang('alliance') : lang('horde'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Overall Statistics -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><?php echo lang('overall_statistics'); ?></h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <strong><?php echo lang('matches_played'); ?>:</strong> <?php echo $player->matches_played; ?><br>
                        <strong><?php echo lang('total_kills'); ?>:</strong> <?php echo $player->total_kills; ?><br>
                        <strong><?php echo lang('total_deaths'); ?>:</strong> <?php echo $player->total_deaths; ?><br>
                        <strong><?php echo lang('total_honorable_kills'); ?>:</strong> <?php echo $player->total_honorable_kills; ?><br>
                        <strong><?php echo lang('total_bonus_honor'); ?>:</strong> <?php echo $player->total_bonus_honor; ?><br>
                        <strong><?php echo lang('total_damage'); ?>:</strong> <?php echo number_format($player->total_damage); ?><br>
                        <strong><?php echo lang('total_healing'); ?>:</strong> <?php echo number_format($player->total_healing); ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><?php echo lang('averages'); ?></h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <strong><?php echo lang('avg_kills'); ?>:</strong> <?php echo $player->avg_kills; ?><br>
                        <strong><?php echo lang('avg_deaths'); ?>:</strong> <?php echo $player->avg_deaths; ?><br>
                        <strong><?php echo lang('avg_damage'); ?>:</strong> <?php echo number_format($player->avg_damage); ?><br>
                        <strong><?php echo lang('avg_healing'); ?>:</strong> <?php echo number_format($player->avg_healing); ?><br>
                        <?php if ($win_rate): ?>
                            <strong><?php echo lang('win_rate'); ?>:</strong> <?php echo $win_rate->win_rate; ?>%
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics by Battleground Type -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h3><?php echo lang('statistics_by_type'); ?></h3>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th><?php echo lang('type'); ?></th>
                            <th><?php echo lang('matches'); ?></th>
                            <th><?php echo lang('total_kills'); ?></th>
                            <th><?php echo lang('total_deaths'); ?></th>
                            <th><?php echo lang('total_damage'); ?></th>
                            <th><?php echo lang('total_healing'); ?></th>
                            <th><?php echo lang('avg_kills'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($stats_by_type)): ?>
                            <?php foreach ($stats_by_type as $stat): ?>
                                <tr>
                                    <td><?php echo $stat->type; ?></td>
                                    <td><?php echo $stat->matches; ?></td>
                                    <td><?php echo $stat->kills; ?></td>
                                    <td><?php echo $stat->deaths; ?></td>
                                    <td><?php echo number_format($stat->damage); ?></td>
                                    <td><?php echo number_format($stat->healing); ?></td>
                                    <td><?php echo $stat->avg_kills; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center"><?php echo lang('no_data'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Battlegrounds -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h3><?php echo lang('recent_battlegrounds'); ?></h3>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th><?php echo lang('type'); ?></th>
                            <th><?php echo lang('start_time'); ?></th>
                            <th><?php echo lang('killing_blows'); ?></th>
                            <th><?php echo lang('deaths'); ?></th>
                            <th><?php echo lang('damage_done'); ?></th>
                            <th><?php echo lang('healing_done'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($history)): ?>
                            <?php foreach ($history as $match): ?>
                                <tr>
                                    <td><?php echo $match->type; ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', strtotime($match->start_time)); ?></td>
                                    <td><?php echo $match->killing_blows; ?></td>
                                    <td><?php echo $match->deaths; ?></td>
                                    <td><?php echo number_format($match->damage_done); ?></td>
                                    <td><?php echo number_format($match->healing_done); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center"><?php echo lang('no_data'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <?php if ($history_count > $limit): ?>
        <div class="row mt-4">
            <div class="col-md-12">
                <nav>
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo site_url('pvpstats/player/' . urlencode($player->name) . '?page=' . ($page - 1)); ?>">
                                    <?php echo lang('previous'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= ceil($history_count / $limit); $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="<?php echo site_url('pvpstats/player/' . urlencode($player->name) . '?page=' . $i); ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < ceil($history_count / $limit)): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo site_url('pvpstats/player/' . urlencode($player->name) . '?page=' . ($page + 1)); ?>">
                                    <?php echo lang('next'); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    <?php endif; ?>

    <!-- Back Button -->
    <div class="row mt-4">
        <div class="col-md-12">
            <a href="<?php echo site_url('pvpstats/players'); ?>" class="btn btn-secondary">
                <?php echo lang('back'); ?>
            </a>
        </div>
    </div>
</div>
