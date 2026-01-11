<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><?= lang('playermap_settings') ?></h4>
                    <a href="<?= site_url('playermap/admin') ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> <?= lang('back') ?>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?= form_open(site_url('playermap/admin/settings'), ['method' => 'post']) ?>
                
                <div class="form-group">
                    <label for="server_type"><?= lang('playermap_server_type') ?></label>
                    <select name="server_type" id="server_type" class="form-control">
                        <option value="0" <?= set_select('server_type', '0', $config['server_type'] == 0) ?>>
                            MaNGOS
                        </option>
                        <option value="1" <?= set_select('server_type', '1', $config['server_type'] == 1) ?>>
                            AzerothCore / TrinityCore
                        </option>
                    </select>
                    <small class="form-text text-muted">
                        <?= lang('playermap_server_type_help') ?>
                    </small>
                </div>

                <hr>

                <h5><?= lang('playermap_gm_settings') ?></h5>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="gm_show_online" name="gm_show_online" value="1" <?= set_checkbox('gm_show_online', '1', $config['gm_show_online']) ?>>
                        <label class="custom-control-label" for="gm_show_online">
                            <?= lang('playermap_gm_show_online') ?>
                        </label>
                    </div>
                    <small class="form-text text-muted">
                        <?= lang('playermap_gm_show_online_help') ?>
                    </small>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="gm_include_count" name="gm_include_count" value="1" <?= set_checkbox('gm_include_count', '1', $config['gm_include_count']) ?>>
                        <label class="custom-control-label" for="gm_include_count">
                            <?= lang('playermap_gm_include_count') ?>
                        </label>
                    </div>
                    <small class="form-text text-muted">
                        <?= lang('playermap_gm_include_count_help') ?>
                    </small>
                </div>

                <div class="alert alert-info">
                    <strong><?= lang('note') ?>:</strong> <?= lang('playermap_gm_additional_settings') ?>
                    <ul class="mb-0 mt-2">
                        <li><strong>GM Only GM Off:</strong> <?= $config['gm_only_gmoff'] ? lang('enabled') : lang('disabled') ?></li>
                        <li><strong>GM Only Visible:</strong> <?= $config['gm_only_gmvisible'] ? lang('enabled') : lang('disabled') ?></li>
                        <li><strong>Add GM Suffix:</strong> <?= $config['gm_add_suffix'] ? lang('enabled') : lang('disabled') ?></li>
                    </ul>
                </div>

                <hr>

                <h5><?= lang('playermap_display_settings') ?></h5>

                <div class="form-group">
                    <label for="update_interval"><?= lang('playermap_update_interval') ?></label>
                    <input type="number" name="update_interval" id="update_interval" class="form-control" min="0" max="60" value="<?= set_value('update_interval', $config['update_interval']) ?>">
                    <small class="form-text text-muted">
                        <?= lang('playermap_update_interval_help') ?>
                    </small>
                </div>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> 
                    <strong><?= lang('warning') ?>:</strong> <?= lang('playermap_settings_manual_edit') ?>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?= lang('save_changes') ?>
                    </button>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
