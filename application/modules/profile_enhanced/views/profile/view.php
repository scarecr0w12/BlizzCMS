<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= htmlspecialchars($user->username) ?></h1>
        <p class="uk-text-small uk-text-muted uk-margin-remove"><?= lang('profile_joined') ?>: <?= date('F Y', strtotime($user->created_at ?? 'now')) ?></p>
      </div>
    </div>

    <div class="uk-margin" uk-grid>
      <div class="uk-width-1-3@m">
        <div class="uk-card uk-card-default uk-margin">
          <div class="uk-card-body uk-text-center">
            <img src="<?= $profile->avatar_url ?? user_avatar($user->id) ?>" 
                 class="uk-border-circle" 
                 style="width: 150px; height: 150px; object-fit: cover;" 
                 alt="<?= htmlspecialchars($user->username) ?>">
            <h3 class="uk-margin-small-top"><?= htmlspecialchars($user->username) ?></h3>
            
            <?php if ($profile->bio): ?>
              <p class="uk-text-small uk-margin-small"><?= nl2br(htmlspecialchars($profile->bio)) ?></p>
            <?php endif; ?>

            <div class="uk-margin-small">
              <?php if ($profile->location): ?>
                <div class="uk-margin-small">
                  <i class="fas fa-map-marker-alt"></i> 
                  <?= htmlspecialchars($profile->location) ?>
                </div>
              <?php endif; ?>

              <?php if ($profile->website): ?>
                <div class="uk-margin-small">
                  <i class="fas fa-globe"></i> 
                  <a href="<?= htmlspecialchars($profile->website) ?>" target="_blank" class="uk-link-text">
                    <?= htmlspecialchars($profile->website) ?>
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <?php if ($settings['enable_profile_visits'] ?? 1): ?>
          <?php if (!empty($recent_visitors)): ?>
            <div class="uk-card uk-card-default uk-margin">
              <div class="uk-card-header">
                <h3 class="uk-card-title"><i class="fas fa-users"></i> <?= lang('profile_recent_visitors') ?></h3>
              </div>
              <div class="uk-card-body">
                <div class="uk-grid-small uk-child-width-auto" uk-grid>
                  <?php foreach ($recent_visitors as $visitor): ?>
                    <div>
                      <a href="<?= site_url('profile/' . $visitor->username) ?>" class="uk-link-reset">
                        <div class="uk-text-center">
                          <i class="fas fa-user-circle fa-2x"></i>
                          <div class="uk-text-small uk-margin-small-top"><?= htmlspecialchars($visitor->username) ?></div>
                        </div>
                      </a>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>

      <div class="uk-width-expand@m">

        <div class="uk-card uk-card-default uk-margin">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fas fa-chart-bar"></i> <?= lang('profile_statistics') ?></h3>
          </div>
          <div class="uk-card-body">
            <div class="uk-grid-small uk-child-width-1-2 uk-child-width-1-4@s" uk-grid>
              <div>
                <div class="uk-text-center uk-padding-small">
                  <i class="fas fa-chart-line fa-2x uk-text-primary uk-margin-small-bottom"></i>
                  <div class="uk-h4 uk-margin-remove"><?= number_format($statistics['total_activities']) ?></div>
                  <div class="uk-text-small uk-text-muted">Total Activities</div>
                </div>
              </div>
              <div>
                <div class="uk-text-center uk-padding-small">
                  <i class="fas fa-trophy fa-2x uk-text-warning uk-margin-small-bottom"></i>
                  <div class="uk-h4 uk-margin-remove"><?= number_format($statistics['total_achievements']) ?></div>
                  <div class="uk-text-small uk-text-muted">Achievements</div>
                </div>
              </div>
              <div>
                <div class="uk-text-center uk-padding-small">
                  <i class="fas fa-eye fa-2x uk-text-primary uk-margin-small-bottom"></i>
                  <div class="uk-h4 uk-margin-remove"><?= number_format($statistics['profile_visits']) ?></div>
                  <div class="uk-text-small uk-text-muted">Profile Visits</div>
                </div>
              </div>
              <div>
                <div class="uk-text-center uk-padding-small">
                  <i class="fas fa-calendar-alt fa-2x uk-text-success uk-margin-small-bottom"></i>
                  <div class="uk-h5 uk-margin-remove"><?= $statistics['join_date'] ? date('M Y', strtotime($statistics['join_date'])) : 'N/A' ?></div>
                  <div class="uk-text-small uk-text-muted">Member Since</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php if ($settings['enable_achievements'] ?? 1): ?>
          <div class="uk-card uk-card-default uk-margin">
            <div class="uk-card-header">
              <h3 class="uk-card-title"><i class="fas fa-trophy"></i> <?= lang('profile_showcase') ?></h3>
            </div>
            <div class="uk-card-body">
              <?php if (!empty($showcased_achievements)): ?>
                <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid>
                  <?php foreach ($showcased_achievements as $achievement): ?>
                    <div>
                      <div class="uk-card uk-card-small uk-card-default uk-text-center">
                        <div class="uk-card-body">
                          <i class="fas fa-trophy fa-2x uk-text-warning uk-margin-small-bottom"></i>
                          <div class="uk-h6 uk-margin-remove">Achievement #<?= $achievement->achievement_id ?></div>
                          <div class="uk-text-small uk-text-muted">
                            <i class="fas fa-calendar-alt"></i> 
                            <?= date('M j, Y', strtotime($achievement->earned_at)) ?>
                          </div>
                          <?php if ($achievement->character_guid): ?>
                            <div class="uk-text-small uk-text-muted uk-margin-small-top">
                              <i class="fas fa-user"></i> Character: <?= $achievement->character_guid ?>
                            </div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php else: ?>
                <div class="uk-text-center uk-padding">
                  <i class="fas fa-trophy fa-3x uk-text-muted uk-margin-bottom"></i>
                  <p class="uk-text-muted">No achievements showcased yet</p>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>

        <?php if ($settings['enable_timeline'] ?? 1): ?>
          <div class="uk-card uk-card-default uk-margin">
            <div class="uk-card-header">
              <h3 class="uk-card-title"><i class="fas fa-clock"></i> <?= lang('profile_recent_activity') ?></h3>
            </div>
            <div class="uk-card-body" style="max-height: 500px; overflow-y: auto;">
              <?php if (!empty($timeline)): ?>
                <ul class="uk-list uk-list-divider">
                  <?php foreach ($timeline as $activity): ?>
                    <li>
                      <div class="uk-flex uk-flex-between uk-flex-middle">
                        <div>
                          <div class="uk-text-bold">
                            <i class="fas fa-circle uk-text-primary" style="font-size: 8px;"></i>
                            <?= ucfirst(str_replace('_', ' ', $activity->activity_type)) ?>
                          </div>
                          <?php if ($activity->activity_data): ?>
                            <div class="uk-text-small uk-text-muted uk-margin-small-top">
                              <?= htmlspecialchars($activity->activity_data) ?>
                            </div>
                          <?php endif; ?>
                        </div>
                        <div class="uk-text-small uk-text-muted">
                          <?= date('M j, Y', strtotime($activity->created_at)) ?>
                        </div>
                      </div>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php else: ?>
                <div class="uk-text-center uk-padding">
                  <i class="fas fa-clock fa-3x uk-text-muted uk-margin-bottom"></i>
                  <p class="uk-text-muted"><?= lang('profile_no_activities') ?></p>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>


        <?php if ($settings['enable_character_gallery'] ?? 1): ?>
          <div class="uk-card uk-card-default uk-margin">
            <div class="uk-card-header">
              <h3 class="uk-card-title"><i class="fas fa-users"></i> <?= lang('profile_characters') ?></h3>
            </div>
            <div class="uk-card-body">
              <?php if (!empty($characters)): ?>
                <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l" uk-grid>
                  <?php foreach ($characters as $character): ?>
                    <div>
                      <a href="<?= site_url('armory/character/' . $character->realm_id . '/' . urlencode($character->name)) ?>" class="uk-link-reset">
                        <div class="uk-card uk-card-small uk-card-default uk-card-hover">
                          <div class="uk-card-body uk-padding-small">
                            <div class="uk-flex uk-flex-middle uk-flex-between">
                              <div class="uk-flex uk-flex-middle">
                                <div class="uk-margin-small-right">
                                  <i class="<?= 'bc-icon-class-' . $character->class ?>" style="font-size: 32px;"></i>
                                </div>
                                <div>
                                  <div class="uk-text-bold <?= 'bc-class-' . $character->class ?>"><?= htmlspecialchars($character->name) ?></div>
                                  <div class="uk-text-small uk-text-muted">
                                    <?= race_name($character->race) ?> <?= class_name($character->class) ?>
                                  </div>
                                  <div class="uk-text-small uk-text-muted">
                                    <i class="fas fa-server"></i> <?= htmlspecialchars($character->realm_name) ?>
                                  </div>
                                </div>
                              </div>
                              <div class="uk-text-center">
                                <div class="uk-text-bold uk-text-large"><?= $character->level ?></div>
                                <div class="uk-text-small uk-text-muted">Level</div>
                              </div>
                            </div>
                            <?php if ($character->online): ?>
                              <div class="uk-margin-small-top">
                                <span class="uk-label uk-label-success uk-text-small">
                                  <i class="fas fa-circle"></i> Online
                                </span>
                              </div>
                            <?php endif; ?>
                          </div>
                        </div>
                      </a>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php else: ?>
                <div class="uk-alert-primary" uk-alert>
                  <p class="uk-margin-remove">
                    <i class="fas fa-info-circle"></i> 
                    No characters found for this account.
                  </p>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
