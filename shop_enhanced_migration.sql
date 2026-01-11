-- Shop Enhanced Module Tables

CREATE TABLE IF NOT EXISTS `shop_wishlist` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `item_id` INT(11) UNSIGNED NOT NULL,
    `added_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `user_item` (`user_id`, `item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `shop_cart` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `item_id` INT(11) UNSIGNED NOT NULL,
    `quantity` INT(11) NOT NULL DEFAULT 1,
    `added_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `user_item` (`user_id`, `item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `shop_reviews` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `item_id` INT(11) UNSIGNED NOT NULL,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `rating` TINYINT(1) UNSIGNED NOT NULL,
    `review` TEXT,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `item_id` (`item_id`),
    KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `shop_item_views` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `item_id` INT(11) UNSIGNED NOT NULL,
    `view_count` INT(11) NOT NULL DEFAULT 0,
    `last_viewed` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `shop_enhanced_settings` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `setting_key` VARCHAR(100) NOT NULL,
    `setting_value` TEXT,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default settings
INSERT INTO `shop_enhanced_settings` (`setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
('enable_wishlist', '1', NOW(), NOW()),
('enable_cart', '1', NOW(), NOW()),
('enable_compare', '1', NOW(), NOW()),
('enable_reviews', '1', NOW(), NOW()),
('enable_item_preview', '1', NOW(), NOW()),
('max_cart_items', '20', NOW(), NOW()),
('max_wishlist_items', '50', NOW(), NOW()),
('max_compare_items', '4', NOW(), NOW()),
('require_review_purchase', '0', NOW(), NOW()),
('min_review_length', '20', NOW(), NOW())
ON DUPLICATE KEY UPDATE `updated_at` = NOW();

-- Create migration record
CREATE TABLE IF NOT EXISTS `shop_enhanced_migrations` (
    `module` VARCHAR(255) NOT NULL,
    `version` BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `shop_enhanced_migrations` (`module`, `version`) VALUES
('shop_enhanced', 20260111000000)
ON DUPLICATE KEY UPDATE `version` = 20260111000000;
