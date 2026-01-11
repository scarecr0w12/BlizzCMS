<div class="container mt-4">
    <h1 class="mb-4">Leaderboards Settings</h1>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <?= form_open('leaderboards/admin/settings') ?>
            
            <h5 class="mb-3">Enable/Disable Leaderboards</h5>
            
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="enable_pvp_rankings" value="1" 
                           class="custom-control-input" id="enablePvp" 
                           <?= ($settings['enable_pvp_rankings'] ?? '1') == '1' ? 'checked' : '' ?>>
                    <label class="custom-control-label" for="enablePvp">
                        Enable PvP Rankings
                    </label>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="enable_honor_kills" value="1" 
                           class="custom-control-input" id="enableHonor" 
                           <?= ($settings['enable_honor_kills'] ?? '1') == '1' ? 'checked' : '' ?>>
                    <label class="custom-control-label" for="enableHonor">
                        Enable Honor Rankings
                    </label>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="enable_arena_rankings" value="1" 
                           class="custom-control-input" id="enableArena" 
                           <?= ($settings['enable_arena_rankings'] ?? '1') == '1' ? 'checked' : '' ?>>
                    <label class="custom-control-label" for="enableArena">
                        Enable Arena Rankings
                    </label>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="enable_achievements" value="1" 
                           class="custom-control-input" id="enableAch" 
                           <?= ($settings['enable_achievements'] ?? '1') == '1' ? 'checked' : '' ?>>
                    <label class="custom-control-label" for="enableAch">
                        Enable Achievement Rankings
                    </label>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="enable_professions" value="1" 
                           class="custom-control-input" id="enableProf" 
                           <?= ($settings['enable_professions'] ?? '1') == '1' ? 'checked' : '' ?>>
                    <label class="custom-control-label" for="enableProf">
                        Enable Profession Rankings
                    </label>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="enable_guild_rankings" value="1" 
                           class="custom-control-input" id="enableGuild" 
                           <?= ($settings['enable_guild_rankings'] ?? '1') == '1' ? 'checked' : '' ?>>
                    <label class="custom-control-label" for="enableGuild">
                        Enable Guild Rankings
                    </label>
                </div>
            </div>

            <hr>

            <h5 class="mb-3">Display Settings</h5>

            <div class="form-group">
                <label>Items Per Page</label>
                <input type="number" name="items_per_page" class="form-control" 
                       value="<?= $settings['items_per_page'] ?? 50 ?>" min="10" max="100">
                <small class="form-text text-muted">Number of items to show per page (10-100)</small>
            </div>

            <div class="form-group">
                <label>Cache Duration (seconds)</label>
                <input type="number" name="cache_duration" class="form-control" 
                       value="<?= $settings['cache_duration'] ?? 300 ?>" min="60" max="3600">
                <small class="form-text text-muted">How long to cache leaderboard data (60-3600 seconds)</small>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Settings
            </button>
            <a href="<?= site_url('leaderboards/admin') ?>" class="btn btn-secondary">Back</a>
            
            <?= form_close() ?>
        </div>
    </div>
</div>
