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
            
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Your Friends</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($friends)): ?>
                        <div class="list-group">
                            <?php foreach ($friends as $friend): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0"><?php echo htmlspecialchars($friend->username); ?></h6>
                                    </div>
                                    <div>
                                        <a href="<?php echo site_url('social/friends/remove/' . $friend->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Remove this friend?');">Remove</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">You don't have any friends yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Friend Requests (<?php echo count($friend_requests); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($friend_requests)): ?>
                        <div class="list-group">
                            <?php foreach ($friend_requests as $request): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0"><?php echo htmlspecialchars($request->username); ?></h6>
                                        <small class="text-muted"><?php echo date('M d, Y', strtotime($request->created_at)); ?></small>
                                    </div>
                                    <div>
                                        <a href="<?php echo site_url('social/friends/accept/' . $request->id); ?>" class="btn btn-sm btn-success">Accept</a>
                                        <a href="<?php echo site_url('social/friends/remove/' . $request->id); ?>" class="btn btn-sm btn-danger">Decline</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No pending friend requests.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
