-- Profile Enhanced Module Migration
-- Run this SQL script in your BlizzCMS database

-- Table 1: user_activities
CREATE TABLE IF NOT EXISTS `user_activities` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `activity_type` VARCHAR(50) NOT NULL,
  `activity_data` TEXT NULL,
  `reference_id` INT(11) NULL,
  `is_public` TINYINT(1) NOT NULL DEFAULT '1',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table 2: user_achievement_showcase
CREATE TABLE IF NOT EXISTS `user_achievement_showcase` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `achievement_id` INT(11) NOT NULL,
  `character_guid` INT(11) NULL,
  `showcase` TINYINT(1) NOT NULL DEFAULT '0',
  `earned_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `showcase` (`showcase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table 3: user_profiles
CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `bio` TEXT NULL,
  `location` VARCHAR(255) NULL,
  `website` VARCHAR(255) NULL,
  `avatar_url` VARCHAR(255) NULL,
  `cover_url` VARCHAR(255) NULL,
  `theme` VARCHAR(50) NOT NULL DEFAULT 'default',
  `show_achievements` TINYINT(1) NOT NULL DEFAULT '1',
  `show_characters` TINYINT(1) NOT NULL DEFAULT '1',
  `show_activity` TINYINT(1) NOT NULL DEFAULT '1',
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table 4: profile_visits
CREATE TABLE IF NOT EXISTS `profile_visits` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `profile_user_id` INT(11) UNSIGNED NOT NULL,
  `visitor_user_id` INT(11) UNSIGNED NULL,
  `visited_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `profile_user_id` (`profile_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table 5: profile_enhanced_settings
CREATE TABLE IF NOT EXISTS `profile_enhanced_settings` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_key` VARCHAR(100) NOT NULL,
  `setting_value` TEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default settings
INSERT INTO `profile_enhanced_settings` (`setting_key`, `setting_value`) VALUES
('enable_timeline', '1'),
('enable_achievements', '1'),
('enable_character_gallery', '1'),
('enable_profile_visits', '1'),
('enable_social_links', '1'),
('enable_profile_themes', '1'),
('max_showcase_achievements', '6'),
('default_profile_visibility', 'public'),
('require_bio_approval', '0'),
('max_bio_length', '500')
ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
