# PvP Stats Module - 500 Error Fix

## Problem Identified

The module was throwing 500 errors because the database tables didn't exist yet. The migration hadn't been run.

**Error in logs:**
```
ERROR - 2026-02-02 17:26:13 --> Query error: Table 'blizzcms.pvpstats_players' doesn't exist
```

## Solution Applied

Fixed all model methods to gracefully handle missing tables by:
1. Checking if tables exist before querying
2. Returning empty arrays/null instead of throwing errors
3. Wrapping query results with null checks

**Files Modified:**
- `/application/modules/pvpstats/models/Pvpstats_battleground_model.php`
- `/application/modules/pvpstats/models/Pvpstats_player_model.php`

## How to Fix the 500 Errors

### Step 1: Run the Database Migration

```bash
cd /var/www/html
php spark migrate
```

Or use BlizzCMS admin panel:
1. Go to System → Database Migrations
2. Find "Migration_Create_pvpstats_tables" (timestamp: 20260202170900)
3. Click "Run"

### Step 2: Verify Tables Were Created

```sql
SHOW TABLES LIKE 'pvpstats%';
```

Should show:
- `pvpstats_battlegrounds`
- `pvpstats_players`
- `pvpstats_settings`

### Step 3: Test the Module

Visit: `http://your-site.com/pvpstats`

Should now load without 500 errors (will show "No data" until battlegrounds are completed).

## What Changed in the Code

### Before (Caused 500 errors):
```php
public function get_top_players($limit = 20, $time_period = 'all')
{
    $query = "SELECT ...";
    return $this->db->query($query)->result();  // ← Fails if table doesn't exist
}
```

### After (Graceful handling):
```php
public function get_top_players($limit = 20, $time_period = 'all')
{
    // Check if table exists
    if (!$this->db->table_exists($this->players_table)) {
        return [];  // ← Returns empty array instead of error
    }
    
    $query = "SELECT ...";
    $result = $this->db->query($query);
    return $result ? $result->result() : [];  // ← Safe null check
}
```

## Module Status After Fix

✅ Module loads without 500 errors  
✅ Shows "No data" message when tables don't exist  
✅ Works normally after migration is run  
✅ All pages are accessible  

## Next Steps

1. **Run the migration** to create tables
2. **Complete a battleground match** on your server
3. **Visit `/pvpstats`** to see data
4. **Configure worldserver.conf** if not already done:
   ```
   Battleground.StoreStatistics.Enable = 1
   ```

## Troubleshooting

**Still getting 500 errors?**
- Clear browser cache
- Check that migration ran successfully
- Verify database tables exist
- Check `/application/logs/log-*.php` for specific errors

**No data appears after migration?**
- Ensure `Battleground.StoreStatistics.Enable = 1` in worldserver.conf
- Restart world server
- Complete a battleground match
- Wait 30 seconds for data to be recorded

---

**Status:** ✅ Fixed - Module now handles missing tables gracefully
