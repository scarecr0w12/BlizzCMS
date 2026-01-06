<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('dashboard') ?></a></li>
          <li><a href="<?= site_url('admin/modules') ?>"><?= lang('modules') ?></a></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('armory_settings') ?></h1>
      </div>
      <div class="uk-width-auto"></div>
    </div>
    <div class="uk-margin" uk-grid>
      <div class="uk-width-1-3@s uk-width-1-4@m">
        <div class="uk-card uk-card-default">
          <ul class="uk-nav-default" uk-nav>
            <li class="uk-nav-header"><?= lang('armory') ?></li>
            <li><a href="<?= site_url('armory/admin') ?>"><?= lang('general') ?></a></li>
            <li class="uk-active"><a href="<?= site_url('armory/admin/display') ?>"><?= lang('armory_display') ?></a></li>
            <li><a href="<?= site_url('armory/admin/features') ?>"><?= lang('armory_features') ?></a></li>
          </ul>
        </div>
      </div>
      <div class="uk-width-expand@s">
        <?= $template['partials']['alerts'] ?>
        <?= form_open(current_url()) ?>
          <h2 class="uk-h4 uk-text-bold uk-margin-remove"><?= lang('armory_display') ?></h2>
          <p class="uk-text-small uk-margin-remove-top uk-margin-small-bottom"><?= lang('armory_display_settings_desc') ?></p>
          <div class="uk-card uk-card-default uk-margin-small">
            <div class="uk-grid-small uk-grid-divider uk-child-width-1-1" uk-grid>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_show_offline') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_show_offline_desc') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <select class="uk-select tail-single" id="select_show_offline" name="show_offline" autocomplete="off" data-placeholder="<?= lang('select_option') ?>">
                        <option value="false" <?= set_select('show_offline', 'false', ! config_item('armory_show_offline')) ?>><?= lang('disable') ?></option>
                        <option value="true" <?= set_select('show_offline', 'true', config_item('armory_show_offline')) ?>><?= lang('enable') ?></option>
                      </select>
                    </div>
                    <?= form_error('show_offline', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_show_guild') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_show_guild_desc') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <select class="uk-select tail-single" id="select_show_guild" name="show_guild" autocomplete="off" data-placeholder="<?= lang('select_option') ?>">
                        <option value="false" <?= set_select('show_guild', 'false', ! config_item('armory_show_guild')) ?>><?= lang('disable') ?></option>
                        <option value="true" <?= set_select('show_guild', 'true', config_item('armory_show_guild')) ?>><?= lang('enable') ?></option>
                      </select>
                    </div>
                    <?= form_error('show_guild', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_show_arena') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_show_arena_desc') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <select class="uk-select tail-single" id="select_show_arena" name="show_arena" autocomplete="off" data-placeholder="<?= lang('select_option') ?>">
                        <option value="false" <?= set_select('show_arena', 'false', ! config_item('armory_show_arena')) ?>><?= lang('disable') ?></option>
                        <option value="true" <?= set_select('show_arena', 'true', config_item('armory_show_arena')) ?>><?= lang('enable') ?></option>
                      </select>
                    </div>
                    <?= form_error('show_arena', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_show_achievements') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_show_achievements_desc') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <select class="uk-select tail-single" id="select_show_achievements" name="show_achievements" autocomplete="off" data-placeholder="<?= lang('select_option') ?>">
                        <option value="false" <?= set_select('show_achievements', 'false', ! config_item('armory_show_achievements')) ?>><?= lang('disable') ?></option>
                        <option value="true" <?= set_select('show_achievements', 'true', config_item('armory_show_achievements')) ?>><?= lang('enable') ?></option>
                      </select>
                    </div>
                    <?= form_error('show_achievements', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_show_talents') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_show_talents_desc') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <select class="uk-select tail-single" id="select_show_talents" name="show_talents" autocomplete="off" data-placeholder="<?= lang('select_option') ?>">
                        <option value="false" <?= set_select('show_talents', 'false', ! config_item('armory_show_talents')) ?>><?= lang('disable') ?></option>
                        <option value="true" <?= set_select('show_talents', 'true', config_item('armory_show_talents')) ?>><?= lang('enable') ?></option>
                      </select>
                    </div>
                    <?= form_error('show_talents', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_show_pvp') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_show_pvp_desc') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <select class="uk-select tail-single" id="select_show_pvp" name="show_pvp" autocomplete="off" data-placeholder="<?= lang('select_option') ?>">
                        <option value="false" <?= set_select('show_pvp', 'false', ! config_item('armory_show_pvp')) ?>><?= lang('disable') ?></option>
                        <option value="true" <?= set_select('show_pvp', 'true', config_item('armory_show_pvp')) ?>><?= lang('enable') ?></option>
                      </select>
                    </div>
                    <?= form_error('show_pvp', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_hide_gms') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_hide_gms_desc') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <select class="uk-select tail-single" id="select_hide_gms" name="hide_gms" autocomplete="off" data-placeholder="<?= lang('select_option') ?>">
                        <option value="false" <?= set_select('hide_gms', 'false', ! config_item('armory_hide_gms')) ?>><?= lang('disable') ?></option>
                        <option value="true" <?= set_select('hide_gms', 'true', config_item('armory_hide_gms')) ?>><?= lang('enable') ?></option>
                      </select>
                    </div>
                    <?= form_error('hide_gms', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="uk-margin-small">
            <button class="uk-button uk-button-primary" type="submit"><?= lang('save') ?></button>
          </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</section>
