    <section class="uk-section uk-section-xsmall" data-uk-height-viewport="expand: true">
      <div class="uk-container">
        <div class="uk-grid uk-grid-small uk-margin-small uk-flex uk-flex-middle" data-uk-grid>
          <div class="uk-width-expand">
            <h4 class="uk-h4 uk-margin-remove"><?= $category->name; ?></h4>
            <ul class="uk-breadcrumb uk-margin-remove">
              <li><a href="<?= site_url('admin'); ?>"><?= lang('dashboard'); ?></a></li>
              <li><a href="<?= site_url('store/admin'); ?>"><?= lang('store'); ?></a></li>
              <li><a href="<?= site_url('store/admin/'.$id); ?>"><?= $category->name; ?></a></li>
            </ul>
          </div>
          <div class="uk-width-auto">
            <a href="<?= site_url('store/admin/'.$id); ?>" class="uk-button uk-button-primary uk-button-small"><i class="fas fa-arrow-circle-left"></i></a>
          </div>
        </div>
        <?= $template['partials']['alerts']; ?>
        <?= form_open(current_url()); ?>
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h4 class="uk-h4"><i class="fas fa-pen"></i> <?= lang('create_item'); ?></h4>
          </div>
          <div class="uk-card-body">
            <div class="uk-margin-small">
              <div class="uk-grid-small" uk-grid>
                <div class="uk-inline uk-width-1-2@s">
                  <label class="uk-form-label"><?= lang('name'); ?></label>
                  <div class="uk-form-controls">
                    <input class="uk-input uk-width-1-1" type="text" name="name" value="<?= set_value('name'); ?>" placeholder="<?= lang('name'); ?>">
                  </div>
                  <?= form_error('name', '<span class="uk-text-small uk-text-danger">', '</span>'); ?>
                </div>
                <div class="uk-inline uk-width-1-2@s">
                  <label class="uk-form-label"><?= lang('realm'); ?></label>
                  <div class="uk-form-controls">
                    <select class="uk-select" name="realm">
                      <option value="" hidden selected><?= lang('select_realm'); ?></option>
                      <?php foreach ($realms as $realm): ?>
                      <option value="<?= $realm->id; ?>" <?= set_select('realm', $realm->id); ?>><?= $realm->name; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <?= form_error('realm', '<span class="uk-text-small uk-text-danger">', '</span>'); ?>
                </div>
              </div>
            </div>
            <div class="uk-margin-small">
              <label class="uk-form-label"><?= lang('description'); ?></label>
              <div class="uk-form-controls">
                <textarea class="uk-textarea" name="description" rows="3"><?= set_value('description'); ?></textarea>
              </div>
              <?= form_error('description', '<span class="uk-text-small uk-text-danger">', '</span>'); ?>
            </div>
            <div class="uk-margin-small">
              <label class="uk-form-label"><?= lang('image'); ?></label>
              <div class="uk-form-controls">
                <input class="uk-input" type="text" name="image" value="<?= set_value('image'); ?>" placeholder="Image Name">
              </div>
              <?= form_error('image', '<span class="uk-text-small uk-text-danger">', '</span>'); ?>
            </div>
            <div class="uk-margin-small">
              <div class="uk-grid-small" uk-grid>
                <div class="uk-inline uk-width-1-2@s">
                  <label class="uk-form-label"><?= lang('type'); ?></label>
                  <div class="uk-form-controls">
                    <select class="uk-select" name="price_type">
                      <option value="" hidden selected><?= lang('select_type'); ?></option>
                      <option value="<?= TYPE_DP ?>" <?= set_select('price_type', TYPE_DP); ?>><?= lang('dp'); ?></option>
                      <option value="<?= TYPE_VP ?>" <?= set_select('price_type', TYPE_VP); ?>><?= lang('vp'); ?></option>
                      <option value="<?= TYPE_AND ?>" <?= set_select('price_type', TYPE_AND); ?>><?= lang('dp_vp'); ?></option>
                    </select>
                  </div>
                  <?= form_error('price_type', '<span class="uk-text-small uk-text-danger">', '</span>'); ?>
                </div>
                <div class="uk-inline uk-width-1-4@s">
                  <label class="uk-form-label"><?= lang('dp'); ?></label>
                  <div class="uk-form-controls">
                    <input class="uk-input" type="text" name="dp" value="<?= set_value('dp', '0'); ?>" placeholder="<?= lang('dp'); ?>">
                  </div>
                  <?= form_error('dp', '<span class="uk-text-small uk-text-danger">', '</span>'); ?>
                </div>
                <div class="uk-inline uk-width-1-4@s">
                  <label class="uk-form-label"><?= lang('vp'); ?></label>
                  <div class="uk-form-controls">
                    <input class="uk-input" type="text" name="vp" value="<?= set_value('vp', '0'); ?>" placeholder="<?= lang('vp'); ?>">
                  </div>
                  <?= form_error('vp', '<span class="uk-text-small uk-text-danger">', '</span>'); ?>
                </div>
              </div>
            </div>
            <div class="uk-margin-small">
              <label class="uk-form-label"><?= lang('command'); ?></label>
              <div class="uk-form-controls">
                <textarea class="uk-textarea" name="command" rows="2"><?= set_value('command'); ?></textarea>
              </div>
              <?= form_error('command', '<span class="uk-text-small uk-text-danger">', '</span>'); ?>
            </div>
            <h5 class="uk-h5 uk-heading-bullet uk-text-uppercase uk-text-bold uk-margin-top uk-margin-small-bottom uk-heading-line"><span><?= lang('optional_settings'); ?></span></h5>
            <div class="uk-grid uk-grid-small uk-flex uk-flex-middle uk-margin-small" data-uk-grid>
              <div class="uk-width-expand">
                <label class="uk-form-label"><i class="fas fa-toggle-off"></i> <?= lang('enable_top_item'); ?></label>
                <?= form_error('top', '<span class="uk-text-small uk-text-danger">', '</span>'); ?>
              </div>
              <div class="uk-width-auto">
                <label class="uk-switch">
                  <input type="checkbox" name="top" value="1" <?= set_checkbox('top', '1'); ?>>
                  <div class="uk-switch-slider"></div>
                </label>
              </div>
            </div>
          </div>
        </div>
        <button class="uk-button uk-button-primary uk-margin-small" type="submit"><i class="fas fa-plus"></i> <?= lang('create'); ?></button>
        <?= form_close(); ?>
      </div>
    </section>