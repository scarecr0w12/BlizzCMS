<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fab fa-discord text-primary"></i> Discord Administration
        </h2>
        <div>
            <a href="<?= site_url('discord') ?>" class="btn btn-info mr-2" target="_blank">
                <i class="fas fa-eye"></i> View Public
            </a>
            <a href="<?= site_url('discord/admin/webhooks') ?>" class="btn btn-secondary mr-2">
                <i class="fas fa-link"></i> Webhooks
            </a>
            <a href="<?= site_url('discord/admin/settings') ?>" class="btn btn-primary">
                <i class="fas fa-cog"></i> Settings
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Linked Accounts</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($linked_count) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fab fa-discord fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Webhooks</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $webhooks_count ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-link fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">OAuth Status</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span class="badge badge-success">Configured</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shield-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Integration</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span class="badge badge-info">Active</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-plug fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-users"></i> Recent Account Links
                    </h6>
                    <span class="badge badge-primary"><?= count($recent_links) ?> Recent</span>
                </div>
                <div class="card-body">
                    <?php if (empty($recent_links)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="fab fa-discord fa-3x mb-3"></i>
                        <p>No linked accounts yet.</p>
                        <small>Users can link their Discord accounts from the Discord page.</small>
                    </div>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th><i class="fas fa-user"></i> User ID</th>
                                    <th><i class="fab fa-discord"></i> Discord Username</th>
                                    <th><i class="fas fa-hashtag"></i> Discord ID</th>
                                    <th><i class="fas fa-clock"></i> Linked Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_links as $link): ?>
                                <tr>
                                    <td><span class="badge badge-secondary"><?= $link->user_id ?></span></td>
                                    <td>
                                        <?php if ($link->discord_avatar): ?>
                                        <img src="https://cdn.discordapp.com/avatars/<?= $link->discord_id ?>/<?= $link->discord_avatar ?>.png" 
                                             class="rounded-circle mr-1" width="20" height="20" alt="">
                                        <?php endif; ?>
                                        <strong><?= htmlspecialchars($link->discord_username) ?></strong>
                                        <?php if ($link->discord_discriminator != '0'): ?>
                                        <small class="text-muted">#<?= htmlspecialchars($link->discord_discriminator) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><code><?= $link->discord_id ?></code></td>
                                    <td><?= date('M d, Y H:i', strtotime($link->linked_at)) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-info-circle"></i> Discord Features
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary"><i class="fas fa-check-circle text-success"></i> OAuth2 Login</h6>
                        <p class="small text-muted mb-2">Secure account linking with Discord authentication</p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <h6 class="text-primary"><i class="fas fa-check-circle text-success"></i> Server Widget</h6>
                        <p class="small text-muted mb-2">Display your Discord server with online members</p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <h6 class="text-primary"><i class="fas fa-check-circle text-success"></i> Webhooks</h6>
                        <p class="small text-muted mb-2">Automated notifications for server events</p>
                    </div>
                    <hr>
                    <div>
                        <h6 class="text-primary"><i class="fas fa-check-circle text-success"></i> User Sync</h6>
                        <p class="small text-muted mb-0">Keep Discord and website accounts synchronized</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary { border-left: 4px solid #4e73df !important; }
.border-left-success { border-left: 4px solid #1cc88a !important; }
.border-left-info { border-left: 4px solid #36b9cc !important; }
.border-left-warning { border-left: 4px solid #f6c23e !important; }
.shadow { box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15) !important; }
.text-gray-800 { color: #5a5c69 !important; }
.text-gray-300 { color: #dddfeb !important; }
</style>
