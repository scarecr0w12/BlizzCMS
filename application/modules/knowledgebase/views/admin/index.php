<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container uk-container-expand">
    <div class="uk-flex uk-flex-between uk-flex-wrap uk-margin">
      <div>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-book"></i> <?php echo lang('knowledgebase_admin'); ?>
        </h1>
        <p class="uk-text-meta uk-margin-remove"><?php echo lang('knowledgebase'); ?></p>
      </div>
    </div>

    <?php echo $template['partials']['alerts']; ?>

    <!-- Statistics Cards -->
    <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-4@m uk-margin-bottom" uk-grid>
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-flex uk-flex-between uk-flex-middle">
            <div>
              <div class="uk-text-large uk-text-bold"><?php echo $total_categories; ?></div>
              <div class="uk-text-muted"><?php echo lang('knowledgebase_categories'); ?></div>
            </div>
            <div>
              <i class="fa-solid fa-folder fa-2x uk-text-primary"></i>
            </div>
          </div>
        </div>
      </div>

      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-flex uk-flex-between uk-flex-middle">
            <div>
              <div class="uk-text-large uk-text-bold"><?php echo $total_articles; ?></div>
              <div class="uk-text-muted"><?php echo lang('knowledgebase_articles'); ?></div>
            </div>
            <div>
              <i class="fa-solid fa-file-alt fa-2x uk-text-success"></i>
            </div>
          </div>
        </div>
      </div>

      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-flex uk-flex-between uk-flex-middle">
            <div>
              <div class="uk-text-large uk-text-bold"><?php echo $total_tags; ?></div>
              <div class="uk-text-muted"><?php echo lang('knowledgebase_tags'); ?></div>
            </div>
            <div>
              <i class="fa-solid fa-tags fa-2x uk-text-warning"></i>
            </div>
          </div>
        </div>
      </div>

      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <div class="uk-flex uk-flex-between uk-flex-middle">
            <div>
              <div class="uk-text-large uk-text-bold"><?php echo $pending_comments; ?></div>
              <div class="uk-text-muted"><?php echo lang('knowledgebase_pending_comments'); ?></div>
            </div>
            <div>
              <i class="fa-solid fa-comments fa-2x uk-text-danger"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m uk-margin-bottom" uk-grid>
      <div>
        <a href="<?php echo site_url('kb/admin/articles'); ?>" class="uk-button uk-button-primary uk-width-1-1">
          <i class="fa-solid fa-list"></i> Manage Articles
        </a>
      </div>
      <div>
        <a href="<?php echo site_url('kb/admin/categories'); ?>" class="uk-button uk-button-secondary uk-width-1-1">
          <i class="fa-solid fa-list"></i> Manage Categories
        </a>
      </div>
      <div>
        <a href="<?php echo site_url('kb/admin/tags'); ?>" class="uk-button uk-button-default uk-width-1-1">
          <i class="fa-solid fa-list"></i> Manage Tags
        </a>
      </div>
    </div>

    <!-- Add New Items -->
    <div class="uk-margin-top">
      <h3 class="uk-h4">Add New</h3>
      <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid>
        <div>
          <a href="<?php echo site_url('kb/admin/articles/add'); ?>" class="uk-button uk-button-primary uk-width-1-1">
            <i class="fa-solid fa-plus"></i> Add Article
          </a>
        </div>
        <div>
          <a href="<?php echo site_url('kb/admin/categories/add'); ?>" class="uk-button uk-button-secondary uk-width-1-1">
            <i class="fa-solid fa-plus"></i> Add Category
          </a>
        </div>
        <div>
          <a href="<?php echo site_url('kb/admin/tags/add'); ?>" class="uk-button uk-button-default uk-width-1-1">
            <i class="fa-solid fa-plus"></i> Add Tag
          </a>
        </div>
      </div>
    </div>

    <!-- Featured Articles -->
    <?php if (!empty($featured_articles)): ?>
    <div class="uk-margin-top">
      <h3 class="uk-h4"><?php echo lang('knowledgebase_featured_articles'); ?></h3>
      <div class="uk-overflow-auto">
        <table class="uk-table uk-table-hover uk-table-divider">
          <tbody>
            <?php foreach ($featured_articles as $article): ?>
            <tr>
              <td>
                <strong><?php echo htmlspecialchars($article->title); ?></strong>
                <br>
                <small class="uk-text-muted"><?php echo $article->views; ?> <?php echo lang('knowledgebase_views'); ?></small>
              </td>
              <td class="uk-text-right">
                <a href="<?php echo site_url('kb/admin/articles/edit/' . $article->id); ?>" class="uk-button uk-button-text">
                  <i class="fa-solid fa-edit"></i>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
