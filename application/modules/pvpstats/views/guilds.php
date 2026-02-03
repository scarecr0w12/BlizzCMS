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
        <h1><?php echo lang('pvpstats_guilds'); ?></h1>
        <hr class="uk-divider-icon">
    </div>

    <!-- Guilds Table -->
    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-striped uk-table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo lang('name'); ?></th>
                    <th><?php echo lang('unique_players'); ?></th>
                    <th><?php echo lang('matches_played'); ?></th>
                    <th><?php echo lang('total_kills'); ?></th>
                    <th><?php echo lang('total_deaths'); ?></th>
                    <th><?php echo lang('total_damage'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($guilds)): ?>
                    <?php $rank = 1; ?>
                    <?php foreach ($guilds as $guild): ?>
                        <tr>
                            <td><?php echo $rank++; ?></td>
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
                        <td colspan="7" class="uk-text-center"><?php echo lang('no_data'); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Back Button -->
    <div class="uk-margin-large-top uk-margin-large-bottom">
        <a href="<?php echo site_url('pvpstats'); ?>" class="uk-button uk-button-secondary">
            <?php echo lang('back'); ?>
        </a>
    </div>
</div>
