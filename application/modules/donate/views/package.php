<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('donate') ?>"><?= lang('donate') ?></a></li>
          <li><span><?= html_escape($package->name) ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-gift"></i> <?= html_escape($package->name) ?>
        </h1>
      </div>
    </div>

    <div uk-grid>
      <div class="uk-width-2-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><?= lang('donate_package_details') ?></h3>
          </div>
          <div class="uk-card-body">
            <div class="uk-grid-medium" uk-grid>
              <div class="uk-width-1-3@s uk-text-center">
                <?php if (!empty($package->image)): ?>
                <img src="<?= base_url('uploads/' . $package->image) ?>" alt="<?= html_escape($package->name) ?>" class="uk-margin-bottom" style="max-width: 150px;">
                <?php else: ?>
                <i class="fa-solid fa-gift fa-5x uk-text-primary uk-margin-bottom"></i>
                <?php endif; ?>
              </div>
              <div class="uk-width-2-3@s">
                <h2 class="uk-h4 uk-margin-remove-top"><?= html_escape($package->name) ?></h2>
                <?php if (!empty($package->description)): ?>
                <p class="uk-text-muted"><?= nl2br(html_escape($package->description)) ?></p>
                <?php endif; ?>

                <table class="uk-table uk-table-small uk-table-divider uk-margin-top">
                  <tbody>
                    <tr>
                      <td class="uk-width-1-2"><strong><?= lang('price') ?>:</strong></td>
                      <td class="uk-text-right uk-text-large uk-text-bold uk-text-primary">
                        <?= $package->currency ?> <?= number_format($package->price, 2) ?>
                      </td>
                    </tr>
                    <tr>
                      <td><strong><?= lang('donate_dp_amount') ?>:</strong></td>
                      <td class="uk-text-right"><?= number_format($package->dp_amount) ?> DP</td>
                    </tr>
                    <?php if ($package->bonus_dp > 0): ?>
                    <tr>
                      <td><strong><?= lang('donate_bonus_dp') ?>:</strong></td>
                      <td class="uk-text-right uk-text-success">+<?= number_format($package->bonus_dp) ?> DP</td>
                    </tr>
                    <?php endif; ?>
                    <tr class="uk-background-muted">
                      <td><strong><?= lang('donate_total_dp') ?>:</strong></td>
                      <td class="uk-text-right uk-text-bold uk-text-large">
                        <?= number_format($package->dp_amount + $package->bonus_dp) ?> DP
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="uk-width-1-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-credit-card"></i> <?= lang('donate_select_gateway') ?></h3>
          </div>
          <div class="uk-card-body">
            <?php if (!is_logged_in()): ?>
            <div class="uk-alert uk-alert-warning">
              <p><i class="fa-solid fa-exclamation-triangle"></i> Please <a href="<?= site_url('login') ?>">log in</a> to make a donation.</p>
            </div>
            <?php elseif (empty($gateways)): ?>
            <div class="uk-alert uk-alert-warning">
              <p><i class="fa-solid fa-exclamation-triangle"></i> <?= lang('donate_no_gateways') ?></p>
            </div>
            <?php else: ?>
            <form action="<?= site_url('donate/process/' . $package->id) ?>" method="post">
              <?= csrf_field() ?>
              <div class="uk-margin">
                <?php foreach ($gateways as $gateway): ?>
                <label class="uk-display-block uk-margin-small-bottom">
                  <input class="uk-radio" type="radio" name="gateway" value="<?= $gateway->name ?>" <?= ($gateway === reset($gateways)) ? 'checked' : '' ?>>
                  <i class="<?= $gateway->icon ?>"></i>
                  <?= html_escape($gateway->display_name) ?>
                  <?php if (!empty($gateway->description)): ?>
                  <div class="uk-text-small uk-text-muted uk-margin-small-left" style="margin-left: 24px;">
                    <?= html_escape($gateway->description) ?>
                  </div>
                  <?php endif; ?>
                </label>
                <?php endforeach; ?>
              </div>

              <div class="uk-margin-top">
                <div class="uk-text-center uk-margin-bottom">
                  <div class="uk-text-muted"><?= lang('total') ?></div>
                  <div class="uk-text-large uk-text-bold uk-text-primary">
                    <?= $package->currency ?> <?= number_format($package->price, 2) ?>
                  </div>
                </div>
                <button type="submit" class="uk-button uk-button-primary uk-width-1-1">
                  <i class="fa-solid fa-shopping-cart"></i> <?= lang('donate_buy_now') ?>
                </button>
              </div>
            </form>
            <?php endif; ?>
          </div>
        </div>

        <div class="uk-margin-top">
          <a href="<?= site_url('donate') ?>" class="uk-button uk-button-text">
            <i class="fa-solid fa-arrow-left"></i> <?= lang('donate_back_to_packages') ?>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
