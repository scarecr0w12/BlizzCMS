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
        <h1><?php echo lang('pvpstats'); ?></h1>
        <hr class="uk-divider-icon">
    </div>

    <!-- Today's Statistics -->
    <div class="uk-margin-large-top">
        <h3><?php echo lang('today'); ?></h3>
    </div>

    <div class="uk-child-width-1-2@m uk-grid-match" uk-grid>
        <?php if (!empty($today_stats)): ?>
            <?php foreach ($today_stats as $stat): ?>
                <div>
                    <div class="uk-card uk-card-default uk-card-body">
                        <h5 class="uk-card-title"><?php echo $stat->type; ?></h5>
                        <p>
                            <strong><?php echo lang('total_matches'); ?>:</strong> <?php echo $stat->total_matches; ?><br>
                            <strong><?php echo lang('alliance_wins'); ?>:</strong> <?php echo $stat->alliance_wins; ?><br>
                            <strong><?php echo lang('horde_wins'); ?>:</strong> <?php echo $stat->horde_wins; ?><br>
                            <strong><?php echo lang('avg_duration'); ?>:</strong> <?php echo round($stat->avg_duration); ?> min
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="uk-width-1-1">
                <p><?php echo lang('no_data'); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Top Players Today -->
    <div class="uk-margin-large-top">
        <h3><?php echo lang('today'); ?> - <?php echo lang('pvpstats_players'); ?></h3>
    </div>

    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-striped uk-table-hover">
            <thead>
                <tr>
                    <th><?php echo lang('name'); ?></th>
                    <th><?php echo lang('class'); ?></th>
                    <th><?php echo lang('level'); ?></th>
                    <th><?php echo lang('killing_blows'); ?></th>
                    <th><?php echo lang('deaths'); ?></th>
                    <th><?php echo lang('damage_done'); ?></th>
                    <th><?php echo lang('healing_done'); ?></th>
                    <th><?php echo lang('matches_played'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($today_players)): ?>
                    <?php foreach ($today_players as $player): ?>
                        <tr>
                            <td>
                                <a href="<?php echo site_url('pvpstats/player/' . urlencode($player->name)); ?>">
                                    <?php echo $player->name; ?>
                                </a>
                            </td>
                            <td><?php echo class_name($player->class); ?></td>
                            <td><?php echo $player->level; ?></td>
                            <td><?php echo $player->total_kills; ?></td>
                            <td><?php echo $player->total_deaths; ?></td>
                            <td><?php echo number_format($player->total_damage); ?></td>
                            <td><?php echo number_format($player->total_healing); ?></td>
                            <td><?php echo $player->matches_played; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="uk-text-center"><?php echo lang('no_data'); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- All Time Top Players -->
    <div class="uk-margin-large-top">
        <h3><?php echo lang('all_time'); ?> - <?php echo lang('pvpstats_players'); ?></h3>
    </div>

    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-striped uk-table-hover">
            <thead>
                <tr>
                    <th><?php echo lang('name'); ?></th>
                    <th><?php echo lang('class'); ?></th>
                    <th><?php echo lang('level'); ?></th>
                    <th><?php echo lang('total_kills'); ?></th>
                    <th><?php echo lang('total_deaths'); ?></th>
                    <th><?php echo lang('total_damage'); ?></th>
                    <th><?php echo lang('total_healing'); ?></th>
                    <th><?php echo lang('matches_played'); ?></th>
                    <th><?php echo lang('avg_kills'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($top_players)): ?>
                    <?php foreach ($top_players as $player): ?>
                        <tr>
                            <td>
                                <a href="<?php echo site_url('pvpstats/player/' . urlencode($player->name)); ?>">
                                    <?php echo $player->name; ?>
                                </a>
                            </td>
                            <td><?php echo class_name($player->class); ?></td>
                            <td><?php echo $player->level; ?></td>
                            <td><?php echo $player->total_kills; ?></td>
                            <td><?php echo $player->total_deaths; ?></td>
                            <td><?php echo number_format($player->total_damage); ?></td>
                            <td><?php echo number_format($player->total_healing); ?></td>
                            <td><?php echo $player->matches_played; ?></td>
                            <td><?php echo $player->avg_kills; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="uk-text-center"><?php echo lang('no_data'); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Top Guilds -->
    <div class="uk-margin-large-top">
        <h3><?php echo lang('pvpstats_guilds'); ?></h3>
    </div>

    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-striped uk-table-hover">
            <thead>
                <tr>
                    <th><?php echo lang('name'); ?></th>
                    <th><?php echo lang('unique_players'); ?></th>
                    <th><?php echo lang('matches_played'); ?></th>
                    <th><?php echo lang('total_kills'); ?></th>
                    <th><?php echo lang('total_deaths'); ?></th>
                    <th><?php echo lang('total_damage'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($top_guilds)): ?>
                    <?php foreach ($top_guilds as $guild): ?>
                        <tr>
                            <td><?php echo $guild->name; ?></td>
                            <td><?php echo $guild->unique_players; ?></td>
                            <td><?php echo $guild->matches_played; ?></td>
                            <td><?php echo $guild->total_kills; ?></td>
                            <td><?php echo $guild->total_deaths; ?></td>
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

    <!-- Navigation Links -->
    <div class="uk-margin-large-top uk-margin-large-bottom">
        <div class="uk-button-group">
            <a href="<?php echo site_url('pvpstats/battlegrounds'); ?>" class="uk-button uk-button-primary"><?php echo lang('pvpstats_battlegrounds'); ?></a>
            <a href="<?php echo site_url('pvpstats/players'); ?>" class="uk-button uk-button-primary"><?php echo lang('pvpstats_players'); ?></a>
            <a href="<?php echo site_url('pvpstats/guilds'); ?>" class="uk-button uk-button-primary"><?php echo lang('pvpstats_guilds'); ?></a>
            <a href="<?php echo site_url('pvpstats/statistics'); ?>" class="uk-button uk-button-primary"><?php echo lang('pvpstats_statistics'); ?></a>
        </div>
    </div>
</div>
