# On-Site SEO Implementation Guide - Code Changes

## Quick Implementation Reference

This document provides specific code changes and implementations for on-site SEO optimizations.

---

## 1. Homepage Title & Meta Description

### File: `/application/controllers/Home.php`

Add to the `index()` method:

```php
public function index()
{
    // Set optimized title
    $this->template->set('title', 'World of Warcraft Private Server | BlizzCMS Community');
    
    // Set optimized meta description
    $meta_description = 'Join our thriving World of Warcraft private server community. Experience epic gameplay, active guilds, and 24/7 support. Create your account today!';
    $this->template->set('meta_description', $meta_description);
    
    // Set meta keywords
    $this->template->set('meta_keywords', 'World of Warcraft, Private Server, WoW Server, Gaming Community, Multiplayer');
    
    // Set OG tags for social sharing
    $og_tags = [
        'og:title' => 'World of Warcraft Private Server | BlizzCMS',
        'og:description' => $meta_description,
        'og:type' => 'website',
        'og:url' => site_url(),
        'og:image' => base_url('assets/img/og-image-home.jpg'),
    ];
    $this->template->set('og_tags', $og_tags);
    
    // ... rest of existing code
}
```

---

## 2. News Listing Page Title & Meta Description

### File: `/application/controllers/News.php`

Add to the `index()` method:

```php
public function index()
{
    // Set optimized title
    $this->template->set('title', 'Latest WoW Server News & Updates | BlizzCMS');
    
    // Set optimized meta description
    $meta_description = 'Browse all World of Warcraft server news and updates. Latest patch notes, events, and community announcements. Check back regularly for new content.';
    $this->template->set('meta_description', $meta_description);
    
    // Set meta keywords
    $this->template->set('meta_keywords', 'WoW News, Server Updates, Patch Notes, Gaming News, Community Updates');
    
    // Set OG tags
    $og_tags = [
        'og:title' => 'Latest WoW Server News & Updates | BlizzCMS',
        'og:description' => $meta_description,
        'og:type' => 'website',
        'og:url' => site_url('news'),
        'og:image' => base_url('assets/img/og-image-news.jpg'),
    ];
    $this->template->set('og_tags', $og_tags);
    
    // ... rest of existing code
}
```

---

## 3. News Article Page Title & Meta Description

### File: `/application/controllers/News.php`

Add to the `article()` method:

```php
public function article($id, $slug)
{
    // Get article
    $article = $this->news_model->find($id);
    
    if (!$article) {
        show_404();
    }
    
    // Set optimized title (50-60 characters)
    $title = substr($article->title, 0, 50);
    $this->template->set('title', $title . ' - WoW Server News | BlizzCMS');
    
    // Set optimized meta description (150-160 characters)
    $summary = $article->summary ?? substr(strip_tags($article->content), 0, 155);
    $this->template->set('meta_description', $summary);
    
    // Set meta keywords from article
    $keywords = $article->meta_keywords ?? 'WoW News, Server Updates, ' . $article->title;
    $this->template->set('meta_keywords', $keywords);
    
    // Set OG tags for social sharing
    $og_tags = [
        'og:title' => $article->title,
        'og:description' => $summary,
        'og:type' => 'article',
        'og:url' => site_url('news/' . $article->id . '/' . $article->slug),
        'og:image' => base_url('uploads/' . $article->image),
        'article:published_time' => $article->created_at,
        'article:modified_time' => $article->updated_at ?? $article->created_at,
    ];
    $this->template->set('og_tags', $og_tags);
    
    // Set schema markup for NewsArticle
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'NewsArticle',
        'headline' => $article->title,
        'description' => $summary,
        'image' => base_url('uploads/' . $article->image),
        'datePublished' => $article->created_at,
        'dateModified' => $article->updated_at ?? $article->created_at,
        'author' => [
            '@type' => 'Organization',
            'name' => config_item('app_name')
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => config_item('app_name'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => base_url('assets/img/favicon.ico')
            ]
        ]
    ];
    $this->template->set('schema_markup', $schema);
    
    // ... rest of existing code
}
```

