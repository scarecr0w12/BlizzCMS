<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><a href="<?= site_url('armory') ?>"><?= lang('armory') ?></a></li>
          <li><span><?= html_escape($character->name) ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <span class="bc-class-<?= $character->class ?>"><?= html_escape($character->name) ?></span>
          <?php if ($character->online == 1): ?>
          <span class="uk-label uk-label-success uk-margin-small-left"><?= lang('character_online') ?></span>
          <?php endif ?>
        </h1>
        <?php if (! empty($guild)): ?>
        <p class="uk-text-muted uk-margin-remove">
          &lt;<a href="<?= site_url('armory/guild/' . $realm_id . '/' . urlencode($guild->name)) ?>"><?= html_escape($guild->name) ?></a>&gt;
          <?php if (! empty($guild->rank_name)): ?>
          - <?= html_escape($guild->rank_name) ?>
          <?php endif ?>
        </p>
        <?php endif ?>
      </div>
      <div class="uk-width-auto">
        <a href="<?= site_url('armory') ?>" class="uk-button uk-button-default">
          <i class="fa-solid fa-arrow-left"></i> <?= lang('back_to_search') ?>
        </a>
      </div>
    </div>

    <!-- Character Navigation -->
    <div class="uk-margin">
      <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li class="uk-active"><a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name)) ?>"><i class="fa-solid fa-user"></i> <?= lang('character_profile') ?></a></li>
        <li><a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name) . '/talents') ?>"><i class="fa-solid fa-book"></i> <?= lang('talents') ?></a></li>
        <li><a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name) . '/achievements') ?>"><i class="fa-solid fa-trophy"></i> <?= lang('achievements') ?></a></li>
        <li><a href="<?= site_url('armory/character/' . $realm_id . '/' . urlencode($character->name) . '/pvp') ?>"><i class="fa-solid fa-shield"></i> <?= lang('pvp') ?></a></li>
      </ul>
    </div>

    <div uk-grid>
      <!-- Left Column - Character Info -->
      <div class="uk-width-1-3@m">
        <!-- Character Card -->
        <div class="uk-card uk-card-default uk-margin">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-id-card"></i> <?= lang('character') ?></h3>
          </div>
          <div class="uk-card-body">
            <div class="uk-text-center uk-margin">
              <!-- Character Avatar Placeholder -->
              <div class="bc-character-avatar bc-race-<?= $character->race ?>-<?= $character->gender ?> bc-class-bg-<?= $character->class ?>">
                <i class="fa-solid fa-user fa-3x"></i>
              </div>
            </div>

            <dl class="uk-description-list uk-description-list-divider">
              <dt><?= lang('character_level') ?></dt>
              <dd><span class="uk-badge uk-badge-large"><?= $character->level ?></span></dd>

              <dt><?= lang('character_race') ?></dt>
              <dd><?= race_name($character->race) ?></dd>

              <dt><?= lang('character_class') ?></dt>
              <dd><span class="bc-class-<?= $character->class ?>"><?= class_name($character->class) ?></span></dd>

              <dt><?= lang('character_faction') ?></dt>
              <dd>
                <?php if (in_array($character->race, config_item('alliance_races'))): ?>
                <span class="uk-label uk-label-primary"><?= lang('alliance') ?></span>
                <?php else: ?>
                <span class="uk-label uk-label-danger"><?= lang('horde') ?></span>
                <?php endif ?>
              </dd>

              <dt><?= lang('realm') ?></dt>
              <dd><?= html_escape($realm->realm_name) ?></dd>

              <?php if (isset($character->zone) && $character->zone > 0): ?>
              <dt><?= lang('character_zone') ?></dt>
              <dd><?= zone_name($character->zone) ?></dd>
              <?php endif ?>

              <?php if (isset($character->totaltime) && $character->totaltime > 0): ?>
              <dt><?= lang('character_playtime') ?></dt>
              <dd><?= format_playtime($character->totaltime) ?></dd>
              <?php endif ?>
            </dl>
          </div>
        </div>

        <!-- Stats Card -->
        <?php if (! empty($stats)): ?>
        <div class="uk-card uk-card-default uk-margin">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-chart-bar"></i> <?= lang('stats') ?></h3>
          </div>
          <div class="uk-card-body">
            <dl class="uk-description-list uk-description-list-divider">
              <?php if (isset($stats->health)): ?>
              <dt><?= lang('stats_health') ?></dt>
              <dd class="uk-text-success"><?= number_format($stats->health) ?></dd>
              <?php endif ?>

              <?php if (isset($stats->power1) && $stats->power1 > 0): ?>
              <dt><?= lang('stats_mana') ?></dt>
              <dd class="uk-text-primary"><?= number_format($stats->power1) ?></dd>
              <?php endif ?>

              <?php if (isset($stats->strength)): ?>
              <dt><?= lang('stats_strength') ?></dt>
              <dd><?= number_format($stats->strength) ?></dd>
              <?php endif ?>

              <?php if (isset($stats->agility)): ?>
              <dt><?= lang('stats_agility') ?></dt>
              <dd><?= number_format($stats->agility) ?></dd>
              <?php endif ?>

              <?php if (isset($stats->stamina)): ?>
              <dt><?= lang('stats_stamina') ?></dt>
              <dd><?= number_format($stats->stamina) ?></dd>
              <?php endif ?>

              <?php if (isset($stats->intellect)): ?>
              <dt><?= lang('stats_intellect') ?></dt>
              <dd><?= number_format($stats->intellect) ?></dd>
              <?php endif ?>

              <?php if (isset($stats->spirit)): ?>
              <dt><?= lang('stats_spirit') ?></dt>
              <dd><?= number_format($stats->spirit) ?></dd>
              <?php endif ?>

              <?php if (isset($stats->armor)): ?>
              <dt><?= lang('stats_armor') ?></dt>
              <dd><?= number_format($stats->armor) ?></dd>
              <?php endif ?>
            </dl>
          </div>
        </div>
        <?php endif ?>
      </div>

      <!-- Right Column - Equipment -->
      <div class="uk-width-2-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-vest"></i> <?= lang('equipment') ?></h3>
          </div>
          <div class="uk-card-body">
            <div class="bc-equipment-grid" uk-grid>
              <!-- Left Equipment Column -->
              <div class="uk-width-1-3@s">
                <?php
                $left_slots = [
                  0 => 'equipment_head',
                  1 => 'equipment_neck',
                  2 => 'equipment_shoulder',
                  14 => 'equipment_back',
                  4 => 'equipment_chest',
                  3 => 'equipment_shirt',
                  18 => 'equipment_tabard',
                  8 => 'equipment_wrist'
                ];
                foreach ($left_slots as $slot => $slot_name):
                ?>
                <div class="bc-equipment-slot uk-margin-small">
                  <?php if (isset($equipment[$slot])): ?>
                  <a href="https://wowhead.com/item=<?= $equipment[$slot]['item_entry'] ?>" data-wowhead="item=<?= $equipment[$slot]['item_entry'] ?>" target="_blank" class="bc-item-link">
                    <div class="bc-item-icon">
                      <i class="fa-solid fa-gem"></i>
                    </div>
                    <span class="bc-slot-name"><?= lang($slot_name) ?></span>
                  </a>
                  <?php else: ?>
                  <div class="bc-item-empty">
                    <div class="bc-item-icon bc-empty">
                      <i class="fa-regular fa-square"></i>
                    </div>
                    <span class="bc-slot-name"><?= lang($slot_name) ?></span>
                  </div>
                  <?php endif ?>
                </div>
                <?php endforeach ?>
              </div>

              <!-- Center - Character Model -->
              <div class="uk-width-1-3@s uk-flex uk-flex-center uk-flex-middle">
                <div class="bc-character-model">
                  <?php if (config_item('armory_3d_models')): ?>
                  <!-- WoW Model Viewer Container -->
                  <div id="model-viewer" class="bc-model-viewer" data-race="<?= $character->race ?>" data-gender="<?= $character->gender ?>" data-class="<?= $character->class ?>">
                    <div class="bc-model-loading">
                      <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
                      <p><?= lang('loading') ?></p>
                    </div>
                  </div>
                  <?php else: ?>
                  <div class="bc-model-placeholder bc-race-<?= $character->race ?>-<?= $character->gender ?>">
                    <i class="fa-solid fa-person fa-5x"></i>
                  </div>
                  <?php endif ?>
                </div>
              </div>

              <!-- Right Equipment Column -->
              <div class="uk-width-1-3@s">
                <?php
                $right_slots = [
                  9 => 'equipment_hands',
                  5 => 'equipment_waist',
                  6 => 'equipment_legs',
                  7 => 'equipment_feet',
                  10 => 'equipment_finger1',
                  11 => 'equipment_finger2',
                  12 => 'equipment_trinket1',
                  13 => 'equipment_trinket2'
                ];
                foreach ($right_slots as $slot => $slot_name):
                ?>
                <div class="bc-equipment-slot uk-margin-small">
                  <?php if (isset($equipment[$slot])): ?>
                  <a href="https://wowhead.com/item=<?= $equipment[$slot]['item_entry'] ?>" data-wowhead="item=<?= $equipment[$slot]['item_entry'] ?>" target="_blank" class="bc-item-link">
                    <div class="bc-item-icon">
                      <i class="fa-solid fa-gem"></i>
                    </div>
                    <span class="bc-slot-name"><?= lang($slot_name) ?></span>
                  </a>
                  <?php else: ?>
                  <div class="bc-item-empty">
                    <div class="bc-item-icon bc-empty">
                      <i class="fa-regular fa-square"></i>
                    </div>
                    <span class="bc-slot-name"><?= lang($slot_name) ?></span>
                  </div>
                  <?php endif ?>
                </div>
                <?php endforeach ?>
              </div>
            </div>

            <!-- Weapons Row -->
            <div class="uk-margin-top">
              <hr>
              <div class="uk-grid-small uk-child-width-1-3@s uk-text-center" uk-grid>
                <?php
                $weapon_slots = [
                  15 => 'equipment_mainhand',
                  16 => 'equipment_offhand',
                  17 => 'equipment_ranged'
                ];
                foreach ($weapon_slots as $slot => $slot_name):
                ?>
                <div>
                  <div class="bc-equipment-slot">
                    <?php if (isset($equipment[$slot])): ?>
                    <a href="https://wowhead.com/item=<?= $equipment[$slot]['item_entry'] ?>" data-wowhead="item=<?= $equipment[$slot]['item_entry'] ?>" target="_blank" class="bc-item-link">
                      <div class="bc-item-icon bc-weapon">
                        <i class="fa-solid fa-sword"></i>
                      </div>
                      <span class="bc-slot-name"><?= lang($slot_name) ?></span>
                    </a>
                    <?php else: ?>
                    <div class="bc-item-empty">
                      <div class="bc-item-icon bc-empty bc-weapon">
                        <i class="fa-regular fa-square"></i>
                      </div>
                      <span class="bc-slot-name"><?= lang($slot_name) ?></span>
                    </div>
                    <?php endif ?>
                  </div>
                </div>
                <?php endforeach ?>
              </div>
            </div>
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

