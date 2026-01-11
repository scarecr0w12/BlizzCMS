<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1><?php echo htmlspecialchars($creature->name); ?></h1>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Creature Information</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Creature ID:</strong></td>
                                    <td><?php echo $creature->entry; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_creature_level'); ?>:</strong></td>
                                    <td><?php echo $creature->minlevel . ' - ' . $creature->maxlevel; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_creature_type'); ?>:</strong></td>
                                    <td><?php echo $creature->type; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_creature_classification'); ?>:</strong></td>
                                    <td><?php echo $creature->rank; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Stats</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong><?php echo lang('database_creature_health'); ?>:</strong></td>
                                    <td><?php echo $creature->maxhealth ?: 'N/A'; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_creature_mana'); ?>:</strong></td>
                                    <td><?php echo $creature->maxmana ?: 'N/A'; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_creature_armor'); ?>:</strong></td>
                                    <td><?php echo $creature->armor ?: 'N/A'; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <?php if (!empty($loot)): ?>
                        <div class="mt-4">
                            <h5><?php echo lang('database_creature_loot'); ?></h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Item ID</th>
                                            <th>Chance</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($loot as $item): ?>
                                            <tr>
                                                <td><?php echo $item->item; ?></td>
                                                <td><?php echo $item->ChanceOrQuestChance . '%'; ?></td>
                                                <td><?php echo $item->mincountOrRef . ' - ' . $item->maxcount; ?></td>
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
                    <a href="<?php echo site_url('database/creatures'); ?>" class="btn btn-secondary btn-block mb-2">
                        <?php echo lang('database_back_to_list'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
