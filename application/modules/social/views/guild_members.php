<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <a href="<?php echo site_url('social/guilds'); ?>" class="btn btn-secondary mb-3">Back to Guilds</a>
            
            <h1><?php echo $page_title; ?></h1>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><?php echo htmlspecialchars($guild->name); ?> - Members (<?php echo count($members); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($members)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Level</th>
                                        <th>Class</th>
                                        <th>Race</th>
                                        <th>Rank</th>
                                        <th>Join Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($members as $member): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($member->name); ?></td>
                                            <td><?php echo $member->level ?? 'N/A'; ?></td>
                                            <td><?php echo htmlspecialchars($member->class ?? 'Unknown'); ?></td>
                                            <td><?php echo htmlspecialchars($member->race ?? 'Unknown'); ?></td>
                                            <td><?php echo $member->rank ?? 'N/A'; ?></td>
                                            <td><?php echo date('M d, Y', strtotime($member->createtime ?? 'now')); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No members found in this guild.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
