<div class="uk-section">
  <div class="uk-container">
    <div class="uk-grid-small uk-child-width-1-1" uk-grid>
      <div>
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <div class="uk-grid-small uk-flex uk-flex-between uk-flex-middle" uk-grid>
              <div class="uk-width-expand">
                <h3 class="uk-card-title uk-margin-remove">Head Scripts Manager</h3>
                <p class="uk-text-small uk-text-muted uk-margin-remove">Manage analytics, tags, and custom scripts in the page head</p>
              </div>
              <div class="uk-width-auto">
                <a href="<?= site_url('admin/head_scripts/create') ?>" class="uk-button uk-button-primary">
                  <i class="fa-solid fa-plus"></i> Add Script
                </a>
              </div>
            </div>
          </div>
          <div class="uk-card-body uk-padding-remove">
            <?php if (empty($scripts)): ?>
            <div class="uk-alert uk-alert-primary uk-margin">
              <i class="fa-solid fa-info-circle"></i> No scripts configured yet. <a href="<?= site_url('admin/head_scripts/create') ?>">Add one now</a>
            </div>
            <?php else: ?>
            <div class="uk-overflow-auto">
              <table class="uk-table uk-table-hover uk-table-divider">
                <thead>
                  <tr>
                    <th>Key</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($scripts as $key => $script): ?>
                  <tr>
                    <td>
                      <code class="uk-text-small"><?= htmlspecialchars($key) ?></code>
                    </td>
                    <td>
                      <span class="uk-badge <?= $script['type'] === 'analytics' ? 'uk-badge-danger' : ($script['type'] === 'tag' ? 'uk-badge-warning' : 'uk-badge-success') ?>">
                        <?= ucfirst($script['type']) ?>
                      </span>
                    </td>
                    <td>
                      <?php if ($script['type'] === 'script'): ?>
                        <?php if (!empty($script['src'])): ?>
                          External: <code class="uk-text-small"><?= htmlspecialchars(substr($script['src'], 0, 50)) ?><?= strlen($script['src']) > 50 ? '...' : '' ?></code>
                        <?php elseif (!empty($script['content'])): ?>
                          Inline script
                        <?php else: ?>
                          <span class="uk-text-muted">No content</span>
                        <?php endif ?>
                      <?php elseif ($script['type'] === 'tag'): ?>
                        HTML Tag
                      <?php elseif ($script['type'] === 'analytics'): ?>
                        <?= isset($script['analytics_type']) ? ucwords(str_replace('_', ' ', $script['analytics_type'])) : 'Custom' ?>
                      <?php endif ?>
                    </td>
                    <td>
                      <div class="uk-inline">
                        <button class="uk-button uk-button-small <?= ($script['enabled'] ?? false) ? 'uk-button-success' : 'uk-button-danger' ?> toggle-script" data-key="<?= htmlspecialchars($key) ?>">
                          <i class="fa-solid <?= ($script['enabled'] ?? false) ? 'fa-check' : 'fa-times' ?>"></i>
                          <?= ($script['enabled'] ?? false) ? 'Enabled' : 'Disabled' ?>
                        </button>
                      </div>
                    </td>
                    <td>
                      <div class="uk-button-group">
                        <a href="<?= site_url('admin/head_scripts/edit/' . urlencode($key)) ?>" class="uk-button uk-button-small uk-button-default">
                          <i class="fa-solid fa-edit"></i>
                        </a>
                        <a href="<?= site_url('admin/head_scripts/delete/' . urlencode($key)) ?>" class="uk-button uk-button-small uk-button-danger" onclick="return confirm('Are you sure?')">
                          <i class="fa-solid fa-trash"></i>
                        </a>
                      </div>
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

      <div>
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title">Quick Reference</h3>
          </div>
          <div class="uk-card-body">
            <div class="uk-grid-small" uk-grid>
              <div class="uk-width-1-1">
                <h4 class="uk-margin-small">Script Types</h4>
                <dl class="uk-description-list">
                  <dt><span class="uk-badge uk-badge-success">JavaScript</span></dt>
                  <dd>External or inline JavaScript code</dd>
                  <dt><span class="uk-badge uk-badge-warning">HTML Tag</span></dt>
                  <dd>Meta tags, link tags, or other HTML elements</dd>
                  <dt><span class="uk-badge uk-badge-danger">Analytics</span></dt>
                  <dd>Google Analytics, GTM, Facebook Pixel, or custom tracking</dd>
                </dl>
              </div>
              <div class="uk-width-1-1">
                <h4 class="uk-margin-small">Common Use Cases</h4>
                <ul class="uk-list uk-list-bullet">
                  <li>Google Analytics tracking</li>
                  <li>Google Tag Manager setup</li>
                  <li>Facebook Pixel conversion tracking</li>
                  <li>Custom meta tags (theme-color, etc.)</li>
                  <li>Third-party library integration</li>
                  <li>Site verification codes</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.toggle-script').forEach(button => {
  button.addEventListener('click', function() {
    const key = this.dataset.key;
    const btn = this;

    fetch('<?= site_url('admin/head_scripts/toggle') ?>/' + encodeURIComponent(key), {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        if (data.enabled) {
          btn.classList.remove('uk-button-danger');
          btn.classList.add('uk-button-success');
          btn.innerHTML = '<i class="fa-solid fa-check"></i> Enabled';
        } else {
          btn.classList.remove('uk-button-success');
          btn.classList.add('uk-button-danger');
          btn.innerHTML = '<i class="fa-solid fa-times"></i> Disabled';
        }
      }
    })
    .catch(error => console.error('Error:', error));
  });
});
</script>
