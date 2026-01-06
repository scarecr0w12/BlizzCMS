<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('armory') ?>"><?= lang('armory') ?></a></li>
          <li><span><?= html_escape($guild->name) ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          &lt;<?= html_escape($guild->name) ?>&gt;
        </h1>
        <p class="uk-text-muted uk-margin-remove"><?= html_escape($realm->realm_name) ?></p>
      </div>
      <div class="uk-width-auto">
        <a href="<?= site_url('armory') ?>" class="uk-button uk-button-default">
          <i class="fa-solid fa-arrow-left"></i> <?= lang('back_to_search') ?>
        </a>
      </div>
    </div>

    <div uk-grid>
      <!-- Guild Info -->
      <div class="uk-width-1-3@m">
        <div class="uk-card uk-card-default uk-margin">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-shield-halved"></i> <?= lang('guild_info') ?></h3>
          </div>
          <div class="uk-card-body">
            <!-- Guild Emblem Placeholder -->
            <div class="uk-text-center uk-margin">
              <div class="bc-guild-emblem" style="background-color: #<?= dechex($guild->BackgroundColor ?? 0) ?>;">
                <i class="fa-solid fa-shield fa-3x"></i>
              </div>
            </div>

            <dl class="uk-description-list uk-description-list-divider">
              <dt><?= lang('guild_name') ?></dt>
              <dd class="uk-text-bold"><?= html_escape($guild->name) ?></dd>

              <dt><?= lang('realm') ?></dt>
              <dd><?= html_escape($realm->realm_name) ?></dd>

              <dt><?= lang('guild_members') ?></dt>
              <dd>
                <span class="uk-badge"><?= number_format($member_count) ?></span>
              </dd>

              <?php if (isset($guild->leaderguid) && $guild->leaderguid > 0): ?>
              <dt><?= lang('guild_leader') ?></dt>
              <dd>
                <?php
                $leader_name = '';
                foreach ($members as $member) {
                    if ($member->guid == $guild->leaderguid) {
                        $leader_name = $member->name;
                        break;
                    }
                }
                if (! empty($leader_name)): ?>
                <a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($leader_name)) ?>" class="uk-link-text">
                  <i class="fa-solid fa-crown uk-text-warning"></i> <?= html_escape($leader_name) ?>
                </a>
                <?php else: ?>
                <span class="uk-text-muted"><?= lang('unknown') ?></span>
                <?php endif ?>
              </dd>
              <?php endif ?>

              <?php if (isset($guild->createdate) && $guild->createdate > 0): ?>
              <dt><?= lang('guild_created') ?></dt>
              <dd><?= date('M j, Y', $guild->createdate) ?></dd>
              <?php endif ?>

              <?php if (isset($guild->BankMoney) && $guild->BankMoney > 0): ?>
              <dt><?= lang('guild_bank') ?></dt>
              <dd>
                <?php
                $gold = floor($guild->BankMoney / 10000);
                $silver = floor(($guild->BankMoney % 10000) / 100);
                $copper = $guild->BankMoney % 100;
                ?>
                <span class="bc-money">
                  <?php if ($gold > 0): ?>
                  <span class="bc-gold"><?= number_format($gold) ?></span>
                  <?php endif ?>
                  <?php if ($silver > 0 || $gold > 0): ?>
                  <span class="bc-silver"><?= $silver ?></span>
                  <?php endif ?>
                  <span class="bc-copper"><?= $copper ?></span>
                </span>
              </dd>
              <?php endif ?>
            </dl>

            <?php if (! empty($guild->info)): ?>
            <hr>
            <h4><?= lang('guild_info') ?></h4>
            <p class="uk-text-muted"><?= nl2br(html_escape($guild->info)) ?></p>
            <?php endif ?>

            <?php if (! empty($guild->motd)): ?>
            <hr>
            <h4><?= lang('guild_motd') ?></h4>
            <p class="uk-text-muted uk-text-italic">"<?= html_escape($guild->motd) ?>"</p>
            <?php endif ?>
          </div>
        </div>
      </div>

      <!-- Guild Members -->
      <div class="uk-width-2-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <div uk-grid>
              <div class="uk-width-expand">
                <h3 class="uk-card-title"><i class="fa-solid fa-users"></i> <?= lang('guild_members') ?></h3>
              </div>
              <div class="uk-width-auto">
                <a href="<?= site_url('armory/guild/' . $realm_id . '/' . urlencode($guild->name) . '/members') ?>" class="uk-button uk-button-small uk-button-primary">
                  <?= lang('view_all') ?> <i class="fa-solid fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
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
                    <th><?= lang('character_class') ?></th>
                    <th><?= lang('guild_rank') ?></th>
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
                    <td>
                      <span class="bc-class-<?= $member->class ?>"><?= class_name($member->class) ?></span>
                    </td>
                    <td>
                      <span class="uk-text-muted"><?= html_escape($member->rank_name ?? '') ?></span>
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
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
.bc-guild-emblem {
  width: 100px;
  height: 100px;
  margin: 0 auto;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  border: 3px solid #666;
  background: linear-gradient(135deg, #1e3a5f 0%, #0d1b2a 100%);
}

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

/* Money display */
.bc-money {
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.bc-gold::after {
  content: '';
  display: inline-block;
  width: 12px;
  height: 12px;
  background: linear-gradient(135deg, #ffd700 0%, #b8860b 100%);
  border-radius: 50%;
  margin-left: 2px;
  vertical-align: middle;
}

.bc-silver::after {
  content: '';
  display: inline-block;
  width: 10px;
  height: 10px;
  background: linear-gradient(135deg, #c0c0c0 0%, #808080 100%);
  border-radius: 50%;
  margin-left: 2px;
  vertical-align: middle;
}

.bc-copper::after {
  content: '';
  display: inline-block;
  width: 10px;
  height: 10px;
  background: linear-gradient(135deg, #b87333 0%, #8b4513 100%);
  border-radius: 50%;
  margin-left: 2px;
  vertical-align: middle;
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