<?php if (config_item('armory_3d_models')): ?>
<!-- WoW Model Viewer -->
<?php
// Build equipment display slots for the model viewer
$model_items = [];
if (! empty($equipment)) {
    // Map equipment slots to Wowhead model viewer slot format
    $slot_mapping = [
        0 => 1,   // Head
        1 => 2,   // Neck (not visible)
        2 => 3,   // Shoulder
        14 => 15, // Back/Cloak
        4 => 5,   // Chest
        3 => 4,   // Shirt
        18 => 19, // Tabard
        8 => 9,   // Wrist
        9 => 10,  // Hands
        5 => 6,   // Waist
        6 => 7,   // Legs
        7 => 8,   // Feet
        15 => 16, // Main Hand
        16 => 17, // Off Hand
        17 => 18  // Ranged
    ];
    foreach ($equipment as $slot => $item) {
        if (isset($item['item_entry']) && $item['item_entry'] > 0) {
            $wh_slot = $slot_mapping[$slot] ?? $slot;
            $model_items[] = $item['item_entry'] . ':' . $wh_slot;
        }
    }
}
$items_param = ! empty($model_items) ? implode(',', $model_items) : '';
?>
<script src="https://wow.zamimg.com/widgets/power.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modelContainer = document.getElementById('model-viewer');
    if (!modelContainer) return;

    const race = parseInt(modelContainer.dataset.race);
    const gender = parseInt(modelContainer.dataset.gender);

    // Race ID to Wowhead model format
    // Format: race-gender (0=male, 1=female)
    const raceMapping = {
        1: 'human',
        2: 'orc',
        3: 'dwarf',
        4: 'nightelf',
        5: 'undead',
        6: 'tauren',
        7: 'gnome',
        8: 'troll',
        10: 'bloodelf',
        11: 'draenei'
    };

    const raceName = raceMapping[race] || 'human';
    const genderName = gender === 0 ? 'male' : 'female';

    // Clear loading indicator
    modelContainer.innerHTML = '';

    // Create Wowhead 3D model viewer using their data-wowhead attribute system
    const modelDiv = document.createElement('div');
    modelDiv.className = 'bc-wowhead-model';
    
    // Use Wowhead's character model viewer widget
    const modelParams = {
        type: 'npc', // or 'outfit' for characters with gear
        displayId: getDisplayId(race, gender)
    };

    <?php if (! empty($items_param)): ?>
    // Character with equipment - use outfit type
    modelDiv.setAttribute('data-wowhead', 'outfit=<?= $character->race ?>:<?= $character->gender ?>:<?= $character->class ?>:0:0:0:0:0:0:0:0&items=<?= $items_param ?>');
    <?php else: ?>
    // Base character model
    modelDiv.setAttribute('data-wowhead', 'npc=' + getDisplayId(race, gender));
    <?php endif ?>

    modelContainer.appendChild(modelDiv);

    // Trigger Wowhead to process the new element
    if (typeof $WowheadPower !== 'undefined' && $WowheadPower.refreshLinks) {
        $WowheadPower.refreshLinks();
    }

    // Fallback to canvas-based viewer if Wowhead doesn't work
    setTimeout(function() {
        if (modelDiv.children.length === 0) {
            showCanvasModel(modelContainer, race, gender);
        }
    }, 3000);
});

