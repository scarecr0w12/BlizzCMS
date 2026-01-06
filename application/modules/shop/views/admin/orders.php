<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container uk-container-expand">
    <div class="uk-flex uk-flex-between uk-flex-wrap uk-margin">
      <div>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-receipt"></i> <?= lang('admin_shop_orders') ?>
        </h1>
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_dashboard') ?></a></li>
          <li><a href="<?= site_url('shop/admin') ?>"><?= lang('admin_shop') ?></a></li>
          <li><span><?= lang('admin_shop_orders') ?></span></li>
        </ul>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <!-- Filters -->
    <div class="uk-card uk-card-default uk-margin-bottom">
      <div class="uk-card-body">
        <?= form_open(current_url(), ['method' => 'get']) ?>
          <div class="uk-grid-small uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <select class="uk-select" name="status">
                <option value=""><?= lang('all_statuses') ?></option>
                <option value="pending" <?= $this->input->get('status') == 'pending' ? 'selected' : '' ?>><?= lang('shop_status_pending') ?></option>
                <option value="processing" <?= $this->input->get('status') == 'processing' ? 'selected' : '' ?>><?= lang('shop_status_processing') ?></option>
                <option value="completed" <?= $this->input->get('status') == 'completed' ? 'selected' : '' ?>><?= lang('shop_status_completed') ?></option>
                <option value="cancelled" <?= $this->input->get('status') == 'cancelled' ? 'selected' : '' ?>><?= lang('shop_status_cancelled') ?></option>
                <option value="refunded" <?= $this->input->get('status') == 'refunded' ? 'selected' : '' ?>><?= lang('shop_status_refunded') ?></option>
              </select>
            </div>
            <div class="uk-width-auto">
              <select class="uk-select" name="payment_method">
                <option value=""><?= lang('shop_all_payment_methods') ?></option>
                <option value="points" <?= $this->input->get('payment_method') == 'points' ? 'selected' : '' ?>>Points</option>
                <option value="paypal" <?= $this->input->get('payment_method') == 'paypal' ? 'selected' : '' ?>>PayPal</option>
                <option value="stripe" <?= $this->input->get('payment_method') == 'stripe' ? 'selected' : '' ?>>Stripe</option>
              </select>
            </div>
            <div class="uk-width-auto">
              <button type="submit" class="uk-button uk-button-primary">
                <i class="fa-solid fa-filter"></i> <?= lang('filter') ?>
              </button>
            </div>
          </div>
        <?= form_close() ?>
      </div>
    </div>

    <div class="uk-card uk-card-default">
      <?php if (empty($orders)): ?>
      <div class="uk-card-body uk-text-center uk-padding-large">
        <i class="fa-solid fa-receipt fa-5x uk-text-muted"></i>
        <h3 class="uk-margin-top"><?= lang('shop_no_orders') ?></h3>
      </div>
      <?php else: ?>
      <div class="uk-card-body uk-padding-remove">
        <table class="uk-table uk-table-middle uk-table-divider uk-table-hover uk-margin-remove">
          <thead>
            <tr>
              <th class="uk-table-shrink"><?= lang('shop_order_number') ?></th>
              <th><?= lang('user') ?></th>
              <th><?= lang('shop_payment_method') ?></th>
              <th class="uk-text-center"><?= lang('shop_total') ?></th>
              <th class="uk-text-center"><?= lang('status') ?></th>
              <th><?= lang('date') ?></th>
              <th class="uk-text-center uk-table-shrink"><?= lang('actions') ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
              <td>#<?= $order->id ?></td>
              <td>
                <a href="<?= site_url('admin/users/' . $order->user_id) ?>"><?= html_escape($order->username ?? 'Unknown') ?></a>
              </td>
              <td>
                <?php
                $payment_icons = [
                    'points' => 'fa-solid fa-coins',
                    'paypal' => 'fa-brands fa-paypal',
                    'stripe' => 'fa-brands fa-stripe',
                ];
                ?>
                <i class="<?= $payment_icons[$order->payment_method] ?? 'fa-solid fa-credit-card' ?>"></i>
                <?= ucfirst($order->payment_method) ?>
              </td>
              <td class="uk-text-center">
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
                <span class="uk-text-small"><?= locate_date($order->created_at) ?></span>
              </td>
              <td class="uk-text-center">
                <a href="<?= site_url('shop/admin/orders/view/' . $order->id) ?>" class="uk-button uk-button-primary uk-button-small">
                  <i class="fa-solid fa-eye"></i>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($total_orders > $per_page): ?>
    <div class="uk-margin-top">
      <?php
      $total_pages = ceil($total_orders / $per_page);
      ?>
      <ul class="uk-pagination uk-flex-center">
        <?php if ($current_page > 1): ?>
        <li><a href="<?= site_url('shop/admin/orders?page=' . ($current_page - 1) . '&' . http_build_query(['status' => $this->input->get('status'), 'payment_method' => $this->input->get('payment_method')])) ?>"><span uk-pagination-previous></span></a></li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <li class="<?= $i === $current_page ? 'uk-active' : '' ?>">
          <a href="<?= site_url('shop/admin/orders?page=' . $i . '&' . http_build_query(['status' => $this->input->get('status'), 'payment_method' => $this->input->get('payment_method')])) ?>"><?= $i ?></a>
        </li>
        <?php endfor; ?>
        <?php if ($current_page < $total_pages): ?>
        <li><a href="<?= site_url('shop/admin/orders?page=' . ($current_page + 1) . '&' . http_build_query(['status' => $this->input->get('status'), 'payment_method' => $this->input->get('payment_method')])) ?>"><span uk-pagination-next></span></a></li>
        <?php endif; ?>
      </ul>
    </div>
    <?php endif; ?>
  </div>
</section>
