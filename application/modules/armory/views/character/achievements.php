<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('armory') ?>"><?= lang('armory') ?></a></li>
          <li><a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name)) ?>"><?= html_escape($character->name) ?></a></li>
          <li><span><?= lang('achievements') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <span class="bc-class-<?= $character->class ?>"><?= html_escape($character->name) ?></span>
          - <?= lang('achievements') ?>
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
        <li class="uk-active"><a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name) . '/achievements') ?>"><i class="fa-solid fa-trophy"></i> <?= lang('achievements') ?></a></li>
        <li><a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name) . '/pvp') ?>"><i class="fa-solid fa-shield"></i> <?= lang('pvp') ?></a></li>
      </ul>
    </div>

    <!-- Achievement Summary -->
    <div class="uk-card uk-card-default uk-margin">
      <div class="uk-card-body">
        <div class="uk-grid-small uk-child-width-1-4@m uk-child-width-1-2@s uk-text-center" uk-grid>
          <div>
            <div class="bc-achievement-stat">
              <i class="fa-solid fa-trophy fa-2x uk-text-warning"></i>
              <div class="bc-stat-value"><?= count($achievements) ?></div>
              <div class="bc-stat-label"><?= lang('achievements_completed') ?></div>
            </div>
          </div>
          <div>
            <div class="bc-achievement-stat">
              <i class="fa-solid fa-star fa-2x uk-text-primary"></i>
              <div class="bc-stat-value"><?= count($achievements) * 10 ?></div>
              <div class="bc-stat-label"><?= lang('achievements_points') ?></div>
            </div>
          </div>
          <div>
            <div class="bc-achievement-stat">
              <i class="fa-solid fa-calendar fa-2x uk-text-success"></i>
              <?php
              $recent_count = 0;
              $week_ago = time() - (7 * 24 * 60 * 60);
              foreach ($achievements as $ach) {
                  if (isset($ach->date) && $ach->date > $week_ago) $recent_count++;
              }
              ?>
              <div class="bc-stat-value"><?= $recent_count ?></div>
              <div class="bc-stat-label"><?= lang('achievements_this_week') ?></div>
            </div>
          </div>
          <div>
            <div class="bc-achievement-stat">
              <i class="fa-solid fa-clock fa-2x uk-text-muted"></i>
              <?php
              $latest_date = 0;
              foreach ($achievements as $ach) {
                  if (isset($ach->date) && $ach->date > $latest_date) $latest_date = $ach->date;
              }
              ?>
              <div class="bc-stat-value"><?= $latest_date > 0 ? date('M j', $latest_date) : '-' ?></div>
              <div class="bc-stat-label"><?= lang('achievements_latest') ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="uk-card uk-card-default">
      <div class="uk-card-header">
        <div uk-grid>
          <div class="uk-width-expand">
            <h3 class="uk-card-title"><i class="fa-solid fa-trophy"></i> <?= lang('achievements_recent') ?></h3>
          </div>
          <div class="uk-width-auto">
            <span class="uk-badge uk-badge-large"><?= count($achievements) ?> <?= lang('total') ?></span>
          </div>
        </div>
      </div>
      <div class="uk-card-body">
        <?php if (empty($achievements)): ?>
        <div class="uk-alert uk-alert-warning">
          <p><i class="fa-solid fa-circle-info"></i> <?= lang('achievements_none') ?></p>
        </div>
        <?php else: ?>
        
        <div class="bc-achievements-grid uk-grid-small uk-child-width-1-2@m" uk-grid>
          <?php foreach (array_slice($achievements, 0, 50) as $achievement): ?>
          <div>
            <a href="https://wowhead.com/wrath/achievement=<?= $achievement->achievement ?>" data-wowhead="achievement=<?= $achievement->achievement ?>&domain=wrath" target="_blank" class="bc-achievement-item">
              <div class="bc-achievement-icon">
                <i class="fa-solid fa-trophy"></i>
              </div>
              <div class="bc-achievement-info">
                <div class="bc-achievement-name"><?= lang('achievement') ?> #<?= $achievement->achievement ?></div>
                <div class="bc-achievement-date">
                  <i class="fa-regular fa-calendar"></i>
                  <?= date('M j, Y', $achievement->date) ?>
                </div>
              </div>
              <div class="bc-achievement-points">
                <span class="uk-badge">10</span>
              </div>
            </a>
          </div>
          <?php endforeach ?>
        </div>
        
        <?php if (count($achievements) > 50): ?>
        <div class="uk-text-center uk-margin-top">
          <p class="uk-text-muted">
            <i class="fa-solid fa-ellipsis"></i> 
            <?= lang('showing') ?> 50 <?= lang('of') ?> <?= count($achievements) ?> <?= lang('achievements') ?>
          </p>
        </div>
        <?php endif ?>
        
        <?php endif ?>
      </div>
    </div>
  </div>
</section>

<!-- Wowhead Tooltips -->
<?php if (config_item('armory_wowhead_tooltips')): ?>
<script>const whTooltips = {colorLinks: true, iconizeLinks: true, renameLinks: true};</script>
<script src="https://wow.zamimg.com/js/tooltips.js"></script>
<?php endif ?>

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

/* Achievement Stats */
.bc-achievement-stat {
  padding: 20px;
  background: rgba(0,0,0,0.1);
  border-radius: 8px;
}

.bc-stat-value {
  font-size: 1.5rem;
  font-weight: bold;
  margin: 10px 0 5px;
}

.bc-stat-label {
  font-size: 0.85rem;
  color: #999;
}

/* Achievement Grid */
.bc-achievement-item {
  display: flex;
  align-items: center;
  padding: 12px;
  background: rgba(0,0,0,0.1);
  border-radius: 8px;
  text-decoration: none;
  color: inherit;
  transition: all 0.2s ease;
  border-left: 3px solid transparent;
}

.bc-achievement-item:hover {
  background: rgba(255,255,255,0.05);
  border-left-color: #c9a227;
  transform: translateX(5px);
}

.bc-achievement-icon {
  width: 44px;
  height: 44px;
  background: linear-gradient(135deg, #c9a227 0%, #8b6914 100%);
  border: 2px solid #c9a227;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 1.2rem;
  flex-shrink: 0;
}

.bc-achievement-info {
  flex-grow: 1;
  margin-left: 12px;
  min-width: 0;
}

.bc-achievement-name {
  font-weight: bold;
  color: #c9a227;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.bc-achievement-date {
  font-size: 0.85rem;
  color: #888;
  margin-top: 2px;
}

.bc-achievement-points {
  flex-shrink: 0;
  margin-left: 10px;
}

.bc-achievement-points .uk-badge {
  background: linear-gradient(135deg, #c9a227 0%, #8b6914 100%);
}

.uk-badge-large {
  font-size: 1rem;
  padding: 5px 15px;
}
</style>
