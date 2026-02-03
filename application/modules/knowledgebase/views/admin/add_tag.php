<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="uk-section uk-section-xsmall">
  <div class="uk-container uk-container-small">
    <h1 class="uk-h2 uk-margin-bottom">Add Tag</h1>

    <form method="post" class="uk-form-stacked">
      <?php $ci = &get_instance(); echo form_hidden($ci->security->get_csrf_token_name(), $ci->security->get_csrf_hash()); ?>
      
      <div class="uk-margin">
        <label class="uk-form-label" for="name">
          Tag Name <span class="uk-text-danger">*</span>
        </label>
        <div class="uk-form-controls">
          <input class="uk-input" type="text" id="name" name="name" value="" 
                 placeholder="e.g., Beginner, Advanced, Guide" required>
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="color">
          Color
        </label>
        <div class="uk-form-controls uk-flex uk-flex-gap uk-flex-middle">
          <input class="uk-input" type="color" id="color" name="color" value="#6B7280" 
                 style="width: 80px; height: 40px; padding: 4px;">
          <input class="uk-input" type="text" id="color_text" name="color_text" value="#6B7280" 
                 placeholder="#6B7280" style="flex: 1;">
        </div>
        <small class="uk-text-muted uk-display-block uk-margin-small-top">Hex color code (e.g., #FF5733)</small>
      </div>

      <div class="uk-margin uk-flex uk-flex-gap">
        <button type="submit" class="uk-button uk-button-primary">
          <i class="fa-solid fa-save"></i> Save
        </button>
        <a href="https://oldmanwarcraft.com/kb/admin/tags" class="uk-button uk-button-default">
          Cancel
        </a>
      </div>
    </form>

    <script>
      const colorInput = document.getElementById('color');
      const colorText = document.getElementById('color_text');
      
      colorInput.addEventListener('change', (e) => {
        colorText.value = e.target.value;
      });
      
      colorText.addEventListener('change', (e) => {
        if (/^#[0-9A-F]{6}$/i.test(e.target.value)) {
          colorInput.value = e.target.value;
        }
      });
    </script>
  </div>
</section>
