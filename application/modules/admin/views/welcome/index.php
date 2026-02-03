<section class="uk-section">
  <div class="uk-container">
    <div class="uk-grid-large" uk-grid>
      <!-- Form Section -->
      <div class="uk-width-2-3@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-header uk-background-secondary">
            <h3 class="uk-h3 uk-text-bold uk-margin-remove">
              <i class="fa-solid fa-hand-fist"></i> <?= lang('welcome_section') ?>
            </h3>
            <p class="uk-text-small uk-text-muted uk-margin-remove-top"><?= lang('edit_welcome_content') ?></p>
          </div>
          <div class="uk-card-body">
            <?= $template['partials']['alerts'] ?>

            <?= form_open(current_url(), ['class' => 'uk-form-stacked', 'id' => 'welcome_form']) ?>

            <!-- Welcome Message Section -->
            <fieldset class="uk-fieldset">
              <legend class="uk-legend uk-text-bold uk-margin-medium-bottom">
                <i class="fa-solid fa-pen"></i> <?= lang('welcome_message') ?>
              </legend>

              <div class="uk-margin">
                <label class="uk-form-label uk-text-bold"><?= lang('welcome_title') ?></label>
                <div class="uk-form-controls">
                  <input class="uk-input" type="text" name="welcome_title" value="<?= set_value('welcome_title', $welcome_title) ?>" placeholder="e.g., Welcome to Old Man Warcraft" id="welcome_title_input">
                  <?= form_error('welcome_title', '<div class="uk-alert uk-alert-danger uk-margin-small-top"><i class="fa-solid fa-circle-exclamation"></i>', '</div>') ?>
                  <small class="uk-text-muted"><i class="fa-solid fa-info-circle"></i> This is the main heading shown on the homepage</small>
                </div>
              </div>

              <div class="uk-margin">
                <label class="uk-form-label uk-text-bold"><?= lang('welcome_description') ?></label>
                <div class="uk-form-controls">
                  <textarea class="uk-textarea tinymce-editor" name="welcome_description" placeholder="Join thousands of players in an epic adventure..." id="welcome_desc_input"><?= set_value('welcome_description', $welcome_description) ?></textarea>
                  <?= form_error('welcome_description', '<div class="uk-alert uk-alert-danger uk-margin-small-top"><i class="fa-solid fa-circle-exclamation"></i>', '</div>') ?>
                  <small class="uk-text-muted"><i class="fa-solid fa-info-circle"></i> Main description text displayed below the title (supports rich text formatting)</small>
                </div>
              </div>

              <div class="uk-margin">
                <label class="uk-form-label uk-text-bold"><?= lang('welcome_subtitle') ?></label>
                <div class="uk-form-controls">
                  <textarea class="uk-textarea tinymce-editor" name="welcome_subtitle" placeholder="Whether you're a seasoned veteran or a new player..." id="welcome_sub_input"><?= set_value('welcome_subtitle', $welcome_subtitle) ?></textarea>
                  <?= form_error('welcome_subtitle', '<div class="uk-alert uk-alert-danger uk-margin-small-top"><i class="fa-solid fa-circle-exclamation"></i>', '</div>') ?>
                  <small class="uk-text-muted"><i class="fa-solid fa-info-circle"></i> Additional description and call-to-action text (supports rich text formatting)</small>
                </div>
              </div>
            </fieldset>

            <hr class="uk-divider-icon">

            <!-- Server Specifications Section -->
            <fieldset class="uk-fieldset">
              <legend class="uk-legend uk-text-bold uk-margin-medium-bottom">
                <i class="fa-solid fa-microchip"></i> <?= lang('server_specs') ?>
              </legend>

              <div class="uk-alert uk-alert-primary uk-margin-bottom">
                <i class="fa-solid fa-lightbulb"></i> <strong><?= lang('tip') ?>:</strong> These values appear as cards on the homepage welcome section
              </div>

              <div class="uk-grid-small" uk-grid>
                <div class="uk-width-1-2@s">
                  <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold">
                      <i class="fa-solid fa-globe"></i> <?= lang('expansion') ?>
                    </label>
                    <div class="uk-form-controls">
                      <input class="uk-input" type="text" name="spec_expansion" value="<?= set_value('spec_expansion', $spec_expansion) ?>" placeholder="e.g., World of Warcraft" id="spec_exp_input">
                      <?= form_error('spec_expansion', '<div class="uk-alert uk-alert-danger uk-margin-small-top"><i class="fa-solid fa-circle-exclamation"></i>', '</div>') ?>
                    </div>
                  </div>
                </div>

                <div class="uk-width-1-2@s">
                  <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold">
                      <i class="fa-solid fa-tachometer-alt"></i> <?= lang('experience_rate') ?>
                    </label>
                    <div class="uk-form-controls">
                      <input class="uk-input" type="text" name="spec_exp_rate" value="<?= set_value('spec_exp_rate', $spec_exp_rate) ?>" placeholder="e.g., 1x - 10x" id="spec_rate_input">
                      <?= form_error('spec_exp_rate', '<div class="uk-alert uk-alert-danger uk-margin-small-top"><i class="fa-solid fa-circle-exclamation"></i>', '</div>') ?>
                    </div>
                  </div>
                </div>

                <div class="uk-width-1-2@s">
                  <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold">
                      <i class="fa-solid fa-users"></i> <?= lang('player_count') ?>
                    </label>
                    <div class="uk-form-controls">
                      <input class="uk-input" type="text" name="spec_realms" value="<?= set_value('spec_realms', $spec_realms) ?>" placeholder="e.g., Multiple Realms" id="spec_realms_input">
                      <?= form_error('spec_realms', '<div class="uk-alert uk-alert-danger uk-margin-small-top"><i class="fa-solid fa-circle-exclamation"></i>', '</div>') ?>
                    </div>
                  </div>
                </div>

                <div class="uk-width-1-2@s">
                  <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold">
                      <i class="fa-solid fa-shield"></i> <?= lang('security') ?>
                    </label>
                    <div class="uk-form-controls">
                      <input class="uk-input" type="text" name="spec_security" value="<?= set_value('spec_security', $spec_security) ?>" placeholder="e.g., Secure and Stable" id="spec_sec_input">
                      <?= form_error('spec_security', '<div class="uk-alert uk-alert-danger uk-margin-small-top"><i class="fa-solid fa-circle-exclamation"></i>', '</div>') ?>
                    </div>
                  </div>
                </div>

                <div class="uk-width-1-2@s">
                  <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold">
                      <i class="fa-solid fa-headset"></i> <?= lang('support') ?>
                    </label>
                    <div class="uk-form-controls">
                      <input class="uk-input" type="text" name="spec_support" value="<?= set_value('spec_support', $spec_support) ?>" placeholder="e.g., 24/7 Support" id="spec_sup_input">
                      <?= form_error('spec_support', '<div class="uk-alert uk-alert-danger uk-margin-small-top"><i class="fa-solid fa-circle-exclamation"></i>', '</div>') ?>
                    </div>
                  </div>
                </div>

                <div class="uk-width-1-2@s">
                  <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold">
                      <i class="fa-solid fa-star"></i> <?= lang('community') ?>
                    </label>
                    <div class="uk-form-controls">
                      <input class="uk-input" type="text" name="spec_community" value="<?= set_value('spec_community', $spec_community) ?>" placeholder="e.g., Active and Friendly" id="spec_com_input">
                      <?= form_error('spec_community', '<div class="uk-alert uk-alert-danger uk-margin-small-top"><i class="fa-solid fa-circle-exclamation"></i>', '</div>') ?>
                    </div>
                  </div>
                </div>
              </div>
            </fieldset>

            <!-- Form Actions -->
            <div class="uk-margin-large-top uk-padding-top uk-border-top">
              <button class="uk-button uk-button-primary uk-button-large" type="submit" id="save_btn">
                <i class="fa-solid fa-save"></i> <?= lang('save_changes') ?>
              </button>
              <a href="<?= site_url('admin') ?>" class="uk-button uk-button-default uk-button-large uk-margin-small-left">
                <i class="fa-solid fa-arrow-left"></i> <?= lang('back') ?>
              </a>
              <a href="<?= site_url() ?>" target="_blank" class="uk-button uk-button-secondary uk-button-large uk-margin-small-left">
                <i class="fa-solid fa-external-link-alt"></i> <?= lang('view_homepage') ?>
              </a>
            </div>

            <?= form_close() ?>
          </div>
        </div>
      </div>

      <!-- Preview Section -->
      <div class="uk-width-1-3@m">
        <div class="uk-card uk-card-default uk-sticky" uk-sticky="offset: 80">
          <div class="uk-card-header uk-background-secondary">
            <h4 class="uk-h4 uk-text-bold uk-margin-remove">
              <i class="fa-solid fa-eye"></i> <?= lang('preview') ?>
            </h4>
          </div>
          <div class="uk-card-body">
            <div class="uk-alert uk-alert-primary">
              <i class="fa-solid fa-info-circle"></i> Live preview of welcome section
            </div>

            <!-- Welcome Message Preview -->
            <div class="uk-margin-bottom">
              <h5 class="uk-h5 uk-text-bold uk-text-muted uk-margin-small-bottom">
                <i class="fa-solid fa-hand-fist"></i> <?= lang('welcome_message') ?>
              </h5>
              <div class="uk-panel uk-panel-box uk-background-muted uk-padding-small">
                <h3 class="uk-h4 uk-margin-small" id="preview_title"><?= $welcome_title ?></h3>
                <p class="uk-text-small uk-margin-small" id="preview_desc"><?= substr($welcome_description, 0, 100) ?>...</p>
                <p class="uk-text-small uk-text-muted uk-margin-remove" id="preview_sub"><?= substr($welcome_subtitle, 0, 100) ?>...</p>
              </div>
            </div>

            <hr class="uk-divider-icon">

            <!-- Server Specs Preview -->
            <div>
              <h5 class="uk-h5 uk-text-bold uk-text-muted uk-margin-small-bottom">
                <i class="fa-solid fa-microchip"></i> <?= lang('server_specs') ?>
              </h5>
              <div class="uk-grid-collapse uk-child-width-1-2 uk-text-center" uk-grid>
                <div class="uk-padding-small uk-background-muted uk-margin-small-bottom">
                  <small class="uk-text-muted uk-text-uppercase"><?= lang('expansion') ?></small>
                  <p class="uk-text-small uk-margin-remove uk-text-bold" id="preview_exp"><?= $spec_expansion ?></p>
                </div>
                <div class="uk-padding-small uk-background-muted uk-margin-small-bottom">
                  <small class="uk-text-muted uk-text-uppercase"><?= lang('experience_rate') ?></small>
                  <p class="uk-text-small uk-margin-remove uk-text-bold" id="preview_rate"><?= $spec_exp_rate ?></p>
                </div>
                <div class="uk-padding-small uk-background-muted uk-margin-small-bottom">
                  <small class="uk-text-muted uk-text-uppercase"><?= lang('player_count') ?></small>
                  <p class="uk-text-small uk-margin-remove uk-text-bold" id="preview_realms"><?= $spec_realms ?></p>
                </div>
                <div class="uk-padding-small uk-background-muted uk-margin-small-bottom">
                  <small class="uk-text-muted uk-text-uppercase"><?= lang('security') ?></small>
                  <p class="uk-text-small uk-margin-remove uk-text-bold" id="preview_sec"><?= $spec_security ?></p>
                </div>
                <div class="uk-padding-small uk-background-muted uk-margin-small-bottom">
                  <small class="uk-text-muted uk-text-uppercase"><?= lang('support') ?></small>
                  <p class="uk-text-small uk-margin-remove uk-text-bold" id="preview_sup"><?= $spec_support ?></p>
                </div>
                <div class="uk-padding-small uk-background-muted">
                  <small class="uk-text-muted uk-text-uppercase"><?= lang('community') ?></small>
                  <p class="uk-text-small uk-margin-remove uk-text-bold" id="preview_com"><?= $spec_community ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.tiny.cloud/1/fm1fvz09ia6w0i0s1gpetgsy9lmx1htrjidqn8jwcofcsssn/tinymce/6/tinymce.min.js"></script>
