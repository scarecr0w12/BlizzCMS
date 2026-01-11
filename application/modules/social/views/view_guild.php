<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <a href="<?php echo site_url('social/guilds'); ?>" class="btn btn-secondary mb-3">Back to Guilds</a>
            
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><?php echo htmlspecialchars($guild->name); ?></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Guild ID:</strong> <?php echo $guild->guildid; ?></p>
                            <p><strong>Leader:</strong> <?php echo htmlspecialchars($guild->leaderguid ?? 'Unknown'); ?></p>
                            <p><strong>Created:</strong> <?php echo date('M d, Y', strtotime($guild->createdate ?? 'now')); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Total Members:</strong> <?php echo count($members); ?></p>
                            <p><strong>Realm:</strong> <?php echo htmlspecialchars($guild->realm ?? 'Unknown'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Members (<?php echo count($members); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($members)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Level</th>
                                        <th>Class</th>
                                        <th>Rank</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($members as $member): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($member->name); ?></td>
                                            <td><?php echo $member->level ?? 'N/A'; ?></td>
                                            <td><?php echo htmlspecialchars($member->class ?? 'Unknown'); ?></td>
                                            <td><?php echo $member->rank ?? 'N/A'; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No members found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
