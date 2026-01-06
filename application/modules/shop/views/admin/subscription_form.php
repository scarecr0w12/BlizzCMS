<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container uk-container-expand">
    <div class="uk-flex uk-flex-between uk-flex-wrap uk-margin">
      <div>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-<?= isset($subscription) ? 'edit' : 'plus' ?>"></i>
          <?= isset($subscription) ? lang('shop_edit_subscription') : lang('shop_add_subscription') ?>
        </h1>
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_dashboard') ?></a></li>
          <li><a href="<?= site_url('shop/admin') ?>"><?= lang('admin_shop') ?></a></li>
          <li><a href="<?= site_url('shop/admin/subscriptions') ?>"><?= lang('admin_shop_subscriptions') ?></a></li>
          <li><span><?= isset($subscription) ? lang('edit') : lang('add') ?></span></li>
        </ul>
      </div>
      <div>
        <a href="<?= site_url('shop/admin/subscriptions') ?>" class="uk-button uk-button-default">
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
                <input class="uk-input <?= form_error('name') ? 'uk-form-danger' : '' ?>" type="text" name="name" value="<?= set_value('name', $subscription->name ?? '') ?>" required>
                <?= form_error('name', '<span class="uk-text-small uk-text-danger">', '</span>') ?>
              </div>

              <div class="uk-margin">
                <label class="uk-form-label"><?= lang('description') ?></label>
                <textarea class="uk-textarea" name="description" rows="4"><?= set_value('description', $subscription->description ?? '') ?></textarea>
                <span class="uk-text-small uk-text-muted"><?= lang('shop_subscription_desc_help') ?></span>
              </div>

              <div class="uk-grid-small" uk-grid>
                <div class="uk-width-1-2@s">
                  <label class="uk-form-label"><?= lang('shop_interval_type') ?> <span class="uk-text-danger">*</span></label>
                  <select class="uk-select <?= form_error('interval_type') ? 'uk-form-danger' : '' ?>" name="interval_type" required>
                    <option value="daily" <?= set_select('interval_type', 'daily', isset($subscription) && $subscription->interval_type == 'daily') ?>><?= lang('shop_daily') ?></option>
                    <option value="weekly" <?= set_select('interval_type', 'weekly', isset($subscription) && $subscription->interval_type == 'weekly') ?>><?= lang('shop_weekly') ?></option>
                    <option value="monthly" <?= set_select('interval_type', 'monthly', ! isset($subscription) || $subscription->interval_type == 'monthly') ?>><?= lang('shop_monthly') ?></option>
                    <option value="yearly" <?= set_select('interval_type', 'yearly', isset($subscription) && $subscription->interval_type == 'yearly') ?>><?= lang('shop_yearly') ?></option>
                  </select>
                </div>
                <div class="uk-width-1-2@s">
                  <label class="uk-form-label"><?= lang('shop_interval_count') ?></label>
                  <input class="uk-input" type="number" name="interval_count" value="<?= set_value('interval_count', $subscription->interval_count ?? 1) ?>" min="1">
                  <span class="uk-text-small uk-text-muted"><?= lang('shop_interval_count_help') ?></span>
                </div>
              </div>

              <div class="uk-margin">
                <label class="uk-form-label"><?= lang('shop_benefits') ?></label>
                <textarea class="uk-textarea" name="benefits" rows="4"><?= set_value('benefits', $subscription->benefits ?? '') ?></textarea>
                <span class="uk-text-small uk-text-muted"><?= lang('shop_benefits_help') ?></span>
              </div>

              <div class="uk-margin">
                <label class="uk-form-label"><?= lang('icon') ?></label>
                <input class="uk-input" type="text" name="icon" value="<?= set_value('icon', $subscription->icon ?? '') ?>" placeholder="fa-solid fa-crown">
              </div>
            </div>

            <div class="uk-width-1-3@m">
              <div class="uk-card uk-card-default uk-card-body">
                <h4><i class="fa-solid fa-tags"></i> <?= lang('shop_pricing') ?></h4>
                
                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_price_dp') ?></label>
                  <input class="uk-input" type="number" name="price_dp" value="<?= set_value('price_dp', $subscription->price_dp ?? 0) ?>" min="0">
                </div>

                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_price_vp') ?></label>
                  <input class="uk-input" type="number" name="price_vp" value="<?= set_value('price_vp', $subscription->price_vp ?? 0) ?>" min="0">
                </div>

                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_price_money') ?></label>
                  <input class="uk-input" type="number" name="price_money" value="<?= set_value('price_money', $subscription->price_money ?? 0) ?>" min="0" step="0.01">
                </div>

                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_currency') ?></label>
                  <select class="uk-select" name="currency">
                    <option value="USD" <?= set_select('currency', 'USD', isset($subscription) && $subscription->currency == 'USD') ?>>USD</option>
                    <option value="EUR" <?= set_select('currency', 'EUR', isset($subscription) && $subscription->currency == 'EUR') ?>>EUR</option>
                    <option value="GBP" <?= set_select('currency', 'GBP', isset($subscription) && $subscription->currency == 'GBP') ?>>GBP</option>
                  </select>
                </div>
              </div>

              <div class="uk-card uk-card-default uk-card-body uk-margin-top">
                <h4><i class="fa-solid fa-gift"></i> <?= lang('shop_delivery') ?></h4>

                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_item_reward') ?></label>
                  <input class="uk-input" type="number" name="item_reward" value="<?= set_value('item_reward', $subscription->item_reward ?? 0) ?>" min="0">
                  <span class="uk-text-small uk-text-muted"><?= lang('shop_item_reward_help') ?></span>
                </div>

                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_gold_reward') ?></label>
                  <input class="uk-input" type="number" name="gold_reward" value="<?= set_value('gold_reward', $subscription->gold_reward ?? 0) ?>" min="0">
                </div>

                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_dp_reward') ?></label>
                  <input class="uk-input" type="number" name="dp_reward" value="<?= set_value('dp_reward', $subscription->dp_reward ?? 0) ?>" min="0">
                </div>

                <div class="uk-margin">
                  <label class="uk-form-label"><?= lang('shop_vp_reward') ?></label>
                  <input class="uk-input" type="number" name="vp_reward" value="<?= set_value('vp_reward', $subscription->vp_reward ?? 0) ?>" min="0">
                </div>
              </div>

              <div class="uk-card uk-card-default uk-card-body uk-margin-top">
                <h4><i class="fa-solid fa-cog"></i> <?= lang('settings') ?></h4>

                <div class="uk-margin">
                  <label>
                    <input class="uk-checkbox" type="checkbox" name="is_active" value="1" <?= set_checkbox('is_active', '1', ! isset($subscription) || $subscription->is_active) ?>>
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
