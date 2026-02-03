<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container uk-container-expand">
    <div class="uk-flex uk-flex-between uk-flex-wrap uk-margin">
      <div>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">
          <i class="fa-solid fa-file-alt"></i> <?php echo lang('knowledgebase_articles'); ?>
        </h1>
      </div>
      <div>
        <a href="<?php echo site_url('kb/admin/articles/add'); ?>" class="uk-button uk-button-primary">
          <i class="fa-solid fa-plus"></i> <?php echo lang('knowledgebase_add_article'); ?>
        </a>
      </div>
    </div>

    <div class="uk-overflow-auto">
      <table class="uk-table uk-table-hover uk-table-divider">
        <thead>
          <tr>
            <th><?php echo lang('knowledgebase_article_title'); ?></th>
            <th><?php echo lang('knowledgebase_category'); ?></th>
            <th><?php echo lang('knowledgebase_status'); ?></th>
            <th><?php echo lang('knowledgebase_views'); ?></th>
            <th class="uk-text-right"><?php echo lang('knowledgebase_actions'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($articles)): ?>
          <tr>
            <td colspan="5" class="uk-text-center uk-text-muted">
              <?php echo lang('knowledgebase_no_articles'); ?> <a href="<?php echo site_url('kb/admin/articles/add'); ?>"><?php echo lang('knowledgebase_create_one'); ?></a>
            </td>
          </tr>
          <?php else: ?>
            <?php foreach ($articles as $article): ?>
            <tr>
              <td><strong><?php echo htmlspecialchars($article->title); ?></strong></td>
              <td><?php echo $article->category_id; ?></td>
              <td>
                <span class="uk-badge <?php echo $article->is_published ? 'uk-badge-success' : 'uk-badge-warning'; ?>">
                  <?php echo $article->is_published ? lang('knowledgebase_published') : lang('knowledgebase_draft'); ?>
                </span>
              </td>
              <td><?php echo $article->views; ?></td>
              <td class="uk-text-right">
                <a href="<?php echo site_url('kb/admin/articles/edit/' . $article->id); ?>" class="uk-button uk-button-text" title="<?php echo lang('knowledgebase_edit'); ?>">
                  <i class="fa-solid fa-edit"></i>
                </a>
                <?php if (!$article->is_published): ?>
                <form method="post" action="<?php echo site_url('kb/admin/articles/publish/' . $article->id); ?>" style="display:inline;">
                  <?php $ci = &get_instance(); echo form_hidden($ci->security->get_csrf_token_name(), $ci->security->get_csrf_hash()); ?>
                  <button type="submit" class="uk-button uk-button-text uk-text-success" title="<?php echo lang('knowledgebase_publish'); ?>">
                    <i class="fa-solid fa-check"></i>
                  </button>
                </form>
                <?php endif; ?>
                <form method="post" action="<?php echo site_url('kb/admin/articles/delete/' . $article->id); ?>" style="display:inline;" 
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

    <?php if ($total_articles > $per_page): ?>
    <div class="uk-margin-top uk-text-center">
      <ul class="uk-pagination">
        <?php for ($i = 1; $i <= ceil($total_articles / $per_page); $i++): ?>
        <li <?php echo $i === $current_page ? 'class="uk-active"' : ''; ?>>
          <a href="<?php echo site_url('kb/admin/articles?page=' . $i); ?>"><?php echo $i; ?></a>
        </li>
        <?php endfor; ?>
      </ul>
    </div>
    <?php endif; ?>
  </div>
</section>
