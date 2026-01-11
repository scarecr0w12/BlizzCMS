<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1><?php echo htmlspecialchars($zone->name); ?></h1>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Zone Information</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Zone ID:</strong></td>
                                    <td><?php echo $zone->id; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_zone_level'); ?>:</strong></td>
                                    <td><?php echo $zone->area_level; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_zone_type'); ?>:</strong></td>
                                    <td><?php echo $zone->area_type; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <a href="<?php echo site_url('database/zones'); ?>" class="btn btn-secondary btn-block mb-2">
                        <?php echo lang('database_back_to_list'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
