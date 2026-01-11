<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1><?php echo htmlspecialchars($npc->name); ?></h1>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>NPC Information</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>NPC ID:</strong></td>
                                    <td><?php echo $npc->entry; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_creature_level'); ?>:</strong></td>
                                    <td><?php echo $npc->minlevel . ' - ' . $npc->maxlevel; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_creature_type'); ?>:</strong></td>
                                    <td><?php echo $npc->type; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <?php if (!empty($vendor_items)): ?>
                        <div class="mt-4">
                            <h5>Vendor Items</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Item ID</th>
                                            <th>Max Count</th>
                                            <th>Restock Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($vendor_items as $item): ?>
                                            <tr>
                                                <td><?php echo $item->item; ?></td>
                                                <td><?php echo $item->maxcount; ?></td>
                                                <td><?php echo $item->incrtime; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <a href="<?php echo site_url('database/npcs'); ?>" class="btn btn-secondary btn-block mb-2">
                        <?php echo lang('database_back_to_list'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
