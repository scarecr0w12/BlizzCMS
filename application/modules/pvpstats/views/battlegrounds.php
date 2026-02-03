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
        <h1><?php echo lang('pvpstats_battlegrounds'); ?></h1>
        <hr class="uk-divider-icon">
    </div>

    <!-- Filters -->
    <div class="uk-margin-large">
        <form method="get">
            <div class="uk-grid-small" uk-grid>
                <div class="uk-width-1-3@m">
                    <label class="uk-form-label"><?php echo lang('type'); ?></label>
                    <input type="text" name="type" class="uk-input" value="<?php echo $filters['type'] ?? ''; ?>">
                </div>
                <div class="uk-width-1-3@m">
                    <label class="uk-form-label"><?php echo lang('bracket'); ?></label>
                    <input type="text" name="bracket" class="uk-input" value="<?php echo $filters['bracket_id'] ?? ''; ?>">
                </div>
                <div class="uk-width-1-3@m">
                    <label class="uk-form-label">&nbsp;</label>
                    <button type="submit" class="uk-button uk-button-primary uk-width-1-1"><?php echo lang('search'); ?></button>
                </div>
            </div>
        </form>
    </div>

    <!-- Battlegrounds Table -->
    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-striped uk-table-hover">
            <thead>
                <tr>
                    <th><?php echo lang('type'); ?></th>
                    <th><?php echo lang('bracket'); ?></th>
                    <th><?php echo lang('winner'); ?></th>
                    <th><?php echo lang('start_time'); ?></th>
                    <th><?php echo lang('duration'); ?></th>
                    <th><?php echo lang('action'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($battlegrounds)): ?>
                    <?php foreach ($battlegrounds as $bg): ?>
                        <tr>
                            <td><?php echo $bg->type; ?></td>
                            <td><?php echo $bg->bracket_id; ?></td>
                            <td><?php echo ($bg->winner == 0) ? lang('alliance') : lang('horde'); ?></td>
                            <td><?php echo date('Y-m-d H:i:s', strtotime($bg->start_time)); ?></td>
                            <td><?php echo $bg->duration ?? 'N/A'; ?> min</td>
                            <td>
                                <a href="<?php echo site_url('pvpstats/battleground/' . $bg->id); ?>" class="uk-button uk-button-small uk-button-secondary">
                                    <?php echo lang('view'); ?>
                                </a>
                            </td>
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

    <!-- Pagination -->
    <div class="uk-margin-large-top uk-margin-large-bottom">
        <ul class="uk-pagination uk-flex-center">
            <?php if ($page > 1): ?>
                <li>
                    <a href="<?php echo site_url('pvpstats/battlegrounds?page=' . ($page - 1)); ?>">
                        <?php echo lang('previous'); ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= ceil($total / $limit); $i++): ?>
                <li <?php echo ($i == $page) ? 'class="uk-active"' : ''; ?>>
                    <a href="<?php echo site_url('pvpstats/battlegrounds?page=' . $i); ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($page < ceil($total / $limit)): ?>
                <li>
                    <a href="<?php echo site_url('pvpstats/battlegrounds?page=' . ($page + 1)); ?>">
                        <?php echo lang('next'); ?>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
