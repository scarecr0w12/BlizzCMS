# PvP Stats Module - Quick Start Guide

## 5-Minute Setup

### Step 1: Verify Installation (1 minute)
Visit: `http://your-site.com/pvpstats/SETUP_VERIFICATION.php`

This will check:
- ✓ All module files are present
- ✓ Module configuration is valid
- ✓ Directory permissions are correct

### Step 2: Run Database Migration (1 minute)

**Option A: Via BlizzCMS Admin Panel**
1. Log in as admin
2. Go to System → Database Migrations
3. Find "Migration_Create_pvpstats_tables"
4. Click "Run"

**Option B: Via Command Line**
```bash
cd /var/www/html
php spark migrate
```

**Option C: Manual SQL**
Execute the SQL in `INSTALLATION.md` → Manual Database Setup section

### Step 3: Configure World Server (1 minute)

Edit your `worldserver.conf`:
```
Battleground.StoreStatistics.Enable = 1
```

Restart the world server:
```bash
systemctl restart azerothcore-worldserver
# or your server restart command
```

### Step 4: Access the Module (1 minute)

**Public Dashboard:**
- URL: `http://your-site.com/pvpstats`
- Shows: Top players, guilds, statistics

**Admin Panel:**
- URL: `http://your-site.com/pvpstats/admin`
- Requires: Admin login
- Features: Dashboard, settings

### Step 5: Test with Real Data (1 minute)

1. Complete a battleground match on your server
2. Wait 30 seconds for data to be recorded
3. Refresh `/pvpstats` to see the data

## Module Features at a Glance

| Feature | URL | Access |
|---------|-----|--------|
| Main Dashboard | `/pvpstats` | Public |
| Battlegrounds List | `/pvpstats/battlegrounds` | Public |
| Battleground Details | `/pvpstats/battleground/{id}` | Public |
| Top Players | `/pvpstats/players` | Public |
| Player Profile | `/pvpstats/player/{name}` | Public |
| Guild Rankings | `/pvpstats/guilds` | Public |
| Statistics | `/pvpstats/statistics` | Public |
| Admin Dashboard | `/pvpstats/admin` | Admin Only |
| Settings | `/pvpstats/admin/settings` | Admin Only |

## Configuration

Access `/pvpstats/admin/settings` to configure:

- **Enable PvP Statistics** - Toggle module on/off
- **Show Detailed Information** - Display detailed stats
- **Top Players Limit** - How many top players to show (default: 20)
- **Top Guilds Limit** - How many top guilds to show (default: 5)

## Troubleshooting

### No data appears after completing battlegrounds?

1. **Check world server config:**
   ```bash
   grep "Battleground.StoreStatistics.Enable" worldserver.conf
   ```
   Should output: `Battleground.StoreStatistics.Enable = 1`

2. **Restart world server:**
   ```bash
   systemctl restart azerothcore-worldserver
   ```

3. **Check database tables exist:**
   ```sql
   SHOW TABLES LIKE 'pvpstats%';
   ```
   Should show 3 tables: `pvpstats_battlegrounds`, `pvpstats_players`, `pvpstats_settings`

4. **Check for database errors:**
   Look at world server logs for SQL errors

### Module not found error?

1. Verify module directory exists:
   ```bash
   ls -la /var/www/html/application/modules/pvpstats/
   ```

2. Check file permissions:
   ```bash
   chmod -R 755 /var/www/html/application/modules/pvpstats/
   ```

3. Clear BlizzCMS cache if available

### Admin panel shows "Access Denied"?

- Ensure you're logged in as an admin user
- Check user permissions in database
- Verify `is_admin()` method works in your BlizzCMS installation

## File Structure

```
pvpstats/
├── config/
│   ├── module.php          ← Module metadata
│   ├── routes.php          ← URL routes
│   └── migration.php       ← Old migration (use main one)
├── controllers/
│   ├── Pvpstats.php        ← Public pages
│   └── Admin.php           ← Admin pages
├── models/
│   ├── Pvpstats_battleground_model.php
│   └── Pvpstats_player_model.php
├── views/
│   ├── index.php
│   ├── battlegrounds.php
│   ├── battleground_detail.php
│   ├── players.php
│   ├── player_stats.php
│   ├── guilds.php
│   ├── statistics.php
│   └── admin/
│       ├── index.php
│       └── settings.php
├── language/
│   └── english/
│       └── pvpstats_lang.php
├── README.md               ← Full documentation
├── INSTALLATION.md         ← Detailed setup
├── QUICK_START.md          ← This file
├── SETUP_VERIFICATION.php  ← Verification tool
└── SAMPLE_DATA.php         ← Test data (delete after use)
```

## Database Schema Overview

**pvpstats_battlegrounds**
- Stores match records (type, duration, winner, bracket)
- One record per completed battleground

**pvpstats_players**
- Stores individual player stats per match
- 20 records per battleground (10v10)
- Includes kills, deaths, damage, healing, objectives

**pvpstats_settings**
- Stores module configuration
- 4 default settings (enable, show_details, limits)

## API Endpoints

### Get Battlegrounds
```
GET /pvpstats/api/battlegrounds?limit=20&offset=0
```

Response:
```json
{
  "success": true,
  "battlegrounds": [...],
  "total": 150
}
```

### Get Player Stats
```
GET /pvpstats/api/player/{player_name}
```

Response:
```json
{
  "success": true,
  "player": {...},
  "win_rate": {...},
  "stats_by_type": [...]
}
```

## Performance Tips

1. **Large Datasets:** Adjust pagination limits in admin settings
2. **Database Optimization:** Indexes are created automatically by migration
3. **Caching:** Consider caching top players/guilds if you have 10k+ matches
4. **Archiving:** Archive old battleground data monthly if needed

## Security Notes

1. **Delete test files after setup:**
   ```bash
   rm /var/www/html/application/modules/pvpstats/SETUP_VERIFICATION.php
   rm /var/www/html/application/modules/pvpstats/SAMPLE_DATA.php
   ```

2. **Admin panel requires login** - Only authenticated admins can access settings

3. **SQL Injection Protection** - All queries use parameterized statements

4. **XSS Protection** - All output is properly escaped

## Getting Help

1. Check `README.md` for detailed documentation
2. Review `INSTALLATION.md` for setup issues
3. Check BlizzCMS community forums
4. Verify AzerothCore/TrinityCore configuration

## Next Steps

- [ ] Run SETUP_VERIFICATION.php
- [ ] Run database migration
- [ ] Configure worldserver.conf
- [ ] Restart world server
- [ ] Complete a battleground match
- [ ] Visit /pvpstats to view data
- [ ] Delete SETUP_VERIFICATION.php and SAMPLE_DATA.php
- [ ] Customize admin settings as needed

## Support

For issues or questions:
1. Review the troubleshooting section above
2. Check the full README.md documentation
3. Verify all configuration steps were completed
4. Check server logs for errors

---

**Module Version:** 1.0.0  
**Last Updated:** February 2, 2026  
**Status:** Ready for Production
