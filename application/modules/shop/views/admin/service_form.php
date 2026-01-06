<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container uk-container-expand">
    <div class="uk-flex uk-flex-between uk-flex-wrap uk-margin">
      <div>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-<?= isset($service) ? 'edit' : 'plus' ?>"></i>
          <?= isset($service) ? lang('shop_edit_service') : lang('shop_add_service') ?>
        </h1>
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_dashboard') ?></a></li>
          <li><a href="<?= site_url('shop/admin') ?>"><?= lang('admin_shop') ?></a></li>
          <li><a href="<?= site_url('shop/admin/services') ?>"><?= lang('admin_shop_services') ?></a></li>
          <li><span><?= isset($service) ? lang('edit') : lang('add') ?></span></li>
        </ul>
      </div>
      <div>
        <a href="<?= site_url('shop/admin/services') ?>" class="uk-button uk-button-default">
          <i class="fa-solid fa-arrow-left"></i> <?= lang('back') ?>
        </a>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body">
        <?= form_open(current_url()) ?>
          <div uk-grid>
            <div class="uk-width-2-3@m">
              <div class="uk-margin">
                <label class="uk-form-label"><?= lang('name') ?> <span class="uk-text-danger">*</span></label>
                <input class="uk-input <?= form_error('name') ? 'uk-form-danger' : '' ?>" type="text" name="name" value="<?= set_value('name', $service->name ?? '') ?>" required>
                <?= form_error('name', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
              </div>

              <div class="uk-margin">
                <label class="uk-form-label"><?= lang('description') ?></label>
                <textarea class="uk-textarea" name="description" rows="4"><?= set_value('description', $service->description ?? '') ?></textarea>
              </div>

              <div class="uk-margin">
                <label class="uk-form-label"><?= lang('type') ?> <span class="uk-text-danger">*</span></label>
                <select class="uk-select <?= form_error('type') ? 'uk-form-danger' : '' ?>" name="type" required>
                  <option value=""><?= lang('select_option') ?></option>
                  <option value="rename" <?= set_select('type', 'rename', isset($service) && $service->type == 'rename') ?>><?= lang('shop_service_rename') ?></option>
                  <option value="faction_change" <?= set_select('type', 'faction_change', isset($service) && $service->type == 'faction_change') ?>><?= lang('shop_service_faction') ?></option>
                  <option value="race_change" <?= set_select('type', 'race_change', isset($service) && $service->type == 'race_change') ?>><?= lang('shop_service_race') ?></option>
                  <option value="customize" <?= set_select('type', 'customize', isset($service) && $service->type == 'customize') ?>><?= lang('shop_service_customize') ?></option>
                  <option value="level_boost" <?= set_select('type', 'level_boost', isset($service) && $service->type == 'level_boost') ?>><?= lang('shop_service_level_boost') ?></option>
                  <option value="gold" <?= set_select('type', 'gold', isset($service) && $service->type == 'gold') ?>><?= lang('shop_service_gold') ?></option>
                  <option value="custom" <?= set_select('type', 'custom', isset($service) && $service->type == 'custom') ?>><?= lang('shop_service_custom') ?></option>
                </select>
                <?= form_error('type', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
              </div>

              <div class="uk-margin">
                <label class="uk-form-label"><?= lang('shop_command') ?></label>
                <input class="uk-input" type="text" name="command" value="<?= set_value('command', $service->command ?? '') ?>" placeholder=".character rename {name}">
                <span class="uk-text-small uk-text-muted"><?= lang('shop_command_help') ?></span>
              </div>

              <div class="uk-margin">
                <label class="uk-form-label"><?= lang('icon') ?></label>
                <input class="uk-input" type="text" name="icon" value="<?= set_value('icon', $service->icon ?? '') ?>" placeholder="fa-solid fa-wand-magic-sparkles">
              </div>
            </div>

            <div class="uk-width-1-3@m">
              <div class="uk-card uk-card-default uk-card-body">
                <h4><i class="fa-solid fa-tags"></i> <?= lang('shop_pricing') ?></h4>
                
                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_price_dp') ?></label>
                  <input class="uk-input" type="number" name="price_dp" value="<?= set_value('price_dp', $service->price_dp ?? 0) ?>" min="0">
                </div>

                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_price_vp') ?></label>
                  <input class="uk-input" type="number" name="price_vp" value="<?= set_value('price_vp', $service->price_vp ?? 0) ?>" min="0">
                </div>

                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_price_money') ?></label>
                  <input class="uk-input" type="number" name="price_money" value="<?= set_value('price_money', $service->price_money ?? 0) ?>" min="0" step="0.01">
                </div>

                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_currency') ?></label>
                  <select class="uk-select" name="currency">
                    <option value="USD" <?= set_select('currency', 'USD', isset($service) && $service->currency == 'USD') ?>>USD</option>
                    <option value="EUR" <?= set_select('currency', 'EUR', isset($service) && $service->currency == 'EUR') ?>>EUR</option>
                    <option value="GBP" <?= set_select('currency', 'GBP', isset($service) && $service->currency == 'GBP') ?>>GBP</option>
                  </select>
                </div>
              </div>

              <div class="uk-card uk-card-default uk-card-body uk-margin-top">
                <h4><i class="fa-solid fa-cog"></i> <?= lang('settings') ?></h4>

                <div class="uk-margin">
                  <label>
                    <input class="uk-checkbox" type="checkbox" name="requires_character" value="1" <?= set_checkbox('requires_character', '1', ! isset($service) || $service->requires_character) ?>>
                    <?= lang('shop_requires_character') ?>
                  </label>
                </div>

                <div class="uk-margin">
                  <label>
                    <input class="uk-checkbox" type="checkbox" name="is_active" value="1" <?= set_checkbox('is_active', '1', ! isset($service) || $service->is_active) ?>>
                    <?= lang('active') ?>
                  </label>
                </div>
              </div>
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
