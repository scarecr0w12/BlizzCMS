<?php
$this->load->helper('seo');

$og_tags = isset($og_tags) ? $og_tags : get_og_tags();
$canonical_url = isset($canonical_url) ? $canonical_url : current_url();
$meta_description = isset($meta_description) ? $meta_description : config_item('seo_description_tag');
$meta_keywords = isset($meta_keywords) ? $meta_keywords : 'World of Warcraft, Gaming, Community';
?>
<!-- SEO Meta Tags -->
<meta name="description" content="<?= htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8') ?>">
<meta name="keywords" content="<?= htmlspecialchars($meta_keywords, ENT_QUOTES, 'UTF-8') ?>">
<meta name="author" content="<?= htmlspecialchars(config_item('app_name'), ENT_QUOTES, 'UTF-8') ?>">
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

<!-- Search Engine Verification Tags -->
<?= render_google_search_console(config_item('google_search_console_verification')) ?>
<?= render_bing_webmaster_tools(config_item('bing_webmaster_verification')) ?>

<!-- Canonical Tag -->
<?= render_canonical_tag($canonical_url) ?>

<!-- Open Graph Tags -->
<?php
if (isset($og_image)) {
    $og_tags['og:image'] = $og_image;
}
echo render_og_tags($og_tags);
?>

<!-- Hreflang Tags -->
<?= get_hreflang_tags($this) ?>

<!-- Additional SEO Tags -->
<link rel="alternate" type="application/rss+xml" title="<?= htmlspecialchars(config_item('app_name'), ENT_QUOTES, 'UTF-8') ?> News Feed" href="<?= site_url('news/feed') ?>">
<link rel="dns-prefetch" href="//www.google-analytics.com">
<link rel="dns-prefetch" href="//www.googletagmanager.com">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<!-- Google Analytics -->
<?= render_google_analytics(config_item('google_analytics_id')) ?>

<!-- Facebook Pixel -->
<?= render_facebook_pixel(config_item('facebook_pixel_id')) ?>

<!-- Matomo Tag Manager -->
<?php if (config_item('matomo_enabled')): ?>
<script>
  var _mtm = window._mtm = window._mtm || [];
  _mtm.push({'mtm.startTime': (new Date().getTime()), 'event': 'mtm.Start'});
  (function() {
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.async=true; g.src='<?= config_item('matomo_site_url') ?>/js/container_<?= config_item('matomo_container_id') ?>.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<?php endif; ?>

<!-- Structured Data -->
<?php if (isset($schema_markup)): ?>
<?= render_schema_json($schema_markup) ?>
<?php else: ?>
<?= render_schema_json(get_structured_data('Organization')) ?>
<?php endif; ?>
