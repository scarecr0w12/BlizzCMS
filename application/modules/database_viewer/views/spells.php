<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><?php echo lang('database_spells'); ?></h1>
        </div>
        <div class="col-md-4">
            <form method="get" class="form-inline">
                <select name="school" class="form-control form-control-sm me-2">
                    <option value="">All Schools</option>
                    <?php foreach ($schools as $id => $name): ?>
                        <option value="<?php echo $id; ?>" <?php echo ($school == $id) ? 'selected' : ''; ?>>
                            <?php echo $name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            </form>
        </div>
    </div>

    <?php if (!empty($spells)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th><?php echo lang('database_spell_name'); ?></th>
                        <th><?php echo lang('database_spell_school'); ?></th>
                        <th><?php echo lang('database_spell_cast_time'); ?></th>
                        <th><?php echo lang('database_spell_cooldown'); ?></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($spells as $spell): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($spell->name); ?></td>
                            <td><span class="badge bg-info"><?php echo isset($schools[$spell->school]) ? $schools[$spell->school] : $spell->school; ?></span></td>
                            <td><?php echo $spell->casttime; ?></td>
                            <td><?php echo $spell->cooldown; ?></td>
                            <td>
                                <a href="<?php echo site_url('database/spell/' . $spell->id); ?>" class="btn btn-sm btn-primary">
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
                            <a class="page-link" href="<?php echo site_url('database/spells?page=' . $i . ($school ? '&school=' . $school : '')); ?>">
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
