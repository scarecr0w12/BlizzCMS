<div class="card">
    <div class="card-header">
        <div class="float-right">
            <a href="<?= site_url('shop') ?>" class="btn btn-sm btn-info" target="_blank">
                <i class="fas fa-eye"></i> View Shop
            </a>
            <a href="<?= site_url('shop_enhanced/admin/settings') ?>" class="btn btn-sm btn-primary">
                <i class="fas fa-cog"></i> Settings
            </a>
        </div>
        <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Shop Enhanced Administration</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card bg-primary text-white mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Total Wishlists</div>
                                <h3 class="mb-0"><?= number_format($statistics['total_wishlists']) ?></h3>
                            </div>
                            <i class="fas fa-heart fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card bg-success text-white mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Active Carts</div>
                                <h3 class="mb-0"><?= number_format($statistics['total_carts']) ?></h3>
                            </div>
                            <i class="fas fa-shopping-cart fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card bg-info text-white mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Total Reviews</div>
                                <h3 class="mb-0"><?= number_format($statistics['total_reviews']) ?></h3>
                            </div>
                            <i class="fas fa-star fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card bg-warning text-white mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small">Total Views</div>
                                <h3 class="mb-0"><?= number_format($statistics['total_views']) ?></h3>
                            </div>
                            <i class="fas fa-eye fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-fire"></i> Popular Items</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($popular_items)): ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <tbody>
                                        <?php foreach ($popular_items as $item): ?>
                                            <tr>
                                                <td>
                                                    <i class="fas fa-cube text-primary"></i>
                                                    <strong><?= htmlspecialchars($item->name ?? 'Item') ?></strong>
                                                </td>
                                                <td class="text-right">
                                                    <span class="badge badge-info"><?= number_format($item->view_count) ?> views</span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-center mb-0">No item views recorded yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Module Features</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Enhanced Shop Experience</strong></p>
                        <p class="small text-muted">This module extends the core shop with advanced features including wishlist management, shopping cart, item comparison, reviews, and detailed previews.</p>
                        
                        <hr>
                        
                        <p class="mb-2"><strong>Features:</strong></p>
                        <ul class="small mb-3">
                            <li>Wishlist - Save items for later</li>
                            <li>Shopping Cart - Multi-item checkout</li>
                            <li>Item Comparison - Compare multiple items</li>
                            <li>Reviews & Ratings - Customer feedback</li>
                            <li>Item Preview - Detailed item information</li>
                            <li>View Tracking - Popular items analytics</li>
                        </ul>
                        
                        <hr>
                        
                        <p class="mb-2"><strong>Quick Links:</strong></p>
                        <div class="btn-group btn-group-sm">
                            <a href="<?= site_url('shop/wishlist') ?>" class="btn btn-outline-primary" target="_blank">Wishlist</a>
                            <a href="<?= site_url('shop/cart') ?>" class="btn btn-outline-primary" target="_blank">Cart</a>
                            <a href="<?= site_url('shop/compare') ?>" class="btn btn-outline-primary" target="_blank">Compare</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-line"></i> Module Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="media">
                                    <div class="media-body">
                                        <h6 class="text-primary"><i class="fas fa-heart"></i> Wishlist System</h6>
                                        <p class="small text-muted mb-0">Users can save items to their wishlist for future purchase. Track which items are most desired by your community.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="media">
                                    <div class="media-body">
                                        <h6 class="text-success"><i class="fas fa-shopping-cart"></i> Shopping Cart</h6>
                                        <p class="small text-muted mb-0">Full cart system allowing users to add multiple items before checkout. Improves conversion rates and user experience.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="media">
                                    <div class="media-body">
                                        <h6 class="text-info"><i class="fas fa-star"></i> Reviews & Ratings</h6>
                                        <p class="small text-muted mb-0">Customer reviews and ratings help build trust and provide valuable feedback about shop items.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.opacity-50 { opacity: 0.5; }
.card-body h3 { font-weight: bold; }
</style>