function getDisplayId(race, gender) {
    // NPC display IDs for base character models
    const displayIds = {
        1: { 0: 49, 1: 50 },      // Human
        2: { 0: 51, 1: 52 },      // Orc
        3: { 0: 53, 1: 54 },      // Dwarf
        4: { 0: 55, 1: 56 },      // Night Elf
        5: { 0: 57, 1: 58 },      // Undead
        6: { 0: 59, 1: 60 },      // Tauren
        7: { 0: 1563, 1: 1564 },  // Gnome
        8: { 0: 1478, 1: 1479 },  // Troll
        10: { 0: 15476, 1: 15475 }, // Blood Elf
        11: { 0: 16125, 1: 16126 }  // Draenei
    };
    return displayIds[race] ? displayIds[race][gender] : 49;
}

function showCanvasModel(container, race, gender) {
    // Show a styled character silhouette as fallback
    const factionClass = [1, 3, 4, 7, 11].includes(race) ? 'alliance' : 'horde';
    container.innerHTML = `
        <div class="bc-model-canvas">
            <canvas id="character-canvas" width="200" height="280"></canvas>
            <div class="bc-model-controls">
                <button type="button" class="bc-model-btn" onclick="rotateModel(-1)" title="Rotate Left">
                    <i class="fa-solid fa-rotate-left"></i>
                </button>
                <button type="button" class="bc-model-btn" onclick="rotateModel(1)" title="Rotate Right">
                    <i class="fa-solid fa-rotate-right"></i>
                </button>
            </div>
        </div>
    `;
    
    initCharacterCanvas(race, gender);
}

