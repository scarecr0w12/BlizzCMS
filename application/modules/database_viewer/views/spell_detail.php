<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1><?php echo htmlspecialchars($spell->name); ?></h1>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Spell Information</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Spell ID:</strong></td>
                                    <td><?php echo $spell->id; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_spell_school'); ?>:</strong></td>
                                    <td><span class="badge bg-info"><?php echo isset($schools[$spell->school]) ? $schools[$spell->school] : $spell->school; ?></span></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_spell_cast_time'); ?>:</strong></td>
                                    <td><?php echo $spell->casttime; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_spell_cooldown'); ?>:</strong></td>
                                    <td><?php echo $spell->cooldown; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_spell_range'); ?>:</strong></td>
                                    <td><?php echo $spell->range ?: 'Self'; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Effects</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Effect 1:</strong></td>
                                    <td><?php echo $spell->effect0 ?: 'None'; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Effect 2:</strong></td>
                                    <td><?php echo $spell->effect1 ?: 'None'; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Effect 3:</strong></td>
                                    <td><?php echo $spell->effect2 ?: 'None'; ?></td>
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
                    <a href="<?php echo site_url('database/spells'); ?>" class="btn btn-secondary btn-block mb-2">
                        <?php echo lang('database_back_to_list'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
