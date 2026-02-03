<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="uk-section">
  <div class="uk-container uk-container-expand">
    <a href="<?php echo site_url('kb'); ?>" class="uk-button uk-button-text uk-margin-bottom">
      <i class="fa-solid fa-arrow-left"></i> <?php echo lang('knowledgebase_back'); ?>
    </a>

    <div class="uk-card uk-card-primary uk-card-body uk-margin-large-bottom">
      <div class="uk-flex uk-flex-middle uk-flex-wrap">
        <?php if ($category->icon): ?>
        <div class="uk-margin-right">
          <i class="<?php echo htmlspecialchars($category->icon); ?> fa-3x"></i>
        </div>
        <?php endif; ?>
        <div>
          <h1 class="uk-h2 uk-margin-remove"><?php echo htmlspecialchars($category->name); ?></h1>
          <?php if ($category->description): ?>
          <p class="uk-text-muted uk-margin-small-top"><?php echo htmlspecialchars($category->description); ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <form method="get" class="uk-margin-large-bottom">
      <div class="uk-search uk-search-large">
        <a href="#" class="uk-search-icon-flip" uk-search-icon></a>
        <input class="uk-search-input" type="search" name="search" placeholder="<?php echo lang('knowledgebase_search'); ?>" 
               value="<?php echo htmlspecialchars($search_query); ?>">
      </div>
    </form>

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
                <a href="<?php echo site_url('kb/category/' . $cat->id); ?>" class="<?php echo $cat->id === $category->id ? 'uk-text-bold' : ''; ?>">
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
            <h2 class="uk-card-title"><?php echo lang('knowledgebase_articles'); ?></h2>

            <?php if (empty($articles)): ?>
            <div class="uk-text-center uk-padding">
              <i class="fa-solid fa-inbox fa-3x uk-text-muted"></i>
              <p class="uk-text-muted uk-margin-top"><?php echo lang('knowledgebase_no_results'); ?></p>
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
                  <i class="fa-solid fa-eye"></i> <?php echo $article->views; ?> <?php echo lang('knowledgebase_views'); ?>
                </small>
              </li>
              <?php endforeach; ?>
            </ul>

            <?php if ($total_articles > $per_page): ?>
            <div class="uk-margin-top uk-text-center">
              <ul class="uk-pagination">
                <?php for ($i = 1; $i <= ceil($total_articles / $per_page); $i++): ?>
                <li <?php echo $i === $current_page ? 'class="uk-active"' : ''; ?>>
                  <a href="<?php echo site_url('kb/category/' . $category->id . '?page=' . $i); ?>"><?php echo $i; ?></a>
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
