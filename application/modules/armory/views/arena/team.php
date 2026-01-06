<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('armory') ?>"><?= lang('armory') ?></a></li>
          <li><a href="<?= site_url('armory/arena/' . $realm_id) ?>"><?= lang('arena_ladder') ?></a></li>
          <li><span><?= html_escape($team->name) ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <?= html_escape($team->name) ?>
        </h1>
        <p class="uk-text-muted uk-margin-remove">
          <?php
          $type_names = [2 => '2v2', 3 => '3v3', 5 => '5v5'];
          echo ($type_names[$team->type] ?? $team->type) . ' ' . lang('arena_team');
          ?>
          - <?= html_escape($realm->realm_name) ?>
        </p>
      </div>
      <div class="uk-width-auto">
        <a href="<?= site_url('armory/arena/' . $realm_id . '?type=' . ($type_names[$team->type] ?? '2v2')) ?>" class="uk-button uk-button-default">
          <i class="fa-solid fa-arrow-left"></i> <?= lang('arena_ladder') ?>
        </a>
      </div>
    </div>

    <!-- Team Stats Summary -->
    <div class="uk-card uk-card-default uk-margin">
      <div class="uk-card-body">
        <div class="uk-grid-small uk-child-width-1-5@m uk-child-width-1-2@s uk-text-center" uk-grid>
          <div>
            <div class="bc-team-stat">
              <i class="fa-solid fa-users fa-2x"></i>
              <div class="bc-stat-value"><?= $type_names[$team->type] ?? $team->type ?></div>
              <div class="bc-stat-label"><?= lang('type') ?></div>
            </div>
          </div>
          <div>
            <div class="bc-team-stat bc-rating-stat">
              <i class="fa-solid fa-shield fa-2x"></i>
              <div class="bc-stat-value"><?= number_format($team->rating) ?></div>
              <div class="bc-stat-label"><?= lang('arena_rating') ?></div>
            </div>
          </div>
          <div>
            <div class="bc-team-stat">
              <i class="fa-solid fa-trophy fa-2x"></i>
              <div class="bc-stat-value"><?= $team->seasonWins ?></div>
              <div class="bc-stat-label"><?= lang('arena_wins') ?></div>
            </div>
          </div>
          <div>
            <div class="bc-team-stat">
              <i class="fa-solid fa-skull fa-2x"></i>
              <div class="bc-stat-value"><?= $team->seasonGames - $team->seasonWins ?></div>
              <div class="bc-stat-label"><?= lang('arena_losses') ?></div>
            </div>
          </div>
          <div>
            <div class="bc-team-stat">
              <?php
              $win_rate = $team->seasonGames > 0 ? round(($team->seasonWins / $team->seasonGames) * 100, 1) : 0;
              $win_class = $win_rate >= 60 ? 'bc-winrate-high' : ($win_rate >= 40 ? 'bc-winrate-mid' : 'bc-winrate-low');
              ?>
              <i class="fa-solid fa-chart-line fa-2x"></i>
              <div class="bc-stat-value <?= $win_class ?>"><?= $win_rate ?>%</div>
              <div class="bc-stat-label"><?= lang('arena_win_rate') ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div uk-grid>
      <!-- Team Info -->
      <div class="uk-width-1-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-shield-halved"></i> <?= lang('arena_team') ?></h3>
          </div>
          <div class="uk-card-body">
            <!-- Team Emblem Placeholder -->
            <div class="uk-text-center uk-margin">
              <div class="bc-team-emblem" style="background-color: #<?= str_pad(dechex($team->backgroundColor ?? 0), 6, '0', STR_PAD_LEFT) ?>;">
                <div class="bc-emblem-inner">
                  <i class="fa-solid fa-swords fa-3x"></i>
                </div>
              </div>
              <h4 class="uk-margin-small-top uk-margin-remove-bottom"><?= html_escape($team->name) ?></h4>
              <span class="uk-badge bc-team-type-badge"><?= $type_names[$team->type] ?? $team->type ?></span>
            </div>

            <hr>

            <!-- Season Stats -->
            <div class="bc-detailed-stats">
              <h5 class="uk-text-uppercase uk-text-muted"><i class="fa-solid fa-calendar"></i> <?= lang('arena_season') ?></h5>
              <div class="bc-stat-row">
                <span class="bc-stat-name"><?= lang('arena_games') ?></span>
                <span class="bc-stat-number"><?= $team->seasonGames ?></span>
              </div>
              <div class="bc-stat-row">
                <span class="bc-stat-name"><?= lang('arena_wins') ?></span>
                <span class="bc-stat-number uk-text-success"><?= $team->seasonWins ?></span>
              </div>
              <div class="bc-stat-row">
                <span class="bc-stat-name"><?= lang('arena_losses') ?></span>
                <span class="bc-stat-number uk-text-danger"><?= $team->seasonGames - $team->seasonWins ?></span>
              </div>
              <div class="bc-progress-bar uk-margin-small-top">
                <?php $season_win_pct = $team->seasonGames > 0 ? ($team->seasonWins / $team->seasonGames) * 100 : 0; ?>
                <div class="bc-progress-fill bc-progress-wins" style="width: <?= $season_win_pct ?>%;"></div>
              </div>
            </div>

            <hr>

            <!-- Week Stats -->
            <div class="bc-detailed-stats">
              <h5 class="uk-text-uppercase uk-text-muted"><i class="fa-solid fa-clock"></i> <?= lang('arena_week') ?></h5>
              <div class="bc-stat-row">
                <span class="bc-stat-name"><?= lang('arena_games') ?></span>
                <span class="bc-stat-number"><?= $team->weekGames ?></span>
              </div>
              <div class="bc-stat-row">
                <span class="bc-stat-name"><?= lang('arena_wins') ?></span>
                <span class="bc-stat-number uk-text-success"><?= $team->weekWins ?></span>
              </div>
              <div class="bc-stat-row">
                <span class="bc-stat-name"><?= lang('arena_losses') ?></span>
                <span class="bc-stat-number uk-text-danger"><?= $team->weekGames - $team->weekWins ?></span>
              </div>
              <div class="bc-progress-bar uk-margin-small-top">
                <?php $week_win_pct = $team->weekGames > 0 ? ($team->weekWins / $team->weekGames) * 100 : 0; ?>
                <div class="bc-progress-fill bc-progress-wins" style="width: <?= $week_win_pct ?>%;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Team Members -->
      <div class="uk-width-2-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-users"></i> <?= lang('arena_members') ?> <span class="uk-badge"><?= count($members ?? []) ?></span></h3>
          </div>
          <div class="uk-card-body">
            <?php if (empty($members)): ?>
            <div class="uk-alert uk-alert-warning">
              <p><i class="fa-solid fa-circle-info"></i> No members found.</p>
            </div>
            <?php else: ?>
            
            <!-- Member Cards for Mobile -->
            <div class="uk-hidden@m">
              <?php foreach ($members as $member): ?>
              <div class="bc-member-card uk-margin-small">
                <div class="bc-member-header">
                  <span class="bc-race-icon bc-race-<?= $member->race ?>-<?= $member->gender ?>"></span>
                  <span class="bc-class-<?= $member->class ?> uk-text-bold"><?= html_escape($member->name) ?></span>
                  <?php if ($member->guid == $team->captainGuid): ?>
                  <span class="uk-label uk-label-warning"><i class="fa-solid fa-crown"></i></span>
                  <?php endif ?>
                </div>
                <div class="bc-member-stats">
                  <div>
                    <span class="bc-stat-label"><?= lang('arena_personal_rating') ?></span>
                    <span class="bc-stat-value uk-text-warning"><?= number_format($member->personalRating) ?></span>
                  </div>
                  <div>
                    <span class="bc-stat-label"><?= lang('arena_season') ?></span>
                    <span class="bc-stat-value">
                      <span class="uk-text-success"><?= $member->seasonWins ?></span>-<span class="uk-text-danger"><?= $member->seasonGames - $member->seasonWins ?></span>
                    </span>
                  </div>
                </div>
                <a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($member->name)) ?>" class="uk-button uk-button-small uk-button-primary uk-width-1-1">
                  <i class="fa-solid fa-eye"></i> <?= lang('view_profile') ?>
                </a>
              </div>
              <?php endforeach ?>
            </div>

            <!-- Member Table for Desktop -->
            <div class="uk-visible@m uk-overflow-auto">
              <table class="uk-table uk-table-middle uk-table-divider uk-table-hover uk-table-small bc-members-table">
                <thead>
                  <tr>
                    <th><?= lang('character') ?></th>
                    <th class="uk-text-center"><?= lang('character_level') ?></th>
                    <th><?= lang('character_class') ?></th>
                    <th class="uk-text-center"><?= lang('arena_personal_rating') ?></th>
                    <th class="uk-text-center"><?= lang('arena_season') ?></th>
                    <th class="uk-text-center"><?= lang('arena_week') ?></th>
                    <th class="uk-text-center"><?= lang('arena_win_rate') ?></th>
                    <th class="uk-text-center"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($members as $member): ?>
                  <?php
                  $member_win_rate = $member->seasonGames > 0 ? round(($member->seasonWins / $member->seasonGames) * 100, 1) : 0;
                  $member_win_class = $member_win_rate >= 60 ? 'bc-winrate-high' : ($member_win_rate >= 40 ? 'bc-winrate-mid' : 'bc-winrate-low');
                  ?>
                  <tr class="<?= $member->guid == $team->captainGuid ? 'bc-captain-row' : '' ?>">
                    <td>
                      <div class="uk-flex uk-flex-middle">
                        <span class="bc-race-icon bc-race-<?= $member->race ?>-<?= $member->gender ?>"></span>
                        <span class="uk-margin-small-left uk-text-bold"><?= html_escape($member->name) ?></span>
                        <?php if ($member->guid == $team->captainGuid): ?>
                        <span class="uk-label uk-label-warning uk-margin-small-left" title="<?= lang('arena_captain') ?>">
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
                    <td class="uk-text-center">
                      <span class="bc-personal-rating"><?= number_format($member->personalRating) ?></span>
                    </td>
                    <td class="uk-text-center">
                      <span class="uk-text-success"><?= $member->seasonWins ?></span>
                      <span class="bc-separator">-</span>
                      <span class="uk-text-danger"><?= $member->seasonGames - $member->seasonWins ?></span>
                    </td>
                    <td class="uk-text-center">
                      <span class="uk-text-success"><?= $member->weekWins ?></span>
                      <span class="bc-separator">-</span>
                      <span class="uk-text-danger"><?= $member->weekGames - $member->weekWins ?></span>
                    </td>
                    <td class="uk-text-center">
                      <span class="bc-winrate <?= $member_win_class ?>"><?= $member_win_rate ?>%</span>
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
/* Team Stats Summary */
.bc-team-stat {
  padding: 15px;
}

