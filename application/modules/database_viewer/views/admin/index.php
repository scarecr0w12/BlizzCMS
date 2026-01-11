<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo lang('database_admin_settings'); ?></h1>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Database Viewer Administration</h5>
                </div>
                <div class="card-body">
                    <p>Welcome to the Database Viewer administration panel. Here you can manage settings for the database viewer module.</p>
                    
                    <div class="list-group">
                        <a href="<?php echo site_url('database_viewer/admin/settings'); ?>" class="list-group-item list-group-item-action">
                            <h6 class="mb-1">Module Settings</h6>
                            <p class="mb-0 text-muted">Configure database viewer options</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
