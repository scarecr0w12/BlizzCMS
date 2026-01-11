<div class="uk-container">
    <h1 class="uk-margin-bottom"><?= lang('serverstatus_settings_title') ?></h1>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="uk-alert-success uk-margin-bottom" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <?= $this->session->flashdata('success') ?>
    </div>
    <?php endif; ?>

    <div class="uk-card uk-card-default">
        <div class="uk-card-body">
            <?= form_open('serverstatus/admin/settings') ?>
            
            <div class="uk-margin">
                <label class="uk-form-label"><?= lang('serverstatus_enable_realtime') ?></label>
                <div class="uk-form-controls">
                    <select name="enable_realtime_updates" class="uk-select">
                        <option value="1" <?= ($settings['enable_realtime_updates'] ?? '1') == '1' ? 'selected' : '' ?>>Enabled</option>
                        <option value="0" <?= ($settings['enable_realtime_updates'] ?? '1') == '0' ? 'selected' : '' ?>>Disabled</option>
                    </select>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label"><?= lang('serverstatus_update_interval') ?></label>
                <div class="uk-form-controls">
                    <input type="number" name="update_interval" class="uk-input" 
                           value="<?= $settings['update_interval'] ?? 30 ?>" min="10" max="300">
                    <small class="uk-text-muted uk-display-block uk-margin-small-top">Recommended: 30-60 seconds</small>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-checkbox">
                    <input type="checkbox" name="show_faction_balance" value="1" 
                           <?= ($settings['show_faction_balance'] ?? '1') == '1' ? 'checked' : '' ?>>
                    <span><?= lang('serverstatus_show_faction') ?></span>
                </label>
            </div>

            <div class="uk-margin">
                <label class="uk-checkbox">
                    <input type="checkbox" name="show_class_distribution" value="1" 
                           <?= ($settings['show_class_distribution'] ?? '1') == '1' ? 'checked' : '' ?>>
                    <span><?= lang('serverstatus_show_classes') ?></span>
                </label>
            </div>

            <div class="uk-margin">
                <label class="uk-checkbox">
                    <input type="checkbox" name="show_level_distribution" value="1" 
                           <?= ($settings['show_level_distribution'] ?? '1') == '1' ? 'checked' : '' ?>>
                    <span><?= lang('serverstatus_show_levels') ?></span>
                </label>
            </div>

            <div class="uk-margin">
                <label class="uk-checkbox">
                    <input type="checkbox" name="track_uptime" value="1" 
                           <?= ($settings['track_uptime'] ?? '1') == '1' ? 'checked' : '' ?>>
                    <span><?= lang('serverstatus_track_uptime') ?></span>
                </label>
            </div>

            <div class="uk-margin-top">
                <button type="submit" class="uk-button uk-button-primary">
                    <i class="fas fa-save"></i> Save Settings
                </button>
                <a href="<?= site_url('serverstatus/admin') ?>" class="uk-button uk-button-default">Cancel</a>
            </div>
            
            <?= form_close() ?>
        </div>
    </div>
</div>
