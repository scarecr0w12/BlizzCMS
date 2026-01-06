<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('admin_panel') ?></a></li>
          <li><span><?= lang('vote') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-vote-yea"></i> <?= lang('vote_admin_title') ?>
        </h1>
      </div>
      <div class="uk-width-auto">
        <a href="<?= site_url('admin/vote/add-site') ?>" class="uk-button uk-button-primary uk-button-small">
          <i class="fa-solid fa-plus"></i> <?= lang('vote_add_site') ?>
        </a>
      </div>
    </div>

    <!-- Statistics Cards -->
    <div class="uk-grid-small uk-child-width-1-4@m uk-child-width-1-2@s" uk-grid>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <div class="uk-border-circle uk-flex uk-flex-center uk-flex-middle" style="width: 50px; height: 50px; background-color: #1e87f0;">
                <i class="fa-solid fa-list fa-lg uk-light"></i>
              </div>
            </div>
            <div class="uk-width-expand">
              <div class="uk-text-small uk-text-muted"><?= lang('vote_active_sites') ?></div>
              <div class="uk-text-large uk-text-bold"><?= $stats['active_sites'] ?? 0 ?></div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <div class="uk-border-circle uk-flex uk-flex-center uk-flex-middle" style="width: 50px; height: 50px; background-color: #32d296;">
                <i class="fa-solid fa-check-circle fa-lg uk-light"></i>
              </div>
            </div>
            <div class="uk-width-expand">
              <div class="uk-text-small uk-text-muted"><?= lang('vote_total_votes') ?></div>
              <div class="uk-text-large uk-text-bold"><?= number_format($stats['total_votes'] ?? 0) ?></div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <div class="uk-border-circle uk-flex uk-flex-center uk-flex-middle" style="width: 50px; height: 50px; background-color: #faa05a;">
                <i class="fa-solid fa-calendar-day fa-lg uk-light"></i>
              </div>
            </div>
            <div class="uk-width-expand">
              <div class="uk-text-small uk-text-muted"><?= lang('vote_votes_today') ?></div>
              <div class="uk-text-large uk-text-bold"><?= number_format($stats['votes_today'] ?? 0) ?></div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <div class="uk-border-circle uk-flex uk-flex-center uk-flex-middle" style="width: 50px; height: 50px; background-color: #f0506e;">
                <i class="fa-solid fa-coins fa-lg uk-light"></i>
              </div>
            </div>
            <div class="uk-width-expand">
              <div class="uk-text-small uk-text-muted"><?= lang('vote_total_vp_awarded') ?></div>
              <div class="uk-text-large uk-text-bold"><?= number_format($stats['total_vp'] ?? 0) ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="uk-grid-small uk-margin-top uk-child-width-1-4@m uk-child-width-1-2@s" uk-grid>
      <div>
        <a href="<?= site_url('admin/vote/sites') ?>" class="uk-card uk-card-default uk-card-body uk-card-hover uk-display-block uk-link-reset">
          <i class="fa-solid fa-globe fa-2x uk-text-primary"></i>
          <h4 class="uk-margin-small-top"><?= lang('vote_manage_sites') ?></h4>
          <p class="uk-text-small uk-text-muted"><?= lang('vote_manage_sites_desc') ?></p>
        </a>
      </div>
      <div>
        <a href="<?= site_url('admin/vote/logs') ?>" class="uk-card uk-card-default uk-card-body uk-card-hover uk-display-block uk-link-reset">
          <i class="fa-solid fa-history fa-2x uk-text-primary"></i>
          <h4 class="uk-margin-small-top"><?= lang('vote_logs') ?></h4>
          <p class="uk-text-small uk-text-muted"><?= lang('vote_logs_desc') ?></p>
        </a>
      </div>
      <div>
        <a href="<?= site_url('admin/vote/settings') ?>" class="uk-card uk-card-default uk-card-body uk-card-hover uk-display-block uk-link-reset">
          <i class="fa-solid fa-cog fa-2x uk-text-primary"></i>
          <h4 class="uk-margin-small-top"><?= lang('settings') ?></h4>
          <p class="uk-text-small uk-text-muted"><?= lang('vote_settings_desc') ?></p>
        </a>
      </div>
      <div>
        <a href="<?= site_url('vote') ?>" class="uk-card uk-card-default uk-card-body uk-card-hover uk-display-block uk-link-reset" target="_blank">
          <i class="fa-solid fa-external-link-alt fa-2x uk-text-primary"></i>
          <h4 class="uk-margin-small-top"><?= lang('vote_view_public') ?></h4>
          <p class="uk-text-small uk-text-muted"><?= lang('vote_view_public_desc') ?></p>
        </a>
      </div>
    </div>

    <!-- Recent Votes -->
    <div class="uk-card uk-card-default uk-margin-top">
      <div class="uk-card-header">
        <h3 class="uk-card-title"><i class="fa-solid fa-history"></i> <?= lang('vote_recent_votes') ?></h3>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <?php if (empty($recent_votes)): ?>
        <div class="uk-padding uk-text-center">
          <p class="uk-text-muted"><?= lang('vote_no_votes') ?></p>
        </div>
        <?php else: ?>
        <div class="uk-overflow-auto">
          <table class="uk-table uk-table-middle uk-table-divider uk-table-striped uk-margin-remove">
            <thead>
              <tr>
                <th><?= lang('user') ?></th>
                <th><?= lang('vote_site_name') ?></th>
                <th class="uk-text-right"><?= lang('vote_vp_reward') ?></th>
                <th class="uk-text-right"><?= lang('date') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recent_votes as $vote): ?>
              <tr>
                <td>
                  <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
                    <div class="uk-width-auto">
                      <img class="uk-border-circle" src="<?= user_avatar($vote->user_id) ?>" width="32" height="32" alt="">
                    </div>
                    <div class="uk-width-expand">
                      <?= html_escape($vote->nickname ?? 'Unknown') ?>
                    </div>
                  </div>
                </td>
                <td><?= html_escape($vote->site_name ?? 'N/A') ?></td>
                <td class="uk-text-right">
                  <span class="uk-label uk-label-success">+<?= number_format($vote->vp_awarded) ?> VP</span>
                </td>
                <td class="uk-text-right uk-text-meta">
                  <time datetime="<?= $vote->created_at ?>"><?= locate_date($vote->created_at) ?></time>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>
      </div>
      <?php if (!empty($recent_votes)): ?>
      <div class="uk-card-footer">
        <a href="<?= site_url('admin/vote/logs') ?>" class="uk-button uk-button-text">
          <?= lang('view_all') ?> <i class="fa-solid fa-arrow-right"></i>
        </a>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
