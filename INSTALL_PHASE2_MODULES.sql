-- BlizzCMS Phase 2 Modules - Database Setup
-- Run this SQL file to create tables for Notifications and Events modules

-- ============================================
-- Notifications Module Tables
-- ============================================

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text,
  `link` text,
  `icon` varchar(100) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `is_read` (`is_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `notification_preferences` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `email_notifications` tinyint(1) NOT NULL DEFAULT '1',
  `browser_notifications` tinyint(1) NOT NULL DEFAULT '1',
  `notify_donations` tinyint(1) NOT NULL DEFAULT '1',
  `notify_shop` tinyint(1) NOT NULL DEFAULT '1',
  `notify_votes` tinyint(1) NOT NULL DEFAULT '1',
  `notify_news` tinyint(1) NOT NULL DEFAULT '1',
  `notify_events` tinyint(1) NOT NULL DEFAULT '1',
  `notify_system` tinyint(1) NOT NULL DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `notification_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `notification_settings` (`setting_key`, `setting_value`) VALUES
('enable_email', '1'),
('enable_browser_push', '0'),
('retention_days', '30'),
('from_email', ''),
('from_name', 'BlizzCMS');

-- ============================================
-- Events Calendar Module Tables
-- ============================================

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `event_type` varchar(50) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `max_participants` int(11) DEFAULT NULL,
  `require_rsvp` tinyint(1) NOT NULL DEFAULT '0',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `realm_id` int(11) DEFAULT NULL,
  `created_by` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_type` (`event_type`),
  KEY `start_date` (`start_date`),
  KEY `featured` (`featured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `event_rsvps` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'attending',
  `character_name` varchar(100) DEFAULT NULL,
  `character_class` varchar(50) DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id_user_id` (`event_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `event_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `event_settings` (`setting_key`, `setting_value`) VALUES
('enable_rsvp', '1'),
('enable_reminders', '1'),
('reminder_hours', '24'),
('default_event_length', '2'),
('events_per_page', '12');
