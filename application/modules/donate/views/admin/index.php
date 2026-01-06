<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_panel') ?></a></li>
          <li><span><?= lang('donate') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('donate_admin') ?></h1>
      </div>
      <div class="uk-width-auto"></div>
    </div>

    <?= $this->load->view('static/alerts') ?>

    <!-- Statistics -->
    <div class="uk-grid-small uk-child-width-1-4@m uk-child-width-1-2@s" uk-grid>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <i class="fa-solid fa-dollar-sign fa-2x uk-text-primary"></i>
            </div>
            <div class="uk-width-expand">
              <div class="uk-text-small uk-text-muted"><?= lang('donate_total_donations') ?></div>
              <div class="uk-text-large uk-text-bold">$<?= number_format($statistics->total_amount, 2) ?></div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <i class="fa-solid fa-coins fa-2x uk-text-warning"></i>
            </div>
            <div class="uk-width-expand">
              <div class="uk-text-small uk-text-muted"><?= lang('donate_total_dp_awarded') ?></div>
              <div class="uk-text-large uk-text-bold"><?= number_format($statistics->total_dp) ?> DP</div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <i class="fa-solid fa-calendar fa-2x uk-text-success"></i>
            </div>
            <div class="uk-width-expand">
              <div class="uk-text-small uk-text-muted"><?= lang('donate_this_month') ?></div>
              <div class="uk-text-large uk-text-bold">$<?= number_format($statistics->month_amount, 2) ?></div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <i class="fa-solid fa-check-circle fa-2x uk-text-success"></i>
            </div>
            <div class="uk-width-expand">
              <div class="uk-text-small uk-text-muted"><?= lang('donate_completed_donations') ?></div>
              <div class="uk-text-large uk-text-bold"><?= number_format($statistics->completed_count) ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="uk-grid-small uk-margin-top" uk-grid>
      <!-- Quick Actions -->
      <div class="uk-width-1-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><?= lang('actions') ?></h3>
          </div>
          <div class="uk-card-body">
            <ul class="uk-list">
              <li>
                <a href="<?= site_url('donate/admin/packages') ?>" class="uk-button uk-button-secondary uk-button-small uk-width-1-1 uk-margin-small-bottom">
                  <i class="fa-solid fa-box"></i> <?= lang('donate_packages') ?>
                </a>
              </li>
              <li>
                <a href="<?= site_url('donate/admin/gateways') ?>" class="uk-button uk-button-secondary uk-button-small uk-width-1-1 uk-margin-small-bottom">
                  <i class="fa-solid fa-credit-card"></i> <?= lang('donate_gateways') ?>
                </a>
              </li>
              <li>
                <a href="<?= site_url('donate/admin/logs') ?>" class="uk-button uk-button-secondary uk-button-small uk-width-1-1 uk-margin-small-bottom">
                  <i class="fa-solid fa-list"></i> <?= lang('donate_logs') ?>
                </a>
              </li>
              <li>
                <a href="<?= site_url('donate/admin/settings') ?>" class="uk-button uk-button-secondary uk-button-small uk-width-1-1">
                  <i class="fa-solid fa-cog"></i> <?= lang('settings') ?>
                </a>
              </li>
            </ul>
          </div>
        </div>

        <!-- Payment Gateways Status -->
        <div class="uk-card uk-card-default uk-margin-top">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><?= lang('donate_gateways') ?></h3>
          </div>
          <div class="uk-card-body uk-padding-remove">
            <ul class="uk-list uk-list-divider uk-margin-remove">
              <?php foreach ($gateways as $gateway): ?>
              <li class="uk-padding-small">
                <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
                  <div class="uk-width-auto">
                    <i class="<?= $gateway->icon ?> fa-lg"></i>
                  </div>
                  <div class="uk-width-expand">
                    <?= html_escape($gateway->display_name) ?>
                  </div>
                  <div class="uk-width-auto">
                    <?php if ($gateway->is_active): ?>
                    <span class="uk-label uk-label-success"><?= lang('active') ?></span>
                    <?php else: ?>
                    <span class="uk-label uk-label-danger"><?= lang('inactive') ?></span>
                    <?php endif; ?>
                  </div>
                </div>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>

      <!-- Recent Donations -->
      <div class="uk-width-2-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><?= lang('donate_recent_donations') ?></h3>
          </div>
          <div class="uk-card-body uk-padding-remove">
            <?php if (empty($recent_logs)): ?>
            <div class="uk-padding uk-text-center">
              <p class="uk-text-muted">No donations yet.</p>
            </div>
            <?php else: ?>
            <div class="uk-overflow-auto">
              <table class="uk-table uk-table-small uk-table-middle uk-table-divider uk-table-striped uk-margin-remove">
                <thead>
                  <tr>
                    <th><?= lang('user') ?></th>
                    <th><?= lang('donate_package') ?></th>
                    <th class="uk-text-right"><?= lang('donate_amount') ?></th>
                    <th class="uk-text-center"><?= lang('status') ?></th>
                    <th><?= lang('date') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($recent_logs as $log): ?>
                  <tr>
                    <td><?= html_escape($log->nickname ?? $log->username ?? 'Unknown') ?></td>
                    <td><?= html_escape($log->package_name ?? 'N/A') ?></td>
                    <td class="uk-text-right"><?= $log->currency ?> <?= number_format($log->amount, 2) ?></td>
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
                    <td><time datetime="<?= $log->created_at ?>"><?= locate_date($log->created_at, 'M d, Y') ?></time></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <?php endif; ?>
          </div>
          <div class="uk-card-footer">
            <a href="<?= site_url('donate/admin/logs') ?>" class="uk-button uk-button-text">
              <?= lang('view') ?> <?= lang('donate_logs') ?> <i class="fa-solid fa-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