<script>
tinymce.init({
  selector: '.tinymce-editor',
  api_key: 'fm1fvz09ia6w0i0s1gpetgsy9lmx1htrjidqn8jwcofcsssn',
  height: 300,
  plugins: 'lists link image table code help wordcount charmap emoticons',
  toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table charmap emoticons | removeformat code help',
  menubar: 'file edit view insert format tools help',
  content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; color: #c6c8cc; background-color: #0e1b3e; }',
  skin: 'oxide-dark',
  content_css: 'dark',
  branding: false,
  promotion: false,
  statusbar: true,
  resize: true,
  autoresize_bottom_margin: 50,
  paste_as_text: false,
  link_target_list: [
    { title: 'None', value: '' },
    { title: 'New window', value: '_blank' }
  ],
  image_advtab: true,
  image_caption: true,
  relative_urls: false,
  remove_script_host: false,
  convert_urls: true,
  images_upload_handler: function(blobInfo, progress) {
    var xhr, formData;
    xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.upload.onprogress = function(e) {
      progress(e.loaded / e.total * 100);
    };
    xhr.onload = function() {
      var json;
      if (xhr.status === 403) {
        failure('HTTP Error: ' + xhr.status, {remove: true});
        return;
      }
      if (xhr.status < 200 || xhr.status >= 300) {
        failure('HTTP Error: ' + xhr.status);
        return;
      }
      json = JSON.parse(xhr.responseText);
      if (!json || typeof json.location != 'string') {
        failure('Invalid JSON: ' + xhr.responseText);
        return;
      }
      success(json.location);
    };
    xhr.onerror = function() {
      failure('Image upload failed due to a XHR Transport error. Status Code: ' + xhr.status);
    };
    formData = new FormData();
    formData.append('file', blobInfo.blob(), blobInfo.filename());
    xhr.open('POST', '<?= site_url('admin/welcome/upload_image') ?>');
    xhr.send(formData);
  }
});

