<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container uk-container-expand">
    <div class="uk-flex uk-flex-between uk-flex-wrap uk-margin">
      <div>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-receipt"></i> <?= lang('shop_order_number') ?> #<?= $order->id ?>
        </h1>
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_dashboard') ?></a></li>
          <li><a href="<?= site_url('shop/admin') ?>"><?= lang('admin_shop') ?></a></li>
          <li><a href="<?= site_url('shop/admin/orders') ?>"><?= lang('admin_shop_orders') ?></a></li>
          <li><span>#<?= $order->id ?></span></li>
        </ul>
      </div>
      <div>
        <a href="<?= site_url('shop/admin/orders') ?>" class="uk-button uk-button-default">
          <i class="fa-solid fa-arrow-left"></i> <?= lang('back') ?>
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
                  <th><?= lang('type') ?></th>
                  <th class="uk-text-center"><?= lang('shop_quantity') ?></th>
                  <th class="uk-text-right"><?= lang('shop_price') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                  <td><strong><?= html_escape($item->product_name) ?></strong></td>
                  <td><span class="uk-label"><?= ucfirst($item->product_type) ?></span></td>
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
              <tfoot>
                <tr>
                  <td colspan="3" class="uk-text-right"><strong><?= lang('shop_total') ?>:</strong></td>
                  <td class="uk-text-right">
                    <?php if ($order->total_dp > 0): ?>
                    <span class="uk-label uk-label-warning"><?= number_format($order->total_dp) ?> DP</span>
                    <?php endif; ?>
                    <?php if ($order->total_vp > 0): ?>
                    <span class="uk-label"><?= number_format($order->total_vp) ?> VP</span>
                    <?php endif; ?>
                    <?php if ($order->total_money > 0): ?>
                    <span class="uk-label uk-label-success">$<?= number_format($order->total_money, 2) ?></span>
                    <?php endif; ?>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <!-- Delivery Info -->
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-truck"></i> <?= lang('shop_delivery_info') ?></h3>
          </div>
          <div class="uk-card-body">
            <dl class="uk-description-list">
              <dt><?= lang('shop_select_realm') ?>:</dt>
              <dd><?= html_escape($realm_name ?? 'N/A') ?></dd>
              <dt><?= lang('shop_select_character') ?>:</dt>
              <dd><?= html_escape($character_name ?? 'N/A') ?></dd>
            </dl>
          </div>
        </div>
      </div>

      <div class="uk-width-1-3@m">
        <!-- Order Info -->
        <div class="uk-card uk-card-default uk-margin-bottom">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-info-circle"></i> <?= lang('shop_order_info') ?></h3>
          </div>
          <div class="uk-card-body">
            <dl class="uk-description-list uk-description-list-divider">
              <dt><?= lang('shop_order_number') ?></dt>
              <dd>#<?= $order->id ?></dd>

              <dt><?= lang('user') ?></dt>
              <dd>
                <a href="<?= site_url('admin/users/' . $order->user_id) ?>"><?= html_escape($order->username ?? 'Unknown') ?></a>
              </dd>

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

              <dt><?= lang('date') ?></dt>
              <dd><?= locate_date($order->created_at) ?></dd>

              <?php if (! empty($order->transaction_id)): ?>
              <dt><?= lang('shop_transaction_id') ?></dt>
              <dd><code><?= html_escape($order->transaction_id) ?></code></dd>
              <?php endif; ?>
            </dl>
          </div>
        </div>

        <!-- Actions -->
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-cog"></i> <?= lang('actions') ?></h3>
          </div>
          <div class="uk-card-body">
            <?php if ($order->status === 'pending'): ?>
            <a href="<?= site_url('shop/admin/orders/process/' . $order->id) ?>" class="uk-button uk-button-success uk-width-1-1 uk-margin-small-bottom" onclick="return confirm('<?= lang('shop_confirm_process') ?>')">
              <i class="fa-solid fa-check"></i> <?= lang('shop_process_order') ?>
            </a>
            <a href="<?= site_url('shop/admin/orders/cancel/' . $order->id) ?>" class="uk-button uk-button-danger uk-width-1-1" onclick="return confirm('<?= lang('shop_confirm_cancel') ?>')">
              <i class="fa-solid fa-times"></i> <?= lang('shop_cancel_order') ?>
            </a>
            <?php elseif ($order->status === 'processing'): ?>
            <a href="<?= site_url('shop/admin/orders/complete/' . $order->id) ?>" class="uk-button uk-button-success uk-width-1-1 uk-margin-small-bottom" onclick="return confirm('<?= lang('shop_confirm_complete') ?>')">
              <i class="fa-solid fa-check-double"></i> <?= lang('shop_complete_order') ?>
            </a>
            <?php elseif ($order->status === 'completed' && $order->payment_method !== 'points'): ?>
            <a href="<?= site_url('shop/admin/orders/refund/' . $order->id) ?>" class="uk-button uk-button-warning uk-width-1-1" onclick="return confirm('<?= lang('shop_confirm_refund') ?>')">
              <i class="fa-solid fa-rotate-left"></i> <?= lang('shop_refund_order') ?>
            </a>
            <?php else: ?>
            <p class="uk-text-muted uk-text-center"><?= lang('shop_no_actions_available') ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
