<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('shop') ?>"><?= lang('shop') ?></a></li>
          <li><span><?= lang('shop_order_history') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-receipt"></i> <?= lang('shop_order_history') ?>
        </h1>
      </div>
      <div class="uk-width-auto">
        <a href="<?= site_url('shop') ?>" class="uk-button uk-button-default">
          <i class="fa-solid fa-store"></i> <?= lang('shop') ?>
        </a>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <?php if (empty($orders)): ?>
    <div class="uk-card uk-card-default">
      <div class="uk-card-body uk-text-center uk-padding-large">
        <i class="fa-solid fa-receipt fa-5x uk-text-muted"></i>
        <h3 class="uk-margin-top"><?= lang('shop_no_orders') ?></h3>
        <p class="uk-text-muted"><?= lang('shop_description') ?></p>
        <a href="<?= site_url('shop') ?>" class="uk-button uk-button-primary">
          <i class="fa-solid fa-store"></i> <?= lang('shop_continue_shopping') ?>
        </a>
      </div>
    </div>
    <?php else: ?>
    <div class="uk-card uk-card-default">
      <div class="uk-card-body uk-padding-remove">
        <table class="uk-table uk-table-middle uk-table-divider uk-table-hover uk-margin-remove">
          <thead>
            <tr>
              <th><?= lang('shop_order_number') ?></th>
              <th><?= lang('date') ?></th>
              <th class="uk-text-center"><?= lang('shop_items') ?></th>
              <th class="uk-text-center"><?= lang('shop_total') ?></th>
              <th class="uk-text-center"><?= lang('status') ?></th>
              <th class="uk-text-center"><?= lang('actions') ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
              <td>
                <strong>#<?= $order->id ?></strong>
              </td>
              <td>
                <span class="uk-text-muted"><?= locate_date($order->created_at) ?></span>
              </td>
              <td class="uk-text-center">
                <span class="uk-badge"><?= $order->item_count ?></span>
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
              <td class="uk-text-center">
                <a href="<?= site_url('shop/history/' . $order->id) ?>" class="uk-button uk-button-primary uk-button-small">
                  <i class="fa-solid fa-eye"></i> <?= lang('view') ?>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    <?php if ($total_orders > $per_page): ?>
    <div class="uk-margin-top">
      <?php
      $total_pages = ceil($total_orders / $per_page);
      ?>
      <ul class="uk-pagination uk-flex-center">
        <?php if ($current_page > 1): ?>
        <li><a href="<?= site_url('shop/history?page=' . ($current_page - 1)) ?>"><span uk-pagination-previous></span></a></li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <li class="<?= $i === $current_page ? 'uk-active' : '' ?>">
          <a href="<?= site_url('shop/history?page=' . $i) ?>"><?= $i ?></a>
        </li>
        <?php endfor; ?>
        <?php if ($current_page < $total_pages): ?>
        <li><a href="<?= site_url('shop/history?page=' . ($current_page + 1)) ?>"><span uk-pagination-next></span></a></li>
        <?php endif; ?>
      </ul>
    </div>
    <?php endif; ?>
    <?php endif; ?>
  </div>
</section>
