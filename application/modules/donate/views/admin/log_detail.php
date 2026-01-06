<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_panel') ?></a></li>
          <li><a href="<?= site_url('donate/admin') ?>"><?= lang('donate') ?></a></li>
          <li><a href="<?= site_url('donate/admin/logs') ?>"><?= lang('donate_logs') ?></a></li>
          <li><span>#<?= $log->id ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('details') ?> #<?= $log->id ?></h1>
      </div>
    </div>

    <div class="uk-grid-small" uk-grid>
      <div class="uk-width-2-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><?= lang('donate_transaction_id') ?>: <?= html_escape($log->transaction_id ?? 'N/A') ?></h3>
          </div>
          <div class="uk-card-body">
            <table class="uk-table uk-table-divider">
              <tbody>
                <tr>
                  <td class="uk-width-1-3"><strong><?= lang('id') ?>:</strong></td>
                  <td><?= $log->id ?></td>
                </tr>
                <tr>
                  <td><strong><?= lang('user') ?>:</strong></td>
                  <td>
                    <?php if ($user): ?>
                    <a href="<?= site_url('admin/users/' . $user->id) ?>">
                      <?= html_escape($user->nickname ?? $user->username) ?>
                    </a>
                    <?php else: ?>
                    User ID: <?= $log->user_id ?>
                    <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <td><strong><?= lang('donate_package') ?>:</strong></td>
                  <td><?= html_escape($package->name ?? 'N/A') ?></td>
                </tr>
                <tr>
                  <td><strong><?= lang('donate_gateway') ?>:</strong></td>
                  <td class="uk-text-capitalize"><?= html_escape($log->gateway) ?></td>
                </tr>
                <tr>
                  <td><strong><?= lang('donate_amount') ?>:</strong></td>
                  <td class="uk-text-bold"><?= $log->currency ?> <?= number_format($log->amount, 2) ?></td>
                </tr>
                <tr>
                  <td><strong><?= lang('donate_points_awarded') ?>:</strong></td>
                  <td><?= number_format($log->dp_awarded) ?> DP</td>
                </tr>
                <tr>
                  <td><strong><?= lang('status') ?>:</strong></td>
                  <td>
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
                </tr>
                <tr>
                  <td><strong><?= lang('ip') ?>:</strong></td>
                  <td><?= html_escape($log->ip_address ?? 'N/A') ?></td>
                </tr>
                <tr>
                  <td><strong><?= lang('created_at') ?>:</strong></td>
                  <td><time datetime="<?= $log->created_at ?>"><?= locate_date($log->created_at) ?></time></td>
                </tr>
                <?php if ($log->updated_at): ?>
                <tr>
                  <td><strong><?= lang('updated_at') ?>:</strong></td>
                  <td><time datetime="<?= $log->updated_at ?>"><?= locate_date($log->updated_at) ?></time></td>
                </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Gateway Response -->
        <?php if (!empty($log->gateway_response)): ?>
        <div class="uk-card uk-card-default uk-margin-top">
          <div class="uk-card-header">
            <h3 class="uk-card-title">Gateway Response</h3>
          </div>
          <div class="uk-card-body">
            <pre class="uk-background-muted uk-padding-small" style="overflow-x: auto; white-space: pre-wrap; word-wrap: break-word;"><?= html_escape($log->gateway_response) ?></pre>
          </div>
        </div>
        <?php endif; ?>
      </div>

      <div class="uk-width-1-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><?= lang('actions') ?></h3>
          </div>
          <div class="uk-card-body">
            <a href="<?= site_url('donate/admin/logs') ?>" class="uk-button uk-button-default uk-width-1-1">
              <i class="fa-solid fa-arrow-left"></i> <?= lang('back') ?>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
