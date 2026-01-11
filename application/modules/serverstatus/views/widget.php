<div class="server-status-widget" data-realm-id="<?= $realm->id ?>">
    <div class="widget-header">
        <span class="realm-name"><?= htmlspecialchars($realm->name) ?></span>
        <span class="realm-status badge badge-<?= $realm->online_count > 0 ? 'success' : 'danger' ?>">
            <?= $realm->online_count > 0 ? 'Online' : 'Offline' ?>
        </span>
    </div>
    <div class="widget-body">
        <div class="stat-item">
            <span class="stat-label">Players Online:</span>
            <span class="stat-value" id="widget-online-<?= $realm->id ?>"><?= $realm->online_count ?></span>
        </div>
        <div class="stat-item">
            <span class="stat-label">Uptime:</span>
            <span class="stat-value"><?= gmdate("H:i:s", $realm->uptime) ?></span>
        </div>
    </div>
</div>

<style>
.server-status-widget {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 15px;
    margin: 10px 0;
}
.widget-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}
.realm-name {
    font-weight: bold;
    font-size: 16px;
}
.stat-item {
    display: flex;
    justify-content: space-between;
    padding: 5px 0;
}
.stat-label {
    color: #666;
}
.stat-value {
    font-weight: bold;
}
</style>
