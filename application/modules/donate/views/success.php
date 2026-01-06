<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container uk-container-small">
    <div class="uk-text-center uk-margin-large-top uk-margin-large-bottom">
      <i class="fa-solid fa-check-circle fa-5x uk-text-success"></i>
      <h1 class="uk-h2 uk-text-bold uk-margin-top"><?= lang('donate_success_title') ?></h1>
      <p class="uk-text-lead"><?= $message ?? lang('donate_success') ?></p>

      <?php if (is_logged_in()): ?>
      <div class="uk-card uk-card-default uk-card-body uk-margin-top">
        <div class="uk-grid-small uk-flex-center" uk-grid>
          <div class="uk-width-auto">
            <div class="uk-text-muted"><?= lang('donation_points') ?></div>
            <div class="uk-text-large uk-text-bold uk-text-primary"><?= number_format(user('dp')) ?> DP</div>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <div class="uk-margin-top">
        <a href="<?= site_url('donate') ?>" class="uk-button uk-button-primary">
          <i class="fa-solid fa-gift"></i> <?= lang('donate_view_packages') ?>
        </a>
        <a href="<?= site_url('donate/history') ?>" class="uk-button uk-button-secondary">
          <i class="fa-solid fa-history"></i> <?= lang('donate_view_history') ?>
        </a>
      </div>
    </div>
  </div>
</section>
