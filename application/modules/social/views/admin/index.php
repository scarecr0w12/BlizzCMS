<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo $page_title; ?></h1>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Friends</h5>
                    <p class="card-text">Manage friend system</p>
                    <a href="<?php echo site_url('social/admin/settings'); ?>" class="btn btn-primary btn-sm">Configure</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Messaging</h5>
                    <p class="card-text">Manage messaging system</p>
                    <a href="<?php echo site_url('social/admin/settings'); ?>" class="btn btn-primary btn-sm">Configure</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Guilds</h5>
                    <p class="card-text">Manage guild features</p>
                    <a href="<?php echo site_url('social/admin/settings'); ?>" class="btn btn-primary btn-sm">Configure</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Settings</h5>
                    <p class="card-text">Global settings</p>
                    <a href="<?php echo site_url('social/admin/settings'); ?>" class="btn btn-primary btn-sm">Configure</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Module Status</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td><strong>Friends System</strong></td>
                            <td>
                                <?php if ($settings['enable_friends'] ?? '1'): ?>
                                    <span class="badge bg-success">Enabled</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Disabled</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Messaging System</strong></td>
                            <td>
                                <?php if ($settings['enable_messaging'] ?? '1'): ?>
                                    <span class="badge bg-success">Enabled</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Disabled</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Guild Features</strong></td>
                            <td>
                                <?php if ($settings['enable_guild_features'] ?? '1'): ?>
                                    <span class="badge bg-success">Enabled</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Disabled</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Max Friends</strong></td>
                            <td><?php echo $settings['max_friends'] ?? '100'; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Message Retention</strong></td>
                            <td><?php echo $settings['message_retention_days'] ?? '90'; ?> days</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
