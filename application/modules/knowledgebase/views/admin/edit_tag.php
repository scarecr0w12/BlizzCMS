<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="uk-section uk-section-xsmall">
  <div class="uk-container uk-container-small">
    <h1 class="uk-h2 uk-margin-bottom"><?php echo lang('knowledgebase_edit_tag'); ?></h1>

    <form method="post" class="uk-form-stacked">
      <?php echo form_hidden(csrf_token(), csrf_hash()); ?>
      <div class="uk-margin">
        <label class="uk-form-label" for="name">
          <?php echo lang('knowledgebase_tag_name'); ?> <span class="uk-text-danger">*</span>
        </label>
        <div class="uk-form-controls">
          <input class="uk-input" type="text" id="name" name="name" value="<?php echo set_value('name', $tag->name); ?>" required>
          <?php echo form_error('name', '<p class="uk-text-danger uk-text-small uk-margin-small-top">', '</p>'); ?>
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="color">
          <?php echo lang('knowledgebase_color'); ?>
        </label>
        <div class="uk-form-controls uk-flex uk-flex-gap uk-flex-middle">
          <input class="uk-input" type="color" id="color" name="color" value="<?php echo set_value('color', $tag->color); ?>" 
                 style="width: 80px; height: 40px; padding: 4px;">
          <input class="uk-input" type="text" id="color_text" name="color_text" value="<?php echo set_value('color', $tag->color); ?>" style="flex: 1;">
        </div>
        <small class="uk-text-muted uk-display-block uk-margin-small-top">Hex color code</small>
        <?php echo form_error('color', '<p class="uk-text-danger uk-text-small uk-margin-small-top">', '</p>'); ?>
      </div>

      <div class="uk-margin uk-flex uk-flex-gap">
        <button type="submit" class="uk-button uk-button-primary">
          <i class="fa-solid fa-save"></i> <?php echo lang('knowledgebase_save'); ?>
        </button>
        <a href="<?php echo site_url('kb/admin/tags'); ?>" class="uk-button uk-button-default">
          <?php echo lang('knowledgebase_cancel'); ?>
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
