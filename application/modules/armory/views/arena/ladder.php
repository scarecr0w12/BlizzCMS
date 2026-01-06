<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('armory') ?>"><?= lang('armory') ?></a></li>
          <li><span><?= lang('arena_ladder') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-trophy"></i> <?= lang('arena_ladder') ?>
        </h1>
      </div>
      <div class="uk-width-auto uk-flex uk-flex-middle">
        <!-- Realm Selector -->
        <?php if (count($all_realms ?? []) > 1): ?>
        <div class="uk-margin-small-right">
          <select class="uk-select" id="realm-selector" onchange="changeRealm(this.value)">
            <?php foreach ($all_realms as $r): ?>
            <option value="<?= $r->id ?>" <?= $r->id == $realm_id ? 'selected' : '' ?>><?= html_escape($r->realm_name) ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <?php else: ?>
        <span class="uk-badge uk-badge-secondary uk-margin-small-right"><?= html_escape($realm->realm_name) ?></span>
        <?php endif ?>
        <a href="<?= site_url('armory') ?>" class="uk-button uk-button-default">
          <i class="fa-solid fa-arrow-left"></i> <?= lang('back_to_search') ?>
        </a>
      </div>
    </div>

    <!-- Stats Summary -->
    <div class="uk-card uk-card-default uk-margin">
      <div class="uk-card-body">
        <div class="uk-grid-small uk-child-width-1-3@m uk-text-center" uk-grid>
          <div>
            <div class="bc-arena-stat">
              <i class="fa-solid fa-trophy fa-2x uk-text-warning"></i>
              <div class="bc-stat-value"><?= count($teams ?? []) ?></div>
              <div class="bc-stat-label"><?= lang('arena_active_teams') ?></div>
            </div>
          </div>
          <div>
            <div class="bc-arena-stat">
              <i class="fa-solid fa-shield fa-2x uk-text-primary"></i>
              <div class="bc-stat-value"><?= !empty($teams) ? number_format($teams[0]->rating ?? 0) : 0 ?></div>
              <div class="bc-stat-label"><?= lang('arena_top_rating') ?></div>
            </div>
          </div>
          <div>
            <div class="bc-arena-stat">
              <i class="fa-solid fa-server fa-2x uk-text-success"></i>
              <div class="bc-stat-value"><?= html_escape($realm->realm_name) ?></div>
              <div class="bc-stat-label"><?= lang('realm') ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Arena Type Tabs -->
    <div class="uk-margin">
      <ul class="uk-subnav uk-subnav-pill bc-arena-tabs">
        <?php foreach ($arena_types as $type): ?>
        <li class="<?= $arena_type === $type ? 'uk-active' : '' ?>">
          <a href="<?= site_url('armory/arena/' . $realm_id . '?type=' . $type) ?>" class="bc-arena-type-btn">
            <span class="bc-type-icon"><?= $type ?></span>
            <span class="bc-type-label"><?= lang('arena_' . str_replace('v', 'vs', $type)) ?></span>
          </a>
        </li>
        <?php endforeach ?>
      </ul>
    </div>

    <div class="uk-card uk-card-default">
      <div class="uk-card-header">
        <h3 class="uk-card-title">
          <i class="fa-solid fa-ranking-star"></i> <?= $arena_type ?> <?= lang('arena_ladder') ?>
        </h3>
      </div>
      <div class="uk-card-body">
        <?php if (empty($teams)): ?>
        <div class="uk-alert uk-alert-warning">
          <p><i class="fa-solid fa-circle-info"></i> <?= lang('arena_no_teams') ?></p>
        </div>
        <?php else: ?>
        <div class="uk-overflow-auto">
          <table class="uk-table uk-table-middle uk-table-divider uk-table-hover uk-table-small bc-arena-table">
            <thead>
              <tr>
                <th class="uk-text-center" style="width: 60px;"><?= lang('arena_rank') ?></th>
                <th><?= lang('arena_team') ?></th>
                <th class="uk-text-center"><?= lang('arena_rating') ?></th>
                <th class="uk-text-center"><?= lang('arena_season') ?></th>
                <th class="uk-text-center"><?= lang('arena_week') ?></th>
                <th class="uk-text-center"><?= lang('arena_win_rate') ?></th>
                <th class="uk-text-center"></th>
              </tr>
            </thead>
            <tbody>
              <?php $rank = 1; foreach ($teams as $team): ?>
              <tr class="<?= $rank <= 3 ? 'bc-top-team' : '' ?>">
                <td class="uk-text-center">
                  <?php if ($rank <= 3): ?>
                  <span class="bc-rank-medal bc-rank-<?= $rank ?>">
                    <i class="fa-solid fa-medal"></i>
                    <span class="bc-rank-number"><?= $rank ?></span>
                  </span>
                  <?php else: ?>
                  <span class="bc-rank-regular">#<?= $rank ?></span>
                  <?php endif ?>
                </td>
                <td>
                  <a href="<?= site_url('armory/arena/' . $realm_id . '/team/' . $team->arenaTeamId) ?>" class="bc-team-link">
                    <span class="bc-team-name"><?= html_escape($team->name) ?></span>
                  </a>
                </td>
                <td class="uk-text-center">
                  <span class="bc-rating"><?= number_format($team->rating) ?></span>
                </td>
                <td class="uk-text-center">
                  <span class="bc-season-record">
                    <span class="uk-text-success"><?= $team->seasonWins ?></span>
                    <span class="bc-separator">-</span>
                    <span class="uk-text-danger"><?= $team->seasonGames - $team->seasonWins ?></span>
                  </span>
                </td>
                <td class="uk-text-center">
                  <span class="bc-week-record">
                    <span class="uk-text-success"><?= $team->weekWins ?></span>
                    <span class="bc-separator">-</span>
                    <span class="uk-text-danger"><?= $team->weekGames - $team->weekWins ?></span>
                  </span>
                </td>
                <td class="uk-text-center">
                  <?php
                  $win_rate = $team->seasonGames > 0 ? round(($team->seasonWins / $team->seasonGames) * 100, 1) : 0;
                  $win_class = $win_rate >= 60 ? 'bc-winrate-high' : ($win_rate >= 40 ? 'bc-winrate-mid' : 'bc-winrate-low');
                  ?>
                  <span class="bc-winrate <?= $win_class ?>"><?= $win_rate ?>%</span>
                </td>
                <td class="uk-text-center">
                  <a href="<?= site_url('armory/arena/' . $realm_id . '/team/' . $team->arenaTeamId) ?>" class="uk-button uk-button-small uk-button-primary">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                </td>
              </tr>
              <?php $rank++; endforeach ?>
            </tbody>
          </table>
        </div>
        <?php endif ?>
      </div>
    </div>
  </div>
