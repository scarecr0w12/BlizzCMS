<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_panel') ?></a></li>
          <li><a href="<?= site_url('donate/admin') ?>"><?= lang('donate') ?></a></li>
          <li><span><?= lang('donate_packages') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('donate_packages') ?></h1>
      </div>
      <div class="uk-width-auto">
        <?php if (has_permission('add.donate', 'donate')): ?>
        <a href="<?= site_url('donate/admin/packages/add') ?>" class="uk-button uk-button-primary uk-button-small">
          <i class="fa-solid fa-plus"></i> <?= lang('donate_add_package') ?>
        </a>
        <?php endif; ?>
      </div>
    </div>

    <?= $this->load->view('static/alerts') ?>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body uk-padding-remove">
        <?php if (empty($packages)): ?>
        <div class="uk-padding uk-text-center">
          <i class="fa-solid fa-box-open fa-3x uk-text-muted"></i>
          <p class="uk-text-muted"><?= lang('donate_no_packages') ?></p>
        </div>
        <?php else: ?>
        <div class="uk-overflow-auto">
          <table class="uk-table uk-table-middle uk-table-divider uk-table-striped uk-table-hover uk-margin-remove">
            <thead>
              <tr>
                <th class="uk-table-shrink"><?= lang('id') ?></th>
                <th><?= lang('name') ?></th>
                <th class="uk-text-right"><?= lang('price') ?></th>
                <th class="uk-text-right"><?= lang('donate_dp_amount') ?></th>
                <th class="uk-text-right"><?= lang('donate_bonus_dp') ?></th>
                <th class="uk-text-center"><?= lang('featured') ?></th>
                <th class="uk-text-center"><?= lang('status') ?></th>
                <th class="uk-text-center"><?= lang('actions') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($packages as $package): ?>
              <tr>
                <td><?= $package->id ?></td>
                <td><strong><?= html_escape($package->name) ?></strong></td>
                <td class="uk-text-right"><?= $package->currency ?> <?= number_format($package->price, 2) ?></td>
                <td class="uk-text-right"><?= number_format($package->dp_amount) ?></td>
                <td class="uk-text-right"><?= number_format($package->bonus_dp) ?></td>
                <td class="uk-text-center">
                  <?php if ($package->featured): ?>
                  <i class="fa-solid fa-star uk-text-warning"></i>
                  <?php else: ?>
                  <i class="fa-regular fa-star uk-text-muted"></i>
                  <?php endif; ?>
                </td>
                <td class="uk-text-center">
                  <?php if ($package->is_active): ?>
                  <span class="uk-label uk-label-success"><?= lang('active') ?></span>
                  <?php else: ?>
                  <span class="uk-label uk-label-danger"><?= lang('inactive') ?></span>
                  <?php endif; ?>
                </td>
                <td class="uk-text-center">
                  <?php if (has_permission('edit.donate', 'donate')): ?>
                  <a href="<?= site_url('donate/admin/packages/edit/' . $package->id) ?>" class="uk-button uk-button-primary uk-button-small">
                    <i class="fa-solid fa-edit"></i>
                  </a>
                  <?php endif; ?>
                  <?php if (has_permission('delete.donate', 'donate')): ?>
                  <button type="button" class="uk-button uk-button-danger uk-button-small" uk-toggle="target: #delete-modal-<?= $package->id ?>">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                  <div id="delete-modal-<?= $package->id ?>" uk-modal>
                    <div class="uk-modal-dialog uk-modal-body">
                      <h2 class="uk-modal-title"><?= lang('donate_delete_package') ?></h2>
                      <p><?= lang('donate_confirm_delete_package') ?></p>
                      <p class="uk-text-right">
                        <button class="uk-button uk-button-default uk-modal-close" type="button"><?= lang('cancel') ?></button>
                        <?= form_open('donate/admin/packages/delete/' . $package->id, ['class' => 'uk-display-inline']) ?>
                          <button type="submit" class="uk-button uk-button-danger"><?= lang('delete') ?></button>
                        <?= form_close() ?>
                      </p>
                    </div>
                  </div>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
