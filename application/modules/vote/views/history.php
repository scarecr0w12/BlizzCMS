<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('vote') ?>"><?= lang('vote') ?></a></li>
          <li><span><?= lang('vote_history') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-history"></i> <?= lang('vote_history') ?>
        </h1>
      </div>
    </div>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body uk-padding-remove">
        <?php if (empty($logs)): ?>
        <div class="uk-padding uk-text-center">
          <i class="fa-solid fa-inbox fa-3x uk-text-muted"></i>
          <p class="uk-text-muted"><?= lang('vote_no_history') ?></p>
          <a href="<?= site_url('vote') ?>" class="uk-button uk-button-primary uk-button-small">
            <?= lang('vote_view_sites') ?>
          </a>
        </div>
        <?php else: ?>
        <div class="uk-overflow-auto">
          <table class="uk-table uk-table-middle uk-table-divider uk-table-striped uk-table-hover uk-margin-remove">
            <thead>
              <tr>
                <th><?= lang('vote_date') ?></th>
                <th><?= lang('vote_site_name') ?></th>
                <th class="uk-text-right"><?= lang('vote_points_awarded') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($logs as $log): ?>
              <tr>
                <td>
                  <time datetime="<?= $log->created_at ?>"><?= locate_date($log->created_at) ?></time>
                </td>
                <td><?= html_escape($log->site_name ?? 'N/A') ?></td>
                <td class="uk-text-right">
                  <span class="uk-label uk-label-success">+<?= number_format($log->vp_awarded) ?> VP</span>
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
            <li><a href="<?= site_url('vote/history?page=' . ($current_page - 1)) ?>"><span uk-pagination-previous></span></a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="<?= $i == $current_page ? 'uk-active' : '' ?>">
              <a href="<?= site_url('vote/history?page=' . $i) ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
            <?php if ($current_page < $total_pages): ?>
            <li><a href="<?= site_url('vote/history?page=' . ($current_page + 1)) ?>"><span uk-pagination-next></span></a></li>
            <?php endif; ?>
          </ul>
        </div>
        <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
