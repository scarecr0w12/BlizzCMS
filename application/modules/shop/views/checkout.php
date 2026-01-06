<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom">
      <ul class="uk-breadcrumb uk-margin-remove">
        <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
        <li><a href="<?= site_url('shop') ?>"><?= lang('shop') ?></a></li>
        <li><a href="<?= site_url('shop/cart') ?>"><?= lang('shop_cart') ?></a></li>
        <li><span><?= lang('shop_checkout') ?></span></li>
      </ul>
      <h1 class="uk-h3 uk-text-bold uk-margin-remove">
        <i class="fa-solid fa-credit-card"></i> <?= lang('shop_checkout') ?>
      </h1>
    </div>

    <?= $template['partials']['alerts'] ?>

    <?php if (empty($cart_items)): ?>
    <div class="uk-card uk-card-default">
      <div class="uk-card-body uk-text-center uk-padding-large">
        <i class="fa-solid fa-cart-shopping fa-5x uk-text-muted"></i>
        <h3 class="uk-margin-top"><?= lang('shop_cart_empty') ?></h3>
        <a href="<?= site_url('shop') ?>" class="uk-button uk-button-primary">
          <i class="fa-solid fa-store"></i> <?= lang('shop_continue_shopping') ?>
        </a>
      </div>
    </div>
    <?php else: ?>

    <?= form_open(site_url('shop/checkout')) ?>
    <div uk-grid>
      <div class="uk-width-2-3@m">
        <!-- Order Items -->
        <div class="uk-card uk-card-default uk-margin-bottom">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-box"></i> <?= lang('shop_order_items') ?></h3>
          </div>
          <div class="uk-card-body uk-padding-remove">
            <table class="uk-table uk-table-middle uk-table-divider uk-margin-remove">
              <thead>
                <tr>
                  <th><?= lang('product') ?></th>
                  <th class="uk-text-center"><?= lang('shop_quantity') ?></th>
                  <th class="uk-text-right"><?= lang('shop_price') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($cart_items as $item): ?>
                <tr>
                  <td>
                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                      <div class="uk-width-auto">
                        <?php if (! empty($item['options']['image'])): ?>
                        <img src="<?= base_url('uploads/shop/' . $item['options']['image']) ?>" width="40" height="40" alt="">
                        <?php else: ?>
                        <div class="uk-background-muted uk-text-center" style="width: 40px; height: 40px; line-height: 40px;">
                          <i class="fa-solid fa-box"></i>
                        </div>
                        <?php endif; ?>
                      </div>
                      <div class="uk-width-expand">
                        <strong><?= html_escape($item['name']) ?></strong>
                        <div class="uk-text-small uk-text-muted"><?= ucfirst($item['options']['product_type']) ?></div>
                      </div>
                    </div>
                  </td>
                  <td class="uk-text-center">x<?= $item['qty'] ?></td>
                  <td class="uk-text-right">
                    <?php if ($item['dp'] > 0): ?>
                    <span class="uk-label uk-label-warning"><?= number_format($item['dp'] * $item['qty']) ?> DP</span>
                    <?php endif; ?>
                    <?php if ($item['vp'] > 0): ?>
                    <span class="uk-label"><?= number_format($item['vp'] * $item['qty']) ?> VP</span>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Character Selection -->
        <div class="uk-card uk-card-default uk-margin-bottom">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-user"></i> <?= lang('shop_select_character') ?></h3>
          </div>
          <div class="uk-card-body">
            <p class="uk-text-muted"><?= lang('shop_character_delivery_note') ?></p>
            
            <div class="uk-margin">
              <label class="uk-form-label"><?= lang('shop_select_realm') ?></label>
              <select class="uk-select" name="realm_id" id="realm_select" required>
                <option value=""><?= lang('select_option') ?></option>
                <?php foreach ($realms as $realm): ?>
                <option value="<?= $realm->id ?>"><?= html_escape($realm->name) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="uk-margin">
              <label class="uk-form-label"><?= lang('shop_select_character') ?></label>
              <select class="uk-select" name="character_id" id="character_select" required>
                <option value=""><?= lang('select_option') ?></option>
              </select>
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

              <?php if ($paypal_enabled): ?>
              <div>
                <label class="uk-card uk-card-default uk-card-body uk-card-small uk-card-hover">
                  <input class="uk-radio" type="radio" name="payment_method" value="paypal" <?= ! $can_pay_with_points ? 'checked' : '' ?>>
                  <span class="uk-margin-small-left">
                    <i class="fa-brands fa-paypal"></i> PayPal
                  </span>
                </label>
              </div>
              <?php endif; ?>

              <?php if ($stripe_enabled): ?>
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
        <!-- Order Summary -->
        <div class="uk-card uk-card-default uk-card-primary">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-receipt"></i> <?= lang('shop_order_summary') ?></h3>
          </div>
          <div class="uk-card-body">
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span><?= lang('shop_items') ?>:</span>
              <span><?= count($cart_items) ?></span>
            </div>

            <?php if ($total_dp > 0): ?>
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span><?= lang('shop_price_dp') ?>:</span>
              <span class="uk-text-bold bc-dp-points"><?= number_format($total_dp) ?> DP</span>
            </div>
            <?php endif; ?>
            
            <?php if ($total_vp > 0): ?>
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span><?= lang('shop_price_vp') ?>:</span>
              <span class="uk-text-bold bc-vp-points"><?= number_format($total_vp) ?> VP</span>
            </div>
            <?php endif; ?>

            <hr>

            <div class="uk-flex uk-flex-between">
              <span class="uk-h4"><?= lang('shop_total') ?>:</span>
              <span></span>
            </div>
            <?php if ($total_dp > 0): ?>
            <div class="uk-flex uk-flex-between uk-margin-small-bottom">
              <span></span>
              <span class="uk-h5 bc-dp-points"><?= number_format($total_dp) ?> DP</span>
            </div>
            <?php endif; ?>
            <?php if ($total_vp > 0): ?>
            <div class="uk-flex uk-flex-between">
              <span></span>
              <span class="uk-h5 bc-vp-points"><?= number_format($total_vp) ?> VP</span>
            </div>
            <?php endif; ?>
          </div>
          <div class="uk-card-footer">
            <button type="submit" class="uk-button uk-button-primary uk-width-1-1 uk-button-large">
              <i class="fa-solid fa-lock"></i> <?= lang('shop_complete_order') ?>
            </button>
            <p class="uk-text-small uk-text-muted uk-text-center uk-margin-small-top">
              <i class="fa-solid fa-shield-halved"></i> <?= lang('shop_secure_checkout') ?>
            </p>
          </div>
        </div>

        <!-- Current Balance -->
        <div class="uk-card uk-card-default uk-margin-top">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-wallet"></i> <?= lang('shop_your_balance') ?></h3>
          </div>
          <div class="uk-card-body">
            <div class="uk-grid-small" uk-grid>
              <div class="uk-width-1-2">
                <div class="uk-text-center">
                  <div class="uk-text-large uk-text-bold bc-dp-points"><?= number_format($user->dp) ?></div>
                  <div class="uk-text-small uk-text-muted">DP</div>
                </div>
              </div>
              <div class="uk-width-1-2">
                <div class="uk-text-center">
                  <div class="uk-text-large uk-text-bold bc-vp-points"><?= number_format($user->vp) ?></div>
                  <div class="uk-text-small uk-text-muted">VP</div>
                </div>
              </div>
            </div>
            
            <?php
            $after_dp = $user->dp - $total_dp;
            $after_vp = $user->vp - $total_vp;
            ?>
            <?php if ($total_dp > 0 || $total_vp > 0): ?>
            <hr>
            <div class="uk-text-small uk-text-muted uk-text-center"><?= lang('shop_balance_after') ?>:</div>
            <div class="uk-grid-small" uk-grid>
              <div class="uk-width-1-2">
                <div class="uk-text-center">
                  <div class="uk-text-bold <?= $after_dp < 0 ? 'uk-text-danger' : '' ?>"><?= number_format($after_dp) ?></div>
                </div>
              </div>
              <div class="uk-width-1-2">
                <div class="uk-text-center">
                  <div class="uk-text-bold <?= $after_vp < 0 ? 'uk-text-danger' : '' ?>"><?= number_format($after_vp) ?></div>
                </div>
              </div>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <?= form_close() ?>
    <?php endif; ?>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const realmSelect = document.getElementById('realm_select');
    const characterSelect = document.getElementById('character_select');
    
    if (realmSelect) {
        realmSelect.addEventListener('change', function() {
            const realmId = this.value;
            characterSelect.innerHTML = '<option value=""><?= lang('select_option') ?></option>';
            
            if (realmId) {
                fetch('<?= site_url('shop/checkout/characters/') ?>' + realmId)
                    .then(response => response.json())
                    .then(data => {
                        if (data.characters && data.characters.length > 0) {
                            data.characters.forEach(function(char) {
                                const option = document.createElement('option');
                                option.value = char.guid;
                                option.textContent = char.name + ' (Lv. ' + char.level + ')';
                                characterSelect.appendChild(option);
                            });
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    }
});
</script>
