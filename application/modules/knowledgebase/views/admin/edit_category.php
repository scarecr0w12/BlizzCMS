<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="uk-section uk-section-xsmall">
  <div class="uk-container uk-container-small">
    <h1 class="uk-h2 uk-margin-bottom">Edit Category</h1>

    <form method="post" class="uk-form-stacked">
      <?php $ci = &get_instance(); echo form_hidden($ci->security->get_csrf_token_name(), $ci->security->get_csrf_hash()); ?>
      <div class="uk-margin">
        <label class="uk-form-label" for="name">
          Category Name <span class="uk-text-danger">*</span>
        </label>
        <div class="uk-form-controls">
          <input class="uk-input" type="text" id="name" name="name" value="<?php echo htmlspecialchars($category->name); ?>" required>
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="description">
          Description
        </label>
        <div class="uk-form-controls">
          <textarea class="uk-textarea" id="description" name="description" rows="4"><?php echo htmlspecialchars($category->description); ?></textarea>
        </div>
      </div>

      <div class="uk-margin">
        <label class="uk-form-label" for="icon">
          Icon
        </label>
        <div class="uk-form-controls">
          <input class="uk-input" type="text" id="icon" name="icon" value="<?php echo htmlspecialchars($category->icon); ?>">
          <small class="uk-text-muted uk-display-block uk-margin-small-top">FontAwesome icon class</small>
        </div>
      </div>

      <div class="uk-margin">
        <div class="uk-form-controls">
          <label><input class="uk-checkbox" type="checkbox" name="is_active" value="1" <?php echo ($category->is_active ? 'checked' : ''); ?>>
            Active
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