---

## 4. Improve Homepage Heading Structure

### File: `/application/views/home.php`

#### Change 1: Add H1 to Hero Section (Line 10)

**Before:**
```php
<h2 class="uk-h1 uk-text-bold uk-margin-remove bc-hero-title"><?= $slide->title ?></h2>
```

**After:**
```php
<h1 class="uk-h1 uk-text-bold uk-margin-remove bc-hero-title"><?= $slide->title ?></h1>
```

#### Change 2: Improve Welcome Section Heading (Line 63)

**Before:**
```php
<h2 class="uk-h3 uk-text-bold uk-margin-remove"><?= config_item('welcome_title') ?? lang('welcome') ?></h2>
```

**After:**
```php
<h2 class="uk-h2 uk-text-bold uk-margin-remove"><?= config_item('welcome_title') ?? lang('welcome') ?></h2>
```

#### Change 3: Improve Server Specs Heading (Line 88)

**Before:**
```php
<h2 class="uk-h3 uk-text-bold uk-margin-remove"><?= lang('server_specs') ?></h2>
```

**After:**
```php
<h2 class="uk-h2 uk-text-bold uk-margin-remove"><?= lang('server_specs') ?></h2>
```

#### Change 4: Improve Latest News Heading (Line 144)

**Before:**
```php
<h3 class="uk-h4 uk-text-bold uk-margin-small"><?= lang('latest_news') ?></h3>
```

**After:**
```php
<h2 class="uk-h2 uk-text-bold uk-margin-small"><?= lang('latest_news') ?></h2>
```

---

## 5. Optimize Image Alt Text

### File: `/application/views/home.php`

#### Change 1: Hero Section Images (Line 7)

**Before:**
```php
<img src="<?= $template['uploads'].$slide->path ?>" alt="<?= $slide->title ?>" uk-cover loading="lazy">
```

**After:**
```php
<img src="<?= $template['uploads'].$slide->path ?>" alt="<?= htmlspecialchars($slide->title . ' - World of Warcraft private server', ENT_QUOTES, 'UTF-8') ?>" uk-cover loading="lazy">
```

#### Change 2: Article Images (Line 150)

**Before:**
```php
<img src="<?= $template['uploads'].$article->image ?>" alt="<?= $article->title ?>" uk-cover>
```

**After:**
```php
<img src="<?= $template['uploads'].$article->image ?>" alt="<?= htmlspecialchars($article->title . ' - WoW server news and updates', ENT_QUOTES, 'UTF-8') ?>" uk-cover>
```

### File: `/application/views/article.php`

#### Change: Article Detail Image (Line 19)

**Before:**
```php
<img src="<?= $template['uploads'].$article->image ?>" alt="<?= $article->title ?>" uk-cover>
```

**After:**
```php
<img src="<?= $template['uploads'].$article->image ?>" alt="<?= htmlspecialchars($article->title . ' - World of Warcraft server news', ENT_QUOTES, 'UTF-8') ?>" uk-cover>
```

---

## 6. Improve Internal Linking

### File: `/application/views/home.php`

#### Change: Article Links (Line 156)

**Before:**
```php
<a class="uk-link-reset" href="<?= site_url('news/'.$article->id.'/'.$article->slug) ?>"><?= word_limiter($article->title, 12) ?></a>
```

**After:**
```php
<a class="uk-link-reset" href="<?= site_url('news/'.$article->id.'/'.$article->slug) ?>" title="Read: <?= htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8') ?>">
  <?= word_limiter($article->title, 12) ?>
</a>
```

### File: `/application/views/article.php`

#### Change: Related Articles Links (Line 115)

**Before:**
```php
<a href="<?= site_url('news/'.$item->id.'/'.$item->slug) ?>"><?= word_limiter($item->title, 10) ?></a>
```

**After:**
```php
<a href="<?= site_url('news/'.$item->id.'/'.$item->slug) ?>" title="Read: <?= htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8') ?>">
  <?= word_limiter($item->title, 10) ?>
</a>
```

