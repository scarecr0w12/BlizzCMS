<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

// General
$lang['shop'] = 'Shop';
$lang['shop_disabled'] = 'The shop is currently disabled.';
$lang['shop_title'] = 'Item Shop';
$lang['shop_description'] = 'Purchase items, services, and subscriptions for your characters.';

// Admin Navigation
$lang['admin_shop'] = 'Shop Dashboard';
$lang['admin_shop_categories'] = 'Categories';
$lang['admin_shop_items'] = 'Items';
$lang['admin_shop_services'] = 'Services';
$lang['admin_shop_subscriptions'] = 'Subscriptions';
$lang['admin_shop_orders'] = 'Orders';
$lang['admin_shop_payments'] = 'Payments';
$lang['shop_products'] = 'Products';
$lang['shop_no_orders'] = 'You have no orders yet.';

// Navigation
$lang['shop_home'] = 'Shop Home';
$lang['shop_items'] = 'Items';
$lang['shop_services'] = 'Services';
$lang['shop_subscriptions'] = 'Subscriptions';
$lang['shop_cart'] = 'Shopping Cart';
$lang['shop_checkout'] = 'Checkout';
$lang['shop_order_history'] = 'Order History';
$lang['shop_my_subscriptions'] = 'My Subscriptions';

// Categories
$lang['shop_all_categories'] = 'All Categories';
$lang['shop_category_items'] = 'In-Game Items';
$lang['shop_category_services'] = 'Character Services';
$lang['shop_category_subscriptions'] = 'Premium Subscriptions';

// Items
$lang['shop_featured_items'] = 'Featured Items';
$lang['shop_item_id'] = 'Game Item ID';
$lang['shop_item_count'] = 'Item Quantity';
$lang['shop_item_not_found'] = 'Item not found.';
$lang['shop_item_out_of_stock'] = 'This item is out of stock.';
$lang['shop_purchase_limit_reached'] = 'You have reached the maximum purchase limit for this item.';
$lang['shop_view_item'] = 'View Item';
$lang['shop_add_to_cart'] = 'Add to Cart';
$lang['shop_buy_now'] = 'Buy Now';
$lang['shop_in_stock'] = 'In Stock';
$lang['shop_out_of_stock'] = 'Out of Stock';
$lang['shop_limited_stock'] = 'Limited Stock';
$lang['shop_unlimited'] = 'Unlimited';
$lang['shop_stock'] = 'Stock';
$lang['shop_max_per_user'] = 'Max Per User';

// Pricing
$lang['shop_price'] = 'Price';
$lang['shop_price_dp'] = 'Donation Points';
$lang['shop_price_vp'] = 'Vote Points';
$lang['shop_price_money'] = 'Real Currency';
$lang['shop_free'] = 'Free';
$lang['shop_or'] = 'or';

// Cart
$lang['shop_cart_empty'] = 'Your cart is empty.';
$lang['shop_item_added_to_cart'] = 'Item added to cart successfully.';
$lang['shop_item_removed_from_cart'] = 'Item removed from cart.';
$lang['shop_cart_updated'] = 'Cart updated successfully.';
$lang['shop_cart_cleared'] = 'Cart cleared successfully.';
$lang['shop_cart_add_error'] = 'Failed to add item to cart.';
$lang['shop_update_cart'] = 'Update Cart';
$lang['shop_clear_cart'] = 'Clear Cart';
$lang['shop_continue_shopping'] = 'Continue Shopping';
$lang['shop_proceed_to_checkout'] = 'Proceed to Checkout';
$lang['shop_cart_total'] = 'Cart Total';
$lang['shop_quantity'] = 'Quantity';
$lang['shop_subtotal'] = 'Subtotal';
$lang['shop_total'] = 'Total';
$lang['shop_remove'] = 'Remove';

