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
                    <h5 class="card-title">Messages</h5>
                    <h2 class="text-primary"><?php echo $unread_messages; ?></h2>
                    <p class="text-muted">Unread</p>
                    <a href="<?php echo site_url('social/messages'); ?>" class="btn btn-sm btn-primary">View</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Friends</h5>
                    <h2 class="text-success"><?php echo $friend_count; ?></h2>
                    <p class="text-muted">Total</p>
                    <a href="<?php echo site_url('social/friends'); ?>" class="btn btn-sm btn-success">View</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Requests</h5>
                    <h2 class="text-warning"><?php echo $pending_requests; ?></h2>
                    <p class="text-muted">Pending</p>
                    <a href="<?php echo site_url('social/friends'); ?>" class="btn btn-sm btn-warning">View</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Guilds</h5>
                    <h2 class="text-info"><?php echo $guild_count; ?></h2>
                    <p class="text-muted">Available</p>
                    <a href="<?php echo site_url('social/guilds'); ?>" class="btn btn-sm btn-info">View</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Friends</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recent_friends)): ?>
                        <div class="list-group">
                            <?php foreach ($recent_friends as $friend): ?>
                                <a href="<?php echo site_url('social/profile/' . $friend->id); ?>" class="list-group-item list-group-item-action">
                                    <?php echo htmlspecialchars($friend->username); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No friends yet. <a href="<?php echo site_url('social/friends'); ?>">Add friends</a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo site_url('social/messages/send'); ?>" class="btn btn-primary">Send Message</a>
                        <a href="<?php echo site_url('social/search'); ?>" class="btn btn-secondary">Search Users</a>
                        <a href="<?php echo site_url('social/guilds'); ?>" class="btn btn-info">Browse Guilds</a>
                        <a href="<?php echo site_url('social/feed'); ?>" class="btn btn-success">View Feed</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
