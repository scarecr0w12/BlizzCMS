<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('dashboard') ?></a></li>
          <li><a href="<?= site_url('admin/modules') ?>"><?= lang('modules') ?></a></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('worldboss_settings') ?></h1>
      </div>
      <div class="uk-width-auto"></div>
    </div>
    <div class="uk-margin" uk-grid>
      <div class="uk-width-1-3@s uk-width-1-4@m">
        <div class="uk-card uk-card-default">
          <ul class="uk-nav-default" uk-nav>
            <li class="uk-nav-header"><?= lang('worldboss') ?></li>
            <li><a href="<?= site_url('worldboss/admin') ?>"><?= lang('general') ?></a></li>
            <li class="uk-active"><a href="<?= site_url('worldboss/admin/bosses') ?>"><?= lang('worldboss_bosses') ?></a></li>
          </ul>
        </div>
      </div>
      <div class="uk-width-expand@s">
        <?= $template['partials']['alerts'] ?>
        <h2 class="uk-h4 uk-text-bold uk-margin-remove"><?= lang('worldboss_bosses') ?></h2>
        <p class="uk-text-small uk-margin-remove-top uk-margin-small-bottom"><?= lang('worldboss_bosses_desc') ?></p>
        <div class="uk-card uk-card-default uk-margin-small">
          <div class="uk-overflow-auto">
            <table class="uk-table uk-table-middle uk-table-divider uk-table-small uk-margin-remove">
              <thead>
                <tr>
                  <th class="uk-table-shrink"><?= lang('worldboss_boss_id') ?></th>
                  <th><?= lang('worldboss_boss_name') ?></th>
                  <th class="uk-table-shrink"><?= lang('worldboss_boss_type') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($bosses as $boss): ?>
                <tr>
                  <td class="uk-text-nowrap">
                    <code><?= $boss['id'] ?></code>
                  </td>
                  <td>
                    <i class="fa-solid fa-skull uk-text-danger"></i>
                    <strong><?= html_escape($boss['name']) ?></strong>
                  </td>
                  <td class="uk-text-nowrap">
                    <?php 
                    // Determine type based on boss ID pattern (ends in 1 = Raid, ends in 3 = Party)
                    $type = substr((string)$boss['id'], -1) === '1' ? 'Raid' : 'Party';
                    $badge_class = $type === 'Raid' ? 'uk-label-danger' : 'uk-label-primary';
                    ?>
                    <span class="uk-label <?= $badge_class ?>"><?= $type ?></span>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
        <p class="uk-text-small uk-text-muted uk-margin-small-top">
          <i class="fa-solid fa-info-circle"></i> <?= lang('worldboss_boss_config_info') ?>
        </p>
      </div>
    </div>
  </div>
</section>
