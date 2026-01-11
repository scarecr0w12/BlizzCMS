<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1>Social Features</h1>
            <p class="lead">Connect with other players and manage your social network</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Friends</h5>
                </div>
                <div class="card-body">
                    <p>Manage your friend list and connect with other players.</p>
                    <p class="text-muted">Send friend requests, accept invitations, and keep track of your friends.</p>
                </div>
                <div class="card-footer">
                    <a href="<?php echo site_url('social/friends'); ?>" class="btn btn-primary">Manage Friends</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Messages</h5>
                </div>
                <div class="card-body">
                    <p>Send and receive private messages from other players.</p>
                    <p class="text-muted">Keep your conversations organized with inbox and sent folders.</p>
                </div>
                <div class="card-footer">
                    <a href="<?php echo site_url('social/messages'); ?>" class="btn btn-success">View Messages</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Guilds</h5>
                </div>
                <div class="card-body">
                    <p>Browse guilds and view member information.</p>
                    <p class="text-muted">Explore guild details and see who's in each guild.</p>
                </div>
                <div class="card-footer">
                    <a href="<?php echo site_url('social/guilds'); ?>" class="btn btn-info">Browse Guilds</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Social Feed</h5>
                </div>
                <div class="card-body">
                    <p>Stay updated with your friends' activities.</p>
                    <p class="text-muted">See what your friends are up to in the community.</p>
                </div>
                <div class="card-footer">
                    <a href="<?php echo site_url('social/feed'); ?>" class="btn btn-warning">View Feed</a>
                </div>
            </div>
        </div>
    </div>
</div>
