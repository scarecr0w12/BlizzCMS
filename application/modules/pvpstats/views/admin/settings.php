<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1><?php echo lang('pvpstats_settings'); ?></h1>
            <hr>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form method="post" class="needs-validation">
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="pvpstats_enabled" name="pvpstats_enabled" value="1" <?php echo ($settings['pvpstats_enabled'] ?? 0) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="pvpstats_enabled">
                            <?php echo lang('pvpstats_enabled'); ?>
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="pvpstats_show_details" name="pvpstats_show_details" value="1" <?php echo ($settings['pvpstats_show_details'] ?? 0) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="pvpstats_show_details">
                            <?php echo lang('pvpstats_show_details'); ?>
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="pvpstats_top_players_limit" class="form-label">
                        <?php echo lang('pvpstats_top_players_limit'); ?>
                    </label>
                    <input type="number" class="form-control" id="pvpstats_top_players_limit" name="pvpstats_top_players_limit" value="<?php echo $settings['pvpstats_top_players_limit'] ?? 20; ?>" min="1" max="100">
                </div>

                <div class="mb-3">
                    <label for="pvpstats_top_guilds_limit" class="form-label">
                        <?php echo lang('pvpstats_top_guilds_limit'); ?>
                    </label>
                    <input type="number" class="form-control" id="pvpstats_top_guilds_limit" name="pvpstats_top_guilds_limit" value="<?php echo $settings['pvpstats_top_guilds_limit'] ?? 5; ?>" min="1" max="50">
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary"><?php echo lang('save'); ?></button>
                    <a href="<?php echo site_url('pvpstats/admin'); ?>" class="btn btn-secondary"><?php echo lang('cancel'); ?></a>
                </div>
            </form>
        </div>
    </div>
</div>
