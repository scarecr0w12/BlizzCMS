<div class="container mt-4">
    <h1 class="mb-4"><?= lang('discord_title') ?></h1>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Account Linking</h5>
                </div>
                <div class="card-body">
                    <?php if ($linked): ?>
                    <div class="alert alert-success">
                        <i class="fab fa-discord fa-2x float-left mr-3"></i>
                        <h5><?= lang('discord_linked') ?></h5>
                        <p class="mb-0">
                            <strong><?= lang('discord_username') ?>:</strong> 
                            <?= htmlspecialchars($discord_user->discord_username) ?>#<?= htmlspecialchars($discord_user->discord_discriminator) ?>
                        </p>
                    </div>
                    <a href="<?= site_url('discord/unlink') ?>" class="btn btn-danger" 
                       onclick="return confirm('Are you sure you want to unlink your Discord account?')">
                        <i class="fab fa-discord"></i> <?= lang('discord_unlink_account') ?>
                    </a>
                    <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fab fa-discord fa-2x float-left mr-3"></i>
                        <h5><?= lang('discord_not_linked') ?></h5>
                        <p class="mb-0">Link your Discord account to access exclusive features and stay connected with our community.</p>
                    </div>
                    <?php if ($settings['enable_oauth'] ?? false): ?>
                    <a href="<?= site_url('discord/auth') ?>" class="btn btn-primary">
                        <i class="fab fa-discord"></i> <?= lang('discord_link_account') ?>
                    </a>
                    <?php else: ?>
                    <p class="text-muted">Discord authentication is currently disabled.</p>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <?php if ($settings['widget_enabled'] ?? false): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Discord Server</h5>
                </div>
                <div class="card-body p-0">
                    <iframe src="https://discord.com/widget?id=<?= htmlspecialchars($settings['guild_id'] ?? '') ?>&theme=dark" 
                            width="100%" height="500" allowtransparency="true" frameborder="0" 
                            sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts">
                    </iframe>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
