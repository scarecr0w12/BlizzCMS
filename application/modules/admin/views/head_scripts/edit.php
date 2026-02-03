<div class="uk-section">
  <div class="uk-container">
    <div class="uk-grid-small uk-child-width-1-1" uk-grid>
      <div>
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title">
              <?= $key ? 'Edit Script: ' . htmlspecialchars($key) : 'Create New Script' ?>
            </h3>
          </div>
          <div class="uk-card-body">
            <?= form_open(current_url(), ['class' => 'uk-form-stacked']) ?>

            <div class="uk-margin">
              <label class="uk-form-label" for="key">Script Key</label>
              <div class="uk-form-controls">
                <input class="uk-input <?= form_error('key') ? 'uk-form-danger' : '' ?>" type="text" id="key" name="key" value="<?= $key ? htmlspecialchars($key) : set_value('key') ?>" <?= $key ? 'disabled' : 'required' ?> placeholder="e.g., google_analytics">
                <?php if ($key): ?>
                <input type="hidden" name="key" value="<?= htmlspecialchars($key) ?>">
                <?php endif ?>
                <?php if (form_error('key')): ?>
                <small class="uk-text-danger"><?= form_error('key') ?></small>
                <?php endif ?>
              </div>
            </div>

            <div class="uk-margin">
              <label class="uk-form-label" for="type">Type</label>
              <div class="uk-form-controls">
                <select class="uk-select <?= form_error('type') ? 'uk-form-danger' : '' ?>" id="type" name="type" required onchange="updateTypeFields()">
                  <option value="">Select Type</option>
                  <?php foreach ($script_types as $value => $label): ?>
                  <option value="<?= $value ?>" <?= (set_value('type') ?: ($script['type'] ?? '')) === $value ? 'selected' : '' ?>>
                    <?= $label ?>
                  </option>
                  <?php endforeach ?>
                </select>
                <?php if (form_error('type')): ?>
                <small class="uk-text-danger"><?= form_error('type') ?></small>
                <?php endif ?>
              </div>
            </div>

            <div class="uk-margin">
              <label class="uk-form-label">
                <input class="uk-checkbox" type="checkbox" id="enabled" name="enabled" value="1" <?= (set_value('enabled') ?: ($script['enabled'] ?? false)) ? 'checked' : '' ?>>
                Enabled
              </label>
            </div>

            <!-- Script Type Fields -->
            <div id="script-fields" style="display: <?= (set_value('type') ?: ($script['type'] ?? '')) === 'script' ? 'block' : 'none' ?>">
              <hr class="uk-divider-small">
              <h4>Script Settings</h4>

              <div class="uk-margin">
                <label class="uk-form-label" for="src">External Script URL (Optional)</label>
                <div class="uk-form-controls">
                  <input class="uk-input" type="url" id="src" name="src" value="<?= set_value('src') ?: ($script['src'] ?? '') ?>" placeholder="https://example.com/script.js">
                  <small class="uk-text-muted">Leave empty if using inline script content</small>
                </div>
              </div>

              <div class="uk-margin">
                <label class="uk-form-label" for="script-content">Inline Script Content (Optional)</label>
                <div class="uk-form-controls">
                  <textarea class="uk-textarea" id="script-content" name="script_content" rows="6" placeholder="console.log('Hello');"></textarea>
                  <small class="uk-text-muted">Leave empty if using external script URL</small>
                </div>
              </div>

              <div class="uk-margin">
                <label class="uk-form-label" for="script_type">Script Type</label>
                <div class="uk-form-controls">
                  <input class="uk-input" type="text" id="script_type" name="script_type" value="<?= set_value('script_type') ?: ($script['script_type'] ?? 'text/javascript') ?>" placeholder="text/javascript">
                </div>
              </div>

              <div class="uk-grid-small" uk-grid>
                <div class="uk-width-1-2">
                  <label class="uk-form-label">
                    <input class="uk-checkbox" type="checkbox" id="async" name="async" value="1" <?= (set_value('async') ?: ($script['async'] ?? false)) ? 'checked' : '' ?>>
                    Async
                  </label>
                  <small class="uk-text-muted">Load script asynchronously</small>
                </div>
                <div class="uk-width-1-2">
                  <label class="uk-form-label">
                    <input class="uk-checkbox" type="checkbox" id="defer" name="defer" value="1" <?= (set_value('defer') ?: ($script['defer'] ?? false)) ? 'checked' : '' ?>>
                    Defer
                  </label>
                  <small class="uk-text-muted">Defer script execution</small>
                </div>
              </div>
            </div>

            <!-- Tag Type Fields -->
            <div id="tag-fields" style="display: <?= (set_value('type') ?: ($script['type'] ?? '')) === 'tag' ? 'block' : 'none' ?>">
              <hr class="uk-divider-small">
              <h4>Tag Content</h4>

              <div class="uk-margin">
                <label class="uk-form-label" for="tag-content">HTML Content</label>
                <div class="uk-form-controls">
                  <textarea class="uk-textarea" id="tag-content" name="tag_content" rows="6" placeholder="&lt;meta name=&quot;theme-color&quot; content=&quot;#1f2937&quot;&gt;"></textarea>
                  <small class="uk-text-muted">Enter the complete HTML tag</small>
                </div>
              </div>
            </div>

            <!-- Analytics Type Fields -->
            <div id="analytics-fields" style="display: <?= (set_value('type') ?: ($script['type'] ?? '')) === 'analytics' ? 'block' : 'none' ?>">
              <hr class="uk-divider-small">
              <h4>Analytics Settings</h4>

              <div class="uk-margin">
                <label class="uk-form-label" for="analytics_type">Analytics Type</label>
                <div class="uk-form-controls">
                  <select class="uk-select" id="analytics_type" name="analytics_type">
                    <option value="">Select Analytics Type</option>
                    <?php foreach ($analytics_types as $value => $label): ?>
                    <option value="<?= $value ?>" <?= (set_value('analytics_type') ?: ($script['analytics_type'] ?? '')) === $value ? 'selected' : '' ?>>
                      <?= $label ?>
                    </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <div class="uk-margin">
                <label class="uk-form-label" for="analytics-content">Tracking ID / Code</label>
                <div class="uk-form-controls">
                  <input class="uk-input" type="text" id="analytics-content" name="analytics_content" value="<?= set_value('analytics_content') ?: ($script['content'] ?? '') ?>" placeholder="e.g., G-XXXXXXXXXX or GTM-XXXXXX">
                  <small class="uk-text-muted">Enter your tracking ID or measurement ID</small>
                </div>
              </div>
            </div>

            <hr class="uk-divider-small">

            <div class="uk-margin uk-flex uk-flex-between">
              <a href="<?= site_url('admin/head_scripts') ?>" class="uk-button uk-button-default">
                <i class="fa-solid fa-arrow-left"></i> Back
              </a>
              <button type="submit" class="uk-button uk-button-primary">
                <i class="fa-solid fa-save"></i> Save Script
              </button>
            </div>

            <?= form_close() ?>
          </div>
        </div>
      </div>

      <div>
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title">Help</h3>
          </div>
          <div class="uk-card-body uk-text-small">
            <h4>Script Types</h4>
            <dl class="uk-description-list uk-description-list-divider">
              <dt>JavaScript</dt>
              <dd>Add external or inline JavaScript code. Use async/defer for performance optimization.</dd>
              <dt>HTML Tag</dt>
              <dd>Add meta tags, link tags, or other HTML elements to the page head.</dd>
              <dt>Analytics</dt>
              <dd>Add tracking code for Google Analytics, GTM, Facebook Pixel, or custom analytics.</dd>
            </dl>

            <h4 class="uk-margin-medium-top">Examples</h4>

            <div class="uk-margin-small">
              <strong>Google Analytics:</strong>
              <div class="uk-background-muted uk-padding-small uk-margin-small" style="border-radius: 3px; overflow-x: auto;">
                <code style="font-size: 11px;">G-XXXXXXXXXX</code>
              </div>
            </div>

            <div class="uk-margin-small">
              <strong>Meta Tag:</strong>
              <div class="uk-background-muted uk-padding-small uk-margin-small" style="border-radius: 3px; overflow-x: auto;">
                <code style="font-size: 11px;">&lt;meta name="theme-color" content="#1f2937"&gt;</code>
              </div>
            </div>

            <div class="uk-margin-small">
              <strong>Inline Script:</strong>
              <div class="uk-background-muted uk-padding-small uk-margin-small" style="border-radius: 3px; overflow-x: auto;">
                <code style="font-size: 11px;">console.log('Page loaded');</code>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function updateTypeFields() {
  const type = document.getElementById('type').value;
  document.getElementById('script-fields').style.display = type === 'script' ? 'block' : 'none';
  document.getElementById('tag-fields').style.display = type === 'tag' ? 'block' : 'none';
  document.getElementById('analytics-fields').style.display = type === 'analytics' ? 'block' : 'none';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
  updateTypeFields();
});
</script>
