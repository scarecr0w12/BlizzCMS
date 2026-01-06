<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('armory') ?>"><?= lang('armory') ?></a></li>
          <li><a href="<?= site_url('armory/guild/' . $realm_id . '/' . urlencode($guild->name)) ?>"><?= html_escape($guild->name) ?></a></li>
          <li><span><?= lang('guild_members') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          &lt;<?= html_escape($guild->name) ?>&gt; - <?= lang('guild_members') ?>
        </h1>
        <p class="uk-text-muted uk-margin-remove"><?= number_format($member_count) ?> <?= lang('guild_members') ?></p>
      </div>
      <div class="uk-width-auto">
        <a href="<?= site_url('armory/guild/' . $realm_id . '/' . urlencode($guild->name)) ?>" class="uk-button uk-button-default">
          <i class="fa-solid fa-arrow-left"></i> <?= lang('guild') ?>
        </a>
      </div>
    </div>

    <div class="uk-card uk-card-default">
      <div class="uk-card-body">
        <?php if (empty($members)): ?>
        <div class="uk-alert uk-alert-warning">
          <p><i class="fa-solid fa-circle-info"></i> <?= lang('guild_no_members') ?></p>
        </div>
        <?php else: ?>
        <div class="uk-overflow-auto">
          <table class="uk-table uk-table-middle uk-table-divider uk-table-hover uk-table-small">
            <thead>
              <tr>
                <th><?= lang('character') ?></th>
                <th class="uk-text-center"><?= lang('character_level') ?></th>
                <th><?= lang('character_race') ?></th>
                <th><?= lang('character_class') ?></th>
                <th><?= lang('guild_rank') ?></th>
                <th><?= lang('character_zone') ?></th>
                <th class="uk-text-center"><?= lang('status') ?></th>
                <th class="uk-text-center"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($members as $member): ?>
              <tr>
                <td>
                  <div class="uk-flex uk-flex-middle">
                    <span class="bc-race-icon bc-race-<?= $member->race ?>-<?= $member->gender ?>"></span>
                    <span class="uk-margin-small-left uk-text-bold"><?= html_escape($member->name) ?></span>
                    <?php if ($member->guid == $guild->leaderguid): ?>
                    <span class="uk-label uk-label-warning uk-margin-small-left" title="<?= lang('guild_leader') ?>">
                      <i class="fa-solid fa-crown"></i>
                    </span>
                    <?php endif ?>
                  </div>
                </td>
                <td class="uk-text-center">
                  <span class="uk-badge"><?= $member->level ?></span>
                </td>
                <td><?= race_name($member->race) ?></td>
                <td>
                  <span class="bc-class-<?= $member->class ?>"><?= class_name($member->class) ?></span>
                </td>
                <td>
                  <span class="uk-text-muted"><?= html_escape($member->rank_name ?? '') ?></span>
                </td>
                <td>
                  <span class="uk-text-muted"><?= zone_name($member->zone ?? 0) ?></span>
                </td>
                <td class="uk-text-center">
                  <?php if ($member->online == 1): ?>
                  <span class="uk-label uk-label-success"><?= lang('character_online') ?></span>
                  <?php else: ?>
                  <span class="uk-label"><?= lang('character_offline') ?></span>
                  <?php endif ?>
                </td>
                <td class="uk-text-center">
                  <a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($member->name)) ?>" class="uk-button uk-button-small uk-button-primary">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                </td>
              </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="uk-margin-top">
          <ul class="uk-pagination uk-flex-center">
            <?php if ($page > 1): ?>
            <li><a href="<?= site_url('armory/guild/' . $realm_id . '/' . urlencode($guild->name) . '/members?page=' . ($page - 1)) ?>"><span uk-pagination-previous></span></a></li>
            <?php endif ?>

            <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
            <li class="<?= $i == $page ? 'uk-active' : '' ?>">
              <a href="<?= site_url('armory/guild/' . $realm_id . '/' . urlencode($guild->name) . '/members?page=' . $i) ?>"><?= $i ?></a>
            </li>
            <?php endfor ?>

            <?php if ($page < $total_pages): ?>
            <li><a href="<?= site_url('armory/guild/' . $realm_id . '/' . urlencode($guild->name) . '/members?page=' . ($page + 1)) ?>"><span uk-pagination-next></span></a></li>
            <?php endif ?>
          </ul>
        </div>
        <?php endif ?>

        <?php endif ?>
      </div>
    </div>
  </div>
</section>

<style>
.bc-race-icon {
  display: inline-block;
  width: 24px;
  height: 24px;
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center;
  border-radius: 50%;
  background-color: #333;
}

.bc-class-1 { color: #C79C6E; }
.bc-class-2 { color: #F58CBA; }
.bc-class-3 { color: #ABD473; }
.bc-class-4 { color: #FFF569; }
.bc-class-5 { color: #FFFFFF; }
.bc-class-6 { color: #C41F3B; }
.bc-class-7 { color: #0070DE; }
.bc-class-8 { color: #69CCF0; }
.bc-class-9 { color: #9482C9; }
.bc-class-10 { color: #00FF96; }
.bc-class-11 { color: #FF7D0A; }
.bc-class-12 { color: #A330C9; }
</style>
