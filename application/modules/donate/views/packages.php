<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('donate') ?>"><?= lang('donate') ?></a></li>
          <li><span><?= lang('donate_packages') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-box"></i> <?= lang('donate_all_packages') ?>
        </h1>
      </div>
    </div>

    <?php if (empty($packages)): ?>
    <div class="uk-card uk-card-default uk-card-body uk-text-center">
      <i class="fa-solid fa-box-open fa-3x uk-text-muted"></i>
      <p class="uk-text-muted"><?= lang('donate_no_packages') ?></p>
    </div>
    <?php else: ?>
    <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l" uk-grid>
      <?php foreach ($packages as $package): ?>
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
            <span class="uk-badge uk-badge-success">+<?= number_format($package->bonus_dp) ?></span>
            <?php endif; ?>
          </div>
          <?php if (!empty($package->description)): ?>
          <p class="uk-text-small uk-text-muted uk-margin-small"><?= character_limiter($package->description, 80) ?></p>
          <?php endif; ?>
          <a href="<?= site_url('donate/package/' . $package->id) ?>" class="uk-button uk-button-primary uk-button-small uk-width-1-1">
            <?= lang('donate_buy_now') ?>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($total > $per_page): ?>
    <div class="uk-margin-top">
      <ul class="uk-pagination uk-flex-center">
        <?php $total_pages = ceil($total / $per_page); ?>
        <?php if ($current_page > 1): ?>
        <li><a href="<?= site_url('donate/packages?page=' . ($current_page - 1)) ?>"><span uk-pagination-previous></span></a></li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <li class="<?= $i == $current_page ? 'uk-active' : '' ?>">
          <a href="<?= site_url('donate/packages?page=' . $i) ?>"><?= $i ?></a>
        </li>
        <?php endfor; ?>
        <?php if ($current_page < $total_pages): ?>
        <li><a href="<?= site_url('donate/packages?page=' . ($current_page + 1)) ?>"><span uk-pagination-next></span></a></li>
        <?php endif; ?>
      </ul>
    </div>
    <?php endif; ?>
    <?php endif; ?>
  </div>
</section>
