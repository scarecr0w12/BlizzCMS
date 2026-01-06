<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container uk-container-expand">
    <div class="uk-flex uk-flex-between uk-flex-wrap uk-margin">
      <div>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-box"></i> <?= lang('admin_shop_items') ?>
        </h1>
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_dashboard') ?></a></li>
          <li><a href="<?= site_url('shop/admin') ?>"><?= lang('admin_shop') ?></a></li>
          <li><span><?= lang('admin_shop_items') ?></span></li>
        </ul>
      </div>
      <div>
        <a href="<?= site_url('shop/admin/items/add') ?>" class="uk-button uk-button-primary">
          <i class="fa-solid fa-plus"></i> <?= lang('add') ?>
        </a>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <div class="uk-card uk-card-default">
      <?php if (empty($items)): ?>
      <div class="uk-card-body uk-text-center uk-padding-large">
        <i class="fa-solid fa-box fa-5x uk-text-muted"></i>
        <h3 class="uk-margin-top"><?= lang('no_data') ?></h3>
        <a href="<?= site_url('shop/admin/items/add') ?>" class="uk-button uk-button-primary">
          <i class="fa-solid fa-plus"></i> <?= lang('shop_add_item') ?>
        </a>
      </div>
      <?php else: ?>
      <div class="uk-card-body uk-padding-remove">
        <table class="uk-table uk-table-middle uk-table-divider uk-table-hover uk-margin-remove">
          <thead>
            <tr>
              <th class="uk-table-shrink"><?= lang('id') ?></th>
              <th><?= lang('name') ?></th>
              <th><?= lang('shop_category') ?></th>
              <th class="uk-text-center"><?= lang('shop_price') ?></th>
              <th class="uk-text-center"><?= lang('shop_stock') ?></th>
              <th class="uk-text-center"><?= lang('status') ?></th>
              <th class="uk-text-center uk-table-shrink"><?= lang('actions') ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
              <td><?= $item->id ?></td>
              <td>
                <strong><?= html_escape($item->name) ?></strong>
                <div class="uk-text-small uk-text-muted">Item ID: <?= $item->game_item_id ?> x<?= $item->item_count ?></div>
              </td>
              <td><?= html_escape($item->category_name ?? 'N/A') ?></td>
              <td class="uk-text-center">
                <?php if ($item->price_dp > 0): ?>
                <span class="uk-label uk-label-warning"><?= number_format($item->price_dp) ?> DP</span>
                <?php endif; ?>
                <?php if ($item->price_vp > 0): ?>
                <span class="uk-label"><?= number_format($item->price_vp) ?> VP</span>
                <?php endif; ?>
                <?php if ($item->price_money > 0): ?>
                <span class="uk-label uk-label-success">$<?= number_format($item->price_money, 2) ?></span>
                <?php endif; ?>
              </td>
              <td class="uk-text-center">
                <?php if ($item->stock == -1): ?>
                <span class="uk-text-success"><?= lang('shop_unlimited') ?></span>
                <?php elseif ($item->stock > 0): ?>
                <span class="uk-badge"><?= $item->stock ?></span>
                <?php else: ?>
                <span class="uk-text-danger"><?= lang('shop_out_of_stock') ?></span>
                <?php endif; ?>
              </td>
              <td class="uk-text-center">
                <?php if ($item->is_active): ?>
                <span class="uk-label uk-label-success"><?= lang('active') ?></span>
                <?php else: ?>
                <span class="uk-label uk-label-danger"><?= lang('inactive') ?></span>
                <?php endif; ?>
              </td>
              <td class="uk-text-center">
                <div class="uk-button-group">
                  <a href="<?= site_url('shop/admin/items/edit/' . $item->id) ?>" class="uk-button uk-button-primary uk-button-small">
                    <i class="fa-solid fa-edit"></i>
                  </a>
                  <a href="<?= site_url('shop/admin/items/delete/' . $item->id) ?>" class="uk-button uk-button-danger uk-button-small" onclick="return confirm('<?= lang('confirm_delete') ?>')">
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
