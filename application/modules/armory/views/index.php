<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><span><?= lang('armory') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('armory') ?></h1>
      </div>
      <div class="uk-width-auto"></div>
    </div>

    <!-- Search Form -->
    <div class="uk-card uk-card-default uk-margin">
      <div class="uk-card-body">
        <form action="<?= site_url('armory/search') ?>" method="get" class="uk-form-stacked">
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-expand@s">
              <input class="uk-input" type="text" name="q" placeholder="<?= lang('armory_search_placeholder') ?>" value="<?= html_escape($query ?? '') ?>" minlength="2" required>
            </div>
            <div class="uk-width-auto@s">
              <select class="uk-select" name="type">
                <option value="all" <?= (isset($search_type) && $search_type == 'all') ? 'selected' : '' ?>><?= lang('armory_search_all') ?></option>
                <option value="character" <?= (isset($search_type) && $search_type == 'character') ? 'selected' : '' ?>><?= lang('characters') ?></option>
                <option value="guild" <?= (isset($search_type) && $search_type == 'guild') ? 'selected' : '' ?>><?= lang('guilds') ?></option>
              </select>
            </div>
            <div class="uk-width-auto@s">
              <select class="uk-select" name="realm">
                <option value="all"><?= lang('armory_all_realms') ?></option>
                <?php foreach ($realms as $r): ?>
                <option value="<?= $r->id ?>" <?= (isset($selected_realm) && $selected_realm == $r->id) ? 'selected' : '' ?>><?= html_escape($r->realm_name) ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="uk-width-auto@s">
              <button type="submit" class="uk-button uk-button-primary">
                <i class="fa-solid fa-magnifying-glass"></i> <?= lang('armory_search') ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Search Results -->
    <?php if (! empty($query)): ?>
    
    <!-- Character Results -->
    <?php if ($search_type === 'character' || $search_type === 'all'): ?>
    <div class="uk-card uk-card-default uk-margin">
      <div class="uk-card-header">
        <h3 class="uk-card-title">
          <i class="fa-solid fa-users"></i> <?= lang('characters') ?>
          <span class="uk-badge"><?= count($results ?? []) ?></span>
        </h3>
      </div>
      <div class="uk-card-body">
        <?php if (empty($results)): ?>
        <div class="uk-alert uk-alert-warning">
          <p><i class="fa-solid fa-circle-exclamation"></i> <?= lang('armory_no_results') ?></p>
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
                <th><?= lang('character_faction') ?></th>
                <th><?= lang('realm') ?></th>
                <th class="uk-text-center"><?= lang('status') ?></th>
                <th class="uk-text-center"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($results as $char): ?>
              <tr>
                <td>
                  <div class="uk-flex uk-flex-middle">
                    <span class="bc-race-icon bc-race-<?= $char->race ?>-<?= $char->gender ?>" title="<?= race_name($char->race) ?>"></span>
                    <span class="uk-margin-small-left uk-text-bold"><?= html_escape($char->name) ?></span>
                  </div>
                </td>
                <td class="uk-text-center">
                  <span class="uk-badge"><?= $char->level ?></span>
                </td>
                <td><?= race_name($char->race) ?></td>
                <td>
                  <span class="bc-class-<?= $char->class ?>"><?= class_name($char->class) ?></span>
                </td>
                <td>
                  <?php if (in_array($char->race, config_item('alliance_races'))): ?>
                  <span class="uk-label uk-label-primary"><?= lang('alliance') ?></span>
                  <?php else: ?>
                  <span class="uk-label uk-label-danger"><?= lang('horde') ?></span>
                  <?php endif ?>
                </td>
                <td>
                  <span class="uk-text-muted"><?= html_escape($char->realm_name ?? '') ?></span>
                </td>
                <td class="uk-text-center">
                  <?php if (isset($char->online) && $char->online == 1): ?>
                  <span class="uk-label uk-label-success"><?= lang('character_online') ?></span>
                  <?php else: ?>
                  <span class="uk-label"><?= lang('character_offline') ?></span>
                  <?php endif ?>
                </td>
                <td class="uk-text-center">
                  <a href="<?= site_url('armory/character/' . ($char->realm_id ?? $selected_realm) . '/' . urlencode($char->name)) ?>" class="uk-button uk-button-small uk-button-primary">
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
    <?php endif ?>

    <!-- Guild Results -->
    <?php if ($search_type === 'guild' || $search_type === 'all'): ?>
    <div class="uk-card uk-card-default uk-margin">
      <div class="uk-card-header">
        <h3 class="uk-card-title">
          <i class="fa-solid fa-shield"></i> <?= lang('guilds') ?>
          <span class="uk-badge"><?= count($guild_results ?? []) ?></span>
        </h3>
      </div>
      <div class="uk-card-body">
        <?php if (empty($guild_results)): ?>
        <div class="uk-alert uk-alert-warning">
          <p><i class="fa-solid fa-circle-exclamation"></i> <?= lang('armory_no_guild_results') ?></p>
        </div>
        <?php else: ?>
        <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l" uk-grid>
          <?php foreach ($guild_results as $guild): ?>
          <div>
            <a href="<?= site_url('armory/guild/' . $guild->realm_id . '/' . urlencode($guild->name)) ?>" class="bc-guild-card uk-card uk-card-default uk-card-hover uk-card-body uk-display-block">
              <div class="bc-guild-icon">
                <i class="fa-solid fa-shield fa-2x"></i>
              </div>
              <h4 class="bc-guild-name uk-margin-small-top uk-margin-remove-bottom"><?= html_escape($guild->name) ?></h4>
              <div class="bc-guild-meta">
                <span class="uk-text-muted"><i class="fa-solid fa-server"></i> <?= html_escape($guild->realm_name ?? '') ?></span>
                <?php if (isset($guild->member_count)): ?>
                <span class="uk-text-muted uk-margin-small-left"><i class="fa-solid fa-users"></i> <?= $guild->member_count ?></span>
                <?php endif ?>
              </div>
            </a>
          </div>
          <?php endforeach ?>
        </div>
        <?php endif ?>
      </div>
    </div>
    <?php endif ?>
    
    <?php endif ?>

    <!-- Quick Links -->
    <?php if (empty($query) && ! empty($realms)): ?>
    <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match" uk-grid>
      <?php foreach ($realms as $r): ?>
      <div>
        <div class="uk-card uk-card-default uk-card-hover">
          <div class="uk-card-body">
            <h3 class="uk-card-title">
              <i class="fa-solid fa-server"></i> <?= html_escape($r->realm_name) ?>
            </h3>
            <ul class="uk-list uk-list-disc">
              <li>
                <a href="<?= site_url('armory/search?realm=' . $r->id . '&type=character&q=') ?>">
                  <i class="fa-solid fa-user"></i> <?= lang('armory_search_characters') ?>
                </a>
              </li>
              <li>
                <a href="<?= site_url('armory/search?realm=' . $r->id . '&type=guild&q=') ?>">
                  <i class="fa-solid fa-shield"></i> <?= lang('armory_search_guilds') ?>
                </a>
              </li>
              <li>
                <a href="<?= site_url('armory/arena/' . $r->id) ?>">
                  <i class="fa-solid fa-trophy"></i> <?= lang('arena_ladder') ?>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <?php endforeach ?>
    </div>
    <?php endif ?>

  </div>
</section>

<style>
/* Race icons - you can customize these with actual icons */
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

/* Guild Cards */
.bc-guild-card {
  text-align: center;
  text-decoration: none;
  color: inherit;
  transition: all 0.3s ease;
  border-left: 3px solid #c9a227;
}

.bc-guild-card:hover {
  transform: translateY(-5px);
  border-left-color: #ffd700;
  text-decoration: none;
  color: inherit;
}

.bc-guild-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: linear-gradient(135deg, #c9a227 0%, #8b6914 100%);
  color: #fff;
}

.bc-guild-name {
  font-weight: bold;
  font-size: 1rem;
}

.bc-guild-meta {
  font-size: 0.85rem;
}

.bc-guild-meta i {
  margin-right: 3px;
}
</style>
