<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('armory') ?>"><?= lang('armory') ?></a></li>
          <li><a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name)) ?>"><?= html_escape($character->name) ?></a></li>
          <li><span><?= lang('talents') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <span class="bc-class-<?= $character->class ?>"><?= html_escape($character->name) ?></span>
          - <?= lang('talents') ?>
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
        <li class="uk-active"><a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name) . '/talents') ?>"><i class="fa-solid fa-book"></i> <?= lang('talents') ?></a></li>
        <li><a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name) . '/achievements') ?>"><i class="fa-solid fa-trophy"></i> <?= lang('achievements') ?></a></li>
        <li><a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name) . '/pvp') ?>"><i class="fa-solid fa-shield"></i> <?= lang('pvp') ?></a></li>
      </ul>
    </div>

    <?php
    // Class talent tree names (WotLK)
    $class_specs = [
        1 => ['Arms', 'Fury', 'Protection'],           // Warrior
        2 => ['Holy', 'Protection', 'Retribution'],    // Paladin
        3 => ['Beast Mastery', 'Marksmanship', 'Survival'], // Hunter
        4 => ['Assassination', 'Combat', 'Subtlety'],  // Rogue
        5 => ['Discipline', 'Holy', 'Shadow'],         // Priest
        6 => ['Blood', 'Frost', 'Unholy'],             // Death Knight
        7 => ['Elemental', 'Enhancement', 'Restoration'], // Shaman
        8 => ['Arcane', 'Fire', 'Frost'],              // Mage
        9 => ['Affliction', 'Demonology', 'Destruction'], // Warlock
        11 => ['Balance', 'Feral Combat', 'Restoration'], // Druid
    ];
    $specs = $class_specs[$character->class] ?? ['Spec 1', 'Spec 2', 'Spec 3'];
    
    // Count talents per spec (simplified - real implementation would need DBC data)
    $spec_counts = [0, 0, 0];
    if (! empty($talents)) {
        foreach ($talents as $talent) {
            $mask = $talent->specMask ?? 0;
            if ($mask & 1) $spec_counts[0]++;
            if ($mask & 2) $spec_counts[1]++;
            if ($mask & 4) $spec_counts[2]++;
        }
    }
    $total_points = count($talents);
    ?>

    <div uk-grid>
      <!-- Talent Specs Overview -->
      <div class="uk-width-1-1">
        <div class="uk-card uk-card-default uk-margin">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-star"></i> <?= lang('talents_spec') ?></h3>
          </div>
          <div class="uk-card-body">
            <?php if (empty($talents)): ?>
            <div class="uk-alert uk-alert-warning">
              <p><i class="fa-solid fa-circle-info"></i> <?= lang('talents_none') ?></p>
            </div>
            <?php else: ?>
            <div class="uk-grid-small uk-child-width-1-3@m uk-text-center" uk-grid>
              <?php foreach ($specs as $index => $spec_name): ?>
              <div>
                <div class="bc-talent-spec bc-spec-<?= $index ?> <?= $spec_counts[$index] > $spec_counts[($index+1)%3] && $spec_counts[$index] > $spec_counts[($index+2)%3] ? 'bc-spec-primary' : '' ?>">
                  <div class="bc-spec-icon bc-class-bg-<?= $character->class ?>">
                    <i class="fa-solid fa-<?= $index == 0 ? 'sword' : ($index == 1 ? 'shield-halved' : 'wand-magic-sparkles') ?>"></i>
                  </div>
                  <h4 class="uk-margin-small"><?= html_escape($spec_name) ?></h4>
                  <div class="bc-spec-points">
                    <span class="uk-text-large uk-text-bold"><?= $spec_counts[$index] ?></span>
                    <span class="uk-text-muted">points</span>
                  </div>
                  <div class="bc-spec-bar">
                    <div class="bc-spec-fill" style="width: <?= $total_points > 0 ? round(($spec_counts[$index] / max($total_points, 71)) * 100) : 0 ?>%"></div>
                  </div>
                </div>
              </div>
              <?php endforeach ?>
            </div>
            
            <div class="uk-text-center uk-margin-top">
              <span class="uk-badge uk-badge-large bc-class-bg-<?= $character->class ?>">
                <?= $spec_counts[0] ?> / <?= $spec_counts[1] ?> / <?= $spec_counts[2] ?>
              </span>
              <p class="uk-text-muted uk-margin-small-top">
                <?= $total_points ?> <?= lang('talents_total_points') ?>
              </p>
            </div>
            <?php endif ?>
          </div>
        </div>
      </div>

      <!-- Talents List -->
      <div class="uk-width-2-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-book"></i> <?= lang('talents_learned') ?></h3>
          </div>
          <div class="uk-card-body">
            <?php if (empty($talents)): ?>
            <div class="uk-alert uk-alert-warning">
              <p><i class="fa-solid fa-circle-info"></i> <?= lang('talents_none') ?></p>
            </div>
            <?php else: ?>
            <div class="bc-talents-grid uk-grid-small uk-child-width-1-4@m uk-child-width-1-3@s uk-child-width-1-2" uk-grid>
              <?php foreach (array_slice($talents, 0, 40) as $talent): ?>
              <div>
                <a href="https://wowhead.com/wrath/spell=<?= $talent->spell ?>" data-wowhead="spell=<?= $talent->spell ?>&domain=wrath" target="_blank" class="bc-talent-item">
                  <div class="bc-talent-icon">
                    <i class="fa-solid fa-sparkles"></i>
                  </div>
                </a>
              </div>
              <?php endforeach ?>
            </div>
            <?php if (count($talents) > 40): ?>
            <p class="uk-text-muted uk-text-center uk-margin-top">
              <i class="fa-solid fa-ellipsis"></i> <?= lang('showing') ?> 40 <?= lang('of') ?> <?= count($talents) ?> <?= lang('talents') ?>
            </p>
            <?php endif ?>
            <?php endif ?>
          </div>
        </div>
      </div>

      <!-- Glyphs -->
      <div class="uk-width-1-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-scroll"></i> <?= lang('glyphs') ?></h3>
          </div>
          <div class="uk-card-body">
            <?php if (empty($glyphs)): ?>
            <div class="uk-alert uk-alert-warning">
              <p><i class="fa-solid fa-circle-info"></i> <?= lang('glyphs_none') ?></p>
            </div>
            <?php else: ?>
            
            <!-- Major Glyphs -->
            <h4 class="uk-text-bold"><?= lang('glyphs_major') ?></h4>
            <div class="bc-glyphs-list uk-margin-bottom">
              <?php 
              $major_slots = ['glyph1', 'glyph2', 'glyph3'];
              foreach ($glyphs as $glyph_set):
                foreach ($major_slots as $slot):
                  if (isset($glyph_set->$slot) && $glyph_set->$slot > 0):
              ?>
              <div class="bc-glyph-item uk-margin-small">
                <a href="https://wowhead.com/wrath/spell=<?= $glyph_set->$slot ?>" data-wowhead="spell=<?= $glyph_set->$slot ?>&domain=wrath" target="_blank" class="bc-glyph-link">
                  <div class="bc-glyph-icon bc-glyph-major">
                    <i class="fa-solid fa-scroll"></i>
                  </div>
                  <span><?= lang('glyph') ?></span>
                </a>
              </div>
              <?php 
                  endif;
                endforeach;
              endforeach;
              ?>
            </div>
            
            <!-- Minor Glyphs -->
            <h4 class="uk-text-bold"><?= lang('glyphs_minor') ?></h4>
            <div class="bc-glyphs-list">
              <?php 
              $minor_slots = ['glyph4', 'glyph5', 'glyph6'];
              foreach ($glyphs as $glyph_set):
                foreach ($minor_slots as $slot):
                  if (isset($glyph_set->$slot) && $glyph_set->$slot > 0):
              ?>
              <div class="bc-glyph-item uk-margin-small">
                <a href="https://wowhead.com/wrath/spell=<?= $glyph_set->$slot ?>" data-wowhead="spell=<?= $glyph_set->$slot ?>&domain=wrath" target="_blank" class="bc-glyph-link">
                  <div class="bc-glyph-icon bc-glyph-minor">
                    <i class="fa-solid fa-scroll"></i>
                  </div>
                  <span><?= lang('glyph') ?></span>
                </a>
              </div>
              <?php 
                  endif;
                endforeach;
              endforeach;
              ?>
            </div>
            
            <?php endif ?>
          </div>
        </div>
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

