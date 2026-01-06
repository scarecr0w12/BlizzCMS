<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container uk-container-expand">
    <div class="uk-flex uk-flex-between uk-flex-wrap uk-margin">
      <div>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-store"></i> <?= lang('admin_shop') ?>
        </h1>
        <p class="uk-text-meta uk-margin-remove"><?= lang('shop_dashboard_desc') ?></p>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <!-- Statistics Cards -->
    <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-4@m uk-margin-bottom" uk-grid>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-flex uk-flex-between uk-flex-middle">
            <div>
              <div class="uk-text-large uk-text-bold"><?= number_format($stats['total_orders']) ?></div>
              <div class="uk-text-muted"><?= lang('shop_total_orders') ?></div>
            </div>
            <div>
              <i class="fa-solid fa-receipt fa-2x uk-text-primary"></i>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-flex uk-flex-between uk-flex-middle">
            <div>
              <div class="uk-text-large uk-text-bold"><?= number_format($stats['completed_orders']) ?></div>
              <div class="uk-text-muted"><?= lang('shop_completed_orders') ?></div>
            </div>
            <div>
              <i class="fa-solid fa-check-circle fa-2x uk-text-success"></i>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-flex uk-flex-between uk-flex-middle">
            <div>
              <div class="uk-text-large uk-text-bold bc-dp-points"><?= number_format($stats['total_dp_earned']) ?></div>
              <div class="uk-text-muted"><?= lang('shop_dp_earned') ?></div>
            </div>
            <div>
              <i class="fa-solid fa-coins fa-2x uk-text-warning"></i>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-flex uk-flex-between uk-flex-middle">
            <div>
              <div class="uk-text-large uk-text-bold bc-vp-points"><?= number_format($stats['total_vp_earned']) ?></div>
              <div class="uk-text-muted"><?= lang('shop_vp_earned') ?></div>
            </div>
            <div>
              <i class="fa-solid fa-check-to-slot fa-2x uk-text-primary"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div uk-grid>
      <!-- Quick Links -->
      <div class="uk-width-1-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-link"></i> <?= lang('quick_links') ?></h3>
          </div>
          <ul class="uk-nav uk-nav-default">
            <li><a href="<?= site_url('shop/admin/categories') ?>"><i class="fa-solid fa-folder uk-margin-small-right"></i> <?= lang('admin_shop_categories') ?></a></li>
            <li><a href="<?= site_url('shop/admin/items') ?>"><i class="fa-solid fa-box uk-margin-small-right"></i> <?= lang('admin_shop_items') ?></a></li>
            <li><a href="<?= site_url('shop/admin/services') ?>"><i class="fa-solid fa-wand-magic-sparkles uk-margin-small-right"></i> <?= lang('admin_shop_services') ?></a></li>
            <li><a href="<?= site_url('shop/admin/subscriptions') ?>"><i class="fa-solid fa-crown uk-margin-small-right"></i> <?= lang('admin_shop_subscriptions') ?></a></li>
            <li class="uk-nav-divider"></li>
            <li><a href="<?= site_url('shop/admin/orders') ?>"><i class="fa-solid fa-receipt uk-margin-small-right"></i> <?= lang('admin_shop_orders') ?></a></li>
            <li><a href="<?= site_url('shop/admin/payments') ?>"><i class="fa-solid fa-credit-card uk-margin-small-right"></i> <?= lang('admin_shop_payments') ?></a></li>
          </ul>
        </div>

        <!-- Product Stats -->
        <div class="uk-card uk-card-default uk-margin-top">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-chart-pie"></i> <?= lang('shop_products') ?></h3>
          </div>
          <div class="uk-card-body">
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span><?= lang('admin_shop_categories') ?>:</span>
              <span class="uk-badge"><?= $category_count ?></span>
            </div>
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span><?= lang('admin_shop_items') ?>:</span>
              <span class="uk-badge"><?= $item_count ?></span>
            </div>
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span><?= lang('admin_shop_services') ?>:</span>
              <span class="uk-badge"><?= $service_count ?></span>
            </div>
            <div class="uk-flex uk-flex-between">
              <span><?= lang('admin_shop_subscriptions') ?>:</span>
              <span class="uk-badge"><?= $subscription_count ?></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Orders -->
      <div class="uk-width-2-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <div class="uk-flex uk-flex-between uk-flex-middle">
              <h3 class="uk-card-title"><i class="fa-solid fa-clock"></i> <?= lang('shop_recent_orders') ?></h3>
              <a href="<?= site_url('shop/admin/orders') ?>" class="uk-button uk-button-text"><?= lang('view_all') ?></a>
            </div>
          </div>
          <?php if (empty($recent_orders)): ?>
          <div class="uk-card-body uk-text-center">
            <i class="fa-solid fa-inbox fa-3x uk-text-muted"></i>
            <p class="uk-text-muted uk-margin-small-top"><?= lang('shop_no_orders') ?></p>
          </div>
          <?php else: ?>
          <div class="uk-card-body uk-padding-remove">
            <table class="uk-table uk-table-small uk-table-middle uk-table-divider uk-margin-remove">
              <thead>
                <tr>
                  <th><?= lang('shop_order_number') ?></th>
                  <th><?= lang('user') ?></th>
                  <th class="uk-text-center"><?= lang('shop_total') ?></th>
                  <th class="uk-text-center"><?= lang('status') ?></th>
                  <th><?= lang('date') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($recent_orders as $order): ?>
                <tr>
                  <td>
                    <a href="<?= site_url('shop/admin/orders/' . $order->id) ?>">#<?= $order->id ?></a>
                  </td>
                  <td><?= html_escape($order->username ?? 'Unknown') ?></td>
                  <td class="uk-text-center">
                    <?php if ($order->total_dp > 0): ?>
                    <span class="uk-text-small bc-dp-points"><?= number_format($order->total_dp) ?> DP</span>
                    <?php endif; ?>
                    <?php if ($order->total_vp > 0): ?>
                    <span class="uk-text-small bc-vp-points"><?= number_format($order->total_vp) ?> VP</span>
                    <?php endif; ?>
                  </td>
                  <td class="uk-text-center">
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
                  </td>
                  <td>
                    <span class="uk-text-small uk-text-muted"><?= locate_date($order->created_at, 'Y-m-d H:i') ?></span>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <?php endif; ?>
        </div>

        <!-- Pending Orders -->
        <?php if (! empty($pending_orders)): ?>
        <div class="uk-card uk-card-default uk-margin-top">
          <div class="uk-card-header">
            <h3 class="uk-card-title">
              <i class="fa-solid fa-exclamation-triangle uk-text-warning"></i>
              <?= lang('shop_pending_orders') ?>
              <span class="uk-badge uk-badge-warning"><?= count($pending_orders) ?></span>
            </h3>
          </div>
          <div class="uk-card-body uk-padding-remove">
            <table class="uk-table uk-table-small uk-table-middle uk-table-divider uk-margin-remove">
              <thead>
                <tr>
                  <th><?= lang('shop_order_number') ?></th>
                  <th><?= lang('user') ?></th>
                  <th class="uk-text-center"><?= lang('shop_payment_method') ?></th>
                  <th class="uk-text-center"><?= lang('actions') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($pending_orders as $order): ?>
                <tr>
                  <td>#<?= $order->id ?></td>
                  <td><?= html_escape($order->username ?? 'Unknown') ?></td>
                  <td class="uk-text-center"><?= ucfirst($order->payment_method) ?></td>
                  <td class="uk-text-center">
                    <a href="<?= site_url('shop/admin/orders/view/' . $order->id) ?>" class="uk-button uk-button-primary uk-button-small">
                      <i class="fa-solid fa-eye"></i> <?= lang('view') ?>
                    </a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
