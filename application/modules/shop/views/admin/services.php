<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container uk-container-expand">
    <div class="uk-flex uk-flex-between uk-flex-wrap uk-margin">
      <div>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-wand-magic-sparkles"></i> <?= lang('admin_shop_services') ?>
        </h1>
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_dashboard') ?></a></li>
          <li><a href="<?= site_url('shop/admin') ?>"><?= lang('admin_shop') ?></a></li>
          <li><span><?= lang('admin_shop_services') ?></span></li>
        </ul>
      </div>
      <div>
        <a href="<?= site_url('shop/admin/services/add') ?>" class="uk-button uk-button-primary">
          <i class="fa-solid fa-plus"></i> <?= lang('add') ?>
        </a>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <div class="uk-card uk-card-default">
      <?php if (empty($services)): ?>
      <div class="uk-card-body uk-text-center uk-padding-large">
        <i class="fa-solid fa-wand-magic-sparkles fa-5x uk-text-muted"></i>
        <h3 class="uk-margin-top"><?= lang('no_data') ?></h3>
        <a href="<?= site_url('shop/admin/services/add') ?>" class="uk-button uk-button-primary">
          <i class="fa-solid fa-plus"></i> <?= lang('shop_add_service') ?>
        </a>
      </div>
      <?php else: ?>
      <div class="uk-card-body uk-padding-remove">
        <table class="uk-table uk-table-middle uk-table-divider uk-table-hover uk-margin-remove">
          <thead>
            <tr>
              <th class="uk-table-shrink"><?= lang('id') ?></th>
              <th><?= lang('name') ?></th>
              <th><?= lang('type') ?></th>
              <th class="uk-text-center"><?= lang('shop_price') ?></th>
              <th class="uk-text-center"><?= lang('status') ?></th>
              <th class="uk-text-center uk-table-shrink"><?= lang('actions') ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($services as $service): ?>
            <tr>
              <td><?= $service->id ?></td>
              <td>
                <?php if (! empty($service->icon)): ?>
                <i class="<?= $service->icon ?> uk-margin-small-right"></i>
                <?php endif; ?>
                <strong><?= html_escape($service->name) ?></strong>
              </td>
              <td><span class="uk-label"><?= $service->type ?></span></td>
              <td class="uk-text-center">
                <?php if ($service->price_dp > 0): ?>
                <span class="uk-label uk-label-warning"><?= number_format($service->price_dp) ?> DP</span>
                <?php endif; ?>
                <?php if ($service->price_vp > 0): ?>
                <span class="uk-label"><?= number_format($service->price_vp) ?> VP</span>
                <?php endif; ?>
                <?php if ($service->price_money > 0): ?>
                <span class="uk-label uk-label-success">$<?= number_format($service->price_money, 2) ?></span>
                <?php endif; ?>
              </td>
              <td class="uk-text-center">
                <?php if ($service->is_active): ?>
                <span class="uk-label uk-label-success"><?= lang('active') ?></span>
                <?php else: ?>
                <span class="uk-label uk-label-danger"><?= lang('inactive') ?></span>
                <?php endif; ?>
              </td>
              <td class="uk-text-center">
                <div class="uk-button-group">
                  <a href="<?= site_url('shop/admin/services/edit/' . $service->id) ?>" class="uk-button uk-button-primary uk-button-small">
                    <i class="fa-solid fa-edit"></i>
                  </a>
                  <a href="<?= site_url('shop/admin/services/delete/' . $service->id) ?>" class="uk-button uk-button-danger uk-button-small" onclick="return confirm('<?= lang('confirm_delete') ?>')">
                    <i class="fa-solid fa-trash"></i>
                  </a>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