---

## 7. Add H1 to Article Page

### File: `/application/views/article.php`

#### Change: Article Title (Line 9)

**Before:**
```php
<h1 class="uk-h3 uk-text-bold uk-margin-remove"><?= html_escape($article->title) ?></h1>
```

**After:**
```php
<h1 class="uk-h1 uk-text-bold uk-margin-remove"><?= html_escape($article->title) ?></h1>
```

---

## 8. Add Canonical Tags to Controllers

### File: `/application/controllers/Home.php`

Add to `index()` method:

```php
// Set canonical URL
$this->template->set('canonical_url', site_url());
```

### File: `/application/controllers/News.php`

Add to `index()` method:

```php
// Set canonical URL for news listing
$this->template->set('canonical_url', site_url('news'));
```

Add to `article()` method:

```php
// Set canonical URL for article
$this->template->set('canonical_url', site_url('news/' . $article->id . '/' . $article->slug));
```

---

## 9. Add Breadcrumb Schema

### File: `/application/controllers/News.php`

Add to `article()` method:

```php
// Set breadcrumb schema
$breadcrumbs = [
    'Home' => site_url(),
    'News' => site_url('news'),
    $article->title => site_url('news/' . $article->id . '/' . $article->slug)
];
$this->template->set('breadcrumbs', $breadcrumbs);

// Generate breadcrumb schema
$breadcrumb_schema = get_breadcrumb_schema($breadcrumbs);
$this->template->set('breadcrumb_schema', $breadcrumb_schema);
```

---

## 10. Add Page Speed Optimization Headers

### File: `/.htaccess`

Add after the CSP header section:

```apache
# Image optimization headers
<IfModule mod_headers.c>
  # WebP support
  <FilesMatch "\.(jpg|jpeg|png)$">
    Header append Vary Accept
  </FilesMatch>
  
  # Preload critical resources
  <FilesMatch "\.(woff2|ttf)$">
    Header set Link "</assets/css/critical.css>; rel=preload; as=style"
  </FilesMatch>
</IfModule>

# Async/Defer JavaScript
<IfModule mod_rewrite.c>
  # Defer non-critical scripts
  RewriteRule ^assets/js/non-critical\.js$ - [E=DEFER:true]
</IfModule>
```

---

## 11. Create Helper Function for Meta Tags

### File: `/application/helpers/seo_helper.php`

Add this function:

```php
if (!function_exists('set_page_seo')) {
    function set_page_seo($ci, $title, $description, $keywords = '', $og_tags = []) {
        // Set title
        $ci->template->set('title', $title);
        
        // Set meta description
        $ci->template->set('meta_description', $description);
        
        // Set meta keywords
        if (!empty($keywords)) {
            $ci->template->set('meta_keywords', $keywords);
        }
        
        // Set OG tags
        if (!empty($og_tags)) {
            $ci->template->set('og_tags', $og_tags);
        }
        
        // Set canonical URL if not already set
        if (!isset($ci->template->data['canonical_url'])) {
            $ci->template->set('canonical_url', current_url());
        }
    }
}
```

### Usage in Controllers:

```php
// In News.php article() method
set_page_seo(
    $this,
    $title . ' - WoW Server News | BlizzCMS',
    $summary,
    'WoW News, Server Updates, ' . $article->title,
    [
        'og:title' => $article->title,
        'og:description' => $summary,
        'og:type' => 'article',
        'og:url' => site_url('news/' . $article->id . '/' . $article->slug),
        'og:image' => base_url('uploads/' . $article->image),
    ]
);
```

---

## 12. Content Formatting Helper

### File: `/application/helpers/content_helper.php` (Create new file)

