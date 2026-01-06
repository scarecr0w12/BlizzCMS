<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('armory') ?>"><?= lang('armory') ?></a></li>
          <li><a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name)) ?>"><?= html_escape($character->name) ?></a></li>
          <li><span><?= lang('pvp') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <span class="bc-class-<?= $character->class ?>"><?= html_escape($character->name) ?></span>
          - <?= lang('pvp') ?>
        </h1>
      </div>
      <div class="uk-width-auto">
        <a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name)) ?>" class="uk-button uk-button-default">
          <i class="fa-solid fa-arrow-left"></i> <?= lang('character_profile') ?>
        </a>
      </div>
    </div>

    <!-- Character Navigation -->
    <div class="uk-margin">
      <ul class="uk-subnav uk-subnav-pill">
        <li><a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name)) ?>"><i class="fa-solid fa-user"></i> <?= lang('character_profile') ?></a></li>
        <li><a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name) . '/talents') ?>"><i class="fa-solid fa-book"></i> <?= lang('talents') ?></a></li>
        <li><a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name) . '/achievements') ?>"><i class="fa-solid fa-trophy"></i> <?= lang('achievements') ?></a></li>
        <li class="uk-active"><a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name) . '/pvp') ?>"><i class="fa-solid fa-shield"></i> <?= lang('pvp') ?></a></li>
      </ul>
    </div>

    <!-- PvP Summary Stats -->
    <div class="uk-card uk-card-default uk-margin">
      <div class="uk-card-body">
        <div class="uk-grid-small uk-child-width-1-3@m uk-child-width-1-1@s uk-text-center" uk-grid>
          <div>
            <div class="bc-pvp-stat bc-pvp-kills">
              <i class="fa-solid fa-skull fa-2x"></i>
              <div class="bc-stat-value"><?= number_format($pvp_stats->total_kills ?? 0) ?></div>
              <div class="bc-stat-label"><?= lang('pvp_total_kills') ?></div>
            </div>
          </div>
          <div>
            <div class="bc-pvp-stat bc-pvp-honor">
              <i class="fa-solid fa-medal fa-2x"></i>
              <div class="bc-stat-value"><?= number_format($character->honor ?? 0) ?></div>
              <div class="bc-stat-label"><?= lang('pvp_honor_points') ?></div>
            </div>
          </div>
          <div>
            <div class="bc-pvp-stat bc-pvp-arena">
              <i class="fa-solid fa-shield-halved fa-2x"></i>
              <div class="bc-stat-value"><?= number_format($character->arenaPoints ?? 0) ?></div>
              <div class="bc-stat-label"><?= lang('pvp_arena_points') ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div uk-grid>
      <!-- Detailed Kill Stats -->
      <div class="uk-width-1-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-skull-crossbones"></i> <?= lang('pvp_kills') ?></h3>
          </div>
          <div class="uk-card-body">
            <div class="bc-kill-stats">
              <div class="bc-kill-stat uk-margin-small">
                <div class="bc-kill-label"><?= lang('pvp_today_kills') ?></div>
                <div class="bc-kill-value uk-text-success"><?= number_format($pvp_stats->today_kills ?? 0) ?></div>
              </div>
              <div class="bc-kill-stat uk-margin-small">
                <div class="bc-kill-label"><?= lang('pvp_yesterday_kills') ?></div>
                <div class="bc-kill-value"><?= number_format($pvp_stats->yesterday_kills ?? 0) ?></div>
              </div>
              <div class="bc-kill-stat uk-margin-small">
                <div class="bc-kill-label"><?= lang('pvp_this_week_kills') ?></div>
                <div class="bc-kill-value"><?= number_format($pvp_stats->week_kills ?? ($pvp_stats->today_kills ?? 0) + ($pvp_stats->yesterday_kills ?? 0)) ?></div>
              </div>
              <hr>
              <div class="bc-kill-stat">
                <div class="bc-kill-label uk-text-bold"><?= lang('pvp_total_kills') ?></div>
                <div class="bc-kill-value uk-text-danger uk-text-large"><?= number_format($pvp_stats->total_kills ?? 0) ?></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Honor Info -->
        <div class="uk-card uk-card-default uk-margin">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-medal"></i> <?= lang('pvp_honor') ?></h3>
          </div>
          <div class="uk-card-body">
            <dl class="uk-description-list uk-description-list-divider">
              <dt><?= lang('pvp_honor_points') ?></dt>
              <dd>
                <span class="bc-honor-badge">
                  <i class="fa-solid fa-medal"></i> <?= number_format($character->honor ?? 0) ?>
                </span>
              </dd>
              <dt><?= lang('pvp_arena_points') ?></dt>
              <dd>
                <span class="bc-arena-badge">
                  <i class="fa-solid fa-shield-halved"></i> <?= number_format($character->arenaPoints ?? 0) ?>
                </span>
              </dd>
            </dl>
          </div>
        </div>
      </div>

      <!-- Arena Teams -->
      <div class="uk-width-2-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-users"></i> <?= lang('arena_teams') ?></h3>
          </div>
          <div class="uk-card-body">
            <?php if (empty($arena_teams)): ?>
            <div class="uk-alert uk-alert-warning">
              <p><i class="fa-solid fa-circle-info"></i> <?= lang('arena_no_teams') ?></p>
            </div>
            <?php else: ?>
            <div class="bc-arena-teams">
              <?php foreach ($arena_teams as $team): ?>
              <div class="bc-arena-team-card uk-margin">
                <div class="bc-team-header">
                  <div class="bc-team-type">
                    <?php
                    $type_names = [2 => '2v2', 3 => '3v3', 5 => '5v5'];
                    echo $type_names[$team->type] ?? $team->type;
                    ?>
                  </div>
                  <a href="<?= site_url('armory/arena/' . $realm_id . '/team/' . $team->arenaTeamId) ?>" class="bc-team-name">
                    <?= html_escape($team->name) ?>
                  </a>
                </div>
                <div class="bc-team-stats uk-grid-small uk-child-width-1-4" uk-grid>
                  <div>
                    <div class="bc-team-stat">
                      <div class="bc-stat-label"><?= lang('arena_team_rating') ?></div>
                      <div class="bc-stat-value uk-text-warning"><?= number_format($team->rating) ?></div>
                    </div>
                  </div>
                  <div>
                    <div class="bc-team-stat">
                      <div class="bc-stat-label"><?= lang('arena_personal_rating') ?></div>
                      <div class="bc-stat-value uk-text-success"><?= number_format($team->personalRating ?? 0) ?></div>
                    </div>
                  </div>
                  <div>
                    <div class="bc-team-stat">
                      <div class="bc-stat-label"><?= lang('arena_season') ?></div>
                      <div class="bc-stat-value">
                        <span class="uk-text-success"><?= $team->memberSeasonWins ?? 0 ?>W</span>
                        /
                        <span class="uk-text-danger"><?= ($team->memberSeasonGames ?? 0) - ($team->memberSeasonWins ?? 0) ?>L</span>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="bc-team-stat">
                      <div class="bc-stat-label"><?= lang('arena_win_rate') ?></div>
                      <?php
                      $games = $team->memberSeasonGames ?? 0;
                      $wins = $team->memberSeasonWins ?? 0;
                      $win_rate = $games > 0 ? round(($wins / $games) * 100, 1) : 0;
                      $win_class = $win_rate >= 60 ? 'uk-text-success' : ($win_rate >= 40 ? 'uk-text-warning' : 'uk-text-danger');
                      ?>
                      <div class="bc-stat-value <?= $win_class ?>"><?= $win_rate ?>%</div>
                    </div>
                  </div>
                </div>
                <div class="bc-team-footer">
                  <a href="<?= site_url('armory/arena/' . $realm_id . '/team/' . $team->arenaTeamId) ?>" class="uk-button uk-button-small uk-button-primary">
                    <i class="fa-solid fa-eye"></i> <?= lang('view_team') ?>
                  </a>
                </div>
              </div>
              <?php endforeach ?>
            </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
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

