<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1><?php echo htmlspecialchars($item->name); ?></h1>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Item Information</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Item ID:</strong></td>
                                    <td><?php echo $item->entry; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_item_quality'); ?>:</strong></td>
                                    <td><span class="badge bg-secondary"><?php echo $item->quality; ?></span></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_item_level'); ?>:</strong></td>
                                    <td><?php echo $item->itemlevel; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_item_type'); ?>:</strong></td>
                                    <td><?php echo $item->class; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_item_subclass'); ?>:</strong></td>
                                    <td><?php echo $item->subclass; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_item_required_level'); ?>:</strong></td>
                                    <td><?php echo $item->RequiredLevel ?: 'None'; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Additional Details</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Inventory Type:</strong></td>
                                    <td><?php echo $item->inventorytype; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Durability:</strong></td>
                                    <td><?php echo $item->MaxDurability ?: 'N/A'; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Armor:</strong></td>
                                    <td><?php echo $item->armor ?: 'N/A'; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Damage:</strong></td>
                                    <td><?php echo ($item->dmg_min && $item->dmg_max) ? $item->dmg_min . ' - ' . $item->dmg_max : 'N/A'; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <?php if ($item->description): ?>
                        <div class="mt-4">
                            <h5>Description</h5>
                            <p><?php echo htmlspecialchars($item->description); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <a href="<?php echo site_url('database/items'); ?>" class="btn btn-secondary btn-block mb-2">
                        <?php echo lang('database_back_to_list'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
