# PvP Stats Module - Deployment Checklist

## Pre-Deployment

- [ ] **Module Files Verified**
  - Run `SETUP_VERIFICATION.php` and confirm all checks pass
  - All 14+ PHP files present
  - All configuration files valid

- [ ] **Permissions Set Correctly**
  ```bash
  chmod -R 755 /var/www/html/application/modules/pvpstats/
  chmod -R 644 /var/www/html/application/modules/pvpstats/*.php
  ```

- [ ] **Database Backup Created**
  ```bash
  mysqldump -u root -p your_database > backup_$(date +%Y%m%d).sql
  ```

## Database Setup

- [ ] **Migration File Present**
  - File: `/var/www/html/application/migrations/20260202170900_create_pvpstats_tables.php`
  - Timestamp: 20260202170900

- [ ] **Run Migration**
  - Method 1: `php spark migrate`
  - Method 2: BlizzCMS Admin Panel → Migrations
  - Method 3: Manual SQL execution

- [ ] **Verify Tables Created**
  ```sql
  SHOW TABLES LIKE 'pvpstats%';
  ```
  Expected output:
  - `pvpstats_battlegrounds`
  - `pvpstats_players`
  - `pvpstats_settings`

- [ ] **Verify Table Structure**
  ```sql
  DESCRIBE pvpstats_battlegrounds;
  DESCRIBE pvpstats_players;
  DESCRIBE pvpstats_settings;
  ```

- [ ] **Check Default Settings Inserted**
  ```sql
  SELECT * FROM pvpstats_settings;
  ```
  Expected 4 rows:
  - `pvpstats_enabled` = 1
  - `pvpstats_show_details` = 1
  - `pvpstats_top_players_limit` = 20
  - `pvpstats_top_guilds_limit` = 5

## Server Configuration

- [ ] **Edit worldserver.conf**
  ```
  Battleground.StoreStatistics.Enable = 1
  ```

- [ ] **Verify Configuration**
  ```bash
  grep "Battleground.StoreStatistics.Enable" worldserver.conf
  ```

- [ ] **Restart World Server**
  ```bash
  systemctl restart azerothcore-worldserver
  # or your server restart command
  ```

- [ ] **Verify Server Started**
  ```bash
  systemctl status azerothcore-worldserver
  ```

## Module Activation

- [ ] **Clear BlizzCMS Cache**
  - Delete `/application/cache/*` if cache exists
  - Or use admin panel cache clear

- [ ] **Verify Routes Loaded**
  - Check `/application/modules/pvpstats/config/routes.php` exists
  - Routes should be auto-loaded by BlizzCMS

- [ ] **Test Module Access**
  - Public: `http://your-site.com/pvpstats`
  - Admin: `http://your-site.com/pvpstats/admin`

## Functionality Testing

- [ ] **Public Pages Load**
  - [ ] `/pvpstats` - Main dashboard
  - [ ] `/pvpstats/battlegrounds` - Battlegrounds list
  - [ ] `/pvpstats/players` - Top players
  - [ ] `/pvpstats/guilds` - Top guilds
  - [ ] `/pvpstats/statistics` - Statistics page

- [ ] **Admin Pages Load (Admin Only)**
  - [ ] `/pvpstats/admin` - Admin dashboard
  - [ ] `/pvpstats/admin/settings` - Settings page

- [ ] **API Endpoints Work**
  - [ ] `GET /pvpstats/api/battlegrounds` returns JSON
  - [ ] `GET /pvpstats/api/player/{name}` returns JSON

- [ ] **Database Connection Works**
  - Pages load without database errors
  - Check server error logs for SQL errors

## Data Population

- [ ] **Complete Test Battleground**
  - Start a battleground match on your server
  - Complete the match (let it finish naturally)
  - Wait 30 seconds for data to be recorded

- [ ] **Verify Data Recorded**
  ```sql
  SELECT COUNT(*) FROM pvpstats_battlegrounds;
  SELECT COUNT(*) FROM pvpstats_players;
  ```
  Should show at least 1 battleground and 20 players

- [ ] **Check Dashboard**
  - Visit `/pvpstats`
  - Should show the completed battleground
  - Should show player statistics

