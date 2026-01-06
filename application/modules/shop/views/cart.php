<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('shop') ?>"><?= lang('shop') ?></a></li>
          <li><span><?= lang('shop_cart') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-cart-shopping"></i> <?= lang('shop_cart') ?>
        </h1>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <?php if (empty($cart_items)): ?>
    <div class="uk-card uk-card-default">
      <div class="uk-card-body uk-text-center uk-padding-large">
        <i class="fa-solid fa-cart-shopping fa-5x uk-text-muted"></i>
        <h3 class="uk-margin-top"><?= lang('shop_cart_empty') ?></h3>
        <p class="uk-text-muted"><?= lang('shop_description') ?></p>
        <a href="<?= site_url('shop') ?>" class="uk-button uk-button-primary">
          <i class="fa-solid fa-store"></i> <?= lang('shop_continue_shopping') ?>
        </a>
      </div>
    </div>
    <?php else: ?>
    <div uk-grid>
      <div class="uk-width-2-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-body uk-padding-remove">
            <table class="uk-table uk-table-middle uk-table-divider uk-margin-remove">
              <thead>
                <tr>
                  <th><?= lang('product') ?></th>
                  <th class="uk-text-center"><?= lang('shop_price') ?></th>
                  <th class="uk-text-center uk-table-shrink"><?= lang('shop_quantity') ?></th>
                  <th class="uk-text-center uk-table-shrink"><?= lang('actions') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($cart_items as $item): ?>
                <tr>
                  <td>
                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                      <div class="uk-width-auto">
                        <?php if (! empty($item['options']['image'])): ?>
                        <img src="<?= base_url('uploads/shop/' . $item['options']['image']) ?>" width="48" height="48" alt="">
                        <?php else: ?>
                        <div class="uk-background-muted uk-text-center" style="width: 48px; height: 48px; line-height: 48px;">
                          <i class="fa-solid fa-box uk-text-muted"></i>
                        </div>
                        <?php endif; ?>
                      </div>
                      <div class="uk-width-expand">
                        <strong><?= html_escape($item['name']) ?></strong>
                        <div class="uk-text-small uk-text-muted">
                          <?= ucfirst($item['options']['product_type']) ?>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="uk-text-center">
                    <?php if ($item['dp'] > 0): ?>
                    <div><span class="uk-label uk-label-warning"><?= number_format($item['dp']) ?> DP</span></div>
                    <?php endif; ?>
                    <?php if ($item['vp'] > 0): ?>
                    <div><span class="uk-label"><?= number_format($item['vp']) ?> VP</span></div>
                    <?php endif; ?>
                    <?php if (! empty($item['price_money']) && $item['price_money'] > 0): ?>
                    <div><span class="uk-label uk-label-success">$<?= number_format($item['price_money'], 2) ?></span></div>
                    <?php endif; ?>
                  </td>
                  <td class="uk-text-center">
                    <?= form_open(site_url('shop/cart/update'), ['class' => 'uk-form-horizontal']) ?>
                      <input type="hidden" name="rowid" value="<?= $item['rowid'] ?>">
                      <input class="uk-input uk-form-width-xsmall uk-text-center" type="number" name="qty" value="<?= $item['qty'] ?>" min="1" max="100" onchange="this.form.submit()">
                    <?= form_close() ?>
                  </td>
                  <td class="uk-text-center">
                    <?= form_open(site_url('shop/cart/remove/' . $item['rowid'])) ?>
                      <button type="submit" class="uk-button uk-button-danger uk-button-small" title="<?= lang('shop_remove') ?>">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    <?= form_close() ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div class="uk-card-footer">
            <div class="uk-grid-small" uk-grid>
              <div class="uk-width-expand">
                <a href="<?= site_url('shop') ?>" class="uk-button uk-button-default">
                  <i class="fa-solid fa-arrow-left"></i> <?= lang('shop_continue_shopping') ?>
                </a>
              </div>
              <div class="uk-width-auto">
                <?= form_open(site_url('shop/cart/clear')) ?>
                  <button type="submit" class="uk-button uk-button-danger">
                    <i class="fa-solid fa-trash"></i> <?= lang('shop_clear_cart') ?>
                  </button>
                <?= form_close() ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="uk-width-1-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-receipt"></i> <?= lang('shop_order_summary') ?></h3>
          </div>
          <div class="uk-card-body">
            <?php if ($total_dp > 0): ?>
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span><?= lang('shop_price_dp') ?>:</span>
              <span class="uk-text-bold bc-dp-points"><?= number_format($total_dp) ?> DP</span>
            </div>
            <?php endif; ?>
            
            <?php if ($total_vp > 0): ?>
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span><?= lang('shop_price_vp') ?>:</span>
              <span class="uk-text-bold bc-vp-points"><?= number_format($total_vp) ?> VP</span>
            </div>
            <?php endif; ?>

            <hr>

            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span class="uk-text-bold"><?= lang('shop_your_balance') ?>:</span>
              <span></span>
            </div>
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span>DP:</span>
              <span class="bc-dp-points"><?= number_format($user->dp) ?></span>
            </div>
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span>VP:</span>
              <span class="bc-vp-points"><?= number_format($user->vp) ?></span>
            </div>
          </div>
          <div class="uk-card-footer">
            <a href="<?= site_url('shop/checkout') ?>" class="uk-button uk-button-primary uk-width-1-1">
              <i class="fa-solid fa-credit-card"></i> <?= lang('shop_proceed_to_checkout') ?>
            </a>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
