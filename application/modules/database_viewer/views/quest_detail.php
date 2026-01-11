<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1><?php echo htmlspecialchars($quest->title); ?></h1>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Quest Information</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Quest ID:</strong></td>
                                    <td><?php echo $quest->id; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_quest_level'); ?>:</strong></td>
                                    <td><?php echo $quest->questlevel; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo lang('database_quest_type'); ?>:</strong></td>
                                    <td><span class="badge bg-success"><?php echo $quest->qtype; ?></span></td>
                                </tr>
                                <tr>
                                    <td><strong>Min Level:</strong></td>
                                    <td><?php echo $quest->minlevel; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Rewards</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Experience:</strong></td>
                                    <td><?php echo $quest->RewardXP ?: '0'; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Money:</strong></td>
                                    <td><?php echo $quest->RewardMoney ?: '0'; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Reputation:</strong></td>
                                    <td><?php echo $quest->RewardRepFaction1 ?: 'None'; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <?php if ($quest->LogDescription): ?>
                        <div class="mt-4">
                            <h5>Description</h5>
                            <p><?php echo htmlspecialchars($quest->LogDescription); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($quest->Objectives): ?>
                        <div class="mt-4">
                            <h5>Objectives</h5>
                            <p><?php echo htmlspecialchars($quest->Objectives); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <a href="<?php echo site_url('database/quests'); ?>" class="btn btn-secondary btn-block mb-2">
                        <?php echo lang('database_back_to_list'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
