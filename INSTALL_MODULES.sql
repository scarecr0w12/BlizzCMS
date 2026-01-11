-- BlizzCMS Phase 1 Modules - Database Setup
-- Run this SQL file to create all required tables

-- ============================================
-- Server Status Module Tables
-- ============================================

CREATE TABLE IF NOT EXISTS `serverstatus_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `serverstatus_settings` (`setting_key`, `setting_value`) VALUES
('enable_realtime_updates', '1'),
('update_interval', '30'),
('show_faction_balance', '1'),
('show_class_distribution', '1'),
('show_level_distribution', '1'),
('track_uptime', '1');

CREATE TABLE IF NOT EXISTS `serverstatus_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `realm_id` int(11) unsigned NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `online_players` int(11) NOT NULL DEFAULT '0',
  `alliance_count` int(11) NOT NULL DEFAULT '0',
  `horde_count` int(11) NOT NULL DEFAULT '0',
  `uptime_seconds` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `realm_id` (`realm_id`,`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Leaderboards Module Tables
-- ============================================

CREATE TABLE IF NOT EXISTS `leaderboards_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `leaderboards_settings` (`setting_key`, `setting_value`) VALUES
('enable_pvp_rankings', '1'),
('enable_honor_kills', '1'),
('enable_arena_rankings', '1'),
('enable_achievements', '1'),
('enable_professions', '1'),
('enable_guild_rankings', '1'),
('items_per_page', '50'),
('cache_duration', '300');

CREATE TABLE IF NOT EXISTS `leaderboards_firsts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `character_guid` int(11) unsigned NOT NULL,
  `achievement_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `achievement_type` varchar(50) NOT NULL,
  `achievement_value` text,
  PRIMARY KEY (`id`),
  KEY `character_guid` (`character_guid`,`achievement_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- Discord Integration Tables
-- ============================================

CREATE TABLE IF NOT EXISTS `discord_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `discord_settings` (`setting_key`, `setting_value`) VALUES
('enable_oauth', '0'),
('client_id', ''),
('client_secret', ''),
('redirect_uri', ''),
('guild_id', ''),
('widget_enabled', '1'),
('webhook_url', ''),
('webhook_enabled', '0'),
('bot_token', '');

CREATE TABLE IF NOT EXISTS `discord_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `discord_id` varchar(100) NOT NULL,
  `discord_username` varchar(255) NOT NULL,
  `discord_discriminator` varchar(10) NOT NULL,
  `discord_avatar` text,
  `access_token` text,
  `refresh_token` text,
  `expires_at` timestamp NULL DEFAULT NULL,
  `linked_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `discord_id` (`discord_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `discord_webhooks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `webhook_name` varchar(100) NOT NULL,
  `webhook_url` text NOT NULL,
  `event_type` varchar(50) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
