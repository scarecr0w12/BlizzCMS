<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container uk-container-expand">
    <div class="uk-flex uk-flex-between uk-flex-wrap uk-margin">
      <div>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-<?= isset($item) ? 'edit' : 'plus' ?>"></i>
          <?= isset($item) ? lang('shop_edit_item') : lang('shop_add_item') ?>
        </h1>
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_dashboard') ?></a></li>
          <li><a href="<?= site_url('shop/admin') ?>"><?= lang('admin_shop') ?></a></li>
          <li><a href="<?= site_url('shop/admin/items') ?>"><?= lang('admin_shop_items') ?></a></li>
          <li><span><?= isset($item) ? lang('edit') : lang('add') ?></span></li>
        </ul>
      </div>
      <div>
        <a href="<?= site_url('shop/admin/items') ?>" class="uk-button uk-button-default">
          <i class="fa-solid fa-arrow-left"></i> <?= lang('back') ?>
        </a>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body">
        <?= form_open_multipart(current_url()) ?>
          <div uk-grid>
            <div class="uk-width-2-3@m">
              <div class="uk-margin">
                <label class="uk-form-label"><?= lang('name') ?> <span class="uk-text-danger">*</span></label>
                <input class="uk-input <?= form_error('name') ? 'uk-form-danger' : '' ?>" type="text" name="name" value="<?= set_value('name', $item->name ?? '') ?>" required>
                <?= form_error('name', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
              </div>

              <div class="uk-margin">
                <label class="uk-form-label"><?= lang('description') ?></label>
                <textarea class="uk-textarea" name="description" rows="4"><?= set_value('description', $item->description ?? '') ?></textarea>
              </div>

              <div class="uk-margin">
                <label class="uk-form-label"><?= lang('shop_category') ?> <span class="uk-text-danger">*</span></label>
                <select class="uk-select <?= form_error('category_id') ? 'uk-form-danger' : '' ?>" name="category_id" required>
                  <option value=""><?= lang('select_option') ?></option>
                  <?php foreach ($categories as $cat): ?>
                  <option value="<?= $cat->id ?>" <?= set_select('category_id', $cat->id, isset($item) && $item->category_id == $cat->id) ?>><?= html_escape($cat->name) ?></option>
                  <?php endforeach; ?>
                </select>
                <?= form_error('category_id', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
              </div>

              <div class="uk-grid-small" uk-grid>
                <div class="uk-width-1-2@s">
                  <label class="uk-form-label"><?= lang('shop_item_id') ?> <span class="uk-text-danger">*</span></label>
                  <input class="uk-input <?= form_error('item_id') ? 'uk-form-danger' : '' ?>" type="number" name="item_id" value="<?= set_value('item_id', $item->item_id ?? '') ?>" required>
                  <span class="uk-text-small uk-text-muted">WoW game item ID</span>
                  <?= form_error('item_id', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
                </div>
                <div class="uk-width-1-2@s">
                  <label class="uk-form-label"><?= lang('shop_item_count') ?> <span class="uk-text-danger">*</span></label>
                  <input class="uk-input" type="number" name="item_count" value="<?= set_value('item_count', $item->item_count ?? 1) ?>" min="1" required>
                </div>
              </div>
            </div>

            <div class="uk-width-1-3@m">
              <div class="uk-card uk-card-default uk-card-body">
                <h4><i class="fa-solid fa-tags"></i> <?= lang('shop_pricing') ?></h4>
                
                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_price_dp') ?></label>
                  <input class="uk-input" type="number" name="price_dp" value="<?= set_value('price_dp', $item->price_dp ?? 0) ?>" min="0">
                </div>

                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_price_vp') ?></label>
                  <input class="uk-input" type="number" name="price_vp" value="<?= set_value('price_vp', $item->price_vp ?? 0) ?>" min="0">
                </div>

                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_price_money') ?></label>
                  <input class="uk-input" type="number" name="price_money" value="<?= set_value('price_money', $item->price_money ?? 0) ?>" min="0" step="0.01">
                </div>

                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_currency') ?></label>
                  <select class="uk-select" name="currency">
                    <option value="USD" <?= set_select('currency', 'USD', isset($item) && $item->currency == 'USD') ?>>USD</option>
                    <option value="EUR" <?= set_select('currency', 'EUR', isset($item) && $item->currency == 'EUR') ?>>EUR</option>
                    <option value="GBP" <?= set_select('currency', 'GBP', isset($item) && $item->currency == 'GBP') ?>>GBP</option>
                  </select>
                </div>
              </div>

              <div class="uk-card uk-card-default uk-card-body uk-margin-top">
                <h4><i class="fa-solid fa-cog"></i> <?= lang('settings') ?></h4>

                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_stock') ?></label>
                  <input class="uk-input" type="number" name="stock" value="<?= set_value('stock', $item->stock ?? -1) ?>" min="-1">
                  <span class="uk-text-small uk-text-muted"><?= lang('shop_stock_help') ?></span>
                </div>

                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_purchase_limit') ?></label>
                  <input class="uk-input" type="number" name="purchase_limit" value="<?= set_value('purchase_limit', $item->purchase_limit ?? 0) ?>" min="0">
                  <span class="uk-text-small uk-text-muted"><?= lang('shop_purchase_limit_help') ?></span>
                </div>

                <div class="uk-margin">
                  <label>
                    <input class="uk-checkbox" type="checkbox" name="is_featured" value="1" <?= set_checkbox('is_featured', '1', isset($item) && $item->is_featured) ?>>
                    <?= lang('shop_featured') ?>
                  </label>
                </div>

                <div class="uk-margin">
                  <label>
                    <input class="uk-checkbox" type="checkbox" name="is_active" value="1" <?= set_checkbox('is_active', '1', ! isset($item) || $item->is_active) ?>>
                    <?= lang('active') ?>
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div class="uk-margin">
            <label class="uk-form-label"><?= lang('image') ?></label>
            <?php if (isset($item) && ! empty($item->image)): ?>
            <div class="uk-margin-small">
              <img src="<?= base_url('uploads/shop/' . $item->image) ?>" width="100" alt="">
            </div>
            <?php endif; ?>
            <div uk-form-custom>
              <input type="file" name="image" accept="image/*">
              <button class="uk-button uk-button-default" type="button" tabindex="-1"><?= lang('select_file') ?></button>
            </div>
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