document.addEventListener('DOMContentLoaded', function() {
  const titleInput = document.getElementById('welcome_title_input');
  const expInput = document.getElementById('spec_exp_input');
  const rateInput = document.getElementById('spec_rate_input');
  const realmsInput = document.getElementById('spec_realms_input');
  const secInput = document.getElementById('spec_sec_input');
  const supInput = document.getElementById('spec_sup_input');
  const comInput = document.getElementById('spec_com_input');
  const form = document.getElementById('welcome_form');

  const previewTitle = document.getElementById('preview_title');
  const previewDesc = document.getElementById('preview_desc');
  const previewSub = document.getElementById('preview_sub');
  const previewExp = document.getElementById('preview_exp');
  const previewRate = document.getElementById('preview_rate');
  const previewRealms = document.getElementById('preview_realms');
  const previewSec = document.getElementById('preview_sec');
  const previewSup = document.getElementById('preview_sup');
  const previewCom = document.getElementById('preview_com');

  titleInput.addEventListener('input', function() {
    previewTitle.textContent = this.value || 'Welcome';
  });

  expInput.addEventListener('input', function() {
    previewExp.textContent = this.value || 'Expansion';
  });

  rateInput.addEventListener('input', function() {
    previewRate.textContent = this.value || 'Rate';
  });

  realmsInput.addEventListener('input', function() {
    previewRealms.textContent = this.value || 'Realms';
  });

  secInput.addEventListener('input', function() {
    previewSec.textContent = this.value || 'Security';
  });

  supInput.addEventListener('input', function() {
    previewSup.textContent = this.value || 'Support';
  });

  comInput.addEventListener('input', function() {
    previewCom.textContent = this.value || 'Community';
  });

  // Wait for TinyMCE to be ready
  tinymce.on('AddEditor', function(e) {
    const editor = e.editor;
    
    if (editor.id === 'welcome_desc_input') {
      editor.on('change', function() {
        const text = this.getContent({ format: 'text' });
        previewDesc.textContent = (text.substring(0, 100) || 'Description...') + '...';
      });
    }
    
    if (editor.id === 'welcome_sub_input') {
      editor.on('change', function() {
        const text = this.getContent({ format: 'text' });
        previewSub.textContent = (text.substring(0, 100) || 'Subtitle...') + '...';
      });
    }
  });

  // Sync TinyMCE content before form submission
  if (form) {
    form.addEventListener('submit', function(e) {
      // Ensure all TinyMCE editors save their content
      tinymce.triggerSave();
      
      // Wait a moment for TinyMCE to sync, then allow form submission
      setTimeout(function() {
        // Form will submit after this
      }, 100);
    });
  }
});
</script>
