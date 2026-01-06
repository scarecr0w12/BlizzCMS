<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('donate') ?>"><?= lang('donate') ?></a></li>
          <li><span><?= lang('donate_top_donators') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-trophy"></i> <?= lang('donate_top_donators') ?>
        </h1>
      </div>
    </div>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body uk-padding-remove">
        <?php if (empty($donators)): ?>
        <div class="uk-padding uk-text-center">
          <i class="fa-solid fa-trophy fa-3x uk-text-muted"></i>
          <p class="uk-text-muted">No donations yet. Be the first!</p>
          <a href="<?= site_url('donate') ?>" class="uk-button uk-button-primary uk-button-small">
            <?= lang('donate_now') ?>
          </a>
        </div>
        <?php else: ?>
        <div class="uk-overflow-auto">
          <table class="uk-table uk-table-middle uk-table-divider uk-table-striped uk-table-hover uk-margin-remove">
            <thead>
              <tr>
                <th class="uk-text-center uk-table-shrink"><?= lang('donate_rank') ?></th>
                <th><?= lang('user') ?></th>
                <th class="uk-text-right"><?= lang('donate_total_donated') ?></th>
                <th class="uk-text-right"><?= lang('donate_donation_count') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php $rank = 1; foreach ($donators as $donator): ?>
              <tr>
                <td class="uk-text-center">
                  <?php if ($rank == 1): ?>
                  <span class="uk-badge" style="background-color: #FFD700;"><i class="fa-solid fa-crown"></i> 1</span>
                  <?php elseif ($rank == 2): ?>
                  <span class="uk-badge" style="background-color: #C0C0C0;"><i class="fa-solid fa-medal"></i> 2</span>
                  <?php elseif ($rank == 3): ?>
                  <span class="uk-badge" style="background-color: #CD7F32;"><i class="fa-solid fa-medal"></i> 3</span>
                  <?php else: ?>
                  <span class="uk-text-muted">#<?= $rank ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
                    <div class="uk-width-auto">
                      <img class="uk-border-circle" src="<?= user_avatar($donator->id) ?>" width="40" height="40" alt="">
                    </div>
                    <div class="uk-width-expand">
                      <div class="uk-text-bold"><?= html_escape($donator->nickname) ?></div>
                    </div>
                  </div>
                </td>
                <td class="uk-text-right uk-text-bold uk-text-primary">
                  $<?= number_format($donator->total_donated, 2) ?>
                </td>
                <td class="uk-text-right">
                  <?= number_format($donator->donation_count) ?>
                </td>
              </tr>
              <?php $rank++; endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
