<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($sitemaps as $sitemap): ?>
  <sitemap>
    <loc><?= htmlspecialchars($sitemap, ENT_QUOTES, 'UTF-8') ?></loc>
    <lastmod><?= date('Y-m-d') ?></lastmod>
  </sitemap>
<?php endforeach; ?>
</sitemapindex>
