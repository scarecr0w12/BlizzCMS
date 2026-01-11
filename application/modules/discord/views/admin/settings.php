<div class="container mt-4">
    <h1 class="mb-4"><?= lang('discord_settings') ?></h1>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <?= form_open('discord/admin/settings') ?>
            
            <h5 class="mb-3">OAuth Settings</h5>
            
            <div class="form-group">
                <label><?= lang('discord_enable_oauth') ?></label>
                <select name="enable_oauth" class="form-control">
                    <option value="1" <?= ($settings['enable_oauth'] ?? '0') == '1' ? 'selected' : '' ?>>Enabled</option>
                    <option value="0" <?= ($settings['enable_oauth'] ?? '0') == '0' ? 'selected' : '' ?>>Disabled</option>
                </select>
            </div>

            <div class="form-group">
                <label><?= lang('discord_client_id') ?></label>
                <input type="text" name="client_id" class="form-control" 
                       value="<?= htmlspecialchars($settings['client_id'] ?? '') ?>" 
                       placeholder="Your Discord Application Client ID">
            </div>

            <div class="form-group">
                <label><?= lang('discord_client_secret') ?></label>
                <input type="password" name="client_secret" class="form-control" 
                       value="<?= htmlspecialchars($settings['client_secret'] ?? '') ?>" 
                       placeholder="Your Discord Application Client Secret">
            </div>

            <div class="form-group">
                <label><?= lang('discord_redirect_uri') ?></label>
                <input type="text" name="redirect_uri" class="form-control" 
                       value="<?= htmlspecialchars($settings['redirect_uri'] ?? site_url('discord/callback')) ?>" 
                       placeholder="<?= site_url('discord/callback') ?>">
                <small class="form-text text-muted">This must match the redirect URI in your Discord application settings</small>
            </div>

            <hr>

            <h5 class="mb-3">Server Widget</h5>

            <div class="form-group">
                <label><?= lang('discord_guild_id') ?></label>
                <input type="text" name="guild_id" class="form-control" 
                       value="<?= htmlspecialchars($settings['guild_id'] ?? '') ?>" 
                       placeholder="Your Discord Server/Guild ID">
            </div>

            <div class="form-group">
                <label><?= lang('discord_enable_widget') ?></label>
                <select name="widget_enabled" class="form-control">
                    <option value="1" <?= ($settings['widget_enabled'] ?? '1') == '1' ? 'selected' : '' ?>>Enabled</option>
                    <option value="0" <?= ($settings['widget_enabled'] ?? '1') == '0' ? 'selected' : '' ?>>Disabled</option>
                </select>
            </div>

            <hr>

            <h5 class="mb-3">Bot & Webhooks</h5>

            <div class="form-group">
                <label><?= lang('discord_bot_token') ?></label>
                <input type="password" name="bot_token" class="form-control" 
                       value="<?= htmlspecialchars($settings['bot_token'] ?? '') ?>" 
                       placeholder="Your Discord Bot Token (optional)">
            </div>

            <div class="form-group">
                <label><?= lang('discord_webhook_url') ?></label>
                <input type="text" name="webhook_url" class="form-control" 
                       value="<?= htmlspecialchars($settings['webhook_url'] ?? '') ?>" 
                       placeholder="Default Webhook URL">
            </div>

            <div class="form-group">
                <label><?= lang('discord_webhook_enabled') ?></label>
                <select name="webhook_enabled" class="form-control">
                    <option value="1" <?= ($settings['webhook_enabled'] ?? '0') == '1' ? 'selected' : '' ?>>Enabled</option>
                    <option value="0" <?= ($settings['webhook_enabled'] ?? '0') == '0' ? 'selected' : '' ?>>Disabled</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Settings
            </button>
            <a href="<?= site_url('discord/admin') ?>" class="btn btn-secondary">Back</a>
            
            <?= form_close() ?>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Setup Instructions</h5>
        </div>
        <div class="card-body">
            <ol>
                <li>Go to <a href="https://discord.com/developers/applications" target="_blank">Discord Developer Portal</a></li>
                <li>Create a new application or select an existing one</li>
                <li>Copy the <strong>Client ID</strong> and <strong>Client Secret</strong> from the OAuth2 tab</li>
                <li>Add <code><?= site_url('discord/callback') ?></code> to OAuth2 Redirects</li>
                <li>For the widget, enable it in your Discord server settings under Widget</li>
                <li>Copy your server ID and paste it above</li>
            </ol>
        </div>
    </div>
</div>
