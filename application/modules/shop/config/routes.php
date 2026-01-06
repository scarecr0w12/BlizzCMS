<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Public shop routes
$route['shop']['get'] = 'shop/index';
$route['shop/category/(:num)']['get'] = 'shop/category/$1';
$route['shop/item/(:num)']['get'] = 'shop/item/$1';
$route['shop/service/(:num)']['get'] = 'shop/service/$1';

// Cart routes
$route['shop/cart']['get'] = 'shop/cart';
$route['shop/cart/add']['post'] = 'shop/add_to_cart';
$route['shop/cart/update']['post'] = 'shop/update_cart';
$route['shop/cart/remove/(:any)']['post'] = 'shop/remove_from_cart/$1';
$route['shop/cart/clear']['post'] = 'shop/clear_cart';

// Checkout routes
$route['shop/checkout']['get'] = 'shop/checkout';
$route['shop/checkout']['post'] = 'shop/process_checkout';
$route['shop/checkout/characters/(:num)']['get'] = 'shop/checkout_characters/$1';
$route['shop/checkout/success']['get'] = 'shop/checkout_success';
$route['shop/checkout/cancel']['get'] = 'shop/checkout_cancel';

// Payment gateway callbacks
$route['shop/payment/paypal/callback']['post'] = 'payment/paypal_callback';
$route['shop/payment/stripe/callback']['post'] = 'payment/stripe_callback';

// Subscription routes
$route['shop/subscriptions']['get'] = 'subscription/index';
$route['shop/subscriptions/(:num)']['get'] = 'subscription/view/$1';
$route['shop/subscriptions/subscribe/(:num)']['post'] = 'subscription/subscribe/$1';
$route['shop/subscriptions/cancel/(:num)']['post'] = 'subscription/cancel/$1';

// Purchase history
$route['shop/history']['get'] = 'shop/history';
$route['shop/history/(:num)']['get'] = 'shop/order_detail/$1';

// Admin routes
$route['shop/admin'] = 'admin/index';
$route['shop/admin/categories'] = 'admin/categories';
$route['shop/admin/categories/add']['get'] = 'admin/add_category';
$route['shop/admin/categories/add']['post'] = 'admin/add_category';
$route['shop/admin/categories/edit/(:num)']['get'] = 'admin/edit_category/$1';
$route['shop/admin/categories/edit/(:num)']['post'] = 'admin/edit_category/$1';
$route['shop/admin/categories/delete/(:num)']['post'] = 'admin/delete_category/$1';

$route['shop/admin/items'] = 'admin/items';
$route['shop/admin/items/add']['get'] = 'admin/add_item';
$route['shop/admin/items/add']['post'] = 'admin/add_item';
$route['shop/admin/items/edit/(:num)']['get'] = 'admin/edit_item/$1';
$route['shop/admin/items/edit/(:num)']['post'] = 'admin/edit_item/$1';
$route['shop/admin/items/delete/(:num)']['post'] = 'admin/delete_item/$1';

$route['shop/admin/services'] = 'admin/services';
$route['shop/admin/services/add']['get'] = 'admin/add_service';
$route['shop/admin/services/add']['post'] = 'admin/add_service';
$route['shop/admin/services/edit/(:num)']['get'] = 'admin/edit_service/$1';
$route['shop/admin/services/edit/(:num)']['post'] = 'admin/edit_service/$1';
$route['shop/admin/services/delete/(:num)']['post'] = 'admin/delete_service/$1';

$route['shop/admin/subscriptions'] = 'admin/subscriptions';
$route['shop/admin/subscriptions/add']['get'] = 'admin/add_subscription';
$route['shop/admin/subscriptions/add']['post'] = 'admin/add_subscription';
$route['shop/admin/subscriptions/edit/(:num)']['get'] = 'admin/edit_subscription/$1';
$route['shop/admin/subscriptions/edit/(:num)']['post'] = 'admin/edit_subscription/$1';
$route['shop/admin/subscriptions/delete/(:num)']['post'] = 'admin/delete_subscription/$1';

$route['shop/admin/orders'] = 'admin/orders';
$route['shop/admin/orders/(:num)']['get'] = 'admin/order_detail/$1';
$route['shop/admin/orders/process/(:num)']['post'] = 'admin/process_order/$1';

$route['shop/admin/payments'] = 'admin/payments';
