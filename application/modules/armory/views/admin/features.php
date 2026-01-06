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
            <li><a href="<?= site_url('armory/admin/display') ?>"><?= lang('armory_display') ?></a></li>
            <li class="uk-active"><a href="<?= site_url('armory/admin/features') ?>"><?= lang('armory_features') ?></a></li>
          </ul>
        </div>
      </div>
      <div class="uk-width-expand@s">
        <?= $template['partials']['alerts'] ?>
        <?= form_open(current_url()) ?>
          <h2 class="uk-h4 uk-text-bold uk-margin-remove"><?= lang('armory_features') ?></h2>
          <p class="uk-text-small uk-margin-remove-top uk-margin-small-bottom"><?= lang('armory_features_settings_desc') ?></p>
          <div class="uk-card uk-card-default uk-margin-small">
            <div class="uk-grid-small uk-grid-divider uk-child-width-1-1" uk-grid>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_enable_search') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_enable_search_desc') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <select class="uk-select tail-single" id="select_enable_search" name="enable_search" autocomplete="off" data-placeholder="<?= lang('select_option') ?>">
                        <option value="false" <?= set_select('enable_search', 'false', ! config_item('armory_enable_search')) ?>><?= lang('disable') ?></option>
                        <option value="true" <?= set_select('enable_search', 'true', config_item('armory_enable_search')) ?>><?= lang('enable') ?></option>
                      </select>
                    </div>
                    <?= form_error('enable_search', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_enable_ladder') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_enable_ladder_desc') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <select class="uk-select tail-single" id="select_enable_ladder" name="enable_ladder" autocomplete="off" data-placeholder="<?= lang('select_option') ?>">
                        <option value="false" <?= set_select('enable_ladder', 'false', ! config_item('armory_enable_ladder')) ?>><?= lang('disable') ?></option>
                        <option value="true" <?= set_select('enable_ladder', 'true', config_item('armory_enable_ladder')) ?>><?= lang('enable') ?></option>
                      </select>
                    </div>
                    <?= form_error('enable_ladder', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_enable_guilds') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_enable_guilds_desc') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <select class="uk-select tail-single" id="select_enable_guilds" name="enable_guilds" autocomplete="off" data-placeholder="<?= lang('select_option') ?>">
                        <option value="false" <?= set_select('enable_guilds', 'false', ! config_item('armory_enable_guilds')) ?>><?= lang('disable') ?></option>
                        <option value="true" <?= set_select('enable_guilds', 'true', config_item('armory_enable_guilds')) ?>><?= lang('enable') ?></option>
                      </select>
                    </div>
                    <?= form_error('enable_guilds', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Integration Settings -->
          <h2 class="uk-h4 uk-text-bold uk-margin-remove uk-margin-top"><?= lang('armory_integration_info') ?></h2>
          <p class="uk-text-small uk-margin-remove-top uk-margin-small-bottom"><?= lang('armory_integration_settings_desc') ?></p>
          <div class="uk-card uk-card-default uk-margin-small">
            <div class="uk-grid-small uk-grid-divider uk-child-width-1-1" uk-grid>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_wowhead_tooltips') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_wowhead_tooltips_desc') ?></p>
                    <p class="uk-text-small uk-text-muted uk-margin-remove"><i class="fa-solid fa-circle-info"></i> <?= lang('armory_wowhead_info') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <select class="uk-select tail-single" id="select_wowhead_tooltips" name="wowhead_tooltips" autocomplete="off" data-placeholder="<?= lang('select_option') ?>">
                        <option value="false" <?= set_select('wowhead_tooltips', 'false', ! config_item('armory_wowhead_tooltips')) ?>><?= lang('disable') ?></option>
                        <option value="true" <?= set_select('wowhead_tooltips', 'true', config_item('armory_wowhead_tooltips')) ?>><?= lang('enable') ?></option>
                      </select>
                    </div>
                    <?= form_error('wowhead_tooltips', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_3d_models') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_3d_models_desc') ?></p>
                    <p class="uk-text-small uk-text-muted uk-margin-remove"><i class="fa-solid fa-flask"></i> <?= lang('armory_3d_models_info') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <select class="uk-select tail-single" id="select_enable_3d_models" name="enable_3d_models" autocomplete="off" data-placeholder="<?= lang('select_option') ?>">
                        <option value="false" <?= set_select('enable_3d_models', 'false', ! config_item('armory_3d_models')) ?>><?= lang('disable') ?></option>
                        <option value="true" <?= set_select('enable_3d_models', 'true', config_item('armory_3d_models')) ?>><?= lang('enable') ?></option>
                      </select>
                    </div>
                    <?= form_error('enable_3d_models', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
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