// Checkout
$lang['shop_checkout_title'] = 'Checkout';
$lang['shop_payment_method'] = 'Payment Method';
$lang['shop_select_payment_method'] = 'Select Payment Method';
$lang['shop_pay_with_points'] = 'Pay with Points';
$lang['shop_pay_with_dp'] = 'Pay with Donation Points';
$lang['shop_pay_with_vp'] = 'Pay with Vote Points';
$lang['shop_pay_with_paypal'] = 'Pay with PayPal';
$lang['shop_pay_with_stripe'] = 'Pay with Credit Card';
$lang['shop_your_balance'] = 'Your Balance';
$lang['shop_order_summary'] = 'Order Summary';
$lang['shop_order_items'] = 'Order Items';
$lang['shop_order_info'] = 'Order Information';
$lang['shop_delivery_info'] = 'Delivery Information';
$lang['shop_place_order'] = 'Place Order';
$lang['shop_complete_order'] = 'Complete Order';
$lang['shop_complete_purchase'] = 'Complete Purchase';
$lang['shop_secure_checkout'] = 'Secure Checkout';
$lang['shop_insufficient_dp'] = 'Insufficient Donation Points.';
$lang['shop_insufficient_vp'] = 'Insufficient Vote Points.';
$lang['shop_payment_method_disabled'] = 'This payment method is currently disabled.';
$lang['shop_invalid_payment_method'] = 'Invalid payment method selected.';
$lang['shop_order_create_error'] = 'Failed to create order. Please try again.';
$lang['shop_checkout_success'] = 'Payment Successful';
$lang['shop_checkout_success_msg'] = 'Your order has been processed successfully!';
$lang['shop_checkout_cancelled'] = 'Payment Cancelled';
$lang['shop_checkout_cancelled_msg'] = 'Your payment was cancelled.';
$lang['shop_paypal_not_configured'] = 'PayPal is not configured yet.';
$lang['shop_stripe_not_configured'] = 'Stripe is not configured yet.';
$lang['shop_all_payment_methods'] = 'All Payment Methods';
$lang['shop_pending_payment_note'] = 'Your payment is being processed. You will receive a notification once it is completed.';

// Orders
$lang['shop_order'] = 'Order';
$lang['shop_order_number'] = 'Order Number';
$lang['shop_order_date'] = 'Order Date';
$lang['shop_order_status'] = 'Status';
$lang['shop_order_completed'] = 'Your order has been completed successfully!';
$lang['shop_order_details'] = 'Order Details';
$lang['shop_no_orders'] = 'You have no orders yet.';
$lang['shop_view_order'] = 'View Order';

// Order Status
$lang['shop_status_pending'] = 'Pending';
$lang['shop_status_processing'] = 'Processing';
$lang['shop_status_completed'] = 'Completed';
$lang['shop_status_failed'] = 'Failed';
$lang['shop_status_refunded'] = 'Refunded';
$lang['shop_status_cancelled'] = 'Cancelled';
$lang['shop_status_delivered'] = 'Delivered';

// Services
$lang['shop_service_type'] = 'Service Type';
$lang['shop_service_rename'] = 'Character Rename';
$lang['shop_service_customize'] = 'Character Customization';
$lang['shop_service_race_change'] = 'Race Change';
$lang['shop_service_faction_change'] = 'Faction Change';
$lang['shop_service_level_boost'] = 'Level Boost';
$lang['shop_service_profession_boost'] = 'Profession Boost';
$lang['shop_service_gold'] = 'Gold Package';
$lang['shop_service_custom'] = 'Custom Service';
$lang['shop_select_character'] = 'Select Character';
$lang['shop_select_realm'] = 'Select Realm';
$lang['shop_requires_character'] = 'This service requires a character selection.';

// Subscriptions
$lang['shop_subscription'] = 'Subscription';
$lang['shop_subscription_type'] = 'Subscription Type';
$lang['shop_subscription_vip'] = 'VIP Membership';
$lang['shop_subscription_premium'] = 'Premium Membership';
$lang['shop_subscription_item_delivery'] = 'Item Delivery';
$lang['shop_subscription_service_access'] = 'Service Access';
$lang['shop_subscription_custom'] = 'Custom Subscription';
$lang['shop_interval_type'] = 'Billing Interval';
$lang['shop_interval_count'] = 'Interval Count';
$lang['shop_interval_daily'] = 'Daily';
$lang['shop_interval_weekly'] = 'Weekly';
$lang['shop_interval_monthly'] = 'Monthly';
$lang['shop_interval_yearly'] = 'Yearly';
$lang['shop_subscribe'] = 'Subscribe';
$lang['shop_subscribed'] = 'Subscribed';
$lang['shop_already_subscribed'] = 'You already have an active subscription for this plan.';
$lang['shop_subscription_not_found'] = 'Subscription not found.';
$lang['shop_subscription_not_active'] = 'This subscription is not active.';
$lang['shop_subscription_plan_inactive'] = 'This subscription plan is no longer available.';
$lang['shop_subscription_activated'] = 'Your subscription has been activated!';
$lang['shop_subscription_error'] = 'Failed to activate subscription.';
$lang['shop_subscription_cancelled'] = 'Your subscription has been cancelled.';
$lang['shop_subscription_cancel_error'] = 'Failed to cancel subscription.';
$lang['shop_subscription_renewed'] = 'Your subscription has been renewed!';
$lang['shop_subscription_renew_error'] = 'Failed to renew subscription.';
$lang['shop_cancel_subscription'] = 'Cancel Subscription';
$lang['shop_renew_subscription'] = 'Renew Subscription';
$lang['shop_subscription_active_until'] = 'Active until';
$lang['shop_subscription_benefits'] = 'Benefits';
$lang['shop_no_subscriptions'] = 'You have no subscriptions.';
$lang['shop_no_active_subscriptions'] = 'You have no active subscriptions.';
$lang['shop_view_available_subscriptions'] = 'View Available Subscriptions';

