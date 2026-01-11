<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-cog text-primary"></i> Shop Enhanced Settings
        </h2>
        <div>
            <a href="<?= site_url('shop_enhanced/admin') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('shop_enhanced/admin/settings') ?>">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-toggle-on"></i> Feature Settings
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="enable_wishlist" name="enable_wishlist" value="1" <?= isset($settings['enable_wishlist']) && $settings['enable_wishlist'] == '1' ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="enable_wishlist">
                                    <strong>Enable Wishlist</strong>
                                    <small class="d-block text-muted">Allow users to save items to their wishlist</small>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="enable_cart" name="enable_cart" value="1" <?= isset($settings['enable_cart']) && $settings['enable_cart'] == '1' ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="enable_cart">
                                    <strong>Enable Shopping Cart</strong>
                                    <small class="d-block text-muted">Allow users to add multiple items to cart before checkout</small>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="enable_reviews" name="enable_reviews" value="1" <?= isset($settings['enable_reviews']) && $settings['enable_reviews'] == '1' ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="enable_reviews">
                                    <strong>Enable Reviews</strong>
                                    <small class="d-block text-muted">Allow users to write reviews and rate items</small>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="enable_compare" name="enable_compare" value="1" <?= isset($settings['enable_compare']) && $settings['enable_compare'] == '1' ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="enable_compare">
                                    <strong>Enable Item Comparison</strong>
                                    <small class="d-block text-muted">Allow users to compare multiple items side-by-side</small>
                                </label>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="enable_item_preview" name="enable_item_preview" value="1" <?= isset($settings['enable_item_preview']) && $settings['enable_item_preview'] == '1' ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="enable_item_preview">
                                    <strong>Enable Item Preview</strong>
                                    <small class="d-block text-muted">Show detailed item preview with 3D model and stats</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">
                            <i class="fas fa-sliders-h"></i> Limit Settings
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="max_cart_items">
                                <strong>Max Cart Items</strong>
                                <small class="text-muted">(Maximum items allowed in cart)</small>
                            </label>
                            <input type="number" class="form-control" id="max_cart_items" name="max_cart_items" value="<?= isset($settings['max_cart_items']) ? $settings['max_cart_items'] : '20' ?>" min="1" max="100">
                        </div>

                        <div class="form-group">
                            <label for="max_wishlist_items">
                                <strong>Max Wishlist Items</strong>
                                <small class="text-muted">(Maximum items allowed in wishlist)</small>
                            </label>
                            <input type="number" class="form-control" id="max_wishlist_items" name="max_wishlist_items" value="<?= isset($settings['max_wishlist_items']) ? $settings['max_wishlist_items'] : '50' ?>" min="1" max="200">
                        </div>

                        <div class="form-group mb-0">
                            <label for="max_compare_items">
                                <strong>Max Compare Items</strong>
                                <small class="text-muted">(Maximum items allowed in comparison)</small>
                            </label>
                            <input type="number" class="form-control" id="max_compare_items" name="max_compare_items" value="<?= isset($settings['max_compare_items']) ? $settings['max_compare_items'] : '4' ?>" min="2" max="10">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">
                            <i class="fas fa-comment"></i> Review Settings
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="require_review_purchase" name="require_review_purchase" value="1" <?= isset($settings['require_review_purchase']) && $settings['require_review_purchase'] == '1' ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="require_review_purchase">
                                            <strong>Require Purchase to Review</strong>
                                            <small class="d-block text-muted">Only users who purchased the item can leave reviews</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="min_review_length">
                                        <strong>Minimum Review Length</strong>
                                        <small class="text-muted">(Characters)</small>
                                    </label>
                                    <input type="number" class="form-control" id="min_review_length" name="min_review_length" value="<?= isset($settings['min_review_length']) ? $settings['min_review_length'] : '20' ?>" min="0" max="500">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0 text-muted small">
                                    <i class="fas fa-info-circle"></i> Changes will take effect immediately after saving.
                                </p>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Settings
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.custom-control-label strong {
    display: block;
    margin-bottom: 2px;
}
.shadow {
    box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15) !important;
}
</style>
