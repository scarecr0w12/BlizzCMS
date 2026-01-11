<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_panel') ?></a></li>
          <li><a href="<?= site_url('vote/admin') ?>"><?= lang('vote') ?></a></li>
          <li><span><?= lang('vote_logs') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-history"></i> <?= lang('vote_logs') ?>
        </h1>
      </div>
    </div>

    <!-- Filters -->
    <div class="uk-card uk-card-default uk-margin-bottom">
      <div class="uk-card-body uk-padding-small">
        <?= form_open('vote/admin/logs', ['method' => 'get', 'class' => 'uk-form-horizontal']) ?>
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <label class="uk-form-label"><?= lang('filter') ?>:</label>
            </div>
            <div class="uk-width-auto">
              <select class="uk-select" name="site_id">
                <option value=""><?= lang('vote_all_sites') ?></option>
                <?php foreach ($sites as $site): ?>
                <option value="<?= $site->id ?>" <?= (isset($filters['site_id']) && $filters['site_id'] == $site->id) ? 'selected' : '' ?>><?= html_escape($site->name) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="uk-width-auto">
              <input class="uk-input" type="text" name="search" value="<?= html_escape($filters['search'] ?? '') ?>" placeholder="<?= lang('search') ?>">
            </div>
            <div class="uk-width-auto">
              <button type="submit" class="uk-button uk-button-primary uk-button-small">
                <i class="fa-solid fa-search"></i> <?= lang('filter') ?>
              </button>
              <a href="<?= site_url('vote/admin/logs') ?>" class="uk-button uk-button-default uk-button-small">
                <i class="fa-solid fa-times"></i> <?= lang('clear') ?>
              </a>
            </div>
          </div>
        <?= form_close() ?>
      </div>
    </div>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body uk-padding-remove">
        <?php if (empty($logs)): ?>
        <div class="uk-padding uk-text-center">
          <i class="fa-solid fa-inbox fa-3x uk-text-muted"></i>
          <p class="uk-text-muted"><?= lang('vote_no_logs') ?></p>
        </div>
        <?php else: ?>
        <div class="uk-overflow-auto">
          <table class="uk-table uk-table-middle uk-table-divider uk-table-striped uk-margin-remove">
            <thead>
              <tr>
                <th class="uk-table-shrink"><?= lang('id') ?></th>
                <th><?= lang('user') ?></th>
                <th><?= lang('vote_site_name') ?></th>
                <th class="uk-text-center"><?= lang('vote_vp_reward') ?></th>
                <th><?= lang('ip_address') ?></th>
                <th class="uk-text-right"><?= lang('date') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($logs as $log): ?>
              <tr>
                <td><?= $log->id ?></td>
                <td>
                  <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
                    <div class="uk-width-auto">
                      <img class="uk-border-circle" src="<?= user_avatar($log->user_id) ?>" width="32" height="32" alt="">
                    </div>
                    <div class="uk-width-expand">
                      <div><?= html_escape($log->nickname ?? 'Unknown') ?></div>
                      <div class="uk-text-small uk-text-muted">ID: <?= $log->user_id ?></div>
                    </div>
                  </div>
                </td>
                <td><?= html_escape($log->site_name ?? 'N/A') ?></td>
                <td class="uk-text-center">
                  <span class="uk-label uk-label-success">+<?= number_format($log->vp_awarded) ?> VP</span>
                </td>
                <td>
                  <code><?= html_escape($log->ip_address) ?></code>
                </td>
                <td class="uk-text-right uk-text-meta">
                  <time datetime="<?= $log->created_at ?>"><?= locate_date($log->created_at) ?></time>
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
            <?php 
            $query_params = [];
            if (!empty($filters['site_id'])) $query_params['site_id'] = $filters['site_id'];
            if (!empty($filters['search'])) $query_params['search'] = $filters['search'];
            ?>
            <?php if ($current_page > 1): ?>
            <li><a href="<?= site_url('vote/admin/logs?' . http_build_query(array_merge($query_params, ['page' => $current_page - 1]))) ?>"><span uk-pagination-previous></span></a></li>
            <?php endif; ?>
            <?php for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++): ?>
            <li class="<?= $i == $current_page ? 'uk-active' : '' ?>">
              <a href="<?= site_url('vote/admin/logs?' . http_build_query(array_merge($query_params, ['page' => $i]))) ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
            <?php if ($current_page < $total_pages): ?>
            <li><a href="<?= site_url('vote/admin/logs?' . http_build_query(array_merge($query_params, ['page' => $current_page + 1]))) ?>"><span uk-pagination-next></span></a></li>
            <?php endif; ?>
          </ul>
        </div>
        <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
