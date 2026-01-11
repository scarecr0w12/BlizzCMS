<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="uk-grid-small" uk-grid>
    <div class="uk-width-1-1">
        <div class="uk-card uk-card-default">
            <div class="uk-card-header">
                <div class="uk-flex uk-flex-between uk-flex-middle">
                    <h4 class="uk-margin-remove"><?= lang('playermap_title') ?> - <?= lang('admin_dashboard') ?></h4>
                    <a href="<?= site_url('playermap/admin/settings') ?>" class="uk-button uk-button-primary uk-button-small">
                        <i class="fas fa-cog"></i> <?= lang('settings') ?>
                    </a>
                </div>
            </div>
            <div class="uk-card-body">
                <p class="uk-text-muted"><?= lang('playermap_admin_description') ?></p>
            </div>
        </div>
    </div>
</div>

<div class="uk-grid-small uk-margin-top" uk-grid>
    <div class="uk-width-1-1">
        <div class="uk-card uk-card-default">
            <div class="uk-card-header">
                <h5 class="uk-margin-remove"><?= lang('playermap_realm_statistics') ?></h5>
            </div>
            <div class="uk-card-body">
                <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-striped">
                        <thead>
                            <tr>
                                <th><?= lang('realm') ?></th>
                                <th class="uk-text-center"><?= lang('playermap_total') ?></th>
                                <th class="uk-text-center">
                                    <i class="fas fa-shield-alt uk-text-primary"></i> <?= lang('playermap_alliance') ?>
                                </th>
                                <th class="uk-text-center">
                                    <i class="fas fa-shield-alt uk-text-danger"></i> <?= lang('playermap_horde') ?>
                                </th>
                                <th class="uk-text-center"><?= lang('status') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($stats)): ?>
                                <?php foreach ($stats as $realm_id => $stat): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($stat['realm_name']) ?></strong>
                                        </td>
                                        <td class="uk-text-center">
                                            <span class="uk-badge uk-badge-primary"><?= $stat['total_online'] ?></span>
                                        </td>
                                        <td class="uk-text-center">
                                            <span class="uk-badge"><?= $stat['alliance'] ?></span>
                                        </td>
                                        <td class="uk-text-center">
                                            <span class="uk-badge uk-badge-danger"><?= $stat['horde'] ?></span>
                                        </td>
                                        <td class="uk-text-center">
                                            <?php if (isset($stat['error'])): ?>
                                                <span class="uk-badge uk-badge-warning" title="<?= htmlspecialchars($stat['error']) ?>">
                                                    <i class="fas fa-exclamation-triangle"></i> <?= lang('error') ?>
                                                </span>
                                            <?php elseif ($stat['total_online'] > 0): ?>
                                                <span class="uk-badge uk-badge-success">
                                                    <i class="fas fa-check-circle"></i> <?= lang('online') ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="uk-badge">
                                                    <i class="fas fa-times-circle"></i> <?= lang('playermap_no_players') ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="uk-text-center uk-text-muted">
                                        <?= lang('playermap_no_realms_configured') ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="uk-grid-small uk-margin-top" uk-grid>
    <div class="uk-width-1-1">
        <div class="uk-card uk-card-default">
            <div class="uk-card-header">
                <h5 class="uk-margin-remove"><?= lang('playermap_quick_links') ?></h5>
            </div>
            <div class="uk-card-body">
                <div class="uk-grid-small" uk-grid>
                    <div class="uk-width-1-3@m uk-width-1-1">
                        <div class="uk-card uk-card-secondary uk-card-small">
                            <div class="uk-card-body uk-text-center">
                                <i class="fas fa-map-marked-alt fa-3x uk-text-primary uk-margin-bottom"></i>
                                <h5 class="uk-margin-small"><?= lang('playermap_view_map') ?></h5>
                                <p class="uk-text-muted uk-margin-small"><?= lang('playermap_view_live_map') ?></p>
                                <a href="<?= site_url('playermap') ?>" class="uk-button uk-button-primary uk-button-small" target="_blank">
                                    <i class="fas fa-external-link-alt"></i> <?= lang('view') ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-3@m uk-width-1-1">
                        <div class="uk-card uk-card-secondary uk-card-small">
                            <div class="uk-card-body uk-text-center">
                                <i class="fas fa-cog fa-3x uk-text-success uk-margin-bottom"></i>
                                <h5 class="uk-margin-small"><?= lang('settings') ?></h5>
                                <p class="uk-text-muted uk-margin-small"><?= lang('playermap_configure_module') ?></p>
                                <a href="<?= site_url('playermap/admin/settings') ?>" class="uk-button uk-button-success uk-button-small">
                                    <i class="fas fa-wrench"></i> <?= lang('configure') ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-3@m uk-width-1-1">
                        <div class="uk-card uk-card-secondary uk-card-small">
                            <div class="uk-card-body uk-text-center">
                                <i class="fas fa-book fa-3x uk-text-info uk-margin-bottom"></i>
                                <h5 class="uk-margin-small"><?= lang('documentation') ?></h5>
                                <p class="uk-text-muted uk-margin-small"><?= lang('playermap_view_documentation') ?></p>
                                <a href="https://github.com/azerothcore/playermap" class="uk-button uk-button-secondary uk-button-small" target="_blank">
                                    <i class="fas fa-external-link-alt"></i> <?= lang('read_more') ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
