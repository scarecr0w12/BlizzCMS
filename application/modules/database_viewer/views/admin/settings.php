<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo lang('database_admin_settings'); ?></h5>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $this->session->flashdata('success'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?php echo site_url('database_viewer/admin/settings'); ?>">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="enabled" id="enabled" value="1" <?php echo $enabled ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="enabled">
                                    <?php echo lang('database_admin_enable'); ?>
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="items_per_page" class="form-label"><?php echo lang('database_admin_items_per_page'); ?></label>
                            <input type="number" class="form-control" id="items_per_page" name="items_per_page" value="<?php echo $items_per_page; ?>" min="10" max="500">
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="show_quality_colors" id="show_quality_colors" value="1" <?php echo $show_quality_colors ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="show_quality_colors">
                                    <?php echo lang('database_admin_show_quality_colors'); ?>
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="enable_tooltips" id="enable_tooltips" value="1" <?php echo $enable_tooltips ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="enable_tooltips">
                                    <?php echo lang('database_admin_enable_tooltips'); ?>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Settings</button>
                        <a href="<?php echo site_url('database_viewer/admin'); ?>" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
