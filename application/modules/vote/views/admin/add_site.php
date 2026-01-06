<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_panel') ?></a></li>
          <li><a href="<?= site_url('admin/vote') ?>"><?= lang('vote') ?></a></li>
          <li><a href="<?= site_url('admin/vote/sites') ?>"><?= lang('vote_sites') ?></a></li>
          <li><span><?= lang('vote_add_site') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-plus"></i> <?= lang('vote_add_site') ?>
        </h1>
      </div>
    </div>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body">
        <?= form_open_multipart('admin/vote/add-site', ['class' => 'uk-form-stacked']) ?>
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="name"><?= lang('name') ?> <span class="uk-text-danger">*</span></label>
                <div class="uk-form-controls">
                  <input class="uk-input <?= form_error('name') ? 'uk-form-danger' : '' ?>" id="name" type="text" name="name" value="<?= set_value('name') ?>" placeholder="Top 100 Arena">
                </div>
                <?= form_error('name', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="url"><?= lang('url') ?> <span class="uk-text-danger">*</span></label>
                <div class="uk-form-controls">
                  <input class="uk-input <?= form_error('url') ? 'uk-form-danger' : '' ?>" id="url" type="url" name="url" value="<?= set_value('url') ?>" placeholder="https://example.com/vote/12345">
                </div>
                <?= form_error('url', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
              </div>
            </div>
            <div class="uk-width-1-1">
              <div class="uk-margin">
                <label class="uk-form-label" for="description"><?= lang('description') ?></label>
                <div class="uk-form-controls">
                  <textarea class="uk-textarea" id="description" name="description" rows="3" placeholder="<?= lang('vote_site_desc_placeholder') ?>"><?= set_value('description') ?></textarea>
                </div>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="vp_reward"><?= lang('vote_vp_reward') ?> <span class="uk-text-danger">*</span></label>
                <div class="uk-form-controls">
                  <input class="uk-input <?= form_error('vp_reward') ? 'uk-form-danger' : '' ?>" id="vp_reward" type="number" name="vp_reward" value="<?= set_value('vp_reward', 1) ?>" min="1">
                </div>
                <?= form_error('vp_reward', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="cooldown_hours"><?= lang('vote_cooldown') ?> (hours) <span class="uk-text-danger">*</span></label>
                <div class="uk-form-controls">
                  <input class="uk-input <?= form_error('cooldown_hours') ? 'uk-form-danger' : '' ?>" id="cooldown_hours" type="number" name="cooldown_hours" value="<?= set_value('cooldown_hours', 12) ?>" min="1">
                </div>
                <?= form_error('cooldown_hours', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="callback_url"><?= lang('vote_callback_url') ?></label>
                <div class="uk-form-controls">
                  <input class="uk-input" id="callback_url" type="text" name="callback_url" value="<?= set_value('callback_url') ?>" placeholder="Optional callback URL">
                </div>
                <span class="uk-text-small uk-text-muted"><?= lang('vote_callback_url_help') ?></span>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="sort_order"><?= lang('sort_order') ?></label>
                <div class="uk-form-controls">
                  <input class="uk-input" id="sort_order" type="number" name="sort_order" value="<?= set_value('sort_order', 0) ?>" min="0">
                </div>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="image"><?= lang('image') ?></label>
                <div class="uk-form-controls" uk-form-custom>
                  <input type="file" name="image" accept="image/*">
                  <button class="uk-button uk-button-default" type="button" tabindex="-1">
                    <i class="fa-solid fa-upload"></i> <?= lang('select_file') ?>
                  </button>
                </div>
                <span class="uk-text-small uk-text-muted"><?= lang('vote_image_help') ?></span>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="is_active"><?= lang('status') ?></label>
                <div class="uk-form-controls">
                  <label class="uk-switch">
                    <input type="checkbox" name="is_active" value="1" <?= set_checkbox('is_active', '1', true) ?>>
                    <span class="uk-switch-slider uk-switch-primary"></span>
                  </label>
                  <span class="uk-margin-small-left"><?= lang('active') ?></span>
                </div>
              </div>
            </div>
          </div>

          <div class="uk-margin-top">
            <button type="submit" class="uk-button uk-button-primary">
              <i class="fa-solid fa-save"></i> <?= lang('save') ?>
            </button>
            <a href="<?= site_url('admin/vote/sites') ?>" class="uk-button uk-button-default">
              <i class="fa-solid fa-times"></i> <?= lang('cancel') ?>
            </a>
          </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</section>
