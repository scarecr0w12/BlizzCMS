<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('shop') ?>"><?= lang('shop') ?></a></li>
          <li><span><?= lang('shop_subscriptions') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-crown"></i> <?= lang('shop_subscriptions') ?>
        </h1>
        <p class="uk-text-meta uk-margin-remove-top"><?= lang('shop_subscription_benefits') ?></p>
      </div>
      <div class="uk-width-auto">
        <a href="<?= site_url('shop') ?>" class="uk-button uk-button-default">
          <i class="fa-solid fa-arrow-left"></i> <?= lang('shop') ?>
        </a>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <!-- Current Subscriptions -->
    <?php if (is_logged_in() && ! empty($user_subscriptions)): ?>
    <div class="uk-card uk-card-default uk-margin-bottom">
      <div class="uk-card-header">
        <h3 class="uk-card-title"><i class="fa-solid fa-star"></i> <?= lang('shop_your_subscriptions') ?></h3>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <table class="uk-table uk-table-middle uk-table-divider uk-margin-remove">
          <thead>
            <tr>
              <th><?= lang('shop_subscription') ?></th>
              <th class="uk-text-center"><?= lang('status') ?></th>
              <th class="uk-text-center"><?= lang('shop_next_billing') ?></th>
              <th class="uk-text-center"><?= lang('actions') ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($user_subscriptions as $sub): ?>
            <tr>
              <td>
                <strong><?= html_escape($sub->subscription_name) ?></strong>
                <div class="uk-text-small uk-text-muted"><?= ucfirst($sub->interval_type) ?></div>
              </td>
              <td class="uk-text-center">
                <?php
                $status_class = [
                    'active' => 'uk-label-success',
                    'pending' => 'uk-label-warning',
                    'cancelled' => 'uk-label-danger',
                    'expired' => 'uk-label-danger',
                ];
                ?>
                <span class="uk-label <?= $status_class[$sub->status] ?? '' ?>">
                  <?= lang('shop_sub_status_' . $sub->status) ?>
                </span>
              </td>
              <td class="uk-text-center">
                <?php if ($sub->status === 'active'): ?>
                <?= locate_date($sub->next_billing_date) ?>
                <?php else: ?>
                -
                <?php endif; ?>
              </td>
              <td class="uk-text-center">
                <a href="<?= site_url('shop/subscriptions/view/' . $sub->id) ?>" class="uk-button uk-button-primary uk-button-small">
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

    <!-- Available Subscriptions -->
    <h2 class="uk-h4 uk-text-bold">
      <i class="fa-solid fa-crown"></i> <?= lang('shop_available_subscriptions') ?>
    </h2>

    <?php if (empty($subscriptions)): ?>
    <div class="uk-card uk-card-default">
      <div class="uk-card-body uk-text-center uk-padding-large">
        <i class="fa-solid fa-crown fa-5x uk-text-muted"></i>
        <h3 class="uk-margin-top"><?= lang('no_data') ?></h3>
        <p class="uk-text-muted"><?= lang('shop_no_subscriptions') ?></p>
      </div>
    </div>
    <?php else: ?>
    <div class="uk-grid-match uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l" uk-grid>
      <?php foreach ($subscriptions as $subscription): ?>
      <div>
        <div class="uk-card uk-card-default uk-card-hover uk-text-center">
          <div class="uk-card-header">
            <i class="<?= ! empty($subscription->icon) ? $subscription->icon : 'fa-solid fa-crown' ?> fa-3x" style="color: gold;"></i>
          </div>
          <div class="uk-card-body">
            <h3 class="uk-card-title uk-h4"><?= html_escape($subscription->name) ?></h3>
            
            <?php if (! empty($subscription->description)): ?>
            <p class="uk-text-muted uk-text-small"><?= nl2br(html_escape(substr($subscription->description, 0, 100))) ?>...</p>
            <?php endif; ?>

            <div class="uk-margin">
              <span class="uk-label"><?= ucfirst($subscription->interval_type) ?></span>
            </div>

            <div class="uk-margin">
              <?php if ($subscription->price_dp > 0): ?>
              <div class="uk-margin-small">
                <span class="uk-label uk-label-warning uk-label-large"><?= number_format($subscription->price_dp) ?> DP</span>
              </div>
              <?php endif; ?>
              <?php if ($subscription->price_vp > 0): ?>
              <div class="uk-margin-small">
                <span class="uk-label uk-label-large"><?= number_format($subscription->price_vp) ?> VP</span>
              </div>
              <?php endif; ?>
              <?php if ($subscription->price_money > 0): ?>
              <div class="uk-margin-small">
                <span class="uk-label uk-label-success uk-label-large">$<?= number_format($subscription->price_money, 2) ?>/<?= substr($subscription->interval_type, 0, 2) ?></span>
              </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="uk-card-footer">
            <?php
            $has_active = false;
            if (is_logged_in() && ! empty($user_subscriptions)) {
                foreach ($user_subscriptions as $us) {
                    if ($us->subscription_id == $subscription->id && $us->status === 'active') {
                        $has_active = true;
                        break;
                    }
                }
            }
            ?>
            <?php if ($has_active): ?>
            <span class="uk-button uk-button-default uk-width-1-1 uk-disabled">
              <i class="fa-solid fa-check"></i> <?= lang('shop_subscribed') ?>
            </span>
            <?php else: ?>
            <a href="<?= site_url('shop/subscriptions/subscribe/' . $subscription->id) ?>" class="uk-button uk-button-primary uk-width-1-1">
              <i class="fa-solid fa-crown"></i> <?= lang('shop_subscribe') ?>
            </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Info Section -->
    <div class="uk-card uk-card-default uk-margin-top">
      <div class="uk-card-body">
        <h3 class="uk-h4"><i class="fa-solid fa-info-circle"></i> <?= lang('shop_subscription_info') ?></h3>
        <div class="uk-grid-small uk-child-width-1-3@m" uk-grid>
          <div>
            <div class="uk-text-center">
              <i class="fa-solid fa-sync fa-2x uk-text-primary"></i>
              <h4 class="uk-h5 uk-margin-small-top"><?= lang('shop_auto_renewal') ?></h4>
              <p class="uk-text-small uk-text-muted"><?= lang('shop_auto_renewal_desc') ?></p>
            </div>
          </div>
          <div>
            <div class="uk-text-center">
              <i class="fa-solid fa-ban fa-2x uk-text-danger"></i>
              <h4 class="uk-h5 uk-margin-small-top"><?= lang('shop_cancel_anytime') ?></h4>
              <p class="uk-text-small uk-text-muted"><?= lang('shop_cancel_anytime_desc') ?></p>
            </div>
          </div>
          <div>
            <div class="uk-text-center">
              <i class="fa-solid fa-bolt fa-2x uk-text-warning"></i>
              <h4 class="uk-h5 uk-margin-small-top"><?= lang('shop_instant_activation') ?></h4>
              <p class="uk-text-small uk-text-muted"><?= lang('shop_instant_activation_desc') ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
