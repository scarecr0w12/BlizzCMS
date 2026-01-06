<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('shop') ?>"><?= lang('shop') ?></a></li>
          <li><a href="<?= site_url('shop/subscriptions') ?>"><?= lang('shop_subscriptions') ?></a></li>
          <li><span><?= lang('shop_subscribe') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-crown"></i> <?= lang('shop_subscribe') ?>
        </h1>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <?= form_open(site_url('shop/subscriptions/subscribe/' . $subscription->id)) ?>
    <div uk-grid>
      <div class="uk-width-2-3@m">
        <!-- Subscription Details -->
        <div class="uk-card uk-card-default uk-margin-bottom">
          <div class="uk-card-header">
            <h3 class="uk-card-title">
              <i class="<?= ! empty($subscription->icon) ? $subscription->icon : 'fa-solid fa-crown' ?>"></i>
              <?= html_escape($subscription->name) ?>
            </h3>
          </div>
          <div class="uk-card-body">
            <?php if (! empty($subscription->description)): ?>
            <div class="uk-margin-bottom">
              <?= nl2br(html_escape($subscription->description)) ?>
            </div>
            <?php endif; ?>

            <div class="uk-alert uk-alert-primary">
              <p>
                <i class="fa-solid fa-info-circle"></i>
                <?= sprintf(lang('shop_subscription_billed'), ucfirst($subscription->interval_type)) ?>
              </p>
            </div>
          </div>
        </div>

        <!-- Payment Method -->
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-wallet"></i> <?= lang('shop_payment_method') ?></h3>
          </div>
          <div class="uk-card-body">
            <div class="uk-grid-small uk-child-width-1-2@s" uk-grid>
              <?php if ($can_pay_with_points): ?>
              <div>
                <label class="uk-card uk-card-default uk-card-body uk-card-small uk-card-hover">
                  <input class="uk-radio" type="radio" name="payment_method" value="points" checked>
                  <span class="uk-margin-small-left">
                    <i class="fa-solid fa-coins"></i> <?= lang('shop_pay_with_points') ?>
                  </span>
                  <div class="uk-text-small uk-text-muted uk-margin-small-top">
                    <?= lang('shop_your_balance') ?>: <?= number_format($user->dp) ?> DP, <?= number_format($user->vp) ?> VP
                  </div>
                </label>
              </div>
              <?php endif; ?>

              <?php if (setting('shop_paypal_enabled')): ?>
              <div>
                <label class="uk-card uk-card-default uk-card-body uk-card-small uk-card-hover">
                  <input class="uk-radio" type="radio" name="payment_method" value="paypal" <?= ! $can_pay_with_points ? 'checked' : '' ?>>
                  <span class="uk-margin-small-left">
                    <i class="fa-brands fa-paypal"></i> PayPal
                  </span>
                </label>
              </div>
              <?php endif; ?>

              <?php if (setting('shop_stripe_enabled')): ?>
              <div>
                <label class="uk-card uk-card-default uk-card-body uk-card-small uk-card-hover">
                  <input class="uk-radio" type="radio" name="payment_method" value="stripe">
                  <span class="uk-margin-small-left">
                    <i class="fa-brands fa-stripe"></i> Stripe
                  </span>
                </label>
              </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="uk-width-1-3@m">
        <!-- Summary -->
        <div class="uk-card uk-card-default uk-card-primary">
          <div class="uk-card-header uk-text-center">
            <i class="<?= ! empty($subscription->icon) ? $subscription->icon : 'fa-solid fa-crown' ?> fa-3x" style="color: gold;"></i>
          </div>
          <div class="uk-card-body">
            <h3 class="uk-card-title uk-text-center"><?= html_escape($subscription->name) ?></h3>
            
            <div class="uk-text-center uk-margin">
              <span class="uk-label"><?= ucfirst($subscription->interval_type) ?></span>
            </div>

            <hr>

            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span><?= lang('shop_price') ?>:</span>
              <span></span>
            </div>
            
            <?php if ($subscription->price_dp > 0): ?>
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span><?= lang('shop_price_dp') ?>:</span>
              <span class="uk-text-bold bc-dp-points"><?= number_format($subscription->price_dp) ?> DP</span>
            </div>
            <?php endif; ?>
            
            <?php if ($subscription->price_vp > 0): ?>
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span><?= lang('shop_price_vp') ?>:</span>
              <span class="uk-text-bold bc-vp-points"><?= number_format($subscription->price_vp) ?> VP</span>
            </div>
            <?php endif; ?>

            <?php if ($subscription->price_money > 0): ?>
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span><?= lang('shop_price_money') ?>:</span>
              <span class="uk-text-bold uk-text-success">$<?= number_format($subscription->price_money, 2) ?></span>
            </div>
            <?php endif; ?>

            <hr>

            <div class="uk-text-center uk-text-small uk-text-muted">
              <?= lang('shop_per_' . $subscription->interval_type) ?>
            </div>
          </div>
          <div class="uk-card-footer">
            <button type="submit" class="uk-button uk-button-primary uk-width-1-1 uk-button-large">
              <i class="fa-solid fa-crown"></i> <?= lang('shop_subscribe_now') ?>
            </button>
            <p class="uk-text-small uk-text-muted uk-text-center uk-margin-small-top">
              <i class="fa-solid fa-shield-halved"></i> <?= lang('shop_secure_checkout') ?>
            </p>
          </div>
        </div>

        <!-- Terms -->
        <div class="uk-card uk-card-default uk-margin-top">
          <div class="uk-card-body">
            <ul class="uk-list uk-list-bullet uk-text-small">
              <li><?= lang('shop_subscription_auto_renew') ?></li>
              <li><?= lang('shop_cancel_anytime') ?></li>
              <li><?= lang('shop_no_refunds_subscriptions') ?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <?= form_close() ?>
  </div>
</section>
