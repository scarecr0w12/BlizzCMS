# PvP Stats Module - Installation Guide

## Quick Start

### Step 1: Verify Module Installation

The PvP Stats module should already be located in:
```
/var/www/html/application/modules/pvpstats/
```

### Step 2: Run Database Migration

The module includes a migration that creates all necessary database tables. You need to run this migration:

#### Option A: Using BlizzCMS Admin Panel
1. Log in to your BlizzCMS admin panel
2. Navigate to System → Database Migrations
3. Find and run the "Migration_Pvpstats" migration
4. Verify all tables were created successfully

#### Option B: Manual Database Setup

If migrations aren't available, manually execute these SQL queries:

```sql
CREATE TABLE IF NOT EXISTS `pvpstats_battlegrounds` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `bracket_id` INT UNSIGNED NOT NULL,
    `type` INT UNSIGNED NOT NULL,
    `winner` INT UNSIGNED NOT NULL,
    `start_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `end_time` TIMESTAMP NULL,
    `duration` INT UNSIGNED DEFAULT 0,
    `index` INT UNSIGNED DEFAULT 0,
    KEY `idx_bracket` (`bracket_id`),
    KEY `idx_type` (`type`),
    KEY `idx_winner` (`winner`),
    KEY `idx_start_time` (`start_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `pvpstats_players` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `battleground_id` INT UNSIGNED NOT NULL,
    `guid` INT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `race` INT UNSIGNED NOT NULL,
    `class` INT UNSIGNED NOT NULL,
    `level` INT UNSIGNED NOT NULL,
    `faction` INT UNSIGNED NOT NULL,
    `killing_blows` INT UNSIGNED DEFAULT 0,
    `deaths` INT UNSIGNED DEFAULT 0,
    `honorable_kills` INT UNSIGNED DEFAULT 0,
    `bonus_honor` INT UNSIGNED DEFAULT 0,
    `damage_done` BIGINT UNSIGNED DEFAULT 0,
    `healing_done` BIGINT UNSIGNED DEFAULT 0,
    `flag_captures` INT UNSIGNED DEFAULT 0,
    `flag_returns` INT UNSIGNED DEFAULT 0,
    `bases_assaulted` INT UNSIGNED DEFAULT 0,
    `bases_defended` INT UNSIGNED DEFAULT 0,
    `nodes_captured` INT UNSIGNED DEFAULT 0,
    `nodes_assaulted` INT UNSIGNED DEFAULT 0,
    `towers_assaulted` INT UNSIGNED DEFAULT 0,
    `towers_defended` INT UNSIGNED DEFAULT 0,
    `mines_captured` INT UNSIGNED DEFAULT 0,
    `farms_captured` INT UNSIGNED DEFAULT 0,
    `graveyards_assaulted` INT UNSIGNED DEFAULT 0,
    `graveyards_defended` INT UNSIGNED DEFAULT 0,
    `team` INT UNSIGNED NOT NULL,
    FOREIGN KEY (`battleground_id`) REFERENCES `pvpstats_battlegrounds` (`id`) ON DELETE CASCADE,
    KEY `idx_guid` (`guid`),
    KEY `idx_name` (`name`),
    KEY `idx_battleground` (`battleground_id`),
    KEY `idx_faction` (`faction`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `pvpstats_settings` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `setting_key` VARCHAR(255) NOT NULL UNIQUE,
    `setting_value` LONGTEXT,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pvpstats_settings` (`setting_key`, `setting_value`) VALUES
('pvpstats_enabled', '1'),
('pvpstats_show_details', '1'),
('pvpstats_top_players_limit', '20'),
('pvpstats_top_guilds_limit', '5')
ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
```

### Step 3: Configure AzerothCore/TrinityCore

Edit your `worldserver.conf` file and ensure this setting is enabled:

```
Battleground.StoreStatistics.Enable = 1
```

Restart your world server for the changes to take effect.

### Step 4: Verify Installation

1. Navigate to `http://your-site.com/pvpstats`
2. You should see the PvP Stats dashboard
3. Admin panel available at `http://your-site.com/pvpstats/admin` (admin only)

## Testing the Module

### Test 1: Access Public Pages
- [ ] `/pvpstats` - Main dashboard
- [ ] `/pvpstats/battlegrounds` - Battlegrounds list
- [ ] `/pvpstats/players` - Top players
- [ ] `/pvpstats/guilds` - Top guilds
- [ ] `/pvpstats/statistics` - Statistics page

### Test 2: Access Admin Panel
- [ ] `/pvpstats/admin` - Admin dashboard (requires admin login)
- [ ] `/pvpstats/admin/settings` - Settings page

### Test 3: Generate Test Data
1. Complete a battleground match on your server
2. Check if data appears in the module
3. Verify player statistics are recorded

## Troubleshooting

### Issue: "Module not found" error
**Solution**: Verify the module directory exists at `/application/modules/pvpstats/` with all required files.

### Issue: Database tables not created
**Solution**: 
1. Check database user has CREATE TABLE permissions
2. Manually execute the SQL queries above
3. Verify no errors in the migration log

### Issue: No battleground data appears
**Solution**:
1. Verify `Battleground.StoreStatistics.Enable = 1` in worldserver.conf
2. Restart the world server
3. Complete a battleground match
4. Check database tables for new records

### Issue: "Access Denied" on admin panel
**Solution**: Ensure you're logged in as an admin user. Only administrators can access `/pvpstats/admin`.

### Issue: Slow page loading with large datasets
**Solution**:
1. Check database indexes are created (done by migration)
2. Adjust pagination limits in admin settings
3. Consider archiving old battleground data

## Configuration

After installation, configure the module:

1. Log in as admin
2. Go to `/pvpstats/admin/settings`
3. Configure:
   - Enable/disable the module
   - Show/hide detailed information
   - Set top players limit
   - Set top guilds limit
4. Click "Save"

## Next Steps

- Review the [README.md](README.md) for detailed feature documentation
- Check the [Routes](#routes) section for available URLs
- Customize language strings in `/language/english/pvpstats_lang.php`
- Modify views in `/views/` to match your site design

## Support

For issues or questions:
1. Check the troubleshooting section above
2. Review the README.md documentation
3. Check BlizzCMS community forums
4. Verify AzerothCore/TrinityCore configuration

## Version Information

- **Module Version**: 1.0.0
- **Compatible with**: BlizzCMS, AzerothCore, TrinityCore
- **Database**: MySQL/MariaDB 5.7+
- **PHP**: 7.2+