// Subscription Status
$lang['shop_sub_status_active'] = 'Active';
$lang['shop_sub_status_paused'] = 'Paused';
$lang['shop_sub_status_cancelled'] = 'Cancelled';
$lang['shop_sub_status_expired'] = 'Expired';

// Admin
$lang['shop_admin'] = 'Shop Administration';
$lang['shop_settings'] = 'Shop Settings';
$lang['shop_general_settings'] = 'General Settings';
$lang['shop_payment_settings'] = 'Payment Settings';
$lang['shop_categories'] = 'Categories';
$lang['shop_manage_items'] = 'Manage Items';
$lang['shop_manage_services'] = 'Manage Services';
$lang['shop_manage_subscriptions'] = 'Manage Subscriptions';
$lang['shop_manage_orders'] = 'Manage Orders';
$lang['shop_payment_logs'] = 'Payment Logs';

$lang['shop_add_category'] = 'Add Category';
$lang['shop_edit_category'] = 'Edit Category';
$lang['shop_add_item'] = 'Add Item';
$lang['shop_edit_item'] = 'Edit Item';
$lang['shop_add_service'] = 'Add Service';
$lang['shop_edit_service'] = 'Edit Service';
$lang['shop_add_subscription'] = 'Add Subscription Plan';
$lang['shop_edit_subscription'] = 'Edit Subscription Plan';

// Admin Alerts
$lang['alert_category_added'] = 'Category added successfully.';
$lang['alert_category_updated'] = 'Category updated successfully.';
$lang['alert_category_deleted'] = 'Category deleted successfully.';
$lang['alert_item_added'] = 'Item added successfully.';
$lang['alert_item_updated'] = 'Item updated successfully.';
$lang['alert_item_deleted'] = 'Item deleted successfully.';
$lang['alert_service_added'] = 'Service added successfully.';
$lang['alert_service_updated'] = 'Service updated successfully.';
$lang['alert_service_deleted'] = 'Service deleted successfully.';
$lang['alert_subscription_added'] = 'Subscription plan added successfully.';
$lang['alert_subscription_updated'] = 'Subscription plan updated successfully.';
$lang['alert_subscription_deleted'] = 'Subscription plan deleted successfully.';
$lang['alert_order_completed'] = 'Order marked as completed.';
$lang['alert_order_cancelled'] = 'Order has been cancelled.';
$lang['alert_order_refunded'] = 'Order has been refunded.';

// Statistics
$lang['shop_total_orders'] = 'Total Orders';
$lang['shop_pending_orders'] = 'Pending Orders';
$lang['shop_completed_orders'] = 'Completed Orders';
$lang['shop_total_revenue'] = 'Total Revenue';
$lang['shop_dp_spent'] = 'DP Spent';
$lang['shop_vp_spent'] = 'VP Spent';
$lang['shop_active_subscriptions'] = 'Active Subscriptions';
$lang['shop_recent_orders'] = 'Recent Orders';

// Misc
$lang['shop_delivery_items'] = 'Delivery Items';
$lang['shop_delivery_items_desc'] = 'JSON array of item IDs to deliver each billing period';
$lang['shop_service_value'] = 'Service Value';
$lang['shop_service_value_desc'] = 'JSON data for service parameters (e.g., level for boost)';
$lang['shop_benefits_desc'] = 'JSON array of benefit descriptions';
$lang['shop_featured'] = 'Featured';
$lang['shop_featured_desc'] = 'Show this item in featured section';

