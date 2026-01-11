<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_panel') ?></a></li>
          <li><a href="<?= site_url('donate/admin') ?>"><?= lang('donate') ?></a></li>
          <li><a href="<?= site_url('donate/admin/packages') ?>"><?= lang('donate_packages') ?></a></li>
          <li><span><?= lang('edit') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('donate_edit_package') ?></h1>
      </div>
    </div>

    <?= $this->load->view('static/alerts') ?>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body">
        <?= form_open('donate/admin/packages/edit/' . $package->id) ?>
          
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-2@s">
              <label class="uk-form-label"><?= lang('name') ?> <span class="uk-text-danger">*</span></label>
              <input class="uk-input" type="text" name="name" value="<?= set_value('name', $package->name) ?>" required>
              <?= form_error('name', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
            </div>
            <div class="uk-width-1-4@s">
              <label class="uk-form-label"><?= lang('price') ?> <span class="uk-text-danger">*</span></label>
              <input class="uk-input" type="number" step="0.01" min="0" name="price" value="<?= set_value('price', $package->price) ?>" required>
              <?= form_error('price', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
            </div>
            <div class="uk-width-1-4@s">
              <label class="uk-form-label"><?= lang('currency') ?></label>
              <select class="uk-select" name="currency">
                <option value="USD" <?= set_select('currency', 'USD', $package->currency == 'USD') ?>>USD</option>
                <option value="EUR" <?= set_select('currency', 'EUR', $package->currency == 'EUR') ?>>EUR</option>
                <option value="GBP" <?= set_select('currency', 'GBP', $package->currency == 'GBP') ?>>GBP</option>
              </select>
            </div>
          </div>

          <div class="uk-margin-top">
            <label class="uk-form-label"><?= lang('description') ?></label>
            <textarea class="uk-textarea" name="description" rows="3"><?= set_value('description', $package->description) ?></textarea>
          </div>

          <div class="uk-grid-small uk-margin-top" uk-grid>
            <div class="uk-width-1-3@s">
              <label class="uk-form-label"><?= lang('donate_dp_amount') ?> <span class="uk-text-danger">*</span></label>
              <input class="uk-input" type="number" min="0" name="dp_amount" value="<?= set_value('dp_amount', $package->dp_amount) ?>" required>
              <?= form_error('dp_amount', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
            </div>
            <div class="uk-width-1-3@s">
              <label class="uk-form-label"><?= lang('donate_bonus_dp') ?></label>
              <input class="uk-input" type="number" min="0" name="bonus_dp" value="<?= set_value('bonus_dp', $package->bonus_dp) ?>">
            </div>
            <div class="uk-width-1-3@s">
              <label class="uk-form-label"><?= lang('position') ?></label>
              <input class="uk-input" type="number" min="0" name="sort_order" value="<?= set_value('sort_order', $package->sort_order) ?>">
            </div>
          </div>

          <div class="uk-margin-top">
            <label class="uk-form-label"><?= lang('image') ?></label>
            <input class="uk-input" type="text" name="image" value="<?= set_value('image', $package->image) ?>" placeholder="path/to/image.jpg">
            <span class="uk-text-small uk-text-muted">Relative path in uploads folder</span>
          </div>

          <div class="uk-grid-small uk-margin-top" uk-grid>
            <div class="uk-width-auto">
              <label>
                <input class="uk-checkbox" type="checkbox" name="featured" value="1" <?= set_checkbox('featured', '1', $package->featured == 1) ?>>
                <?= lang('featured') ?>
              </label>
            </div>
            <div class="uk-width-auto">
              <label>
                <input class="uk-checkbox" type="checkbox" name="is_active" value="1" <?= set_checkbox('is_active', '1', $package->is_active == 1) ?>>
                <?= lang('active') ?>
              </label>
            </div>
          </div>

          <div class="uk-margin-top">
            <button type="submit" class="uk-button uk-button-primary">
              <i class="fa-solid fa-save"></i> <?= lang('save') ?>
            </button>
            <a href="<?= site_url('donate/admin/packages') ?>" class="uk-button uk-button-default">
              <?= lang('cancel') ?>
            </a>
          </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</section>