let modelRotation = 0;
function rotateModel(direction) {
    modelRotation += direction * 45;
    const canvas = document.getElementById('character-canvas');
    if (canvas) {
        canvas.style.transform = `rotateY(${modelRotation}deg)`;
    }
}

function initCharacterCanvas(race, gender) {
    const canvas = document.getElementById('character-canvas');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    const width = canvas.width;
    const height = canvas.height;
    
    // Clear canvas
    ctx.clearRect(0, 0, width, height);
    
    // Draw stylized character silhouette based on race
    const raceStyles = {
        1: { color: '#8B7355', height: 0.85 },  // Human
        2: { color: '#4A7C59', height: 0.95 },  // Orc
        3: { color: '#8B6914', height: 0.70 },  // Dwarf
        4: { color: '#6B5B95', height: 1.0 },   // Night Elf
        5: { color: '#556B2F', height: 0.85 },  // Undead
        6: { color: '#8B4513', height: 1.1 },   // Tauren
        7: { color: '#FFB6C1', height: 0.55 },  // Gnome
        8: { color: '#4169E1', height: 1.0 },   // Troll
        10: { color: '#FFD700', height: 0.90 }, // Blood Elf
        11: { color: '#4682B4', height: 1.0 }   // Draenei
    };
    
    const style = raceStyles[race] || raceStyles[1];
    const charHeight = height * style.height * 0.8;
    const charY = height - charHeight - 20;
    
    // Draw shadow
    ctx.fillStyle = 'rgba(0,0,0,0.3)';
    ctx.beginPath();
    ctx.ellipse(width/2, height - 15, 40, 10, 0, 0, Math.PI * 2);
    ctx.fill();
    
    // Draw character silhouette
    ctx.fillStyle = style.color;
    ctx.shadowColor = 'rgba(0,0,0,0.5)';
    ctx.shadowBlur = 10;
    
    // Body
    ctx.beginPath();
    ctx.moveTo(width/2 - 25, charY + charHeight * 0.3);
    ctx.lineTo(width/2 - 35, charY + charHeight);
    ctx.lineTo(width/2 - 15, charY + charHeight);
    ctx.lineTo(width/2, charY + charHeight * 0.5);
    ctx.lineTo(width/2 + 15, charY + charHeight);
    ctx.lineTo(width/2 + 35, charY + charHeight);
    ctx.lineTo(width/2 + 25, charY + charHeight * 0.3);
    ctx.closePath();
    ctx.fill();
    
    // Head
    const headRadius = charHeight * 0.12;
    ctx.beginPath();
    ctx.arc(width/2, charY + headRadius, headRadius, 0, Math.PI * 2);
    ctx.fill();
    
    ctx.shadowBlur = 0;
    
    // Add faction indicator
    const factionColor = [1, 3, 4, 7, 11].includes(race) ? '#1e90ff' : '#dc143c';
    ctx.fillStyle = factionColor;
    ctx.beginPath();
    ctx.arc(width - 25, 25, 8, 0, Math.PI * 2);
    ctx.fill();
}
</script>
<?php endif ?>

