<div class="container mt-4">
    <h1 class="mb-4"><?= lang('discord_webhooks') ?></h1>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><?= lang('discord_webhook_add') ?></h5>
        </div>
        <div class="card-body">
            <?= form_open('discord/admin/webhooks') ?>
            <input type="hidden" name="action" value="add">
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><?= lang('discord_webhook_name') ?></label>
                        <input type="text" name="webhook_name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label><?= lang('discord_webhook_event') ?></label>
                        <select name="event_type" class="form-control" required>
                            <option value="registration"><?= lang('discord_event_registration') ?></option>
                            <option value="donation"><?= lang('discord_event_donation') ?></option>
                            <option value="shop"><?= lang('discord_event_shop') ?></option>
                            <option value="vote"><?= lang('discord_event_vote') ?></option>
                            <option value="news"><?= lang('discord_event_news') ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="enabled" class="form-control">
                            <option value="1">Enabled</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label><?= lang('discord_webhook_url') ?></label>
                <input type="url" name="webhook_url" class="form-control" required 
                       placeholder="https://discord.com/api/webhooks/...">
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Webhook
            </button>
            
            <?= form_close() ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Active Webhooks</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Event Type</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($webhooks as $webhook): ?>
                        <tr>
                            <td><?= htmlspecialchars($webhook->webhook_name) ?></td>
                            <td><span class="badge badge-info"><?= htmlspecialchars($webhook->event_type) ?></span></td>
                            <td>
                                <?php if ($webhook->enabled): ?>
                                <span class="badge badge-success">Enabled</span>
                                <?php else: ?>
                                <span class="badge badge-secondary">Disabled</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('Y-m-d', strtotime($webhook->created_at)) ?></td>
                            <td>
                                <a href="<?= site_url("discord/admin/webhooks?delete={$webhook->id}") ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this webhook?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
