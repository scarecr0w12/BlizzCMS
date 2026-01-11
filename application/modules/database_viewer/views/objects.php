<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1><?php echo lang('database_objects'); ?></h1>
        </div>
    </div>

    <?php if (!empty($objects)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Object Name</th>
                        <th>Type</th>
                        <th>Display ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($objects as $object): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($object->name); ?></td>
                            <td><?php echo $object->type; ?></td>
                            <td><?php echo $object->displayId; ?></td>
                            <td>
                                <a href="<?php echo site_url('database/object/' . $object->entry); ?>" class="btn btn-sm btn-primary">
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
                            <a class="page-link" href="<?php echo site_url('database/objects?page=' . $i . ($type ? '&type=' . $type : '')); ?>">
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
