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
        <h1><?php echo lang('pvpstats_players'); ?></h1>
        <hr class="uk-divider-icon">
    </div>

    <!-- Players Table -->
    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-striped uk-table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo lang('name'); ?></th>
                    <th><?php echo lang('class'); ?></th>
                    <th><?php echo lang('level'); ?></th>
                    <th><?php echo lang('total_kills'); ?></th>
                    <th><?php echo lang('total_deaths'); ?></th>
                    <th><?php echo lang('total_damage'); ?></th>
                    <th><?php echo lang('total_healing'); ?></th>
                    <th><?php echo lang('matches_played'); ?></th>
                    <th><?php echo lang('action'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($players)): ?>
                    <?php $rank = 1; ?>
                    <?php foreach ($players as $player): ?>
                        <tr>
                            <td><?php echo $rank++; ?></td>
                            <td><?php echo $player->name; ?></td>
                            <td><?php echo class_name($player->class); ?></td>
                            <td><?php echo $player->level; ?></td>
                            <td><?php echo $player->total_kills; ?></td>
                            <td><?php echo $player->total_deaths; ?></td>
                            <td><?php echo number_format($player->total_damage); ?></td>
                            <td><?php echo number_format($player->total_healing); ?></td>
                            <td><?php echo $player->matches_played; ?></td>
                            <td>
                                <a href="<?php echo site_url('pvpstats/player/' . urlencode($player->name)); ?>" class="uk-button uk-button-small uk-button-secondary">
                                    <?php echo lang('view'); ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="uk-text-center"><?php echo lang('no_data'); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
