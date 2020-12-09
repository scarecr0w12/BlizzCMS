    <section class="uk-section uk-section-xsmall" data-uk-height-viewport="expand: true">
      <div class="uk-container">
        <div class="uk-grid uk-grid-small uk-margin-small" data-uk-grid>
          <div class="uk-width-expand">
            <h4 class="uk-h4 uk-margin-remove"><?= lang('admin_nav_realms'); ?></h4>
            <ul class="uk-breadcrumb uk-margin-remove">
              <li><a href="<?= site_url('admin'); ?>"><?= lang('admin_nav_dashboard'); ?></a></li>
              <li><span><?= lang('admin_nav_realms'); ?></span></li>
            </ul>
          </div>
          <div class="uk-width-auto">
            <a href="<?= site_url('admin/realms/create'); ?>" class="uk-button uk-button-primary uk-button-small"><i class="fas fa-pen"></i> <?= lang('button_create'); ?></a>
          </div>
        </div>
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h4 class="uk-h4"></h4>
          </div>
          <div class="uk-card-body uk-padding-remove">
            <table class="uk-table uk-table-middle uk-table-divider uk-table-small">
              <thead>
                <tr>
                  <th class="uk-width-medium"><?= lang('placeholder_name'); ?></th>
                  <th class="uk-width-medium"><?= lang('placeholder_database'); ?></th>
                  <th class="uk-width-small">Soap Port</th>
                  <th class="uk-width-small"><?= lang('table_header_actions'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($realms as $item): ?>
                <tr>
                  <td><?= $item->name; ?></td>
                  <td><?= $item->char_database; ?></td>
                  <td><?= $item->console_port; ?></td>
                  <td>
                    <div class="uk-button-group">
                      <a href="<?= site_url('admin/realms/edit/'.$item->id); ?>" class="uk-button uk-button-primary uk-button-small"><i class="fas fa-edit"></i> Edit</a>
                      <div class="uk-inline">
                        <button class="uk-button uk-button-primary uk-button-small" type="button"><i class="fas fa-ellipsis-v"></i></button>
                        <div uk-dropdown="mode: click; boundary: .uk-container;">
                          <ul class="uk-nav uk-dropdown-nav">
                            <li><a href="<?= site_url('admin/realms/delete/'.$item->id); ?>"><i class="fas fa-trash-alt"></i> Delete</a></li>
                            <li><a href="<?= site_url('admin/realms/check/'.$item->id); ?>"><i class="fas fa-trash-alt"></i> Check</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>