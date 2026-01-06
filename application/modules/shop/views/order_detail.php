<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('shop') ?>"><?= lang('shop') ?></a></li>
          <li><a href="<?= site_url('shop/history') ?>"><?= lang('shop_order_history') ?></a></li>
          <li><span><?= lang('shop_order_number') ?> #<?= $order->id ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-receipt"></i> <?= lang('shop_order_number') ?> #<?= $order->id ?>
        </h1>
      </div>
      <div class="uk-width-auto">
        <a href="<?= site_url('shop/history') ?>" class="uk-button uk-button-default">
          <i class="fa-solid fa-arrow-left"></i> <?= lang('shop_order_history') ?>
        </a>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <div uk-grid>
      <div class="uk-width-2-3@m">
        <!-- Order Items -->
        <div class="uk-card uk-card-default uk-margin-bottom">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-box"></i> <?= lang('shop_order_items') ?></h3>
          </div>
          <div class="uk-card-body uk-padding-remove">
            <table class="uk-table uk-table-middle uk-table-divider uk-margin-remove">
              <thead>
                <tr>
                  <th><?= lang('product') ?></th>
                  <th class="uk-text-center"><?= lang('shop_quantity') ?></th>
                  <th class="uk-text-right"><?= lang('shop_price') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                  <td>
                    <strong><?= html_escape($item->product_name) ?></strong>
                    <div class="uk-text-small uk-text-muted"><?= ucfirst($item->product_type) ?></div>
                  </td>
                  <td class="uk-text-center">x<?= $item->quantity ?></td>
                  <td class="uk-text-right">
                    <?php if ($item->price_dp > 0): ?>
                    <span class="uk-label uk-label-warning"><?= number_format($item->price_dp) ?> DP</span>
                    <?php endif; ?>
                    <?php if ($item->price_vp > 0): ?>
                    <span class="uk-label"><?= number_format($item->price_vp) ?> VP</span>
                    <?php endif; ?>
                    <?php if ($item->price_money > 0): ?>
                    <span class="uk-label uk-label-success">$<?= number_format($item->price_money, 2) ?></span>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Delivery Info -->
        <?php if (! empty($order->realm_id) || ! empty($order->character_guid)): ?>
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-truck"></i> <?= lang('shop_delivery_info') ?></h3>
          </div>
          <div class="uk-card-body">
            <dl class="uk-description-list">
              <?php if (! empty($order->realm_id)): ?>
              <dt><?= lang('shop_select_realm') ?>:</dt>
              <dd><?= html_escape($realm_name ?? 'N/A') ?></dd>
              <?php endif; ?>
              <?php if (! empty($order->character_guid)): ?>
              <dt><?= lang('shop_select_character') ?>:</dt>
              <dd><?= html_escape($character_name ?? 'N/A') ?></dd>
              <?php endif; ?>
            </dl>
          </div>
        </div>
        <?php endif; ?>
      </div>

      <div class="uk-width-1-3@m">
        <!-- Order Summary -->
        <div class="uk-card uk-card-default uk-margin-bottom">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-info-circle"></i> <?= lang('shop_order_summary') ?></h3>
          </div>
          <div class="uk-card-body">
            <dl class="uk-description-list uk-description-list-divider">
              <dt><?= lang('shop_order_number') ?></dt>
              <dd>#<?= $order->id ?></dd>

              <dt><?= lang('date') ?></dt>
              <dd><?= locate_date($order->created_at) ?></dd>

              <dt><?= lang('status') ?></dt>
              <dd>
                <?php
                $status_class = [
                    'pending' => 'uk-label-warning',
                    'processing' => 'uk-label-warning',
                    'completed' => 'uk-label-success',
                    'cancelled' => 'uk-label-danger',
                    'refunded' => 'uk-label-danger',
                ];
                ?>
                <span class="uk-label <?= $status_class[$order->status] ?? '' ?>">
                  <?= lang('shop_status_' . $order->status) ?>
                </span>
              </dd>

              <dt><?= lang('shop_payment_method') ?></dt>
              <dd>
                <?php
                $payment_icons = [
                    'points' => 'fa-solid fa-coins',
                    'paypal' => 'fa-brands fa-paypal',
                    'stripe' => 'fa-brands fa-stripe',
                ];
                ?>
                <i class="<?= $payment_icons[$order->payment_method] ?? 'fa-solid fa-credit-card' ?>"></i>
                <?= ucfirst($order->payment_method) ?>
              </dd>
            </dl>

            <hr>

            <div class="uk-text-bold uk-margin-bottom"><?= lang('shop_total') ?>:</div>
            
            <?php if ($order->total_dp > 0): ?>
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span><?= lang('shop_price_dp') ?>:</span>
              <span class="uk-text-bold bc-dp-points"><?= number_format($order->total_dp) ?> DP</span>
            </div>
            <?php endif; ?>
            
            <?php if ($order->total_vp > 0): ?>
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span><?= lang('shop_price_vp') ?>:</span>
              <span class="uk-text-bold bc-vp-points"><?= number_format($order->total_vp) ?> VP</span>
            </div>
            <?php endif; ?>

            <?php if ($order->total_money > 0): ?>
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span><?= lang('shop_price_money') ?>:</span>
              <span class="uk-text-bold uk-text-success">$<?= number_format($order->total_money, 2) ?></span>
            </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Actions -->
        <?php if ($order->status === 'pending'): ?>
        <div class="uk-card uk-card-default">
          <div class="uk-card-body">
            <p class="uk-text-muted uk-text-small"><?= lang('shop_pending_payment_note') ?></p>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
