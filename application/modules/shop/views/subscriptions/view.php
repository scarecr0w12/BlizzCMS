<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('shop') ?>"><?= lang('shop') ?></a></li>
          <li><a href="<?= site_url('shop/subscriptions') ?>"><?= lang('shop_subscriptions') ?></a></li>
          <li><span><?= html_escape($subscription->name) ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-crown"></i> <?= html_escape($subscription->name) ?>
        </h1>
      </div>
      <div class="uk-width-auto">
        <a href="<?= site_url('shop/subscriptions') ?>" class="uk-button uk-button-default">
          <i class="fa-solid fa-arrow-left"></i> <?= lang('shop_subscriptions') ?>
        </a>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <div uk-grid>
      <div class="uk-width-2-3@m">
        <!-- Subscription Details -->
        <div class="uk-card uk-card-default uk-margin-bottom">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-info-circle"></i> <?= lang('shop_subscription_details') ?></h3>
          </div>
          <div class="uk-card-body">
            <dl class="uk-description-list uk-description-list-divider">
              <dt><?= lang('status') ?></dt>
              <dd>
                <?php
                $status_class = [
                    'active' => 'uk-label-success',
                    'pending' => 'uk-label-warning',
                    'cancelled' => 'uk-label-danger',
                    'expired' => 'uk-label-danger',
                ];
                ?>
                <span class="uk-label <?= $status_class[$user_subscription->status] ?? '' ?>">
                  <?= lang('shop_sub_status_' . $user_subscription->status) ?>
                </span>
              </dd>

              <dt><?= lang('shop_subscription_type') ?></dt>
              <dd>
                <i class="<?= ! empty($subscription->icon) ? $subscription->icon : 'fa-solid fa-crown' ?>"></i>
                <?= html_escape($subscription->name) ?>
                <span class="uk-text-muted">(<?= ucfirst($subscription->interval_type) ?>)</span>
              </dd>

              <dt><?= lang('shop_started_on') ?></dt>
              <dd><?= locate_date($user_subscription->start_date) ?></dd>

              <?php if ($user_subscription->status === 'active'): ?>
              <dt><?= lang('shop_next_billing') ?></dt>
              <dd>
                <?= locate_date($user_subscription->next_billing_date) ?>
                <span class="uk-text-muted">(<?= lang('shop_auto_renewal') ?>)</span>
              </dd>
              <?php endif; ?>

              <?php if (! empty($user_subscription->end_date)): ?>
              <dt><?= lang('shop_end_date') ?></dt>
              <dd><?= locate_date($user_subscription->end_date) ?></dd>
              <?php endif; ?>

              <dt><?= lang('shop_payment_method') ?></dt>
              <dd>
                <?php
                $payment_icons = [
                    'points' => 'fa-solid fa-coins',
                    'paypal' => 'fa-brands fa-paypal',
                    'stripe' => 'fa-brands fa-stripe',
                ];
                ?>
                <i class="<?= $payment_icons[$user_subscription->payment_method] ?? 'fa-solid fa-credit-card' ?>"></i>
                <?= ucfirst($user_subscription->payment_method) ?>
              </dd>
            </dl>
          </div>
        </div>

        <!-- Subscription Benefits -->
        <?php if (! empty($subscription->description)): ?>
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-gift"></i> <?= lang('shop_subscription_benefits') ?></h3>
          </div>
          <div class="uk-card-body">
            <?= nl2br(html_escape($subscription->description)) ?>
          </div>
        </div>
        <?php endif; ?>
      </div>

      <div class="uk-width-1-3@m">
        <!-- Subscription Plan -->
        <div class="uk-card uk-card-default uk-card-primary uk-margin-bottom">
          <div class="uk-card-header uk-text-center">
            <i class="<?= ! empty($subscription->icon) ? $subscription->icon : 'fa-solid fa-crown' ?> fa-3x" style="color: gold;"></i>
          </div>
          <div class="uk-card-body uk-text-center">
            <h3 class="uk-card-title"><?= html_escape($subscription->name) ?></h3>
            <div class="uk-margin">
              <span class="uk-label"><?= ucfirst($subscription->interval_type) ?></span>
            </div>
            <div class="uk-h3">
              <?php if ($subscription->price_dp > 0): ?>
              <div class="bc-dp-points"><?= number_format($subscription->price_dp) ?> DP</div>
              <?php endif; ?>
              <?php if ($subscription->price_vp > 0): ?>
              <div class="bc-vp-points"><?= number_format($subscription->price_vp) ?> VP</div>
              <?php endif; ?>
              <?php if ($subscription->price_money > 0): ?>
              <div class="uk-text-success">$<?= number_format($subscription->price_money, 2) ?></div>
              <?php endif; ?>
            </div>
            <div class="uk-text-small uk-text-muted">
              <?= lang('shop_per_' . $subscription->interval_type) ?>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-cog"></i> <?= lang('actions') ?></h3>
          </div>
          <div class="uk-card-body">
            <?php if ($user_subscription->status === 'active'): ?>
            <p class="uk-text-small uk-text-muted"><?= lang('shop_cancel_subscription_note') ?></p>
            <?= form_open(site_url('shop/subscriptions/cancel/' . $user_subscription->id)) ?>
              <button type="submit" class="uk-button uk-button-danger uk-width-1-1" onclick="return confirm('<?= lang('shop_cancel_confirm') ?>')">
                <i class="fa-solid fa-ban"></i> <?= lang('shop_cancel_subscription') ?>
              </button>
            <?= form_close() ?>
            <?php elseif ($user_subscription->status === 'cancelled'): ?>
            <p class="uk-text-small uk-text-muted"><?= lang('shop_renew_subscription_note') ?></p>
            <a href="<?= site_url('shop/subscriptions/renew/' . $user_subscription->id) ?>" class="uk-button uk-button-primary uk-width-1-1">
              <i class="fa-solid fa-sync"></i> <?= lang('shop_renew') ?>
            </a>
            <?php elseif ($user_subscription->status === 'expired'): ?>
            <p class="uk-text-small uk-text-muted"><?= lang('shop_subscription_expired_note') ?></p>
            <a href="<?= site_url('shop/subscriptions/subscribe/' . $subscription->id) ?>" class="uk-button uk-button-primary uk-width-1-1">
              <i class="fa-solid fa-crown"></i> <?= lang('shop_subscribe') ?>
            </a>
            <?php endif; ?>
          </div>
        </div>

        <!-- Balance -->
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
    </div>
  </div>
</section>