<style>
/* Character Avatar */
.bc-character-avatar {
  width: 120px;
  height: 120px;
  margin: 0 auto;
  border-radius: 50%;
  background: linear-gradient(135deg, #1e3a5f 0%, #0d1b2a 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  border: 3px solid #444;
}

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

/* Class text colors */
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

/* Equipment Grid */
.bc-equipment-slot {
  display: flex;
  align-items: center;
  padding: 8px;
  background: rgba(0, 0, 0, 0.1);
  border-radius: 4px;
}

.bc-item-link,
.bc-item-empty {
  display: flex;
  align-items: center;
  text-decoration: none;
  width: 100%;
}

.bc-item-icon {
  width: 36px;
  height: 36px;
  background: linear-gradient(135deg, #4a4a4a 0%, #2a2a2a 100%);
  border: 2px solid #666;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 10px;
  color: #fff;
}

.bc-item-icon.bc-empty {
  background: rgba(0, 0, 0, 0.2);
  border-color: #444;
  color: #666;
}

.bc-item-icon.bc-weapon {
  width: 44px;
  height: 44px;
}

.bc-slot-name {
  font-size: 0.85rem;
  color: #999;
}

.bc-item-link:hover .bc-slot-name {
  color: #1e87f0;
}

/* Character Model Placeholder */
.bc-character-model {
  padding: 20px;
}

.bc-model-placeholder {
  width: 200px;
  height: 300px;
  background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
  border-radius: 8px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: #444;
  border: 2px solid #333;
}

/* 3D Model Viewer */
.bc-model-viewer {
  width: 200px;
  height: 300px;
  background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
  border-radius: 8px;
  border: 2px solid #333;
  overflow: hidden;
  position: relative;
}

.bc-model-viewer canvas {
  width: 100% !important;
  height: 100% !important;
}

.bc-model-loading {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  color: #666;
}

.bc-model-loading p {
  margin-top: 10px;
  font-size: 0.85rem;
}

/* Canvas Model Viewer */
.bc-model-canvas {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.bc-model-canvas canvas {
  transition: transform 0.3s ease;
}

.bc-model-controls {
  display: flex;
  gap: 10px;
  margin-top: 10px;
  position: absolute;
  bottom: 10px;
}

.bc-model-btn {
  background: rgba(255,255,255,0.1);
  border: 1px solid rgba(255,255,255,0.2);
  color: #fff;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.bc-model-btn:hover {
  background: rgba(255,255,255,0.2);
  border-color: rgba(255,255,255,0.4);
}

.bc-wowhead-model {
  width: 100%;
  height: 100%;
}

.bc-model-fallback {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100%;
  color: #666;
}

/* Badge large */
.uk-badge-large {
  font-size: 1.1rem;
  padding: 5px 15px;
}
</style>
