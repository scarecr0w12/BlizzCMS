<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><span><?= lang('worldboss') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-dragon"></i> <?= lang('worldboss_title') ?>
        </h1>
        <p class="uk-text-meta uk-margin-remove-top"><?= lang('worldboss_description') ?></p>
      </div>
    </div>

    <!-- Boss Selector -->
    <div class="uk-card uk-card-default uk-margin">
      <div class="uk-card-body">
        <form id="boss-selector-form" method="get" class="uk-form-horizontal">
          <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <label class="uk-form-label" for="boss-select">
                <strong><i class="fa-solid fa-skull"></i> <?= lang('worldboss_select_boss') ?>:</strong>
              </label>
            </div>
            <div class="uk-width-expand@s uk-width-1-1">
              <select class="uk-select" id="boss-select" name="boss" onchange="window.location.href='<?= site_url('worldboss/boss/') ?>' + this.value">
                <?php foreach ($bosses as $boss): ?>
                <option value="<?= $boss['id'] ?>" <?= ($selected_boss == $boss['id']) ? 'selected' : '' ?>>
                  <?= html_escape($boss['name']) ?>
                </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Statistics -->
    <div class="uk-card uk-card-default uk-margin">
      <div class="uk-card-header">
        <h3 class="uk-card-title"><i class="fa-solid fa-chart-bar"></i> <?= lang('worldboss_stats') ?> - <?= html_escape($selected_boss_name ?? '') ?></h3>
      </div>
      <div class="uk-card-body">
        <div class="uk-grid-small uk-child-width-1-3@m uk-child-width-1-1@s uk-text-center" uk-grid>
          <div>
            <div class="bc-stat-box">
              <i class="fa-solid fa-list fa-2x uk-text-primary"></i>
              <div class="uk-text-large uk-text-bold"><?= number_format($stats->total_encounters ?? 0) ?></div>
              <div class="uk-text-meta"><?= lang('worldboss_total_encounters') ?></div>
            </div>
          </div>
          <div>
            <div class="bc-stat-box">
              <i class="fa-solid fa-shield fa-2x" style="color: #1A67F4;"></i>
              <div class="uk-text-large uk-text-bold" style="color: #1A67F4;"><?= number_format($stats->alliance_count ?? 0) ?></div>
              <div class="uk-text-meta"><?= lang('worldboss_alliance_count') ?></div>
            </div>
          </div>
          <div>
            <div class="bc-stat-box">
              <i class="fa-solid fa-shield fa-2x" style="color: #CD0A0E;"></i>
              <div class="uk-text-large uk-text-bold" style="color: #CD0A0E;"><?= number_format($stats->horde_count ?? 0) ?></div>
              <div class="uk-text-meta"><?= lang('worldboss_horde_count') ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Encounters Table -->
    <div class="uk-card uk-card-default uk-margin">
      <div class="uk-card-header">
        <h3 class="uk-card-title">
          <i class="fa-solid fa-trophy"></i> 
          <?= html_escape($selected_boss_name ?? lang('worldboss')) ?> - Rankings
        </h3>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <?php if (empty($encounters)): ?>
        <div class="uk-padding uk-text-center">
          <i class="fa-solid fa-inbox fa-3x uk-text-muted"></i>
          <p class="uk-text-muted"><?= lang('worldboss_no_encounters') ?></p>
        </div>
        <?php else: ?>
        <div class="uk-overflow-auto">
          <table class="uk-table uk-table-middle uk-table-divider uk-table-striped uk-table-hover uk-margin-remove">
            <thead>
              <tr>
                <th class="uk-text-center uk-table-shrink">#</th>
                <th><?= lang('worldboss_character') ?></th>
                <th class="uk-text-center"><?= lang('worldboss_class') ?></th>
                <th class="uk-text-center"><?= lang('worldboss_race') ?></th>
                <th class="uk-text-center"><?= lang('worldboss_faction') ?></th>
                <th class="uk-text-center"><?= lang('worldboss_level') ?></th>
                <th class="uk-text-center"><?= lang('worldboss_date') ?></th>
                <th class="uk-text-center"><?= lang('worldboss_difficulty') ?></th>
                <th class="uk-text-center"><?= lang('worldboss_duration') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php $rank = 1; foreach ($encounters as $encounter): ?>
              <tr class="bc-faction-<?= $encounter->faction ?>">
                <td class="uk-text-center uk-text-bold"><?= $rank++ ?></td>
                <td>
                  <a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($encounter->name)) ?>" class="uk-link-reset">
                    <span class="bc-class-<?= $encounter->class ?> uk-text-bold"><?= html_escape($encounter->name) ?></span>
                  </a>
                </td>
                <td class="uk-text-center">
                  <span class="bc-class-<?= $encounter->class ?>" title="<?= class_name($encounter->class) ?>">
                    <?= class_name($encounter->class) ?>
                  </span>
                </td>
                <td class="uk-text-center" title="<?= race_name($encounter->race) ?>">
                  <?= race_name($encounter->race) ?>
                </td>
                <td class="uk-text-center">
                  <?php if ($encounter->faction === 'alliance'): ?>
                  <span class="uk-label uk-label-primary" title="<?= lang('worldboss_alliance') ?>">
                    <i class="fa-solid fa-shield-halved"></i>
                  </span>
                  <?php elseif ($encounter->faction === 'horde'): ?>
                  <span class="uk-label uk-label-danger" title="<?= lang('worldboss_horde') ?>">
                    <i class="fa-solid fa-shield-halved"></i>
                  </span>
                  <?php else: ?>
                  <span class="uk-text-muted">-</span>
                  <?php endif; ?>
                </td>
                <td class="uk-text-center uk-text-bold"><?= $encounter->level ?></td>
                <td class="uk-text-center uk-text-small"><?= html_escape($encounter->timestamp_formatted) ?></td>
                <td class="uk-text-center">
                  <span class="uk-badge bc-difficulty-<?= min($encounter->difficulty, 10) ?>"><?= $encounter->difficulty ?></span>
                </td>
                <td class="uk-text-center uk-text-bold"><?= html_escape($encounter->duration_formatted) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Credits -->
    <div class="uk-text-center uk-margin-top uk-text-small uk-text-muted">
      <p>
        Based on <a href="https://github.com/azerothcore/world-boss-rank" target="_blank" rel="noopener">World Boss Rank</a> 
        by <a href="https://github.com/FrancescoBorzi/" target="_blank" rel="noopener">ShinDarth</a> & 
        <a href="https://github.com/Helias/" target="_blank" rel="noopener">Helias</a>
      </p>
    </div>
  </div>
