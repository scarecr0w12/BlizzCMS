<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('shop') ?>"><?= lang('shop') ?></a></li>
          <li><span><?= html_escape($service->name) ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="<?= ! empty($service->icon) ? $service->icon : 'fa-solid fa-wand-magic-sparkles' ?>"></i>
          <?= html_escape($service->name) ?>
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
            <div class="uk-text-center uk-margin-bottom">
              <i class="<?= ! empty($service->icon) ? $service->icon : 'fa-solid fa-wand-magic-sparkles' ?> fa-5x uk-text-primary"></i>
            </div>

            <h2 class="uk-h3 uk-text-center"><?= html_escape($service->name) ?></h2>
            
            <?php if (! empty($service->description)): ?>
            <p class="uk-text-muted uk-text-center"><?= nl2br(html_escape($service->description)) ?></p>
            <?php endif; ?>

            <hr>

            <div class="uk-h4 uk-text-center uk-margin">
              <?= lang('shop_price') ?>:
              <?php if ($service->price_dp > 0): ?>
              <span class="uk-label uk-label-warning uk-margin-small-right"><i class="fa-solid fa-coins"></i> <?= number_format($service->price_dp) ?> DP</span>
              <?php endif; ?>
              <?php if ($service->price_vp > 0): ?>
              <span class="uk-label uk-margin-small-right"><i class="fa-solid fa-check-to-slot"></i> <?= number_format($service->price_vp) ?> VP</span>
              <?php endif; ?>
              <?php if ($service->price_money > 0): ?>
              <span class="uk-label uk-label-success"><i class="fa-solid fa-dollar-sign"></i> <?= number_format($service->price_money, 2) ?> <?= $service->currency ?></span>
              <?php endif; ?>
            </div>

            <hr>

            <?= form_open(site_url('shop/cart/add')) ?>
              <input type="hidden" name="product_type" value="service">
              <input type="hidden" name="product_id" value="<?= $service->id ?>">
              
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
                <select class="uk-select" name="character_guid" id="character_select" required>
                  <option value=""><?= lang('select_option') ?></option>
                </select>
              </div>

              <div class="uk-margin uk-text-center">
                <button type="submit" class="uk-button uk-button-primary uk-button-large">
                  <i class="fa-solid fa-cart-plus"></i> <?= lang('shop_add_to_cart') ?>
                </button>
              </div>
            <?= form_close() ?>
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
            <h3 class="uk-card-title"><i class="fa-solid fa-info-circle"></i> <?= lang('shop_service_info') ?></h3>
          </div>
          <div class="uk-card-body">
            <ul class="uk-list uk-list-bullet">
              <li><?= lang('shop_service_requires_character') ?></li>
              <li><?= lang('shop_service_instant_delivery') ?></li>
              <li><?= lang('shop_service_non_refundable') ?></li>
            </ul>
          </div>
        </div>

        <!-- Other Services -->
        <?php if (! empty($other_services)): ?>
        <div class="uk-card uk-card-default uk-margin-top">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-wand-magic-sparkles"></i> <?= lang('shop_other_services') ?></h3>
          </div>
          <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
            <?php foreach ($other_services as $other): ?>
            <li class="<?= $other->id == $service->id ? 'uk-active' : '' ?>">
              <a href="<?= site_url('shop/service/' . $other->id) ?>">
                <?php if (! empty($other->icon)): ?>
                <span class="uk-margin-small-right"><i class="<?= $other->icon ?>"></i></span>
                <?php endif; ?>
                <?= html_escape($other->name) ?>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>
      </div>
    </div>
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
