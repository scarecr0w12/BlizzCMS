<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><span><?= lang('donate') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-heart"></i> <?= lang('donate_title') ?>
        </h1>
        <p class="uk-text-meta uk-margin-remove-top"><?= lang('donate_description') ?></p>
      </div>
    </div>

    <!-- Featured Packages -->
    <?php if (!empty($featured_packages)): ?>
    <div class="uk-margin-medium-bottom">
      <h2 class="uk-h4 uk-text-bold"><i class="fa-solid fa-star"></i> <?= lang('donate_featured_packages') ?></h2>
      <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-4@m" uk-grid>
        <?php foreach ($featured_packages as $package): ?>
        <div>
          <div class="uk-card uk-card-default uk-card-hover uk-card-body uk-text-center">
            <?php if (!empty($package->image)): ?>
            <img src="<?= base_url('uploads/' . $package->image) ?>" alt="<?= html_escape($package->name) ?>" class="uk-margin-small-bottom" style="max-height: 80px;">
            <?php else: ?>
            <i class="fa-solid fa-gift fa-3x uk-text-primary uk-margin-small-bottom"></i>
            <?php endif; ?>
            <h3 class="uk-card-title uk-margin-small"><?= html_escape($package->name) ?></h3>
            <div class="uk-text-large uk-text-bold uk-text-primary">
              <?= $package->currency ?> <?= number_format($package->price, 2) ?>
            </div>
            <div class="uk-margin-small">
              <span class="uk-badge uk-badge-primary"><?= number_format($package->dp_amount) ?> DP</span>
              <?php if ($package->bonus_dp > 0): ?>
              <span class="uk-badge uk-badge-success">+<?= number_format($package->bonus_dp) ?> Bonus</span>
              <?php endif; ?>
            </div>
            <a href="<?= site_url('donate/package/' . $package->id) ?>" class="uk-button uk-button-primary uk-button-small uk-width-1-1">
              <?= lang('donate_buy_now') ?>
            </a>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <div uk-grid>
      <!-- Main Content -->
      <div class="uk-width-2-3@m">
        <!-- All Packages -->
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-box"></i> <?= lang('donate_all_packages') ?></h3>
          </div>
          <div class="uk-card-body">
            <?php if (empty($packages)): ?>
            <div class="uk-text-center uk-padding">
              <i class="fa-solid fa-box-open fa-3x uk-text-muted"></i>
              <p class="uk-text-muted"><?= lang('donate_no_packages') ?></p>
            </div>
            <?php else: ?>
            <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid>
              <?php foreach ($packages as $package): ?>
              <div>
                <div class="uk-card uk-card-secondary uk-card-body uk-card-small uk-text-center">
                  <h4 class="uk-card-title uk-margin-small"><?= html_escape($package->name) ?></h4>
                  <div class="uk-text-large uk-text-bold">
                    <?= $package->currency ?> <?= number_format($package->price, 2) ?>
                  </div>
                  <div class="uk-margin-small-top uk-margin-small-bottom">
                    <div class="uk-text-small">
                      <strong><?= number_format($package->dp_amount + $package->bonus_dp) ?></strong> <?= lang('dp') ?>
                      <?php if ($package->bonus_dp > 0): ?>
                      <span class="uk-text-success">(+<?= $package->bonus_dp ?>)</span>
                      <?php endif; ?>
                    </div>
                  </div>
                  <a href="<?= site_url('donate/package/' . $package->id) ?>" class="uk-button uk-button-primary uk-button-small uk-width-1-1">
                    <?= lang('view') ?>
                  </a>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Payment Methods -->
        <div class="uk-card uk-card-default uk-margin-top">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-credit-card"></i> <?= lang('donate_gateways') ?></h3>
          </div>
          <div class="uk-card-body">
            <?php if (empty($gateways)): ?>
            <p class="uk-text-muted"><?= lang('donate_no_gateways') ?></p>
            <?php else: ?>
            <div class="uk-grid-small uk-child-width-auto" uk-grid>
              <?php foreach ($gateways as $gateway): ?>
              <div>
                <div class="uk-card uk-card-body uk-card-small uk-text-center" style="min-width: 120px;">
                  <i class="<?= $gateway->icon ?> fa-2x uk-text-muted"></i>
                  <div class="uk-text-small uk-margin-small-top"><?= html_escape($gateway->display_name) ?></div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="uk-width-1-3@m">
        <!-- Top Donators -->
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-trophy"></i> <?= lang('donate_top_supporters') ?></h3>
          </div>
          <div class="uk-card-body uk-padding-remove">
            <?php if (empty($top_donators)): ?>
            <div class="uk-padding uk-text-center">
              <p class="uk-text-muted">No donations yet. Be the first!</p>
            </div>
            <?php else: ?>
            <ul class="uk-list uk-list-divider uk-margin-remove">
              <?php $rank = 1; foreach ($top_donators as $donator): ?>
              <li class="uk-padding-small">
                <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
                  <div class="uk-width-auto">
                    <?php if ($rank <= 3): ?>
                    <span class="uk-badge <?= $rank == 1 ? 'uk-badge-warning' : ($rank == 2 ? '' : 'uk-badge-danger') ?>">#<?= $rank ?></span>
                    <?php else: ?>
                    <span class="uk-text-muted">#<?= $rank ?></span>
                    <?php endif; ?>
                  </div>
                  <div class="uk-width-auto">
                    <img class="uk-border-circle" src="<?= user_avatar($donator->id) ?>" width="32" height="32" alt="">
                  </div>
                  <div class="uk-width-expand">
                    <div class="uk-text-bold"><?= html_escape($donator->nickname) ?></div>
                    <div class="uk-text-small uk-text-muted">
                      $<?= number_format($donator->total_donated, 2) ?>
                    </div>
                  </div>
                </div>
              </li>
              <?php $rank++; endforeach; ?>
            </ul>
            <?php endif; ?>
          </div>
          <div class="uk-card-footer">
            <a href="<?= site_url('donate/top') ?>" class="uk-button uk-button-text">
              <?= lang('view') ?> <?= lang('donate_top_donators') ?> <i class="fa-solid fa-arrow-right"></i>
            </a>
          </div>
        </div>

        <!-- User Actions -->
        <?php if (is_logged_in()): ?>
        <div class="uk-card uk-card-default uk-margin-top">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-user"></i> <?= lang('user') ?></h3>
          </div>
          <div class="uk-card-body">
            <div class="uk-margin-small-bottom">
              <span class="uk-text-muted"><?= lang('donation_points') ?>:</span>
              <span class="uk-text-bold uk-float-right"><?= number_format(user('dp')) ?> DP</span>
            </div>
            <a href="<?= site_url('donate/history') ?>" class="uk-button uk-button-secondary uk-button-small uk-width-1-1">
              <i class="fa-solid fa-history"></i> <?= lang('donate_view_history') ?>
            </a>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
