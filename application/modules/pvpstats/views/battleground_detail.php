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
        <h1><?php echo lang('pvpstats_battleground_detail'); ?></h1>
        <hr class="uk-divider-icon">
    </div>

    <!-- Battleground Info -->
    <div class="uk-margin-large">
        <div class="uk-card uk-card-default uk-card-body">
            <h5 class="uk-card-title"><?php echo lang('battleground'); ?> #<?php echo $battleground->id; ?></h5>
            <p>
                <strong><?php echo lang('type'); ?>:</strong> <?php echo $battleground->type; ?><br>
                <strong><?php echo lang('bracket'); ?>:</strong> <?php echo $battleground->bracket_id; ?><br>
                <strong><?php echo lang('winner'); ?>:</strong> <?php echo ($battleground->winner == 0) ? lang('alliance') : lang('horde'); ?><br>
                <strong><?php echo lang('start_time'); ?>:</strong> <?php echo date('Y-m-d H:i:s', strtotime($battleground->start_time)); ?><br>
                <strong><?php echo lang('end_time'); ?>:</strong> <?php echo $battleground->end_time ? date('Y-m-d H:i:s', strtotime($battleground->end_time)) : 'N/A'; ?><br>
                <strong><?php echo lang('duration'); ?>:</strong> <?php echo $battleground->duration ?? 'N/A'; ?> minutes
            </p>
        </div>
    </div>

    <!-- Players Table -->
    <div class="uk-margin-large-top">
        <h3><?php echo lang('players'); ?></h3>
        <div class="uk-overflow-auto">
            <table class="uk-table uk-table-striped uk-table-hover">
                <thead>
                    <tr>
                        <th><?php echo lang('name'); ?></th>
                        <th><?php echo lang('class'); ?></th>
                        <th><?php echo lang('level'); ?></th>
                        <th><?php echo lang('killing_blows'); ?></th>
                        <th><?php echo lang('deaths'); ?></th>
                        <th><?php echo lang('honorable_kills'); ?></th>
                        <th><?php echo lang('damage_done'); ?></th>
                        <th><?php echo lang('healing_done'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($players)): ?>
                        <?php foreach ($players as $player): ?>
                            <tr>
                                <td>
                                    <a href="<?php echo site_url('pvpstats/player/' . urlencode($player->name)); ?>">
                                        <?php echo $player->name; ?>
                                    </a>
                                </td>
                                <td><?php echo class_name($player->class); ?></td>
                                <td><?php echo $player->level; ?></td>
                                <td><?php echo $player->killing_blows; ?></td>
                                <td><?php echo $player->deaths; ?></td>
                                <td><?php echo $player->honorable_kills; ?></td>
                                <td><?php echo number_format($player->damage_done); ?></td>
                                <td><?php echo number_format($player->healing_done); ?></td>
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
    </div>

    <!-- Back Button -->
    <div class="uk-margin-large-top uk-margin-large-bottom">
        <a href="<?php echo site_url('pvpstats/battlegrounds'); ?>" class="uk-button uk-button-secondary">
            <?php echo lang('back'); ?>
        </a>
    </div>
</div>