// Additional Admin
$lang['shop_dashboard_desc'] = 'Manage shop products, orders, and subscriptions.';
$lang['shop_dp_earned'] = 'DP Earned';
$lang['shop_vp_earned'] = 'VP Earned';
$lang['shop_add_category'] = 'Add Category';
$lang['shop_edit_category'] = 'Edit Category';
$lang['shop_add_item'] = 'Add Item';
$lang['shop_edit_item'] = 'Edit Item';
$lang['shop_add_service'] = 'Add Service';
$lang['shop_edit_service'] = 'Edit Service';
$lang['shop_add_subscription'] = 'Add Subscription';
$lang['shop_edit_subscription'] = 'Edit Subscription';
$lang['shop_game_item_id'] = 'Game Item ID';
$lang['shop_game_item_id_help'] = 'The item entry ID from your game database.';
$lang['shop_icon_help'] = 'FontAwesome icon class (e.g., fa-solid fa-box)';
$lang['shop_stock_help'] = '-1 for unlimited stock, 0 for out of stock';
$lang['shop_purchase_limit_help'] = '0 for no limit';
$lang['shop_pricing'] = 'Pricing';
$lang['shop_category_empty'] = 'No items in this category yet.';
$lang['shop_interval'] = 'Billing Interval';
$lang['shop_subscribers'] = 'Subscribers';
$lang['shop_interval_type'] = 'Interval Type';
$lang['shop_interval_count'] = 'Interval Count';
$lang['shop_interval_count_help'] = 'Number of intervals between billing (e.g., 2 weeks)';
$lang['shop_subscription_desc_help'] = 'Describe the benefits included in this subscription.';
$lang['shop_benefits_help'] = 'JSON format benefits array';
$lang['shop_item_reward'] = 'Item Reward ID';
$lang['shop_item_reward_help'] = 'Game item ID to deliver each billing cycle (0 = none)';
$lang['shop_gold_reward'] = 'Gold Reward';
$lang['shop_dp_reward'] = 'DP Reward';
$lang['shop_vp_reward'] = 'VP Reward';
$lang['shop_all_payment_methods'] = 'All Payment Methods';
$lang['shop_transaction_id'] = 'Transaction ID';
$lang['shop_gateway'] = 'Payment Gateway';
$lang['shop_amount'] = 'Amount';
$lang['shop_order_info'] = 'Order Information';
$lang['shop_confirm_process'] = 'Are you sure you want to process this order?';
$lang['shop_confirm_cancel'] = 'Are you sure you want to cancel this order?';
$lang['shop_confirm_complete'] = 'Are you sure you want to mark this order as completed?';
$lang['shop_confirm_refund'] = 'Are you sure you want to refund this order?';
$lang['shop_process_order'] = 'Process Order';
$lang['shop_cancel_order'] = 'Cancel Order';
$lang['shop_refund_order'] = 'Refund Order';
$lang['shop_no_actions_available'] = 'No actions available for this order.';

// Subscription Additional
$lang['shop_subscription_auto_renew'] = 'Subscriptions renew automatically.';
$lang['shop_no_refunds_subscriptions'] = 'No refunds for subscriptions.';
$lang['shop_your_subscriptions'] = 'Your Subscriptions';
$lang['shop_available_subscriptions'] = 'Available Subscriptions';
$lang['shop_subscription_info'] = 'Subscription Info';
$lang['shop_auto_renewal_desc'] = 'Your subscription will automatically renew when the billing period ends.';
$lang['shop_cancel_anytime_desc'] = 'You can cancel your subscription at any time from your account.';
$lang['shop_instant_activation_desc'] = 'Your subscription benefits are activated immediately after payment.';
$lang['shop_subscription_billed'] = 'This subscription will be billed %s.';
$lang['shop_subscribe_now'] = 'Subscribe Now';
$lang['shop_subscribed'] = 'Subscribed';
$lang['shop_subscription_details'] = 'Subscription Details';
$lang['shop_subscription_type'] = 'Subscription Type';
$lang['shop_started_on'] = 'Started On';
$lang['shop_end_date'] = 'End Date';
$lang['shop_cancel_subscription_note'] = 'You can cancel your subscription at any time. You will keep your benefits until the end of the current billing period.';
$lang['shop_cancel_confirm'] = 'Are you sure you want to cancel this subscription?';
$lang['shop_renew_subscription_note'] = 'Renew your subscription to continue enjoying the benefits.';
$lang['shop_subscription_expired_note'] = 'This subscription has expired. Subscribe again to continue.';
$lang['shop_per_daily'] = 'per day';
$lang['shop_per_weekly'] = 'per week';
$lang['shop_per_monthly'] = 'per month';
$lang['shop_per_yearly'] = 'per year';
$lang['shop_daily'] = 'Daily';
$lang['shop_weekly'] = 'Weekly';
$lang['shop_monthly'] = 'Monthly';
$lang['shop_yearly'] = 'Yearly';

// Service Info
$lang['shop_service_info'] = 'Service Information';
$lang['shop_service_requires_character'] = 'This service requires a character selection.';
$lang['shop_service_instant_delivery'] = 'Service is applied instantly after purchase.';
$lang['shop_service_non_refundable'] = 'Services are non-refundable.';
$lang['shop_other_services'] = 'Other Services';
$lang['shop_command'] = 'Server Command';
$lang['shop_command_help'] = 'Use {name} for character name, {guid} for GUID';
$lang['shop_requires_character'] = 'Requires Character Selection';

// Checkout
$lang['shop_character_delivery_note'] = 'Select the realm and character to receive the items.';
$lang['shop_balance_after'] = 'Balance after purchase';
$lang['shop_pending_payment_note'] = 'This order is awaiting payment processing.';
