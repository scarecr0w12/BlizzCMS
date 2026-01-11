-- BlizzCMS Phase 3 Modules - Database Setup
-- Run this SQL file to create tables for Shop Enhanced and Profile Enhanced modules

-- ============================================
-- Shop Enhanced Module Tables
-- ============================================

CREATE TABLE IF NOT EXISTS `shop_wishlist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `item_id` int(11) unsigned NOT NULL,
  `added_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_item_id` (`user_id`,`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `shop_cart` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `item_id` int(11) unsigned NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `added_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_item_id` (`user_id`,`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `shop_reviews` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `rating` tinyint(1) unsigned NOT NULL,
  `review` text,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `shop_item_views` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(11) unsigned NOT NULL,
  `view_count` int(11) NOT NULL DEFAULT '0',
  `last_viewed` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `shop_enhanced_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `shop_enhanced_settings` (`setting_key`, `setting_value`) VALUES
('enable_wishlist', '1'),
('enable_cart', '1'),
('enable_compare', '1'),
('enable_reviews', '1'),
('max_cart_items', '20'),
('max_compare_items', '4');

-- ============================================
-- Profile Enhanced Module Tables
-- ============================================

CREATE TABLE IF NOT EXISTS `user_activities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `activity_type` varchar(50) NOT NULL,
  `activity_data` text,
  `reference_id` int(11) DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `user_achievement_showcase` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `achievement_id` int(11) NOT NULL,
  `character_guid` int(11) DEFAULT NULL,
  `showcase` tinyint(1) NOT NULL DEFAULT '0',
  `earned_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `showcase` (`showcase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `bio` text,
  `location` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `cover_url` varchar(255) DEFAULT NULL,
  `theme` varchar(50) NOT NULL DEFAULT 'default',
  `show_achievements` tinyint(1) NOT NULL DEFAULT '1',
  `show_characters` tinyint(1) NOT NULL DEFAULT '1',
  `show_activity` tinyint(1) NOT NULL DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `profile_visits` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `profile_user_id` int(11) unsigned NOT NULL,
  `visitor_user_id` int(11) unsigned DEFAULT NULL,
  `visited_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `profile_user_id` (`profile_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `profile_enhanced_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `profile_enhanced_settings` (`setting_key`, `setting_value`) VALUES
('enable_timeline', '1'),
('enable_achievements', '1'),
('enable_statistics', '1'),
('max_showcase_achievements', '6'),
('timeline_items_per_page', '20');
