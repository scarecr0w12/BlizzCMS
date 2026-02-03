<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="uk-section uk-section-xsmall">
  <div class="uk-container uk-container-small">
    <h1 class="uk-h2 uk-margin-bottom">Add Article</h1>

    <form method="post" class="uk-form-stacked">
      <?php $ci = &get_instance(); echo form_hidden($ci->security->get_csrf_token_name(), $ci->security->get_csrf_hash()); ?>
      <div class="uk-margin">
        <label class="uk-form-label" for="title">
          Article Title <span class="uk-text-danger">*</span>
        </label>
        <div class="uk-form-controls">
          <input class="uk-input" type="text" id="title" name="title" value="" 
                 placeholder="Article title" required>
        </div>
      </div>

      <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-2@m">
          <div class="uk-margin">
            <label class="uk-form-label" for="category_id">
              Category <span class="uk-text-danger">*</span>
            </label>
            <div class="uk-form-controls">
              <select class="uk-select" id="category_id" name="category_id" required>
                <option value="">Select a category</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?php echo $cat->id; ?>">
                  <?php echo htmlspecialchars($cat->name); ?>
                </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>

        <div class="uk-width-1-2@m">
          <div class="uk-margin">
            <label class="uk-form-label" for="tags">
              Tags
            </label>
            <div class="uk-form-controls">
              <select class="uk-select" id="tags" name="tags[]" multiple>
                <?php foreach ($tags as $tag): ?>
                <option value="<?php echo $tag->id; ?>"><?php echo htmlspecialchars($tag->name); ?></option>
                <?php endforeach; ?>
              </select>
              <small class="uk-text-muted uk-display-block uk-margin-small-top">Hold Ctrl/Cmd to select multiple tags</small>
            </div>
          </div>
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="excerpt">
          Excerpt
        </label>
        <div class="uk-form-controls">
          <textarea class="uk-textarea" id="excerpt" name="excerpt" rows="3"
                    placeholder="Brief summary of the article"></textarea>
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="content">
          Content <span class="uk-text-danger">*</span>
        </label>
        <div class="uk-form-controls">
          <textarea id="content" name="content"></textarea>
        </div>
      </div>

      <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-2@m">
          <div class="uk-margin">
            <div class="uk-form-controls">
              <label><input class="uk-checkbox" type="checkbox" name="is_featured" value="1">
                Featured
              </label>
            </div>
          </div>
        </div>

        <div class="uk-width-1-2@m">
          <div class="uk-margin">
            <div class="uk-form-controls">
              <label><input class="uk-checkbox" type="checkbox" name="is_published" value="1">
                Published
              </label>
            </div>
          </div>
        </div>
      </div>

      <div class="uk-margin uk-flex uk-flex-gap">
        <button type="submit" class="uk-button uk-button-primary">
          <i class="fa-solid fa-save"></i> Save
        </button>
        <a href="https://oldmanwarcraft.com/kb/admin/articles" class="uk-button uk-button-default">
          Cancel
        </a>
      </div>
    </form>
  </div>
</section>

<script src="/assets/tinymce/tinymce.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof tinymce !== 'undefined') {
      tinymce.init({
        selector: '#content',
        height: 500,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | ul ol | removeformat',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        branding: false,
        promotion: false
      });
    }
  });
</script>
