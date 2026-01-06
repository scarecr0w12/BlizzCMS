<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_panel') ?></a></li>
          <li><a href="<?= site_url('admin/vote') ?>"><?= lang('vote') ?></a></li>
          <li><span><?= lang('vote_sites') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-globe"></i> <?= lang('vote_manage_sites') ?>
        </h1>
      </div>
      <div class="uk-width-auto">
        <a href="<?= site_url('admin/vote/add-site') ?>" class="uk-button uk-button-primary uk-button-small">
          <i class="fa-solid fa-plus"></i> <?= lang('vote_add_site') ?>
        </a>
      </div>
    </div>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body uk-padding-remove">
        <?php if (empty($sites)): ?>
        <div class="uk-padding uk-text-center">
          <i class="fa-solid fa-globe fa-3x uk-text-muted"></i>
          <p class="uk-text-muted"><?= lang('vote_no_sites') ?></p>
          <a href="<?= site_url('admin/vote/add-site') ?>" class="uk-button uk-button-primary uk-button-small">
            <i class="fa-solid fa-plus"></i> <?= lang('vote_add_site') ?>
          </a>
        </div>
        <?php else: ?>
        <div class="uk-overflow-auto">
          <table class="uk-table uk-table-middle uk-table-divider uk-table-striped uk-table-hover uk-margin-remove">
            <thead>
              <tr>
                <th class="uk-table-shrink"><?= lang('id') ?></th>
                <th><?= lang('name') ?></th>
                <th><?= lang('url') ?></th>
                <th class="uk-text-center"><?= lang('vote_vp_reward') ?></th>
                <th class="uk-text-center"><?= lang('vote_cooldown') ?></th>
                <th class="uk-text-center"><?= lang('status') ?></th>
                <th class="uk-text-right"><?= lang('actions') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($sites as $site): ?>
              <tr>
                <td><?= $site->id ?></td>
                <td>
                  <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
                    <?php if (!empty($site->image)): ?>
                    <div class="uk-width-auto">
                      <img src="<?= base_url('uploads/' . $site->image) ?>" alt="<?= html_escape($site->name) ?>" style="max-height: 30px; max-width: 60px;">
                    </div>
                    <?php endif; ?>
                    <div class="uk-width-expand">
                      <strong><?= html_escape($site->name) ?></strong>
                    </div>
                  </div>
                </td>
                <td>
                  <a href="<?= $site->url ?>" target="_blank" class="uk-text-truncate uk-display-inline-block" style="max-width: 200px;">
                    <?= html_escape($site->url) ?>
                    <i class="fa-solid fa-external-link-alt fa-xs"></i>
                  </a>
                </td>
                <td class="uk-text-center">
                  <span class="uk-label uk-label-success">+<?= $site->vp_reward ?> VP</span>
                </td>
                <td class="uk-text-center">
                  <span class="uk-text-muted"><?= $site->cooldown_hours ?> hours</span>
                </td>
                <td class="uk-text-center">
                  <?php if ($site->is_active): ?>
                  <span class="uk-label uk-label-success"><?= lang('active') ?></span>
                  <?php else: ?>
                  <span class="uk-label uk-label-danger"><?= lang('inactive') ?></span>
                  <?php endif; ?>
                </td>
                <td class="uk-text-right">
                  <a href="<?= site_url('admin/vote/edit-site/' . $site->id) ?>" class="uk-button uk-button-primary uk-button-small" uk-tooltip="<?= lang('edit') ?>">
                    <i class="fa-solid fa-edit"></i>
                  </a>
                  <a href="<?= site_url('admin/vote/delete-site/' . $site->id) ?>" class="uk-button uk-button-danger uk-button-small" uk-tooltip="<?= lang('delete') ?>" onclick="return confirm('<?= lang('confirm_delete') ?>');">
                    <i class="fa-solid fa-trash"></i>
                  </a>
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