</section>

<script>
function changeRealm(realmId) {
  const currentUrl = new URL(window.location.href);
  const type = currentUrl.searchParams.get('type') || '2v2';
  window.location.href = '<?= site_url('armory/arena/') ?>' + realmId + '?type=' + type;
}
</script>

<style>
/* Arena Stats Summary */
.bc-arena-stat {
  padding: 20px;
}

.bc-arena-stat .bc-stat-value {
  font-size: 1.8rem;
  font-weight: bold;
  margin: 10px 0 5px;
}

.bc-arena-stat .bc-stat-label {
  font-size: 0.85rem;
  color: #888;
}

/* Arena Type Tabs */
.bc-arena-tabs > li > a {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 15px 25px;
  border-radius: 8px;
  background: rgba(0,0,0,0.1);
  transition: all 0.3s ease;
}

.bc-arena-tabs > li.uk-active > a {
  background: linear-gradient(135deg, #c9a227 0%, #8b6914 100%);
  color: #fff;
}

.bc-arena-tabs > li > a:hover {
  background: rgba(201, 162, 39, 0.3);
}

.bc-type-icon {
  font-size: 1.5rem;
  font-weight: bold;
}

.bc-type-label {
  font-size: 0.75rem;
  margin-top: 5px;
}

/* Arena Table */
.bc-arena-table tbody tr {
  transition: all 0.2s ease;
}

.bc-arena-table tbody tr:hover {
  background: rgba(201, 162, 39, 0.1);
}

.bc-top-team {
  background: rgba(201, 162, 39, 0.05);
}

/* Rank Medals */
.bc-rank-medal {
  display: inline-flex;
  flex-direction: column;
  align-items: center;
  font-size: 1.5rem;
  line-height: 1;
}

.bc-rank-medal .bc-rank-number {
  font-size: 0.7rem;
  font-weight: bold;
  margin-top: -5px;
}

.bc-rank-1 { color: #FFD700; }
.bc-rank-2 { color: #C0C0C0; }
.bc-rank-3 { color: #CD7F32; }

.bc-rank-regular {
  color: #888;
  font-weight: normal;
}

/* Team Link */
.bc-team-link {
  text-decoration: none;
}

.bc-team-name {
  font-weight: bold;
  color: inherit;
}

.bc-team-link:hover .bc-team-name {
  color: #c9a227;
}

/* Rating */
.bc-rating {
  font-size: 1.2rem;
  font-weight: bold;
  color: #ffd700;
  text-shadow: 0 0 5px rgba(255, 215, 0, 0.3);
}

/* Records */
.bc-season-record,
.bc-week-record {
  font-weight: 500;
}

.bc-separator {
  color: #666;
  margin: 0 3px;
}

/* Win Rate */
.bc-winrate {
  font-weight: bold;
  padding: 3px 8px;
  border-radius: 4px;
}

.bc-winrate-high {
  background: rgba(0, 128, 0, 0.2);
  color: #00ff00;
}

.bc-winrate-mid {
  background: rgba(255, 165, 0, 0.2);
  color: #ffa500;
}

.bc-winrate-low {
  background: rgba(255, 0, 0, 0.2);
  color: #ff6b6b;
}
</style>