</section>

<style>
/* Faction row colors */
.bc-faction-alliance td:first-child {
  border-left: 3px solid #1A67F4;
}
.bc-faction-horde td:first-child {
  border-left: 3px solid #CD0A0E;
}

/* Difficulty badges */
.bc-difficulty-1 { background-color: #28a745; }
.bc-difficulty-2 { background-color: #5cb85c; }
.bc-difficulty-3 { background-color: #8bc34a; }
.bc-difficulty-4 { background-color: #cddc39; }
.bc-difficulty-5 { background-color: #ffc107; }
.bc-difficulty-6 { background-color: #ff9800; }
.bc-difficulty-7 { background-color: #ff5722; }
.bc-difficulty-8 { background-color: #f44336; }
.bc-difficulty-9 { background-color: #e91e63; }
.bc-difficulty-10 { background-color: #9c27b0; }

/* Stat boxes */
.bc-stat-box {
  padding: 15px;
}

/* Class colors */
.bc-class-1 { color: #C79C6E; } /* Warrior */
.bc-class-2 { color: #F58CBA; } /* Paladin */
.bc-class-3 { color: #ABD473; } /* Hunter */
.bc-class-4 { color: #FFF569; } /* Rogue */
.bc-class-5 { color: #FFFFFF; } /* Priest */
.bc-class-6 { color: #C41F3B; } /* Death Knight */
.bc-class-7 { color: #0070DE; } /* Shaman */
.bc-class-8 { color: #69CCF0; } /* Mage */
.bc-class-9 { color: #9482C9; } /* Warlock */
.bc-class-10 { color: #00FF96; } /* Monk */
.bc-class-11 { color: #FF7D0A; } /* Druid */
.bc-class-12 { color: #A330C9; } /* Demon Hunter */
</style>
