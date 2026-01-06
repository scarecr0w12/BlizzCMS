<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_panel') ?></a></li>
          <li><a href="<?= site_url('donate/admin') ?>"><?= lang('donate') ?></a></li>
          <li><span><?= lang('donate_logs') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('donate_logs') ?></h1>
      </div>
    </div>

    <?= $this->load->view('static/alerts') ?>

    <!-- Filters -->
    <div class="uk-card uk-card-default uk-margin-bottom">
      <div class="uk-card-body">
        <form method="get" class="uk-form-horizontal">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-1-4@s">
              <select class="uk-select" name="status">
                <option value=""><?= lang('status') ?> - All</option>
                <option value="pending" <?= ($filters['status'] ?? '') == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="completed" <?= ($filters['status'] ?? '') == 'completed' ? 'selected' : '' ?>>Completed</option>
                <option value="failed" <?= ($filters['status'] ?? '') == 'failed' ? 'selected' : '' ?>>Failed</option>
                <option value="refunded" <?= ($filters['status'] ?? '') == 'refunded' ? 'selected' : '' ?>>Refunded</option>
                <option value="cancelled" <?= ($filters['status'] ?? '') == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
              </select>
            </div>
            <div class="uk-width-1-4@s">
              <select class="uk-select" name="gateway">
                <option value=""><?= lang('donate_gateway') ?> - All</option>
                <?php foreach ($gateways as $gateway): ?>
                <option value="<?= $gateway->name ?>" <?= ($filters['gateway'] ?? '') == $gateway->name ? 'selected' : '' ?>>
                  <?= html_escape($gateway->display_name) ?>
                </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="uk-width-expand@s">
              <input class="uk-input" type="text" name="search" value="<?= html_escape($filters['search'] ?? '') ?>" placeholder="<?= lang('search') ?>...">
            </div>
            <div class="uk-width-auto">
              <button type="submit" class="uk-button uk-button-primary uk-button-small">
                <i class="fa-solid fa-filter"></i> <?= lang('filter') ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body uk-padding-remove">
        <?php if (empty($logs)): ?>
        <div class="uk-padding uk-text-center">
          <i class="fa-solid fa-inbox fa-3x uk-text-muted"></i>
          <p class="uk-text-muted">No donation logs found.</p>
        </div>
        <?php else: ?>
        <div class="uk-overflow-auto">
          <table class="uk-table uk-table-small uk-table-middle uk-table-divider uk-table-striped uk-table-hover uk-margin-remove">
            <thead>
              <tr>
                <th class="uk-table-shrink"><?= lang('id') ?></th>
                <th><?= lang('user') ?></th>
                <th><?= lang('donate_package') ?></th>
                <th><?= lang('donate_gateway') ?></th>
                <th class="uk-text-right"><?= lang('donate_amount') ?></th>
                <th class="uk-text-right"><?= lang('dp') ?></th>
                <th class="uk-text-center"><?= lang('status') ?></th>
                <th><?= lang('date') ?></th>
                <th class="uk-text-center"><?= lang('actions') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($logs as $log): ?>
              <tr>
                <td><?= $log->id ?></td>
                <td><?= html_escape($log->nickname ?? $log->username ?? 'Unknown') ?></td>
                <td><?= html_escape($log->package_name ?? 'N/A') ?></td>
                <td class="uk-text-capitalize"><?= html_escape($log->gateway) ?></td>
                <td class="uk-text-right"><?= $log->currency ?> <?= number_format($log->amount, 2) ?></td>
                <td class="uk-text-right"><?= number_format($log->dp_awarded) ?></td>
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
                  <span class="uk-label <?= $status_class[$log->status] ?? '' ?>"><?= $log->status ?></span>
                </td>
                <td><time datetime="<?= $log->created_at ?>"><?= locate_date($log->created_at, 'M d, Y H:i') ?></time></td>
                <td class="uk-text-center">
                  <a href="<?= site_url('donate/admin/logs/' . $log->id) ?>" class="uk-button uk-button-default uk-button-small">
                    <i class="fa-solid fa-eye"></i>
                  </a>
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
            $query_params = array_filter($filters);
            ?>
            <?php if ($current_page > 1): ?>
            <li><a href="<?= site_url('donate/admin/logs?' . http_build_query(array_merge($query_params, ['page' => $current_page - 1]))) ?>"><span uk-pagination-previous></span></a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="<?= $i == $current_page ? 'uk-active' : '' ?>">
              <a href="<?= site_url('donate/admin/logs?' . http_build_query(array_merge($query_params, ['page' => $i]))) ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
            <?php if ($current_page < $total_pages): ?>
            <li><a href="<?= site_url('donate/admin/logs?' . http_build_query(array_merge($query_params, ['page' => $current_page + 1]))) ?>"><span uk-pagination-next></span></a></li>
            <?php endif; ?>
          </ul>
        </div>
        <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