- [ ] **Check Player Profile**
  - Click on a player name
  - Should show individual player statistics
  - Should show match history

## Admin Settings

- [ ] **Access Settings Page**
  - Navigate to `/pvpstats/admin/settings`
  - Should load without errors

- [ ] **Test Settings Update**
  - Change a setting (e.g., top players limit to 10)
  - Click Save
  - Verify setting was saved
  - Refresh page to confirm persistence

- [ ] **Verify Settings Applied**
  - Check `/pvpstats` dashboard
  - Should show 10 top players instead of 20

## Performance & Optimization

- [ ] **Page Load Times**
  - Dashboard loads in < 2 seconds
  - Battlegrounds list loads in < 2 seconds
  - Player profile loads in < 3 seconds

- [ ] **Database Indexes**
  - Verify indexes created by migration
  - Check slow query log for any issues

- [ ] **Memory Usage**
  - Monitor PHP memory usage
  - Should not exceed 50MB per request

## Security Verification

- [ ] **Delete Test Files**
  ```bash
  rm /var/www/html/application/modules/pvpstats/SETUP_VERIFICATION.php
  rm /var/www/html/application/modules/pvpstats/SAMPLE_DATA.php
  ```

- [ ] **Check File Permissions**
  - No world-writable files
  - Configuration files not readable by web server

- [ ] **Verify Admin Access Control**
  - Non-admin users cannot access `/pvpstats/admin`
  - Should redirect to login page

- [ ] **Test SQL Injection Protection**
  - Try searching with SQL characters
  - Should not cause errors or expose data

- [ ] **Test XSS Protection**
  - Try entering HTML/JavaScript in search
  - Should be properly escaped in output

## Documentation

- [ ] **README.md Present**
  - Complete feature documentation
  - Database schema documented
  - API endpoints documented

- [ ] **INSTALLATION.md Present**
  - Step-by-step setup instructions
  - Troubleshooting guide
  - Manual SQL provided

- [ ] **QUICK_START.md Present**
  - 5-minute setup guide
  - Feature overview
  - Configuration instructions

## Backup & Rollback

- [ ] **Database Backup Created**
  - Before any production deployment
  - Stored in safe location

- [ ] **Rollback Plan Documented**
  - How to restore from backup
  - How to remove module if needed

- [ ] **Rollback Tested** (Optional)
  - Test backup restoration process
  - Verify data integrity after restore

## Post-Deployment

- [ ] **Monitor Error Logs**
  - Check `/application/logs/` for errors
  - Check web server error logs
  - Check world server logs

- [ ] **Monitor Database**
  - Check table sizes
  - Monitor query performance
  - Check for slow queries

- [ ] **User Feedback**
  - Test with regular users
  - Gather feedback on usability
  - Check for reported issues

- [ ] **Performance Monitoring**
  - Monitor page load times
  - Monitor database query times
  - Monitor server resource usage

## Maintenance Schedule

- [ ] **Daily**
  - Monitor error logs
  - Check database size growth

- [ ] **Weekly**
  - Review performance metrics
  - Check for slow queries
  - Verify data accuracy

- [ ] **Monthly**
  - Archive old battleground data (optional)
  - Optimize database tables
  - Review and update settings

- [ ] **Quarterly**
  - Full backup and restore test
  - Performance analysis
  - Security audit

## Known Issues & Workarounds

| Issue | Cause | Workaround |
|-------|-------|-----------|
| No data appears | World server not configured | Enable `Battleground.StoreStatistics.Enable = 1` |
| Module not found | Routes not loaded | Clear cache, restart web server |
| Slow queries | Large dataset | Archive old data, adjust pagination |
| Admin access denied | User not admin | Check user permissions in database |

## Support Contacts

- **BlizzCMS Community:** https://wow-cms.com
- **AzerothCore:** https://www.azerothcore.org
- **TrinityCore:** https://www.trinitycore.org

## Sign-Off

- [ ] **Deployment Completed By:** ________________
- [ ] **Date:** ________________
- [ ] **Verified By:** ________________
- [ ] **Date:** ________________

## Notes

```
[Space for deployment notes and observations]
```

---

**Module Version:** 1.0.0  
**Deployment Date:** ________________  
**Status:** ☐ Development ☐ Staging ☐ Production
