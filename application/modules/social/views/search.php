<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo $page_title; ?></h1>
            
            <form method="get" action="<?php echo site_url('social/search'); ?>" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="q" placeholder="Search for users..." value="<?php echo htmlspecialchars($search_term); ?>" required>
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($users)): ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Search Results (<?php echo count($users); ?> found)</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php foreach ($users as $user): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0"><?php echo htmlspecialchars($user->username); ?></h6>
                                    </div>
                                    <div>
                                        <a href="<?php echo site_url('social/friends/add/' . $user->id); ?>" class="btn btn-sm btn-primary">Add Friend</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">No users found matching "<?php echo htmlspecialchars($search_term); ?>"</div>
            <?php endif; ?>
        </div>
    </div>
</div>
