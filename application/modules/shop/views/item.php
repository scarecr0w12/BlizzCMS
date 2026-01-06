<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('shop') ?>"><?= lang('shop') ?></a></li>
          <li><span><?= html_escape($item->name) ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-box"></i> <?= html_escape($item->name) ?>
        </h1>
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

    <div uk-grid>
      <div class="uk-width-2-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-body">
            <div uk-grid>
              <div class="uk-width-1-3@m">
                <?php if (! empty($item->image)): ?>
                <img src="<?= base_url('uploads/shop/' . $item->image) ?>" alt="<?= html_escape($item->name) ?>" class="uk-width-1-1">
                <?php else: ?>
                <div class="uk-background-muted uk-text-center uk-padding uk-border-rounded">
                  <i class="fa-solid fa-box fa-5x uk-text-muted"></i>
                </div>
                <?php endif; ?>
              </div>
              <div class="uk-width-2-3@m">
                <h2 class="uk-h3"><?= html_escape($item->name) ?></h2>
                
                <?php if (! empty($item->description)): ?>
                <p class="uk-text-muted"><?= nl2br(html_escape($item->description)) ?></p>
                <?php endif; ?>

                <div class="uk-margin">
                  <span class="uk-text-muted"><?= lang('shop_item_count') ?>:</span>
                  <span class="uk-text-bold"><?= $item->item_count ?></span>
                </div>

                <div class="uk-margin">
                  <?php if ($item->stock == -1): ?>
                  <span class="uk-label uk-label-success"><i class="fa-solid fa-check"></i> <?= lang('shop_in_stock') ?></span>
                  <?php elseif ($item->stock > 0): ?>
                  <span class="uk-label uk-label-warning"><i class="fa-solid fa-exclamation-triangle"></i> <?= $item->stock ?> <?= lang('shop_in_stock') ?></span>
                  <?php else: ?>
                  <span class="uk-label uk-label-danger"><i class="fa-solid fa-times"></i> <?= lang('shop_out_of_stock') ?></span>
                  <?php endif; ?>
                </div>

                <hr>

                <div class="uk-h4 uk-margin">
                  <?= lang('shop_price') ?>:
                  <?php if ($item->price_dp > 0): ?>
                  <span class="uk-label uk-label-warning uk-margin-small-right"><i class="fa-solid fa-coins"></i> <?= number_format($item->price_dp) ?> DP</span>
                  <?php endif; ?>
                  <?php if ($item->price_vp > 0): ?>
                  <span class="uk-label uk-margin-small-right"><i class="fa-solid fa-check-to-slot"></i> <?= number_format($item->price_vp) ?> VP</span>
                  <?php endif; ?>
                  <?php if ($item->price_money > 0): ?>
                  <span class="uk-label uk-label-success"><i class="fa-solid fa-dollar-sign"></i> <?= number_format($item->price_money, 2) ?> <?= $item->currency ?></span>
                  <?php endif; ?>
                </div>

                <?php if ($item->stock != 0): ?>
                <?= form_open(site_url('shop/cart/add')) ?>
                  <input type="hidden" name="product_type" value="item">
                  <input type="hidden" name="product_id" value="<?= $item->id ?>">
                  
                  <div class="uk-margin">
                    <label class="uk-form-label"><?= lang('shop_select_realm') ?></label>
                    <select class="uk-select" name="realm_id" required>
                      <?php foreach ($realms as $realm): ?>
                      <option value="<?= $realm->id ?>"><?= html_escape($realm->name) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="uk-margin">
                    <label class="uk-form-label"><?= lang('shop_quantity') ?></label>
                    <input class="uk-input uk-form-width-small" type="number" name="quantity" value="1" min="1" max="<?= $item->stock > 0 ? $item->stock : 100 ?>">
                  </div>

                  <div class="uk-margin">
                    <button type="submit" class="uk-button uk-button-primary uk-button-large">
                      <i class="fa-solid fa-cart-plus"></i> <?= lang('shop_add_to_cart') ?>
                    </button>
                  </div>
                <?= form_close() ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="uk-width-1-3@m">
        <?php if (is_logged_in()): ?>
        <div class="uk-card uk-card-default uk-margin-bottom">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-wallet"></i> <?= lang('shop_your_balance') ?></h3>
          </div>
          <div class="uk-card-body">
            <div class="uk-grid-small" uk-grid>
              <div class="uk-width-1-2">
                <div class="uk-text-center">
                  <div class="uk-text-large uk-text-bold bc-dp-points"><?= number_format(user('dp')) ?></div>
                  <div class="uk-text-small uk-text-muted">Donation Points</div>
                </div>
              </div>
              <div class="uk-width-1-2">
                <div class="uk-text-center">
                  <div class="uk-text-large uk-text-bold bc-vp-points"><?= number_format(user('vp')) ?></div>
                  <div class="uk-text-small uk-text-muted">Vote Points</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-list"></i> <?= lang('shop_all_categories') ?></h3>
          </div>
          <ul class="uk-nav-default" uk-nav>
            <?php foreach ($categories as $cat): ?>
            <li class="<?= isset($category) && $category->id == $cat->id ? 'uk-active' : '' ?>">
              <a href="<?= site_url('shop/category/' . $cat->id) ?>">
                <?php if (! empty($cat->icon)): ?>
                <span class="uk-margin-small-right"><i class="<?= $cat->icon ?>"></i></span>
                <?php endif; ?>
                <?= html_escape($cat->name) ?>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
