<?php
$this->load->helper('seo');

if (isset($breadcrumbs) && !empty($breadcrumbs)):
    $schema = get_breadcrumb_schema($breadcrumbs);
?>
<!-- Breadcrumb Navigation -->
<nav class="uk-breadcrumb uk-margin-small" aria-label="Breadcrumbs">
  <ul>
    <?php foreach ($breadcrumbs as $name => $url): ?>
    <li>
      <a href="<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></a>
    </li>
    <?php endforeach; ?>
  </ul>
</nav>

<!-- Breadcrumb Schema Markup -->
<?= render_schema_json($schema) ?>
<?php endif; ?>
