<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container uk-container-expand">
    <div class="uk-flex uk-flex-between uk-flex-wrap uk-margin">
      <div>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-folder"></i> <?= lang('admin_shop_categories') ?>
        </h1>
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_dashboard') ?></a></li>
          <li><a href="<?= site_url('shop/admin') ?>"><?= lang('admin_shop') ?></a></li>
          <li><span><?= lang('admin_shop_categories') ?></span></li>
        </ul>
      </div>
      <div>
        <a href="<?= site_url('shop/admin/categories/add') ?>" class="uk-button uk-button-primary">
          <i class="fa-solid fa-plus"></i> <?= lang('add') ?>
        </a>
      </div>
    </div>

    <?= $template['partials']['alerts'] ?>

    <div class="uk-card uk-card-default">
      <?php if (empty($categories)): ?>
      <div class="uk-card-body uk-text-center uk-padding-large">
        <i class="fa-solid fa-folder fa-5x uk-text-muted"></i>
        <h3 class="uk-margin-top"><?= lang('no_data') ?></h3>
        <a href="<?= site_url('shop/admin/categories/add') ?>" class="uk-button uk-button-primary">
          <i class="fa-solid fa-plus"></i> <?= lang('shop_add_category') ?>
        </a>
      </div>
      <?php else: ?>
      <div class="uk-card-body uk-padding-remove">
        <table class="uk-table uk-table-middle uk-table-divider uk-table-hover uk-margin-remove">
          <thead>
            <tr>
              <th class="uk-table-shrink"><?= lang('id') ?></th>
              <th><?= lang('name') ?></th>
              <th class="uk-text-center"><?= lang('shop_items') ?></th>
              <th class="uk-text-center"><?= lang('sort_order') ?></th>
              <th class="uk-text-center uk-table-shrink"><?= lang('actions') ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($categories as $category): ?>
            <tr>
              <td><?= $category->id ?></td>
              <td>
                <?php if (! empty($category->icon)): ?>
                <i class="<?= $category->icon ?> uk-margin-small-right"></i>
                <?php endif; ?>
                <strong><?= html_escape($category->name) ?></strong>
                <?php if (! empty($category->description)): ?>
                <div class="uk-text-small uk-text-muted"><?= html_escape(substr($category->description, 0, 50)) ?>...</div>
                <?php endif; ?>
              </td>
              <td class="uk-text-center">
                <span class="uk-badge"><?= $category->item_count ?? 0 ?></span>
              </td>
              <td class="uk-text-center"><?= $category->sort_order ?></td>
              <td class="uk-text-center">
                <div class="uk-button-group">
                  <a href="<?= site_url('shop/admin/categories/edit/' . $category->id) ?>" class="uk-button uk-button-primary uk-button-small">
                    <i class="fa-solid fa-edit"></i>
                  </a>
                  <a href="<?= site_url('shop/admin/categories/delete/' . $category->id) ?>" class="uk-button uk-button-danger uk-button-small" onclick="return confirm('<?= lang('confirm_delete') ?>')">
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
