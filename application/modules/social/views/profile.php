<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><?php echo htmlspecialchars($user->username); ?></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>User ID:</strong> <?php echo $user->id; ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($user->email ?? 'N/A'); ?></p>
                            <p><strong>Joined:</strong> <?php echo date('M d, Y', strtotime($user->created_at ?? 'now')); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Friends:</strong> <?php echo $friend_count ?? 0; ?></p>
                            <p><strong>Activities:</strong> <?php echo $activity_count ?? 0; ?></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <?php if ($this->session->userdata('user_id') != $user->id): ?>
                        <a href="<?php echo site_url('social/messages/send?to=' . $user->id); ?>" class="btn btn-primary">Send Message</a>
                        <a href="<?php echo site_url('social/friends/add/' . $user->id); ?>" class="btn btn-success">Add Friend</a>
                    <?php endif; ?>
                    <a href="<?php echo site_url('social/friends'); ?>" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
