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
            <h1><?php echo lang('pvpstats_admin'); ?></h1>
            <hr>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo lang('total_matches'); ?></h5>
                    <p class="card-text display-4"><?php echo $total_battlegrounds; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo lang('today'); ?></h5>
                    <p class="card-text display-4"><?php echo $today_battlegrounds; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Players -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h3><?php echo lang('top_players'); ?></h3>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th><?php echo lang('name'); ?></th>
                            <th><?php echo lang('class'); ?></th>
                            <th><?php echo lang('total_kills'); ?></th>
                            <th><?php echo lang('matches_played'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($top_players)): ?>
                            <?php foreach ($top_players as $player): ?>
                                <tr>
                                    <td><?php echo $player->name; ?></td>
                                    <td><?php echo class_name($player->class); ?></td>
                                    <td><?php echo $player->total_kills; ?></td>
                                    <td><?php echo $player->matches_played; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center"><?php echo lang('no_data'); ?></td>
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
                            <th><?php echo lang('bracket'); ?></th>
                            <th><?php echo lang('winner'); ?></th>
                            <th><?php echo lang('start_time'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recent_battlegrounds)): ?>
                            <?php foreach ($recent_battlegrounds as $bg): ?>
                                <tr>
                                    <td><?php echo $bg->type; ?></td>
                                    <td><?php echo $bg->bracket_id; ?></td>
                                    <td><?php echo ($bg->winner == 0) ? lang('alliance') : lang('horde'); ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', strtotime($bg->start_time)); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center"><?php echo lang('no_data'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Admin Links -->
    <div class="row mt-4">
        <div class="col-md-12">
            <a href="<?php echo site_url('pvpstats/admin/settings'); ?>" class="btn btn-primary">
                <?php echo lang('pvpstats_settings'); ?>
            </a>
        </div>
    </div>
</div>
