<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1><?php echo lang('database_search'); ?></h1>
            <?php if (isset($query)): ?>
                <p class="text-muted">Results for: <strong><?php echo htmlspecialchars($query); ?></strong></p>
            <?php endif; ?>
        </div>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-warning">
            <?php echo $error; ?>
        </div>
    <?php else: ?>
        <?php if (isset($items) && !empty($items)): ?>
            <div class="mb-5">
                <h3><?php echo lang('database_items'); ?> (<?php echo isset($items_total) ? $items_total : count($items); ?>)</h3>
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
            </div>
        <?php endif; ?>

        <?php if (isset($spells) && !empty($spells)): ?>
            <div class="mb-5">
                <h3><?php echo lang('database_spells'); ?> (<?php echo isset($spells_total) ? $spells_total : count($spells); ?>)</h3>
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
                                    <td><span class="badge bg-info"><?php echo $spell->school; ?></span></td>
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
            </div>
        <?php endif; ?>

        <?php if (isset($quests) && !empty($quests)): ?>
            <div class="mb-5">
                <h3><?php echo lang('database_quests'); ?> (<?php echo isset($quests_total) ? $quests_total : count($quests); ?>)</h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th><?php echo lang('database_quest_name'); ?></th>
                                <th><?php echo lang('database_quest_level'); ?></th>
                                <th><?php echo lang('database_quest_type'); ?></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($quests as $quest): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($quest->title); ?></td>
                                    <td><?php echo $quest->questlevel; ?></td>
                                    <td><span class="badge bg-success"><?php echo $quest->qtype; ?></span></td>
                                    <td>
                                        <a href="<?php echo site_url('database/quest/' . $quest->id); ?>" class="btn btn-sm btn-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($creatures) && !empty($creatures)): ?>
            <div class="mb-5">
                <h3><?php echo lang('database_creatures'); ?> (<?php echo isset($creatures_total) ? $creatures_total : count($creatures); ?>)</h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th><?php echo lang('database_creature_name'); ?></th>
                                <th><?php echo lang('database_creature_level'); ?></th>
                                <th><?php echo lang('database_creature_type'); ?></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($creatures as $creature): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($creature->name); ?></td>
                                    <td><?php echo $creature->minlevel . ' - ' . $creature->maxlevel; ?></td>
                                    <td><?php echo $creature->type; ?></td>
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
            </div>
        <?php endif; ?>

        <?php if (!isset($items) && !isset($spells) && !isset($quests) && !isset($creatures)): ?>
            <div class="alert alert-info">
                <?php echo lang('database_no_results'); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
