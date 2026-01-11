<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><?php echo lang('database_creatures'); ?></h1>
        </div>
        <div class="col-md-4">
            <form method="get" class="form-inline">
                <select name="type" class="form-control form-control-sm me-2">
                    <option value="">All Types</option>
                    <?php foreach ($types as $t): ?>
                        <option value="<?php echo $t->type; ?>" <?php echo ($type == $t->type) ? 'selected' : ''; ?>>
                            Type <?php echo $t->type; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            </form>
        </div>
    </div>

    <?php if (!empty($creatures)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th><?php echo lang('database_creature_name'); ?></th>
                        <th><?php echo lang('database_creature_level'); ?></th>
                        <th><?php echo lang('database_creature_type'); ?></th>
                        <th><?php echo lang('database_creature_classification'); ?></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($creatures as $creature): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($creature->name); ?></td>
                            <td><?php echo $creature->minlevel . ' - ' . $creature->maxlevel; ?></td>
                            <td><?php echo $creature->type; ?></td>
                            <td><?php echo $creature->rank; ?></td>
                            <td>
                                <a href="<?php echo site_url('database/creature/' . $creature->entry); ?>" class="btn btn-sm btn-primary">
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
                            <a class="page-link" href="<?php echo site_url('database/creatures?page=' . $i . ($type ? '&type=' . $type : '')); ?>">
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
