<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container uk-container-expand">
    <div class="uk-flex uk-flex-between uk-flex-wrap uk-margin">
      <div>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-credit-card"></i> <?= lang('admin_shop_payments') ?>
        </h1>
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_dashboard') ?></a></li>
          <li><a href="<?= site_url('shop/admin') ?>"><?= lang('admin_shop') ?></a></li>
          <li><span><?= lang('admin_shop_payments') ?></span></li>
        </ul>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <div class="uk-card uk-card-default">
      <?php if (empty($payments)): ?>
      <div class="uk-card-body uk-text-center uk-padding-large">
        <i class="fa-solid fa-credit-card fa-5x uk-text-muted"></i>
        <h3 class="uk-margin-top"><?= lang('no_data') ?></h3>
      </div>
      <?php else: ?>
      <div class="uk-card-body uk-padding-remove">
        <table class="uk-table uk-table-middle uk-table-divider uk-table-hover uk-margin-remove">
          <thead>
            <tr>
              <th class="uk-table-shrink"><?= lang('id') ?></th>
              <th><?= lang('shop_order_number') ?></th>
              <th><?= lang('shop_transaction_id') ?></th>
              <th><?= lang('shop_gateway') ?></th>
              <th class="uk-text-center"><?= lang('shop_amount') ?></th>
              <th class="uk-text-center"><?= lang('status') ?></th>
              <th><?= lang('date') ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($payments as $payment): ?>
            <tr>
              <td><?= $payment->id ?></td>
              <td>
                <a href="<?= site_url('shop/admin/orders/view/' . $payment->order_id) ?>">#<?= $payment->order_id ?></a>
              </td>
              <td>
                <code class="uk-text-small"><?= html_escape($payment->transaction_id) ?></code>
              </td>
              <td>
                <?php
                $gateway_icons = [
                    'paypal' => 'fa-brands fa-paypal',
                    'stripe' => 'fa-brands fa-stripe',
                ];
                ?>
                <i class="<?= $gateway_icons[$payment->gateway] ?? 'fa-solid fa-credit-card' ?>"></i>
                <?= ucfirst($payment->gateway) ?>
              </td>
              <td class="uk-text-center">
                <span class="uk-label uk-label-success">
                  <?= $payment->currency ?> <?= number_format($payment->amount, 2) ?>
                </span>
              </td>
              <td class="uk-text-center">
                <?php
                $status_class = [
                    'pending' => 'uk-label-warning',
                    'completed' => 'uk-label-success',
                    'failed' => 'uk-label-danger',
                    'refunded' => 'uk-label-danger',
                ];
                ?>
                <span class="uk-label <?= $status_class[$payment->status] ?? '' ?>">
                  <?= ucfirst($payment->status) ?>
                </span>
              </td>
              <td>
                <span class="uk-text-small"><?= locate_date($payment->created_at) ?></span>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($total_payments > $per_page): ?>
    <div class="uk-margin-top">
      <?php
      $total_pages = ceil($total_payments / $per_page);
      ?>
      <ul class="uk-pagination uk-flex-center">
        <?php if ($current_page > 1): ?>
        <li><a href="<?= site_url('shop/admin/payments?page=' . ($current_page - 1)) ?>"><span uk-pagination-previous></span></a></li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <li class="<?= $i === $current_page ? 'uk-active' : '' ?>">
          <a href="<?= site_url('shop/admin/payments?page=' . $i) ?>"><?= $i ?></a>
        </li>
        <?php endfor; ?>
        <?php if ($current_page < $total_pages): ?>
        <li><a href="<?= site_url('shop/admin/payments?page=' . ($current_page + 1)) ?>"><span uk-pagination-next></span></a></li>
        <?php endif; ?>
      </ul>
    </div>
    <?php endif; ?>
  </div>
</section>
