<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo $page_title; ?></h1>
            
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Social Features Configuration</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo site_url('social/admin/settings'); ?>">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="enable_friends" name="enable_friends" value="1" 
                                    <?php echo ($settings['enable_friends'] ?? '1') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="enable_friends">
                                    Enable Friends System
                                </label>
                            </div>
                            <small class="text-muted d-block mt-2">Allow users to add and manage friends</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="enable_messaging" name="enable_messaging" value="1"
                                    <?php echo ($settings['enable_messaging'] ?? '1') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="enable_messaging">
                                    Enable Messaging System
                                </label>
                            </div>
                            <small class="text-muted d-block mt-2">Allow users to send and receive messages</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="enable_guild_features" name="enable_guild_features" value="1"
                                    <?php echo ($settings['enable_guild_features'] ?? '1') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="enable_guild_features">
                                    Enable Guild Features
                                </label>
                            </div>
                            <small class="text-muted d-block mt-2">Allow users to view guild information and members</small>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label for="max_friends" class="form-label">Maximum Friends Per User</label>
                            <input type="number" class="form-control" id="max_friends" name="max_friends" 
                                value="<?php echo $settings['max_friends'] ?? '100'; ?>" min="1" max="1000">
                            <small class="text-muted">Maximum number of friends a user can have</small>
                        </div>

                        <div class="mb-3">
                            <label for="message_retention_days" class="form-label">Message Retention (Days)</label>
                            <input type="number" class="form-control" id="message_retention_days" name="message_retention_days" 
                                value="<?php echo $settings['message_retention_days'] ?? '90'; ?>" min="1" max="365">
                            <small class="text-muted">Number of days to keep messages before automatic deletion</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                            <a href="<?php echo site_url('social/admin'); ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Information</h5>
                </div>
                <div class="card-body">
                    <h6>Social Features Module</h6>
                    <p class="small text-muted">
                        This module provides comprehensive social networking features for your WoW CMS including:
                    </p>
                    <ul class="small">
                        <li>Friend management system</li>
                        <li>Private messaging</li>
                        <li>Guild information and browsing</li>
                        <li>Social activity feed</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
