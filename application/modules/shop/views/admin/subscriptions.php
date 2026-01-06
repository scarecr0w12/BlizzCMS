<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container uk-container-expand">
    <div class="uk-flex uk-flex-between uk-flex-wrap uk-margin">
      <div>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-crown"></i> <?= lang('admin_shop_subscriptions') ?>
        </h1>
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_dashboard') ?></a></li>
          <li><a href="<?= site_url('shop/admin') ?>"><?= lang('admin_shop') ?></a></li>
          <li><span><?= lang('admin_shop_subscriptions') ?></span></li>
        </ul>
      </div>
      <div>
        <a href="<?= site_url('shop/admin/subscriptions/add') ?>" class="uk-button uk-button-primary">
          <i class="fa-solid fa-plus"></i> <?= lang('add') ?>
        </a>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <div class="uk-card uk-card-default">
      <?php if (empty($subscriptions)): ?>
      <div class="uk-card-body uk-text-center uk-padding-large">
        <i class="fa-solid fa-crown fa-5x uk-text-muted"></i>
        <h3 class="uk-margin-top"><?= lang('no_data') ?></h3>
        <a href="<?= site_url('shop/admin/subscriptions/add') ?>" class="uk-button uk-button-primary">
          <i class="fa-solid fa-plus"></i> <?= lang('shop_add_subscription') ?>
        </a>
      </div>
      <?php else: ?>
      <div class="uk-card-body uk-padding-remove">
        <table class="uk-table uk-table-middle uk-table-divider uk-table-hover uk-margin-remove">
          <thead>
            <tr>
              <th class="uk-table-shrink"><?= lang('id') ?></th>
              <th><?= lang('name') ?></th>
              <th><?= lang('shop_interval') ?></th>
              <th class="uk-text-center"><?= lang('shop_price') ?></th>
              <th class="uk-text-center"><?= lang('shop_subscribers') ?></th>
              <th class="uk-text-center"><?= lang('status') ?></th>
              <th class="uk-text-center uk-table-shrink"><?= lang('actions') ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($subscriptions as $sub): ?>
            <tr>
              <td><?= $sub->id ?></td>
              <td>
                <?php if (! empty($sub->icon)): ?>
                <i class="<?= $sub->icon ?> uk-margin-small-right"></i>
                <?php endif; ?>
                <strong><?= html_escape($sub->name) ?></strong>
              </td>
              <td><?= ucfirst($sub->interval_type) ?> (<?= $sub->interval_count ?>)</td>
              <td class="uk-text-center">
                <?php if ($sub->price_dp > 0): ?>
                <span class="uk-label uk-label-warning"><?= number_format($sub->price_dp) ?> DP</span>
                <?php endif; ?>
                <?php if ($sub->price_vp > 0): ?>
                <span class="uk-label"><?= number_format($sub->price_vp) ?> VP</span>
                <?php endif; ?>
                <?php if ($sub->price_money > 0): ?>
                <span class="uk-label uk-label-success">$<?= number_format($sub->price_money, 2) ?></span>
                <?php endif; ?>
              </td>
              <td class="uk-text-center">
                <span class="uk-badge"><?= $sub->subscriber_count ?? 0 ?></span>
              </td>
              <td class="uk-text-center">
                <?php if ($sub->is_active): ?>
                <span class="uk-label uk-label-success"><?= lang('active') ?></span>
                <?php else: ?>
                <span class="uk-label uk-label-danger"><?= lang('inactive') ?></span>
                <?php endif; ?>
              </td>
              <td class="uk-text-center">
                <div class="uk-button-group">
                  <a href="<?= site_url('shop/admin/subscriptions/edit/' . $sub->id) ?>" class="uk-button uk-button-primary uk-button-small">
                    <i class="fa-solid fa-edit"></i>
                  </a>
                  <a href="<?= site_url('shop/admin/subscriptions/delete/' . $sub->id) ?>" class="uk-button uk-button-danger uk-button-small" onclick="return confirm('<?= lang('confirm_delete') ?>')">
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
