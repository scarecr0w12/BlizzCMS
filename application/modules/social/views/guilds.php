<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo $page_title; ?></h1>
        </div>
    </div>

    <div class="row mt-4">
        <?php if (!empty($guilds)): ?>
            <?php foreach ($guilds as $guild): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><?php echo htmlspecialchars($guild->name); ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><strong>Realm:</strong> <?php echo htmlspecialchars($guild->realm ?? 'Unknown'); ?></p>
                            <p class="mb-2"><strong>Leader:</strong> <?php echo htmlspecialchars($guild->leaderguid ?? 'Unknown'); ?></p>
                            <p class="mb-2"><strong>Members:</strong> <?php echo $guild->member_count ?? 0; ?></p>
                            <p class="mb-0"><strong>Created:</strong> <?php echo date('M d, Y', strtotime($guild->createdate ?? 'now')); ?></p>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo site_url('social/guilds/' . $guild->guildid); ?>" class="btn btn-sm btn-info">View Details</a>
                            <a href="<?php echo site_url('social/guilds/' . $guild->guildid . '/members'); ?>" class="btn btn-sm btn-secondary">View Members</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-md-12">
                <div class="alert alert-info">No guilds available.</div>
            </div>
        <?php endif; ?>
    </div>
</div>