```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('format_article_content')) {
    function format_article_content($content) {
        // Ensure proper heading hierarchy
        $content = preg_replace('/<h1/', '<h2', $content);
        $content = preg_replace('/<\/h1>/', '</h2>', $content);
        
        // Add classes to lists for styling
        $content = preg_replace('/<ul>/', '<ul class="uk-list uk-list-bullet">', $content);
        $content = preg_replace('/<ol>/', '<ol class="uk-list uk-list-decimal">', $content);
        
        // Add classes to blockquotes
        $content = preg_replace('/<blockquote>/', '<blockquote class="uk-blockquote">', $content);
        
        return $content;
    }
}

if (!function_exists('get_excerpt')) {
    function get_excerpt($content, $length = 160) {
        $text = strip_tags($content);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        
        if (strlen($text) > $length) {
            $text = substr($text, 0, $length);
            $text = substr($text, 0, strrpos($text, ' ')) . '...';
        }
        
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}
```

Add to autoload helpers in `/application/config/autoload.php`:

```php
$autoload['helper'] = [..., 'content'];
```

---

## 13. Quick Implementation Checklist

### Phase 1: Titles & Descriptions (30 minutes)
- [ ] Update Home controller with optimized title and meta description
- [ ] Update News controller index with optimized title and meta description
- [ ] Update News controller article with dynamic title and meta description
- [ ] Test titles display correctly in browser tab

### Phase 2: Heading Structure (30 minutes)
- [ ] Change hero section H2 to H1 in home.php
- [ ] Update section headings from H3 to H2 in home.php
- [ ] Verify heading hierarchy is correct
- [ ] Test with accessibility tools

### Phase 3: Image Optimization (20 minutes)
- [ ] Update image alt text in home.php
- [ ] Update image alt text in article.php
- [ ] Verify alt text is descriptive and under 125 characters
- [ ] Test with screen readers

### Phase 4: Internal Linking (20 minutes)
- [ ] Add title attributes to article links
- [ ] Improve anchor text where needed
- [ ] Add internal links to related content
- [ ] Test all links work correctly

### Phase 5: Schema Markup (30 minutes)
- [ ] Add NewsArticle schema to article pages
- [ ] Verify schema with Schema.org validator
- [ ] Add breadcrumb schema
- [ ] Test in Google Search Console

### Phase 6: Testing & Verification (30 minutes)
- [ ] Test with Google Mobile-Friendly Test
- [ ] Test with Google PageSpeed Insights
- [ ] Validate schema markup
- [ ] Check in Google Search Console
- [ ] Test OG tags with Facebook Debugger

---

## 14. Testing Commands

### Validate Schema Markup
Visit: https://validator.schema.org/  
Paste your page source code

### Test Mobile Friendliness
Visit: https://search.google.com/test/mobile-friendly  
Enter: https://oldmanwarcraft.com/

### Test Page Speed
Visit: https://pagespeed.web.dev/  
Enter: https://oldmanwarcraft.com/

### Test OG Tags
Visit: https://developers.facebook.com/tools/debug/  
Enter: https://oldmanwarcraft.com/

### Check in Search Console
Visit: https://search.google.com/search-console  
Use URL Inspection tool

---

## 15. Expected Results

### Immediate (Week 1)
- ✅ Better CTR in search results (more compelling titles/descriptions)
- ✅ Improved accessibility (better heading structure)
- ✅ Better social sharing (OG tags)

### Short-term (Month 1)
- ✅ Improved keyword rankings
- ✅ Better user engagement
- ✅ Increased organic traffic

### Long-term (Month 3+)
- ✅ Significant traffic increase
- ✅ Higher conversion rates
- ✅ Established authority

---

## 16. Maintenance

### Weekly
- [ ] Monitor Google Search Console for errors
- [ ] Check for broken links
- [ ] Review new article titles and descriptions

### Monthly
- [ ] Analyze keyword rankings
- [ ] Review top performing pages
- [ ] Update underperforming content
- [ ] Check page speed metrics

### Quarterly
- [ ] Full on-site SEO audit
- [ ] Update content strategy
- [ ] Analyze competitor pages
- [ ] Plan content calendar

---

**Implementation Time**: 3-4 hours for all changes  
**Testing Time**: 1-2 hours  
**Total**: 4-6 hours

Start with Phase 1 and work through each phase systematically.

