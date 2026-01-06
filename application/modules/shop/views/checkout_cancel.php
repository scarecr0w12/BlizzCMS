<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom">
      <ul class="uk-breadcrumb uk-margin-remove">
        <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
        <li><a href="<?= site_url('shop') ?>"><?= lang('shop') ?></a></li>
        <li><span><?= lang('shop_order_cancelled') ?></span></li>
      </ul>
    </div>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body uk-text-center uk-padding-large">
        <i class="fa-solid fa-circle-xmark fa-5x uk-text-warning"></i>
        <h2 class="uk-margin-top"><?= lang('shop_order_cancelled') ?></h2>
        <p class="uk-text-muted uk-text-large">
          <?= lang('shop_checkout_cancelled') ?>
        </p>

        <div class="uk-margin-top">
          <a href="<?= site_url('shop/cart') ?>" class="uk-button uk-button-primary uk-margin-small-right">
            <i class="fa-solid fa-cart-shopping"></i> <?= lang('shop_cart') ?>
          </a>
          <a href="<?= site_url('shop') ?>" class="uk-button uk-button-default">
            <i class="fa-solid fa-store"></i> <?= lang('shop_continue_shopping') ?>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
