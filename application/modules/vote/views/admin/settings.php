<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_panel') ?></a></li>
          <li><a href="<?= site_url('vote/admin') ?>"><?= lang('vote') ?></a></li>
          <li><span><?= lang('settings') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-cog"></i> <?= lang('vote_settings') ?>
        </h1>
      </div>
    </div>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body">
        <?= form_open('vote/admin/settings', ['class' => 'uk-form-stacked']) ?>
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="vote_enabled"><?= lang('vote_enabled') ?></label>
                <div class="uk-form-controls">
                  <label class="uk-switch">
                    <input type="checkbox" name="vote_enabled" id="vote_enabled" value="1" <?= config_item('vote_enabled') ? 'checked' : '' ?>>
                    <span class="uk-switch-slider uk-switch-primary"></span>
                  </label>
                  <span class="uk-margin-small-left"><?= lang('vote_enabled_help') ?></span>
                </div>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="vote_cooldown_hours"><?= lang('vote_default_cooldown') ?></label>
                <div class="uk-form-controls">
                  <div class="uk-inline">
                    <span class="uk-form-icon uk-form-icon-flip"><i class="fa-solid fa-clock"></i></span>
                    <input class="uk-input" id="vote_cooldown_hours" type="number" name="vote_cooldown_hours" value="<?= config_item('vote_cooldown_hours') ?? 12 ?>" min="1" max="168">
                  </div>
                </div>
                <span class="uk-text-small uk-text-muted"><?= lang('vote_cooldown_help') ?></span>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="vote_points_per_vote"><?= lang('vote_default_vp') ?></label>
                <div class="uk-form-controls">
                  <div class="uk-inline">
                    <span class="uk-form-icon uk-form-icon-flip"><i class="fa-solid fa-coins"></i></span>
                    <input class="uk-input" id="vote_points_per_vote" type="number" name="vote_points_per_vote" value="<?= config_item('vote_points_per_vote') ?? 1 ?>" min="1">
                  </div>
                </div>
                <span class="uk-text-small uk-text-muted"><?= lang('vote_default_vp_help') ?></span>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="vote_ip_check"><?= lang('vote_ip_check') ?></label>
                <div class="uk-form-controls">
                  <label class="uk-switch">
                    <input type="checkbox" name="vote_ip_check" id="vote_ip_check" value="1" <?= config_item('vote_ip_check') ? 'checked' : '' ?>>
                    <span class="uk-switch-slider uk-switch-primary"></span>
                  </label>
                  <span class="uk-margin-small-left"><?= lang('vote_ip_check_help') ?></span>
                </div>
              </div>
            </div>
          </div>

          <hr class="uk-divider-icon">

          <h4><?= lang('vote_display_settings') ?></h4>
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="vote_top_voters_count"><?= lang('vote_top_voters_count') ?></label>
                <div class="uk-form-controls">
                  <input class="uk-input" id="vote_top_voters_count" type="number" name="vote_top_voters_count" value="<?= config_item('vote_top_voters_count') ?? 10 ?>" min="5" max="100">
                </div>
                <span class="uk-text-small uk-text-muted"><?= lang('vote_top_voters_count_help') ?></span>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="vote_show_top_sidebar"><?= lang('vote_show_top_sidebar') ?></label>
                <div class="uk-form-controls">
                  <label class="uk-switch">
                    <input type="checkbox" name="vote_show_top_sidebar" id="vote_show_top_sidebar" value="1" <?= config_item('vote_show_top_sidebar') ? 'checked' : '' ?>>
                    <span class="uk-switch-slider uk-switch-primary"></span>
                  </label>
                  <span class="uk-margin-small-left"><?= lang('vote_show_top_sidebar_help') ?></span>
                </div>
              </div>
            </div>
          </div>

          <div class="uk-margin-top">
            <button type="submit" class="uk-button uk-button-primary">
              <i class="fa-solid fa-save"></i> <?= lang('save') ?>
            </button>
          </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</section>
