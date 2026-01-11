<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><?= lang('playermap_title') ?> - <?= lang('admin_dashboard') ?></h4>
                    <a href="<?= site_url('playermap/admin/settings') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-cog"></i> <?= lang('settings') ?>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <p class="text-muted"><?= lang('playermap_admin_description') ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><?= lang('playermap_realm_statistics') ?></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><?= lang('realm') ?></th>
                                <th class="text-center"><?= lang('playermap_total') ?></th>
                                <th class="text-center">
                                    <i class="fas fa-shield-alt text-primary"></i> <?= lang('playermap_alliance') ?>
                                </th>
                                <th class="text-center">
                                    <i class="fas fa-shield-alt text-danger"></i> <?= lang('playermap_horde') ?>
                                </th>
                                <th class="text-center"><?= lang('status') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($stats)): ?>
                                <?php foreach ($stats as $realm_id => $stat): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($stat['realm_name']) ?></strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-primary"><?= $stat['total_online'] ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info"><?= $stat['alliance'] ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-danger"><?= $stat['horde'] ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?php if (isset($stat['error'])): ?>
                                                <span class="badge badge-warning" title="<?= htmlspecialchars($stat['error']) ?>">
                                                    <i class="fas fa-exclamation-triangle"></i> <?= lang('error') ?>
                                                </span>
                                            <?php elseif ($stat['total_online'] > 0): ?>
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle"></i> <?= lang('online') ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">
                                                    <i class="fas fa-times-circle"></i> <?= lang('playermap_no_players') ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
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

<div class="row mt-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><?= lang('playermap_quick_links') ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <i class="fas fa-map-marked-alt fa-3x text-primary mb-3"></i>
                                <h5><?= lang('playermap_view_map') ?></h5>
                                <p class="text-muted"><?= lang('playermap_view_live_map') ?></p>
                                <a href="<?= site_url('playermap') ?>" class="btn btn-primary btn-sm" target="_blank">
                                    <i class="fas fa-external-link-alt"></i> <?= lang('view') ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <i class="fas fa-cog fa-3x text-success mb-3"></i>
                                <h5><?= lang('settings') ?></h5>
                                <p class="text-muted"><?= lang('playermap_configure_module') ?></p>
                                <a href="<?= site_url('playermap/admin/settings') ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-wrench"></i> <?= lang('configure') ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <i class="fas fa-book fa-3x text-info mb-3"></i>
                                <h5><?= lang('documentation') ?></h5>
                                <p class="text-muted"><?= lang('playermap_view_documentation') ?></p>
                                <a href="https://github.com/azerothcore/playermap" class="btn btn-info btn-sm" target="_blank">
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
