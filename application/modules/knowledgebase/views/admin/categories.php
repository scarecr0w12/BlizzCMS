<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container uk-container-expand">
    <div class="uk-flex uk-flex-between uk-flex-wrap uk-margin">
      <div>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-folder"></i> <?php echo lang('knowledgebase_categories'); ?>
        </h1>
      </div>
      <div>
        <a href="<?php echo site_url('kb/admin/categories/add'); ?>" class="uk-button uk-button-primary">
          <i class="fa-solid fa-plus"></i> <?php echo lang('knowledgebase_add_category'); ?>
        </a>
      </div>
    </div>

    <div class="uk-overflow-auto">
      <table class="uk-table uk-table-hover uk-table-divider">
        <thead>
          <tr>
            <th><?php echo lang('knowledgebase_category_name'); ?></th>
            <th><?php echo lang('knowledgebase_description'); ?></th>
            <th><?php echo lang('knowledgebase_icon'); ?></th>
            <th><?php echo lang('knowledgebase_status'); ?></th>
            <th class="uk-text-right"><?php echo lang('knowledgebase_actions'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($categories)): ?>
          <tr>
            <td colspan="5" class="uk-text-center uk-text-muted">
              <?php echo lang('knowledgebase_no_categories'); ?> <a href="<?php echo site_url('kb/admin/categories/add'); ?>"><?php echo lang('knowledgebase_create_one'); ?></a>
            </td>
          </tr>
          <?php else: ?>
            <?php foreach ($categories as $category): ?>
            <tr>
              <td><strong><?php echo htmlspecialchars($category->name); ?></strong></td>
              <td><?php echo htmlspecialchars(substr($category->description, 0, 50)); ?></td>
              <td class="uk-text-center">
                <?php if ($category->icon): ?>
                <i class="<?php echo htmlspecialchars($category->icon); ?>"></i>
                <?php else: ?>
                <span class="uk-text-muted">-</span>
                <?php endif; ?>
              </td>
              <td>
                <span class="uk-badge <?php echo $category->is_active ? 'uk-badge-success' : 'uk-badge-warning'; ?>">
                  <?php echo $category->is_active ? lang('knowledgebase_active') : lang('knowledgebase_inactive'); ?>
                </span>
              </td>
              <td class="uk-text-right">
                <a href="<?php echo site_url('kb/admin/categories/edit/' . $category->id); ?>" class="uk-button uk-button-text" title="<?php echo lang('knowledgebase_edit'); ?>">
                  <i class="fa-solid fa-edit"></i>
                </a>
                <form method="post" action="<?php echo site_url('kb/admin/categories/delete/' . $category->id); ?>" style="display:inline;" 
                      onsubmit="return confirm('<?php echo lang('knowledgebase_confirm_delete'); ?>');">
                  <?php $ci = &get_instance(); echo form_hidden($ci->security->get_csrf_token_name(), $ci->security->get_csrf_hash()); ?>
                  <button type="submit" class="uk-button uk-button-text uk-text-danger" title="<?php echo lang('knowledgebase_delete'); ?>">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