/* Class background colors */
.bc-class-bg-1 { background: linear-gradient(135deg, #C79C6E 0%, #8B6914 100%); }
.bc-class-bg-2 { background: linear-gradient(135deg, #F58CBA 0%, #B05085 100%); }
.bc-class-bg-3 { background: linear-gradient(135deg, #ABD473 0%, #5E8C31 100%); }
.bc-class-bg-4 { background: linear-gradient(135deg, #FFF569 0%, #C4B200 100%); }
.bc-class-bg-5 { background: linear-gradient(135deg, #FFFFFF 0%, #AAAAAA 100%); }
.bc-class-bg-6 { background: linear-gradient(135deg, #C41F3B 0%, #7A0012 100%); }
.bc-class-bg-7 { background: linear-gradient(135deg, #0070DE 0%, #003B7A 100%); }
.bc-class-bg-8 { background: linear-gradient(135deg, #69CCF0 0%, #2E8FB3 100%); }
.bc-class-bg-9 { background: linear-gradient(135deg, #9482C9 0%, #5E4D8C 100%); }
.bc-class-bg-10 { background: linear-gradient(135deg, #00FF96 0%, #00996B 100%); }
.bc-class-bg-11 { background: linear-gradient(135deg, #FF7D0A 0%, #B35100 100%); }
.bc-class-bg-12 { background: linear-gradient(135deg, #A330C9 0%, #6B1F85 100%); }

/* Talent Spec Cards */
.bc-talent-spec {
  padding: 20px;
  background: rgba(0,0,0,0.1);
  border-radius: 8px;
  transition: all 0.3s ease;
}

.bc-talent-spec.bc-spec-primary {
  background: rgba(255,255,255,0.05);
  box-shadow: 0 0 20px rgba(255,255,255,0.1);
}

.bc-spec-icon {
  width: 60px;
  height: 60px;
  margin: 0 auto;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 1.5rem;
}

.bc-spec-points {
  margin: 10px 0;
}

.bc-spec-bar {
  height: 6px;
  background: rgba(0,0,0,0.3);
  border-radius: 3px;
  overflow: hidden;
}

.bc-spec-fill {
  height: 100%;
  background: linear-gradient(90deg, #c9a227 0%, #e6be2e 100%);
  border-radius: 3px;
  transition: width 0.5s ease;
}

/* Talent Grid */
.bc-talent-item {
  display: block;
  text-align: center;
  padding: 10px;
  background: rgba(0,0,0,0.1);
  border-radius: 4px;
  transition: all 0.2s ease;
}

.bc-talent-item:hover {
  background: rgba(255,255,255,0.1);
  transform: scale(1.05);
}

.bc-talent-icon {
  width: 40px;
  height: 40px;
  margin: 0 auto;
  background: linear-gradient(135deg, #4a4a4a 0%, #2a2a2a 100%);
  border: 2px solid #666;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #c9a227;
}

/* Glyphs */
.bc-glyph-item {
  padding: 8px;
  background: rgba(0,0,0,0.1);
  border-radius: 4px;
}

.bc-glyph-link {
  display: flex;
  align-items: center;
  text-decoration: none;
  color: inherit;
}

.bc-glyph-icon {
  width: 32px;
  height: 32px;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 10px;
  color: #fff;
}

.bc-glyph-major {
  background: linear-gradient(135deg, #7b68ee 0%, #483d8b 100%);
  border: 2px solid #7b68ee;
}

.bc-glyph-minor {
  background: linear-gradient(135deg, #20b2aa 0%, #008b8b 100%);
  border: 2px solid #20b2aa;
}

.uk-badge-large {
  font-size: 1rem;
  padding: 8px 16px;
}
</style>
