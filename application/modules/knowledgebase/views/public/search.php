<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="uk-section">
  <div class="uk-container uk-container-expand">
    <a href="<?php echo site_url('kb'); ?>" class="uk-button uk-button-text uk-margin-bottom">
      <i class="fa-solid fa-arrow-left"></i> <?php echo lang('knowledgebase_back'); ?>
    </a>

    <div class="uk-margin-large-bottom">
      <h1 class="uk-h2 uk-margin-small-bottom"><?php echo lang('knowledgebase_search_results'); ?></h1>
      <p class="uk-text-lead uk-text-muted">
        <?php echo lang('knowledgebase_found'); ?> <?php echo $total_articles; ?> <?php echo $total_articles !== 1 ? lang('knowledgebase_results') : lang('knowledgebase_result'); ?> <?php echo lang('knowledgebase_for'); ?> "<?php echo htmlspecialchars($search_query); ?>"
      </p>

      <form method="get" action="<?php echo site_url('kb/search'); ?>" class="uk-margin-large-top">
        <div class="uk-search uk-search-large">
          <a href="#" class="uk-search-icon-flip" uk-search-icon></a>
          <input class="uk-search-input" type="search" name="q" placeholder="<?php echo lang('knowledgebase_search'); ?>" 
                 value="<?php echo htmlspecialchars($search_query); ?>" autofocus>
        </div>
      </form>
    </div>

    <div class="uk-grid-large" uk-grid>
      <div class="uk-width-1-4@m">
        <div class="uk-card uk-card-default uk-sticky" uk-sticky="offset: 20">
          <div class="uk-card-body">
            <h3 class="uk-card-title"><?php echo lang('knowledgebase_categories'); ?></h3>
            <ul class="uk-list uk-list-divider">
              <li>
                <a href="<?php echo site_url('kb'); ?>">
                  <?php echo lang('knowledgebase_all_articles'); ?>
                </a>
              </li>
              <?php foreach ($categories as $cat): ?>
              <li>
                <a href="<?php echo site_url('kb/category/' . $cat->id); ?>">
                  <?php if ($cat->icon): ?>
                  <i class="<?php echo htmlspecialchars($cat->icon); ?>"></i>
                  <?php endif; ?>
                  <?php echo htmlspecialchars($cat->name); ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>

      <div class="uk-width-3-4@m">
        <div class="uk-card uk-card-default">
          <div class="uk-card-body">
            <?php if (empty($articles)): ?>
            <div class="uk-text-center uk-padding">
              <i class="fa-solid fa-search fa-3x uk-text-muted"></i>
              <p class="uk-text-muted uk-margin-top"><?php echo lang('knowledgebase_no_search_results'); ?></p>
              <small class="uk-text-muted"><?php echo lang('knowledgebase_try_different_keywords'); ?></small>
            </div>
            <?php else: ?>
            <ul class="uk-list uk-list-divider">
              <?php foreach ($articles as $article): ?>
              <li>
                <h4 class="uk-margin-small-bottom">
                  <a href="<?php echo site_url('kb/article/' . $article->id); ?>" class="uk-link-heading">
                    <?php echo htmlspecialchars($article->title); ?>
                  </a>
                </h4>
                <p class="uk-text-muted uk-margin-small-bottom"><?php echo htmlspecialchars($article->excerpt); ?></p>
                <small class="uk-text-muted">
                  <i class="fa-solid fa-folder"></i> <?php echo lang('knowledgebase_category'); ?>
                </small>
              </li>
              <?php endforeach; ?>
            </ul>

            <?php if ($total_articles > $per_page): ?>
            <div class="uk-margin-top uk-text-center">
              <ul class="uk-pagination">
                <?php for ($i = 1; $i <= ceil($total_articles / $per_page); $i++): ?>
                <li <?php echo $i === $current_page ? 'class="uk-active"' : ''; ?>>
                  <a href="<?php echo site_url('kb/search?q=' . urlencode($search_query) . '&page=' . $i); ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>
              </ul>
            </div>
            <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
