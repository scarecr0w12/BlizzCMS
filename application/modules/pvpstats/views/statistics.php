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

<div class="uk-container">
    <div class="uk-margin-large-top">
        <h1><?php echo lang('pvpstats_statistics'); ?></h1>
        <hr class="uk-divider-icon">
    </div>

    <!-- Time Period Filter -->
    <div class="uk-margin-large">
        <div class="uk-button-group">
            <a href="<?php echo site_url('pvpstats/statistics?period=today'); ?>" class="uk-button uk-button-secondary <?php echo ($time_period == 'today') ? 'uk-active' : ''; ?>">
                <?php echo lang('today'); ?>
            </a>
            <a href="<?php echo site_url('pvpstats/statistics?period=week'); ?>" class="uk-button uk-button-secondary <?php echo ($time_period == 'week') ? 'uk-active' : ''; ?>">
                <?php echo lang('last_7_days'); ?>
            </a>
            <a href="<?php echo site_url('pvpstats/statistics?period=month'); ?>" class="uk-button uk-button-secondary <?php echo ($time_period == 'month') ? 'uk-active' : ''; ?>">
                <?php echo lang('this_month'); ?>
            </a>
            <a href="<?php echo site_url('pvpstats/statistics?period=all'); ?>" class="uk-button uk-button-secondary <?php echo ($time_period == 'all') ? 'uk-active' : ''; ?>">
                <?php echo lang('all_time'); ?>
            </a>
        </div>
    </div>

    <!-- Battleground Statistics -->
    <div class="uk-margin-large-top">
        <h3><?php echo lang('battleground_statistics'); ?></h3>
        <div class="uk-overflow-auto">
            <table class="uk-table uk-table-striped uk-table-hover">
                <thead>
                    <tr>
                        <th><?php echo lang('type'); ?></th>
                        <th><?php echo lang('total_matches'); ?></th>
                        <th><?php echo lang('alliance_wins'); ?></th>
                        <th><?php echo lang('horde_wins'); ?></th>
                        <th><?php echo lang('avg_duration'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bg_stats)): ?>
                        <?php foreach ($bg_stats as $stat): ?>
                            <tr>
                                <td><?php echo $stat->type; ?></td>
                                <td><?php echo $stat->total_matches; ?></td>
                                <td><?php echo $stat->alliance_wins; ?></td>
                                <td><?php echo $stat->horde_wins; ?></td>
                                <td><?php echo round($stat->avg_duration); ?> min</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="uk-text-center"><?php echo lang('no_data'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Faction Statistics -->
    <div class="uk-margin-large-top">
        <h3><?php echo lang('faction_statistics'); ?></h3>
        <div class="uk-overflow-auto">
            <table class="uk-table uk-table-striped uk-table-hover">
                <thead>
                    <tr>
                        <th><?php echo lang('faction'); ?></th>
                        <th><?php echo lang('wins'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($faction_stats)): ?>
                        <?php foreach ($faction_stats as $stat): ?>
                            <tr>
                                <td><?php echo ($stat->faction == 0) ? lang('alliance') : lang('horde'); ?></td>
                                <td><?php echo $stat->wins; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="uk-text-center"><?php echo lang('no_data'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Players -->
    <div class="uk-margin-large-top">
        <h3><?php echo lang('top_players'); ?></h3>
        <div class="uk-overflow-auto">
            <table class="uk-table uk-table-striped uk-table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo lang('name'); ?></th>
                        <th><?php echo lang('class'); ?></th>
                        <th><?php echo lang('total_kills'); ?></th>
                        <th><?php echo lang('total_deaths'); ?></th>
                        <th><?php echo lang('matches_played'); ?></th>
                        <th><?php echo lang('avg_kills'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($top_players)): ?>
                        <?php $rank = 1; ?>
                        <?php foreach ($top_players as $player): ?>
                            <tr>
                                <td><?php echo $rank++; ?></td>
                                <td>
                                    <a href="<?php echo site_url('pvpstats/player/' . urlencode($player->name)); ?>">
                                        <?php echo $player->name; ?>
                                    </a>
                                </td>
                                <td><?php echo class_name($player->class); ?></td>
                                <td><?php echo $player->total_kills; ?></td>
                                <td><?php echo $player->total_deaths; ?></td>
                                <td><?php echo $player->matches_played; ?></td>
                                <td><?php echo $player->avg_kills; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="uk-text-center"><?php echo lang('no_data'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Guilds -->
    <div class="uk-margin-large-top">
        <h3><?php echo lang('top_guilds'); ?></h3>
        <div class="uk-overflow-auto">
            <table class="uk-table uk-table-striped uk-table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo lang('name'); ?></th>
                        <th><?php echo lang('unique_players'); ?></th>
                        <th><?php echo lang('matches_played'); ?></th>
                        <th><?php echo lang('total_kills'); ?></th>
                        <th><?php echo lang('total_damage'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($top_guilds)): ?>
                        <?php $rank = 1; ?>
                        <?php foreach ($top_guilds as $guild): ?>
                            <tr>
                                <td><?php echo $rank++; ?></td>
                                <td><?php echo $guild->name; ?></td>
                                <td><?php echo $guild->unique_players; ?></td>
                                <td><?php echo $guild->matches_played; ?></td>
                                <td><?php echo $guild->total_kills; ?></td>
                                <td><?php echo number_format($guild->total_damage); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="uk-text-center"><?php echo lang('no_data'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Back Button -->
    <div class="uk-margin-large-top uk-margin-large-bottom">
        <a href="<?php echo site_url('pvpstats'); ?>" class="uk-button uk-button-secondary">
            <?php echo lang('back'); ?>
        </a>
    </div>
</div>