.bc-team-stat i {
  color: #888;
}

.bc-rating-stat i {
  color: #ffd700;
}

.bc-team-stat .bc-stat-value {
  font-size: 1.8rem;
  font-weight: bold;
  margin: 10px 0 5px;
}

.bc-team-stat .bc-stat-label {
  font-size: 0.8rem;
  color: #888;
}

/* Team Emblem */
.bc-team-emblem {
  width: 120px;
  height: 120px;
  margin: 0 auto;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 3px solid #c9a227;
  background: linear-gradient(135deg, #1e3a5f 0%, #0d1b2a 100%);
  position: relative;
  overflow: hidden;
}

.bc-emblem-inner {
  color: rgba(255, 255, 255, 0.8);
}

.bc-team-type-badge {
  background: linear-gradient(135deg, #c9a227 0%, #8b6914 100%);
  font-size: 1rem;
  padding: 5px 15px;
}

/* Detailed Stats */
.bc-detailed-stats h5 {
  font-size: 0.8rem;
  letter-spacing: 1px;
  margin-bottom: 10px;
}

.bc-stat-row {
  display: flex;
  justify-content: space-between;
  padding: 5px 0;
}

.bc-stat-name {
  color: #888;
}

.bc-stat-number {
  font-weight: bold;
}

/* Progress Bar */
.bc-progress-bar {
  height: 6px;
  background: rgba(255, 0, 0, 0.3);
  border-radius: 3px;
  overflow: hidden;
}

.bc-progress-fill {
  height: 100%;
  border-radius: 3px;
  transition: width 0.5s ease;
}

.bc-progress-wins {
  background: linear-gradient(90deg, #00ff00, #00cc00);
}

/* Member Cards (Mobile) */
.bc-member-card {
  background: rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  padding: 15px;
  border-left: 3px solid #c9a227;
}

.bc-member-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
}

.bc-member-stats {
  display: flex;
  justify-content: space-around;
  margin-bottom: 10px;
  text-align: center;
}

.bc-member-stats .bc-stat-label {
  font-size: 0.75rem;
  color: #888;
  display: block;
}

.bc-member-stats .bc-stat-value {
  font-weight: bold;
}

/* Members Table */
.bc-members-table tbody tr {
  transition: all 0.2s ease;
}

.bc-members-table tbody tr:hover {
  background: rgba(201, 162, 39, 0.1);
}

.bc-captain-row {
  background: rgba(201, 162, 39, 0.05);
}

.bc-personal-rating {
  font-weight: bold;
  color: #ffd700;
}

.bc-separator {
  color: #666;
  margin: 0 3px;
}

/* Win Rate Badges */
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

/* Race Icons */
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

/* Class Colors */
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
