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
            <li class="uk-active"><a href="<?= site_url('armory/admin') ?>"><?= lang('general') ?></a></li>
            <li><a href="<?= site_url('armory/admin/display') ?>"><?= lang('armory_display') ?></a></li>
            <li><a href="<?= site_url('armory/admin/features') ?>"><?= lang('armory_features') ?></a></li>
          </ul>
        </div>
      </div>
      <div class="uk-width-expand@s">
        <?= $template['partials']['alerts'] ?>
        <?= form_open(current_url()) ?>
          <h2 class="uk-h4 uk-text-bold uk-margin-remove"><?= lang('general') ?></h2>
          <p class="uk-text-small uk-margin-remove-top uk-margin-small-bottom"><?= lang('armory_general_settings_desc') ?></p>
          <div class="uk-card uk-card-default uk-margin-small">
            <div class="uk-grid-small uk-grid-divider uk-child-width-1-1" uk-grid>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_enabled') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_enabled_desc') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <select class="uk-select tail-single" id="select_enabled" name="enabled" autocomplete="off" data-placeholder="<?= lang('select_option') ?>">
                        <option value="false" <?= set_select('enabled', 'false', ! config_item('armory_enabled')) ?>><?= lang('disable') ?></option>
                        <option value="true" <?= set_select('enabled', 'true', config_item('armory_enabled')) ?>><?= lang('enable') ?></option>
                      </select>
                    </div>
                    <?= form_error('enabled', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_cache_time') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_cache_time_desc') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <input class="uk-input" type="number" name="cache_time" value="<?= set_value('cache_time', config_item('armory_cache_time') ?? 300) ?>" min="0" autocomplete="off">
                    </div>
                    <?= form_error('cache_time', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_items_per_page') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_items_per_page_desc') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <input class="uk-input" type="number" name="items_per_page" value="<?= set_value('items_per_page', config_item('armory_items_per_page') ?? 25) ?>" min="1" max="100" autocomplete="off">
                    </div>
                    <?= form_error('items_per_page', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_search_min_chars') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_search_min_chars_desc') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <input class="uk-input" type="number" name="search_min_chars" value="<?= set_value('search_min_chars', config_item('armory_search_min_chars') ?? 2) ?>" min="1" max="10" autocomplete="off">
                    </div>
                    <?= form_error('search_min_chars', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                  </div>
                </div>
              </div>
              <div>
                <div class="uk-grid-small uk-flex uk-flex-middle uk-padding-small" uk-grid>
                  <div class="uk-width-expand">
                    <p class="uk-text-secondary uk-text-bold uk-margin-remove"><?= lang('armory_arena_min_games') ?></p>
                    <p class="uk-text-small uk-margin-remove"><?= lang('armory_arena_min_games_desc') ?></p>
                  </div>
                  <div class="uk-width-1-2 uk-width-2-5@m">
                    <div class="uk-form-controls">
                      <input class="uk-input" type="number" name="arena_min_games" value="<?= set_value('arena_min_games', config_item('armory_arena_min_games') ?? 10) ?>" min="0" autocomplete="off">
                    </div>
                    <?= form_error('arena_min_games', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
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
