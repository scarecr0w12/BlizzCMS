<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('donate') ?>"><?= lang('donate') ?></a></li>
          <li><span><?= lang('donate_history') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-history"></i> <?= lang('donate_history') ?>
        </h1>
      </div>
    </div>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body uk-padding-remove">
        <?php if (empty($logs)): ?>
        <div class="uk-padding uk-text-center">
          <i class="fa-solid fa-inbox fa-3x uk-text-muted"></i>
          <p class="uk-text-muted"><?= lang('donate_no_history') ?></p>
          <a href="<?= site_url('donate') ?>" class="uk-button uk-button-primary uk-button-small">
            <?= lang('donate_view_packages') ?>
          </a>
        </div>
        <?php else: ?>
        <div class="uk-overflow-auto">
          <table class="uk-table uk-table-middle uk-table-divider uk-table-striped uk-table-hover uk-margin-remove">
            <thead>
              <tr>
                <th><?= lang('donate_date') ?></th>
                <th><?= lang('donate_package') ?></th>
                <th><?= lang('donate_gateway') ?></th>
                <th class="uk-text-right"><?= lang('donate_amount') ?></th>
                <th class="uk-text-right"><?= lang('donate_points_awarded') ?></th>
                <th class="uk-text-center"><?= lang('donate_status') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($logs as $log): ?>
              <tr>
                <td>
                  <time datetime="<?= $log->created_at ?>"><?= locate_date($log->created_at) ?></time>
                </td>
                <td><?= html_escape($log->package_name ?? 'N/A') ?></td>
                <td class="uk-text-capitalize"><?= html_escape($log->gateway) ?></td>
                <td class="uk-text-right">
                  <?= $log->currency ?> <?= number_format($log->amount, 2) ?>
                </td>
                <td class="uk-text-right">
                  <?= number_format($log->dp_awarded) ?> DP
                </td>
                <td class="uk-text-center">
                  <?php
                  $status_class = [
                      'pending' => 'uk-label-warning',
                      'completed' => 'uk-label-success',
                      'failed' => 'uk-label-danger',
                      'refunded' => 'uk-label',
                      'cancelled' => 'uk-label'
                  ];
                  ?>
                  <span class="uk-label <?= $status_class[$log->status] ?? '' ?>">
                    <?= lang('donate_status_' . $log->status) ?>
                  </span>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <?php if ($total > $per_page): ?>
        <div class="uk-padding-small">
          <ul class="uk-pagination uk-flex-center uk-margin-remove">
            <?php $total_pages = ceil($total / $per_page); ?>
            <?php if ($current_page > 1): ?>
            <li><a href="<?= site_url('donate/history?page=' . ($current_page - 1)) ?>"><span uk-pagination-previous></span></a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="<?= $i == $current_page ? 'uk-active' : '' ?>">
              <a href="<?= site_url('donate/history?page=' . $i) ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
            <?php if ($current_page < $total_pages): ?>
            <li><a href="<?= site_url('donate/history?page=' . ($current_page + 1)) ?>"><span uk-pagination-next></span></a></li>
            <?php endif; ?>
          </ul>
        </div>
        <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
