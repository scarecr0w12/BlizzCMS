<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo $page_title; ?></h1>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8 offset-md-2">
            <?php if (!empty($activities)): ?>
                <?php foreach ($activities as $activity): ?>
                    <div class="card mb-3">
                        <div class="card-header">
                            <strong><?php echo htmlspecialchars($activity->username); ?></strong>
                            <small class="text-muted float-end"><?php echo date('M d, Y H:i', strtotime($activity->created_at)); ?></small>
                        </div>
                        <div class="card-body">
                            <p><?php echo htmlspecialchars($activity->activity_description ?? $activity->activity_type); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if ($total > $limit): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= ceil($total / $limit); $i++): ?>
                                <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                    <a class="page-link" href="<?php echo site_url('social/feed?page=' . $i); ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-info">No activities to display. Add some friends to see their activities!</div>
            <?php endif; ?>
        </div>
    </div>
</div>
