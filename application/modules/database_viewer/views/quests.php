<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1><?php echo lang('database_quests'); ?></h1>
        </div>
    </div>

    <?php if (!empty($quests)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th><?php echo lang('database_quest_name'); ?></th>
                        <th><?php echo lang('database_quest_level'); ?></th>
                        <th><?php echo lang('database_quest_type'); ?></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quests as $quest): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($quest->title); ?></td>
                            <td><?php echo $quest->questlevel; ?></td>
                            <td><span class="badge bg-success"><?php echo $quest->qtype; ?></span></td>
                            <td>
                                <a href="<?php echo site_url('database/quest/' . $quest->id); ?>" class="btn btn-sm btn-primary">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($total > $per_page): ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php 
                    $total_pages = ceil($total / $per_page);
                    for ($i = 1; $i <= $total_pages; $i++): 
                    ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="<?php echo site_url('database/quests?page=' . $i); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-info">
            <?php echo lang('database_no_results'); ?>
        </div>
    <?php endif; ?>
</div>
