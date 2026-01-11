<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><?php echo lang('database_items'); ?></h1>
        </div>
        <div class="col-md-4">
            <form method="get" class="form-inline">
                <select name="class" class="form-control form-control-sm me-2">
                    <option value="">All Classes</option>
                    <?php foreach ($classes as $c): ?>
                        <option value="<?php echo $c->class; ?>" <?php echo ($class == $c->class) ? 'selected' : ''; ?>>
                            Class <?php echo $c->class; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            </form>
        </div>
    </div>

    <?php if (!empty($items)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th><?php echo lang('database_item_name'); ?></th>
                        <th><?php echo lang('database_item_quality'); ?></th>
                        <th><?php echo lang('database_item_level'); ?></th>
                        <th><?php echo lang('database_item_type'); ?></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item->name); ?></td>
                            <td><span class="badge bg-secondary"><?php echo $item->quality; ?></span></td>
                            <td><?php echo $item->itemlevel; ?></td>
                            <td><?php echo $item->class; ?></td>
                            <td>
                                <a href="<?php echo site_url('database/item/' . $item->entry); ?>" class="btn btn-sm btn-primary">
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
                            <a class="page-link" href="<?php echo site_url('database/items?page=' . $i . ($class ? '&class=' . $class : '')); ?>">
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
