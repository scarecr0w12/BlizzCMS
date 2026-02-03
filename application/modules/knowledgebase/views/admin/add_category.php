<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="uk-section uk-section-xsmall">
  <div class="uk-container uk-container-small">
    <h1 class="uk-h2 uk-margin-bottom">Add Category</h1>

    <form method="post" class="uk-form-stacked">
      <?php $ci = &get_instance(); echo form_hidden($ci->security->get_csrf_token_name(), $ci->security->get_csrf_hash()); ?>
      <div class="uk-margin">
        <label class="uk-form-label" for="name">
          <?php echo lang('knowledgebase_category_name'); ?> <span class="uk-text-danger">*</span>
        </label>
        <div class="uk-form-controls">
          <input class="uk-input" type="text" id="name" name="name" value="<?php echo set_value('name'); ?>" 
                 placeholder="e.g., Getting Started" required>
          <?php echo form_error('name', '<p class="uk-text-danger uk-text-small uk-margin-small-top">', '</p>'); ?>
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="description">
          <?php echo lang('knowledgebase_description'); ?>
        </label>
        <div class="uk-form-controls">
          <textarea class="uk-textarea" id="description" name="description" rows="4"
                    placeholder="Brief description of this category"><?php echo set_value('description'); ?></textarea>
          <?php echo form_error('description', '<p class="uk-text-danger uk-text-small uk-margin-small-top">', '</p>'); ?>
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="icon">
          <?php echo lang('knowledgebase_icon'); ?>
        </label>
        <div class="uk-form-controls">
          <input class="uk-input" type="text" id="icon" name="icon" value="<?php echo set_value('icon'); ?>" 
                 placeholder="e.g., fas fa-book">
          <small class="uk-text-muted uk-display-block uk-margin-small-top">FontAwesome icon class (e.g., fas fa-book, fas fa-cog)</small>
          <?php echo form_error('icon', '<p class="uk-text-danger uk-text-small uk-margin-small-top">', '</p>'); ?>
        </div>
      </div>

      <div class="uk-margin">
        <div class="uk-form-controls">
          <label><input class="uk-checkbox" type="checkbox" name="is_active" value="1" <?php echo set_checkbox('is_active', 1, true); ?>>
            <?php echo lang('knowledgebase_active'); ?>
          </label>
        </div>
      </div>

      <div class="uk-margin uk-flex uk-flex-gap">
        <button type="submit" class="uk-button uk-button-primary">
          <i class="fa-solid fa-save"></i> Save
        </button>
        <a href="https://oldmanwarcraft.com/kb/admin/categories" class="uk-button uk-button-default">
          Cancel
        </a>
      </div>
    </form>
  </div>
</section>
