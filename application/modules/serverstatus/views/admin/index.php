<div class="uk-container">
    <div class="uk-flex uk-flex-between uk-flex-middle uk-margin-bottom">
        <h2 class="uk-margin-remove">
            <i class="fas fa-server"></i> Server Status Administration
        </h2>
        <a href="<?= site_url('serverstatus/admin/settings') ?>" class="uk-button uk-button-primary">
            <i class="fas fa-cog"></i> Settings
        </a>
    </div>

    <?php if (!empty($table_missing)): ?>
    <div class="uk-alert-warning uk-padding-small uk-margin-bottom" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <h4><i class="fas fa-exclamation-triangle"></i> Database Tables Not Found</h4>
        <p class="uk-margin-small">The server status module tables have not been created yet. Please import the SQL file:</p>
        <code class="uk-display-block uk-padding-small uk-background-muted uk-margin-small">mysql -u root -p blizzcms < INSTALL_MODULES.sql</code>
    </div>
    <?php endif; ?>

    <div class="uk-grid-small uk-margin-bottom" uk-grid>
        <div class="uk-width-1-1 uk-width-1-2@s uk-width-1-4@m">
            <div class="uk-card uk-card-default uk-card-hover">
                <div class="uk-card-body">
                    <div class="uk-flex uk-flex-between uk-flex-middle">
                        <div>
                            <div class="uk-text-small uk-text-uppercase uk-text-muted">Total Records</div>
                            <div class="uk-text-lead uk-text-bold"><?= number_format($stats_overview['total_records']) ?></div>
                        </div>
                        <div>
                            <i class="fas fa-database fa-2x uk-text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-width-1-1 uk-width-1-2@s uk-width-1-4@m">
            <div class="uk-card uk-card-default uk-card-hover">
                <div class="uk-card-body">
                    <div class="uk-flex uk-flex-between uk-flex-middle">
                        <div>
                            <div class="uk-text-small uk-text-uppercase uk-text-muted">Realms Tracked</div>
                            <div class="uk-text-lead uk-text-bold"><?= $stats_overview['realms_tracked'] ?></div>
                        </div>
                        <div>
                            <i class="fas fa-network-wired fa-2x uk-text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-width-1-1 uk-width-1-2@s uk-width-1-4@m">
            <div class="uk-card uk-card-default uk-card-hover">
                <div class="uk-card-body">
                    <div class="uk-flex uk-flex-between uk-flex-middle">
                        <div>
                            <div class="uk-text-small uk-text-uppercase uk-text-muted">Module Status</div>
                            <div class="uk-text-lead uk-text-bold">
                                <?php if (empty($table_missing)): ?>
                                <span class="uk-badge uk-badge-success">Active</span>
                                <?php else: ?>
                                <span class="uk-badge uk-badge-warning">Setup Required</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-check-circle fa-2x uk-text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-width-1-1 uk-width-1-2@s uk-width-1-4@m">
            <div class="uk-card uk-card-default uk-card-hover">
                <div class="uk-card-body">
                    <div class="uk-flex uk-flex-between uk-flex-middle">
                        <div>
                            <div class="uk-text-small uk-text-uppercase uk-text-muted">Quick Actions</div>
                            <div class="uk-margin-top">
                                <a href="<?= site_url('serverstatus') ?>" class="uk-button uk-button-small uk-button-default" target="_blank">
                                    <i class="fas fa-eye"></i> View Public
                                </a>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-bolt fa-2x uk-text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($table_missing)): ?>
    <div class="uk-card uk-card-default uk-margin-bottom">
        <div class="uk-card-header uk-flex uk-flex-between uk-flex-middle">
            <h5 class="uk-margin-remove">
                <i class="fas fa-history"></i> Recent History (Last 24 Hours)
            </h5>
            <span class="uk-badge"><?= count($recent_history) ?> Records</span>
        </div>
        <div class="uk-card-body">
            <?php if (empty($recent_history)): ?>
            <div class="uk-text-center uk-text-muted uk-padding">
                <i class="fas fa-inbox fa-3x uk-display-block uk-margin-bottom"></i>
                <p>No history data available yet.</p>
                <small>Server statistics will appear here once tracking begins.</small>
            </div>
            <?php else: ?>
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-hover uk-table-small">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> Realm</th>
                            <th><i class="fas fa-clock"></i> Timestamp</th>
                            <th><i class="fas fa-users"></i> Online</th>
                            <th><i class="fas fa-shield-alt"></i> Alliance</th>
                            <th><i class="fas fa-fist-raised"></i> Horde</th>
                            <th><i class="fas fa-hourglass-half"></i> Uptime</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_history as $record): ?>
                        <tr>
                            <td><span class="uk-badge"><?= $record->realm_id ?></span></td>
                            <td><?= date('M d, Y H:i', strtotime($record->timestamp)) ?></td>
                            <td><strong><?= $record->online_players ?></strong></td>
                            <td><?= $record->alliance_count ?></td>
                            <td><?= $record->horde_count ?></td>
                            <td><code><?= gmdate("H:i:s", $record->uptime_seconds) ?></code></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
