# Fixing 500 and 404 Errors - Quick Guide

## Issue Summary
1. **Server Status Admin 500 Error** - Database tables don't exist
2. **Leaderboards 404 Error** - Fixed (Admin controller added)
3. **Character Database Not Connected** - Configuration needed

---

## Step 1: Import Database Tables

Run the SQL file to create all required tables:

```bash
mysql -u root -p blizzcms < /home/scarecrow/BlizzCMS/INSTALL_MODULES.sql
```

Or manually import via phpMyAdmin:
1. Go to phpMyAdmin
2. Select `blizzcms` database
3. Click Import
4. Choose `INSTALL_MODULES.sql`
5. Click Go

---

## Step 2: Configure Character Database Connection

Edit `/home/scarecrow/BlizzCMS/application/config/database.php`

Add this configuration (if not already present):

```php
// Characters Database
$db['characters'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',  // Or your MySQL host
    'username' => 'root',        // Your MySQL username
    'password' => 'rootpassword', // Your MySQL password
    'database' => 'acore_characters', // Your character database name
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
```

**Important:** Replace these values:
- `hostname` - Your database server (usually 'localhost')
- `username` - Your MySQL username
- `password` - Your MySQL password
- `database` - Your character database name (e.g., 'acore_characters', 'characters', or 'acore_world')

---

## Step 3: Verify Database Names

Check what databases you have:

```bash
mysql -u root -p -e "SHOW DATABASES;"
```

Common character database names:
- `acore_characters`
- `characters`
- `mangos_characters`
- `trinity_characters`

Update the `database` value in Step 2 to match your actual database name.

---

## Step 4: Test the Modules

### Test Server Status:
1. Visit: `https://oldmanwarcraft.com/serverstatus`
2. Should show server statistics (may show 0 if no players online)
3. Visit admin: `https://oldmanwarcraft.com/serverstatus/admin`
4. Should no longer give 500 error

### Test Leaderboards:
1. Visit: `https://oldmanwarcraft.com/leaderboards`
2. Should show category selection
3. Click any category (PvP, Arena, etc.)
4. Should show rankings (may be empty if no character data)

---

## Common Issues & Solutions

### Issue: Still getting 500 error on server status
**Solution:** 
- Verify SQL import completed successfully
- Check `serverstatus_settings` and `serverstatus_history` tables exist:
  ```sql
  SHOW TABLES LIKE 'serverstatus%';
  ```

### Issue: Leaderboards show no data
**Solution:**
- This is normal if your character database is empty
- Data will populate automatically as players join
- Leaderboards pull live data from the character database

### Issue: "Table doesn't exist" errors in logs
**Solution:**
- Verify character database name in config matches actual database
- Ensure character database is accessible by the web user
- Grant permissions if needed:
  ```sql
  GRANT ALL ON acore_characters.* TO 'blizzcms'@'localhost';
  FLUSH PRIVILEGES;
  ```

### Issue: Discord module errors
**Solution:**
- Discord OAuth is optional
- It works independently of server status and leaderboards
- Configure only if you want Discord integration

---

## Verification Checklist

- [ ] SQL file imported successfully
- [ ] All 6 new tables exist in blizzcms database
- [ ] Character database configured in database.php
- [ ] Server status page loads without error
- [ ] Server status admin panel loads
- [ ] Leaderboards main page loads
- [ ] At least one leaderboard category page loads

---

## Quick SQL Verification

Run this to check if tables were created:

```sql
USE blizzcms;
SHOW TABLES LIKE 'serverstatus%';
SHOW TABLES LIKE 'leaderboards%';
SHOW TABLES LIKE 'discord%';
```

Should return:
- serverstatus_settings
- serverstatus_history
- leaderboards_settings
- leaderboards_firsts
- discord_settings
- discord_users
- discord_webhooks

---

## Still Having Issues?

### Check Error Logs:
```bash
tail -f /home/scarecrow/BlizzCMS/application/logs/log-2026-01-11.php
```

### Common Error Messages:

**"Table 'blizzcms.serverstatus_history' doesn't exist"**
- Solution: Import SQL file from Step 1

**"Table 'blizzcms.characters' doesn't exist"**
- Solution: Configure character database in Step 2

**"Unknown database 'acore_characters'"**
- Solution: Use correct database name from Step 3

---

## Need Help?

The modules are now set up with graceful error handling, so even if the character database isn't configured, the pages will load (just showing 0 counts). This lets you verify the modules work before connecting to actual game data.
