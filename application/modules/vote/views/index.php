<section class="uk-section uk-section-small bc-primary-section" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-margin-top uk-margin-bottom" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url() ?>"><?= lang('home') ?></a></li>
          <li><span><?= lang('vote') ?></span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-vote-yea"></i> <?= lang('vote_title') ?>
        </h1>
        <p class="uk-text-meta uk-margin-remove-top"><?= lang('vote_description') ?></p>
      </div>
    </div>

    <div uk-grid>
      <!-- Main Content -->
      <div class="uk-width-2-3@m">
        <!-- Vote Sites -->
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-list"></i> <?= lang('vote_available_sites') ?></h3>
          </div>
          <div class="uk-card-body">
            <?php if (empty($sites)): ?>
            <div class="uk-text-center uk-padding">
              <i class="fa-solid fa-vote-yea fa-3x uk-text-muted"></i>
              <p class="uk-text-muted"><?= lang('vote_no_sites') ?></p>
            </div>
            <?php else: ?>
            <div class="uk-grid-small uk-child-width-1-1" uk-grid>
              <?php foreach ($sites as $site): ?>
              <?php 
                $can_vote = true;
                $cooldown_text = '';
                if (is_logged_in() && isset($vote_status[$site->id])) {
                    $status = $vote_status[$site->id];
                    $can_vote = $status['can_vote'];
                    if (!$can_vote && $status['cooldown_remaining']) {
                        $hours = floor($status['cooldown_remaining'] / 3600);
                        $minutes = floor(($status['cooldown_remaining'] % 3600) / 60);
                        $cooldown_text = sprintf('%dh %dm', $hours, $minutes);
                    }
                }
              ?>
              <div>
                <div class="uk-card uk-card-secondary uk-card-body uk-card-small">
                  <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
                    <div class="uk-width-auto">
                      <?php if (!empty($site->image)): ?>
                      <img src="<?= base_url('uploads/' . $site->image) ?>" alt="<?= html_escape($site->name) ?>" style="max-height: 50px; max-width: 100px;">
                      <?php else: ?>
                      <i class="fa-solid fa-external-link fa-2x uk-text-primary"></i>
                      <?php endif; ?>
                    </div>
                    <div class="uk-width-expand">
                      <h4 class="uk-margin-remove"><?= html_escape($site->name) ?></h4>
                      <?php if (!empty($site->description)): ?>
                      <p class="uk-text-small uk-text-muted uk-margin-remove"><?= html_escape($site->description) ?></p>
                      <?php endif; ?>
                    </div>
                    <div class="uk-width-auto uk-text-center">
                      <div class="uk-text-small uk-text-muted"><?= lang('vote_vp_reward') ?></div>
                      <div class="uk-text-large uk-text-bold uk-text-primary">+<?= $site->vp_reward ?> VP</div>
                    </div>
                    <div class="uk-width-auto">
                      <?php if (!is_logged_in()): ?>
                      <a href="<?= site_url('login') ?>" class="uk-button uk-button-default uk-button-small">
                        <i class="fa-solid fa-sign-in-alt"></i> <?= lang('login') ?>
                      </a>
                      <?php elseif ($can_vote): ?>
                      <a href="<?= site_url('vote/site/' . $site->id) ?>" class="uk-button uk-button-primary uk-button-small" target="_blank" onclick="startVoteTimer(<?= $site->id ?>)">
                        <i class="fa-solid fa-external-link-alt"></i> <?= lang('vote_now') ?>
                      </a>
                      <?php else: ?>
                      <button class="uk-button uk-button-default uk-button-small" disabled>
                        <i class="fa-solid fa-clock"></i> <?= sprintf(lang('vote_wait'), $cooldown_text) ?>
                      </button>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Instructions -->
        <div class="uk-card uk-card-default uk-margin-top">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-info-circle"></i> How to Vote</h3>
          </div>
          <div class="uk-card-body">
            <ol class="uk-list uk-list-decimal">
              <li>Click the <strong>"Vote Now"</strong> button next to a vote site</li>
              <li>You will be redirected to the voting site in a new window</li>
              <li>Complete the vote on the external site</li>
              <li>Return to this page and click the callback link to claim your reward</li>
              <li>Your Vote Points will be automatically added to your account</li>
            </ol>
            <div class="uk-alert uk-alert-primary">
              <i class="fa-solid fa-lightbulb"></i> <strong>Tip:</strong> You can vote on each site once every <?= config_item('vote_cooldown_hours') ?? 12 ?> hours!
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="uk-width-1-3@m">
        <!-- Top Voters -->
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-trophy"></i> <?= lang('vote_top_voters') ?></h3>
          </div>
          <div class="uk-card-body uk-padding-remove">
            <?php if (empty($top_voters)): ?>
            <div class="uk-padding uk-text-center">
              <p class="uk-text-muted">No votes yet. Be the first!</p>
            </div>
            <?php else: ?>
            <ul class="uk-list uk-list-divider uk-margin-remove">
              <?php $rank = 1; foreach ($top_voters as $voter): ?>
              <li class="uk-padding-small">
                <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
                  <div class="uk-width-auto">
                    <?php if ($rank <= 3): ?>
                    <span class="uk-badge <?= $rank == 1 ? 'uk-badge-warning' : ($rank == 2 ? '' : 'uk-badge-danger') ?>">#<?= $rank ?></span>
                    <?php else: ?>
                    <span class="uk-text-muted">#<?= $rank ?></span>
                    <?php endif; ?>
                  </div>
                  <div class="uk-width-auto">
                    <img class="uk-border-circle" src="<?= user_avatar($voter->id) ?>" width="32" height="32" alt="">
                  </div>
                  <div class="uk-width-expand">
                    <div class="uk-text-bold"><?= html_escape($voter->nickname) ?></div>
                    <div class="uk-text-small uk-text-muted">
                      <?= number_format($voter->vote_count) ?> votes
                    </div>
                  </div>
                </div>
              </li>
              <?php $rank++; endforeach; ?>
            </ul>
            <?php endif; ?>
          </div>
          <div class="uk-card-footer">
            <a href="<?= site_url('vote/top') ?>" class="uk-button uk-button-text">
              <?= lang('view') ?> <?= lang('vote_top_voters') ?> <i class="fa-solid fa-arrow-right"></i>
            </a>
          </div>
        </div>

        <!-- User Actions -->
        <?php if (is_logged_in()): ?>
        <div class="uk-card uk-card-default uk-margin-top">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-user"></i> <?= lang('user') ?></h3>
          </div>
          <div class="uk-card-body">
            <div class="uk-margin-small-bottom">
              <span class="uk-text-muted"><?= lang('voting_points') ?>:</span>
              <span class="uk-text-bold uk-float-right"><?= number_format(user('vp')) ?> VP</span>
            </div>
            <a href="<?= site_url('vote/history') ?>" class="uk-button uk-button-secondary uk-button-small uk-width-1-1">
              <i class="fa-solid fa-history"></i> <?= lang('vote_view_history') ?>
            </a>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<script>
function startVoteTimer(siteId) {
    // Store the site ID and timestamp
    localStorage.setItem('vote_site_' + siteId, Date.now());
    
    // Show callback link after a delay
    setTimeout(function() {
        var callbackLink = document.getElementById('callback-' + siteId);
        if (callbackLink) {
            callbackLink.style.display = 'inline-block';
        }
    }, 10000);
}
</script>
