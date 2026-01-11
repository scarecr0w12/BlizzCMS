<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1><?php echo lang('database_title'); ?></h1>
            <p class="text-muted"><?php echo lang('database_description'); ?></p>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12">
            <div class="input-group input-group-lg">
                <input type="text" class="form-control" id="search-input" placeholder="<?php echo lang('database_search_placeholder'); ?>">
                <button class="btn btn-primary" type="button" id="search-btn">
                    <i class="fas fa-search"></i> <?php echo lang('database_search'); ?>
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <?php foreach ($categories as $key => $label): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm hover-shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-book fa-3x mb-3 text-primary"></i>
                        <h5 class="card-title"><?php echo $label; ?></h5>
                        <p class="card-text text-muted">Browse all <?php echo strtolower($label); ?></p>
                        <a href="<?php echo site_url('database/' . $key); ?>" class="btn btn-primary btn-sm">
                            <?php echo lang('database_browse'); ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .hover-shadow {
        transition: box-shadow 0.3s ease;
    }
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>

<script>
document.getElementById('search-btn').addEventListener('click', function() {
    var query = document.getElementById('search-input').value;
    if (query.length >= 2) {
        window.location.href = '<?php echo site_url('database/search'); ?>?q=' + encodeURIComponent(query);
    }
});

document.getElementById('search-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        document.getElementById('search-btn').click();
    }
});
</script>
