<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_panel') ?></a></li>
          <li><a href="<?= site_url('vote/admin') ?>"><?= lang('vote') ?></a></li>
          <li><a href="<?= site_url('vote/admin/sites') ?>"><?= lang('vote_sites') ?></a></li>
          <li><span><?= lang('vote_edit_site') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-edit"></i> <?= lang('vote_edit_site') ?>
        </h1>
      </div>
    </div>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body">
        <?= form_open_multipart('vote/admin/sites/edit/' . $site->id, ['class' => 'uk-form-stacked']) ?>
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="name"><?= lang('name') ?> <span class="uk-text-danger">*</span></label>
                <div class="uk-form-controls">
                  <input class="uk-input <?= form_error('name') ? 'uk-form-danger' : '' ?>" id="name" type="text" name="name" value="<?= set_value('name', $site->name) ?>">
                </div>
                <?= form_error('name', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="url"><?= lang('url') ?> <span class="uk-text-danger">*</span></label>
                <div class="uk-form-controls">
                  <input class="uk-input <?= form_error('url') ? 'uk-form-danger' : '' ?>" id="url" type="url" name="url" value="<?= set_value('url', $site->url) ?>">
                </div>
                <?= form_error('url', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
              </div>
            </div>
            <div class="uk-width-1-1">
              <div class="uk-margin">
                <label class="uk-form-label" for="description"><?= lang('description') ?></label>
                <div class="uk-form-controls">
                  <textarea class="uk-textarea" id="description" name="description" rows="3"><?= set_value('description', $site->description) ?></textarea>
                </div>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="vp_reward"><?= lang('vote_vp_reward') ?> <span class="uk-text-danger">*</span></label>
                <div class="uk-form-controls">
                  <input class="uk-input <?= form_error('vp_reward') ? 'uk-form-danger' : '' ?>" id="vp_reward" type="number" name="vp_reward" value="<?= set_value('vp_reward', $site->vp_reward) ?>" min="1">
                </div>
                <?= form_error('vp_reward', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="cooldown_hours"><?= lang('vote_cooldown') ?> (hours) <span class="uk-text-danger">*</span></label>
                <div class="uk-form-controls">
                  <input class="uk-input <?= form_error('cooldown_hours') ? 'uk-form-danger' : '' ?>" id="cooldown_hours" type="number" name="cooldown_hours" value="<?= set_value('cooldown_hours', $site->cooldown_hours) ?>" min="1">
                </div>
                <?= form_error('cooldown_hours', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="callback_url"><?= lang('vote_callback_url') ?></label>
                <div class="uk-form-controls">
                  <input class="uk-input" id="callback_url" type="text" name="callback_url" value="<?= set_value('callback_url', $site->callback_url) ?>">
                </div>
                <span class="uk-text-small uk-text-muted"><?= lang('vote_callback_url_help') ?></span>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="sort_order"><?= lang('sort_order') ?></label>
                <div class="uk-form-controls">
                  <input class="uk-input" id="sort_order" type="number" name="sort_order" value="<?= set_value('sort_order', $site->sort_order) ?>" min="0">
                </div>
              </div>
            </div>
            <div class="uk-width-1-2@m">
              <div class="uk-margin">
                <label class="uk-form-label" for="image"><?= lang('image') ?></label>
                <?php if (!empty($site->image)): ?>
                <div class="uk-margin-small-bottom">
                  <img src="<?= base_url('uploads/' . $site->image) ?>" alt="<?= html_escape($site->name) ?>" style="max-height: 50px;">
                </div>
                <?php endif; ?>
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
                    <input type="checkbox" name="is_active" value="1" <?= $site->is_active ? 'checked' : '' ?>>
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
            <a href="<?= site_url('vote/admin/sites') ?>" class="uk-button uk-button-default">
              <i class="fa-solid fa-times"></i> <?= lang('cancel') ?>
            </a>
          </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</section>
