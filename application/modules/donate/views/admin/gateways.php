<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_panel') ?></a></li>
          <li><a href="<?= site_url('donate/admin') ?>"><?= lang('donate') ?></a></li>
          <li><span><?= lang('donate_gateways') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('donate_gateways') ?></h1>
      </div>
    </div>

    <?= $this->load->view('static/alerts') ?>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body uk-padding-remove">
        <div class="uk-overflow-auto">
          <table class="uk-table uk-table-middle uk-table-divider uk-table-striped uk-table-hover uk-margin-remove">
            <thead>
              <tr>
                <th><?= lang('name') ?></th>
                <th><?= lang('description') ?></th>
                <th class="uk-text-center"><?= lang('donate_sandbox_mode') ?></th>
                <th class="uk-text-center"><?= lang('status') ?></th>
                <th class="uk-text-center"><?= lang('actions') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($gateways as $gateway): ?>
              <tr>
                <td>
                  <i class="<?= $gateway->icon ?> fa-lg uk-margin-small-right"></i>
                  <strong><?= html_escape($gateway->display_name) ?></strong>
                </td>
                <td class="uk-text-muted"><?= html_escape($gateway->description) ?></td>
                <td class="uk-text-center">
                  <?php if ($gateway->is_sandbox): ?>
                  <span class="uk-label uk-label-warning">Sandbox</span>
                  <?php else: ?>
                  <span class="uk-label uk-label-success">Live</span>
                  <?php endif; ?>
                </td>
                <td class="uk-text-center">
                  <?php if ($gateway->is_active): ?>
                  <span class="uk-label uk-label-success"><?= lang('active') ?></span>
                  <?php else: ?>
                  <span class="uk-label uk-label-danger"><?= lang('inactive') ?></span>
                  <?php endif; ?>
                </td>
                <td class="uk-text-center">
                  <?php if (has_permission('edit.donate', 'donate')): ?>
                  <a href="<?= site_url('donate/admin/gateways/edit/' . $gateway->name) ?>" class="uk-button uk-button-primary uk-button-small">
                    <i class="fa-solid fa-cog"></i> <?= lang('configure') ?>
                  </a>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
