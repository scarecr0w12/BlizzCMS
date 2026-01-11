<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><span><?= lang('shop') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-store"></i> <?= lang('shop_title') ?>
        </h1>
        <p class="uk-text-meta uk-margin-remove-top"><?= lang('shop_description') ?></p>
      </div>
      <div class="uk-width-auto">
        <a href="<?= site_url('shop/cart') ?>" class="uk-button uk-button-default">
          <i class="fa-solid fa-cart-shopping"></i> <?= lang('shop_cart') ?>
          <?php if ($cart_count > 0): ?>
          <span class="uk-badge"><?= $cart_count ?></span>
          <?php endif; ?>
        </a>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <!-- Categories -->
    <div class="uk-card uk-card-default uk-margin">
      <div class="uk-card-body">
        <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-auto@l uk-flex-center" uk-grid>
          <?php foreach ($categories as $category): ?>
          <div>
            <a href="<?= site_url('shop/category/' . $category->id) ?>" class="uk-button uk-button-default uk-width-1-1">
              <?php if (! empty($category->icon)): ?>
              <i class="<?= $category->icon ?>"></i>
              <?php endif; ?>
              <?= html_escape($category->name) ?>
            </a>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Featured Items -->
    <?php if (! empty($featured_items)): ?>
    <div class="uk-margin">
      <h2 class="uk-h4 uk-text-bold">
        <i class="fa-solid fa-star"></i> <?= lang('shop_featured_items') ?>
      </h2>
      <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l" uk-grid>
        <?php foreach ($featured_items as $item): ?>
        <div>
          <div class="uk-card uk-card-default uk-card-hover">
            <div class="uk-card-media-top">
              <img src="<?= get_item_image($item) ?>" alt="<?= html_escape($item->name) ?>">
            </div>
            <div class="uk-card-body uk-padding-small">
              <h3 class="uk-card-title uk-h5 uk-margin-remove"><?= html_escape($item->name) ?></h3>
              <div class="uk-margin-small-top">
                <?php if ($item->price_dp > 0): ?>
                <span class="uk-label uk-label-warning"><i class="fa-solid fa-coins"></i> <?= number_format($item->price_dp) ?> DP</span>
                <?php endif; ?>
                <?php if ($item->price_vp > 0): ?>
                <span class="uk-label"><i class="fa-solid fa-check-to-slot"></i> <?= number_format($item->price_vp) ?> VP</span>
                <?php endif; ?>
                <?php if ($item->price_money > 0): ?>
                <span class="uk-label uk-label-success"><i class="fa-solid fa-dollar-sign"></i> <?= number_format($item->price_money, 2) ?></span>
                <?php endif; ?>
              </div>
            </div>
            <div class="uk-card-footer uk-padding-small">
              <a href="<?= site_url('shop/item/' . $item->id) ?>" class="uk-button uk-button-primary uk-button-small uk-width-1-1">
                <?= lang('shop_view_item') ?>
              </a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <div uk-grid>
      <!-- Sidebar -->
      <div class="uk-width-1-4@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-list"></i> <?= lang('shop_all_categories') ?></h3>
          </div>
          <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
            <?php foreach ($categories as $category): ?>
            <li>
              <a href="<?= site_url('shop/category/' . $category->id) ?>">
                <?php if (! empty($category->icon)): ?>
                <span class="uk-margin-small-right"><i class="<?= $category->icon ?>"></i></span>
                <?php endif; ?>
                <?= html_escape($category->name) ?>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <?php if (is_logged_in()): ?>
        <div class="uk-card uk-card-default uk-margin-top">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-wallet"></i> <?= lang('shop_your_balance') ?></h3>
          </div>
          <div class="uk-card-body">
            <div class="uk-grid-small" uk-grid>
              <div class="uk-width-1-2">
                <div class="uk-text-center">
                  <div class="uk-text-large uk-text-bold bc-dp-points"><?= number_format(user('dp')) ?></div>
                  <div class="uk-text-small uk-text-muted">DP</div>
                </div>
              </div>
              <div class="uk-width-1-2">
                <div class="uk-text-center">
                  <div class="uk-text-large uk-text-bold bc-vp-points"><?= number_format(user('vp')) ?></div>
                  <div class="uk-text-small uk-text-muted">VP</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>

      <!-- Main Content -->
      <div class="uk-width-3-4@m">
        <!-- All Items -->
        <h2 class="uk-h4 uk-text-bold">
          <i class="fa-solid fa-box"></i> <?= lang('shop_items') ?>
        </h2>
        <?php if (empty($items)): ?>
        <div class="uk-card uk-card-default">
          <div class="uk-card-body uk-text-center">
            <i class="fa-solid fa-inbox fa-3x uk-text-muted"></i>
            <p class="uk-text-muted uk-margin-small-top"><?= lang('no_data') ?></p>
          </div>
        </div>
        <?php else: ?>
        <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@l" uk-grid>
          <?php foreach ($items as $item): ?>
          <div>
            <div class="uk-card uk-card-default uk-card-hover">
              <div class="uk-card-media-top">
                <img src="<?= get_item_image($item) ?>" alt="<?= html_escape($item->name) ?>">
              </div>
              <div class="uk-card-body uk-padding-small">
                <h3 class="uk-card-title uk-h5 uk-margin-remove"><?= html_escape($item->name) ?></h3>
                <div class="uk-margin-small-top">
                  <?php if ($item->price_dp > 0): ?>
                  <span class="uk-label uk-label-warning"><i class="fa-solid fa-coins"></i> <?= number_format($item->price_dp) ?> DP</span>
                  <?php endif; ?>
                  <?php if ($item->price_vp > 0): ?>
                  <span class="uk-label"><i class="fa-solid fa-check-to-slot"></i> <?= number_format($item->price_vp) ?> VP</span>
                  <?php endif; ?>
                  <?php if ($item->price_money > 0): ?>
                  <span class="uk-label uk-label-success"><i class="fa-solid fa-dollar-sign"></i> <?= number_format($item->price_money, 2) ?></span>
                  <?php endif; ?>
                </div>
                <div class="uk-margin-small-top">
                  <?php if ($item->stock == -1): ?>
                  <span class="uk-text-success uk-text-small"><i class="fa-solid fa-check"></i> <?= lang('shop_in_stock') ?></span>
                  <?php elseif ($item->stock > 0): ?>
                  <span class="uk-text-warning uk-text-small"><i class="fa-solid fa-exclamation-triangle"></i> <?= lang('shop_limited_stock') ?>: <?= $item->stock ?></span>
                  <?php else: ?>
                  <span class="uk-text-danger uk-text-small"><i class="fa-solid fa-times"></i> <?= lang('shop_out_of_stock') ?></span>
                  <?php endif; ?>
                </div>
              </div>
              <div class="uk-card-footer uk-padding-small">
                <a href="<?= site_url('shop/item/' . $item->id) ?>" class="uk-button uk-button-primary uk-button-small uk-width-1-1">
                  <?= lang('shop_view_item') ?>
                </a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_items > $per_page): ?>
        <div class="uk-margin-top">
          <?php
          $total_pages = ceil($total_items / $per_page);
          ?>
          <ul class="uk-pagination uk-flex-center">
            <?php if ($current_page > 1): ?>
            <li><a href="<?= site_url('shop?page=' . ($current_page - 1)) ?>"><span uk-pagination-previous></span></a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="<?= $i === $current_page ? 'uk-active' : '' ?>">
              <a href="<?= site_url('shop?page=' . $i) ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
            <?php if ($current_page < $total_pages): ?>
            <li><a href="<?= site_url('shop?page=' . ($current_page + 1)) ?>"><span uk-pagination-next></span></a></li>
            <?php endif; ?>
          </ul>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        <!-- Services Preview -->
        <?php if (! empty($services)): ?>
        <h2 class="uk-h4 uk-text-bold uk-margin-top">
          <i class="fa-solid fa-wand-magic-sparkles"></i> <?= lang('shop_services') ?>
        </h2>
        <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@l" uk-grid>
          <?php foreach ($services as $service): ?>
          <div>
            <div class="uk-card uk-card-default uk-card-hover">
              <div class="uk-card-body uk-text-center">
                <i class="<?= ! empty($service->icon) ? $service->icon : 'fa-solid fa-gear' ?> fa-3x uk-text-primary"></i>
                <h3 class="uk-card-title uk-h5 uk-margin-small-top"><?= html_escape($service->name) ?></h3>
                <div class="uk-margin-small-top">
                  <?php if ($service->price_dp > 0): ?>
                  <span class="uk-label uk-label-warning"><?= number_format($service->price_dp) ?> DP</span>
                  <?php endif; ?>
                  <?php if ($service->price_vp > 0): ?>
                  <span class="uk-label"><?= number_format($service->price_vp) ?> VP</span>
                  <?php endif; ?>
                </div>
              </div>
              <div class="uk-card-footer uk-padding-small">
                <a href="<?= site_url('shop/service/' . $service->id) ?>" class="uk-button uk-button-secondary uk-button-small uk-width-1-1">
                  <?= lang('view') ?>
                </a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Subscriptions Preview -->
        <?php if (! empty($subscriptions)): ?>
        <h2 class="uk-h4 uk-text-bold uk-margin-top">
          <i class="fa-solid fa-crown"></i> <?= lang('shop_subscriptions') ?>
        </h2>
        <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-4@l" uk-grid>
          <?php foreach ($subscriptions as $subscription): ?>
          <div>
            <div class="uk-card uk-card-default uk-card-hover">
              <div class="uk-card-body uk-text-center">
                <i class="<?= ! empty($subscription->icon) ? $subscription->icon : 'fa-solid fa-crown' ?> fa-3x" style="color: gold;"></i>
                <h3 class="uk-card-title uk-h5 uk-margin-small-top"><?= html_escape($subscription->name) ?></h3>
                <p class="uk-text-small uk-text-muted"><?= ucfirst($subscription->interval_type) ?></p>
                <div class="uk-margin-small-top">
                  <?php if ($subscription->price_dp > 0): ?>
                  <span class="uk-label uk-label-warning"><?= number_format($subscription->price_dp) ?> DP</span>
                  <?php endif; ?>
                  <?php if ($subscription->price_vp > 0): ?>
                  <span class="uk-label"><?= number_format($subscription->price_vp) ?> VP</span>
                  <?php endif; ?>
                  <?php if ($subscription->price_money > 0): ?>
                  <span class="uk-label uk-label-success">$<?= number_format($subscription->price_money, 2) ?></span>
                  <?php endif; ?>
                </div>
              </div>
              <div class="uk-card-footer uk-padding-small">
                <a href="<?= site_url('shop/subscriptions') ?>" class="uk-button uk-button-primary uk-button-small uk-width-1-1">
                  <?= lang('shop_subscribe') ?>
                </a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