/* PvP Stats Summary */
.bc-pvp-stat {
  padding: 25px 20px;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.bc-pvp-stat:hover {
  transform: translateY(-5px);
}

.bc-pvp-kills {
  background: linear-gradient(135deg, rgba(220,20,60,0.2) 0%, rgba(139,0,0,0.2) 100%);
  color: #dc143c;
}

.bc-pvp-honor {
  background: linear-gradient(135deg, rgba(255,215,0,0.2) 0%, rgba(184,134,11,0.2) 100%);
  color: #ffd700;
}

.bc-pvp-arena {
  background: linear-gradient(135deg, rgba(30,144,255,0.2) 0%, rgba(0,0,139,0.2) 100%);
  color: #1e90ff;
}

.bc-pvp-stat .bc-stat-value {
  font-size: 2rem;
  font-weight: bold;
  margin: 10px 0 5px;
}

.bc-pvp-stat .bc-stat-label {
  font-size: 0.9rem;
  opacity: 0.8;
}

/* Kill Stats */
.bc-kill-stat {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  background: rgba(0,0,0,0.1);
  border-radius: 4px;
}

.bc-kill-label {
  color: #999;
}

.bc-kill-value {
  font-weight: bold;
}

.bc-kill-value.uk-text-large {
  font-size: 1.5rem;
}

/* Honor/Arena Badges */
.bc-honor-badge,
.bc-arena-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 16px;
  border-radius: 20px;
  font-weight: bold;
}

.bc-honor-badge {
  background: linear-gradient(135deg, #ffd700 0%, #b8860b 100%);
  color: #000;
}

.bc-arena-badge {
  background: linear-gradient(135deg, #1e90ff 0%, #0000cd 100%);
  color: #fff;
}

/* Arena Team Cards */
.bc-arena-team-card {
  background: rgba(0,0,0,0.1);
  border-radius: 8px;
  padding: 15px;
  border-left: 4px solid #c9a227;
}

.bc-team-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 15px;
}

.bc-team-type {
  background: linear-gradient(135deg, #c9a227 0%, #8b6914 100%);
  color: #fff;
  padding: 5px 12px;
  border-radius: 4px;
  font-weight: bold;
  font-size: 0.85rem;
}

.bc-team-name {
  font-size: 1.2rem;
  font-weight: bold;
  color: inherit;
}

.bc-team-name:hover {
  color: #c9a227;
}

.bc-team-stat {
  text-align: center;
}

.bc-team-stat .bc-stat-label {
  font-size: 0.75rem;
  color: #888;
  margin-bottom: 5px;
}

.bc-team-stat .bc-stat-value {
  font-weight: bold;
}

.bc-team-footer {
  margin-top: 15px;
  text-align: right;
}
</style>
