<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container uk-container-expand">
    <div class="uk-flex uk-flex-between uk-flex-wrap uk-margin">
      <div>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-<?= isset($category) ? 'edit' : 'plus' ?>"></i>
          <?= isset($category) ? lang('shop_edit_category') : lang('shop_add_category') ?>
        </h1>
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_dashboard') ?></a></li>
          <li><a href="<?= site_url('shop/admin') ?>"><?= lang('admin_shop') ?></a></li>
          <li><a href="<?= site_url('shop/admin/categories') ?>"><?= lang('admin_shop_categories') ?></a></li>
          <li><span><?= isset($category) ? lang('edit') : lang('add') ?></span></li>
        </ul>
      </div>
      <div>
        <a href="<?= site_url('shop/admin/categories') ?>" class="uk-button uk-button-default">
          <i class="fa-solid fa-arrow-left"></i> <?= lang('back') ?>
        </a>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body">
        <?= form_open(current_url()) ?>
          <div class="uk-margin">
            <label class="uk-form-label"><?= lang('name') ?> <span class="uk-text-danger">*</span></label>
            <input class="uk-input <?= form_error('name') ? 'uk-form-danger' : '' ?>" type="text" name="name" value="<?= set_value('name', $category->name ?? '') ?>" required>
            <?= form_error('name', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
          </div>

          <div class="uk-margin">
            <label class="uk-form-label"><?= lang('description') ?></label>
            <textarea class="uk-textarea" name="description" rows="3"><?= set_value('description', $category->description ?? '') ?></textarea>
          </div>

          <div class="uk-margin">
            <label class="uk-form-label"><?= lang('icon') ?></label>
            <input class="uk-input" type="text" name="icon" value="<?= set_value('icon', $category->icon ?? '') ?>" placeholder="fa-solid fa-box">
            <span class="uk-text-small uk-text-muted"><?= lang('shop_icon_help') ?></span>
          </div>

          <div class="uk-margin">
            <label class="uk-form-label"><?= lang('sort_order') ?></label>
            <input class="uk-input uk-form-width-small" type="number" name="sort_order" value="<?= set_value('sort_order', $category->sort_order ?? 0) ?>" min="0">
          </div>

          <div class="uk-margin">
            <button type="submit" class="uk-button uk-button-primary">
              <i class="fa-solid fa-save"></i> <?= lang('save') ?>
            </button>
          </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</section>
