<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="uk-section">
  <div class="uk-container uk-container-expand">
    <a href="<?php echo site_url('kb/category/' . $article->category_id); ?>" class="uk-button uk-button-text uk-margin-bottom">
      <i class="fa-solid fa-arrow-left"></i> <?php echo lang('knowledgebase_back_to'); ?> <?php echo htmlspecialchars($category->name); ?>
    </a>

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
        <article class="uk-card uk-card-default">
          <?php if ($article->featured_image): ?>
          <div class="uk-card-media-top">
            <img src="<?php echo htmlspecialchars($article->featured_image); ?>" alt="<?php echo htmlspecialchars($article->title); ?>" uk-cover>
          </div>
          <?php endif; ?>

          <div class="uk-card-body">
            <h1 class="uk-h2 uk-margin-small-bottom"><?php echo htmlspecialchars($article->title); ?></h1>

            <div class="uk-flex uk-flex-wrap uk-flex-middle uk-margin-bottom uk-padding-small uk-background-muted">
              <span class="uk-margin-small-right">
                <i class="fa-solid fa-calendar"></i> <?php echo date('F j, Y', strtotime($article->published_at)); ?>
              </span>
              <span>
                <i class="fa-solid fa-eye"></i> <?php echo $article->views; ?> <?php echo lang('knowledgebase_views'); ?>
              </span>
            </div>

            <?php if (!empty($tags)): ?>
            <div class="uk-margin-bottom">
              <div class="uk-flex uk-flex-wrap uk-flex-gap">
                <?php foreach ($tags as $tag): ?>
                <span class="uk-badge" style="background-color: <?php echo htmlspecialchars($tag->color); ?>">
                  <?php echo htmlspecialchars($tag->name); ?>
                </span>
                <?php endforeach; ?>
              </div>
            </div>
            <?php endif; ?>

            <div class="uk-margin-large-bottom uk-text-justify">
              <?php echo $article->content; ?>
            </div>

            <div class="uk-margin-top uk-padding-small uk-background-muted">
              <h4 class="uk-margin-small-bottom"><?php echo lang('knowledgebase_share'); ?></h4>
              <div class="uk-flex uk-flex-gap">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(current_url()); ?>" 
                   target="_blank" class="uk-button uk-button-text">
                  <i class="fab fa-facebook"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(current_url()); ?>&text=<?php echo urlencode($article->title); ?>" 
                   target="_blank" class="uk-button uk-button-text">
                  <i class="fab fa-twitter"></i>
                </a>
              </div>
            </div>
          </div>
        </article>

        <?php if (!empty($comments)): ?>
        <div class="uk-card uk-card-default uk-margin-top">
          <div class="uk-card-body">
            <h2 class="uk-card-title"><?php echo lang('knowledgebase_comments'); ?> (<?php echo count($comments); ?>)</h2>
            <ul class="uk-list uk-list-divider">
              <?php foreach ($comments as $comment): ?>
              <li>
                <div class="uk-flex uk-flex-between uk-flex-middle uk-margin-small-bottom">
                  <strong><?php echo htmlspecialchars($comment->author_name ?: lang('knowledgebase_anonymous')); ?></strong>
                  <small class="uk-text-muted"><?php echo date('F j, Y', strtotime($comment->created_at)); ?></small>
                </div>
                <p class="uk-margin-small-bottom"><?php echo htmlspecialchars($comment->content); ?></p>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
