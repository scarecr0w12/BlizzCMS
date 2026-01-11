# Phase 1 Complete Setup Guide

This guide walks you through setting up all Phase 1 modules: Server Status, Leaderboards, and Discord Integration.

---

## Phase 1A: Configure Character Database Connection

### Step 1: Verify Database Configuration

Edit `/application/config/database.php` and ensure you have a `characters` database configuration:

```php
$db['characters'] = [
    'dsn'      => '',
    'hostname' => 'host.docker.internal',  // or your MySQL host
    'username' => 'acore',                  // your character DB username
    'password' => 'acore',                  // your character DB password
    'database' => 'acore_characters',       // your character database name
    'port'     => 3306,
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => false,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => false,
    'cachedir' => '',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_unicode_ci',
    'swap_pre' => '',
    'encrypt'  => false,
    'compress' => false,
    'stricton' => false,
    'failover' => [],
    'save_queries' => true,
];
```

### Step 2: Test Database Connection

1. Go to Admin Panel > Settings > Database
2. Test the character database connection
3. Verify tables exist: `characters`, `character_skills`, `mail`, `mail_items`

**Common Issues:**
- Connection refused: Check hostname and port
- Access denied: Check username and password
- Database not found: Verify database name matches your emulator

---

## Phase 1B: Configure Realms for Leaderboards

### Step 1: Add Realm in Admin Panel

1. Login to Admin Panel
2. Navigate to **Admin > Realms**
3. Click **Add Realm**

### Step 2: Fill in Realm Details

**Basic Information:**
- **Realm Name:** Your server name (e.g., "Azeroth")
- **Maximum Capacity:** Player limit (e.g., 5000)

**Character Database Connection:**
- **Hostname:** Character database host (usually `localhost` or `host.docker.internal`)
- **Username:** Character database user
- **Password:** Character database password
- **Database:** Character database name (e.g., `acore_characters`)
- **Port:** Database port (usually 3306)

**Console Connection (for admin commands):**
- **Hostname:** Console/World server hostname
- **Username:** Console username
- **Password:** Console password
- **Port:** Console port (usually 7878)

**Realm Connection (for client):**
- **Hostname:** Realm server hostname (what players connect to)
- **Port:** Realm port (usually 8085)

### Step 3: Verify Realm Setup

1. Click **Save**
2. Go back to **Admin > Realms**
3. Verify realm appears in list with green status indicator

### Step 4: Test Leaderboards

1. Navigate to `/leaderboards`
2. You should see realm selection
3. Click a category (PvP, Honor, Arena, etc.)
4. Rankings should populate if characters exist in database

**If no data shows:**
- Ensure characters in database have level >= 70 for PvP rankings
- Check character database has proper data in `character_stats` table
- Verify realm ID matches in leaderboards queries

---

## Phase 1C: Setup Discord OAuth Integration

### Step 1: Create Discord Application

1. Go to [Discord Developer Portal](https://discord.com/developers/applications)
2. Click **New Application**
3. Enter application name (e.g., "BlizzCMS")
4. Accept terms and create

### Step 2: Get OAuth2 Credentials

1. In application settings, go to **OAuth2 > General**
2. Copy **Client ID**
3. Click **Reset Secret** and copy **Client Secret**

### Step 3: Configure Redirect URL

1. In **OAuth2 > General**, scroll to **Redirects**
2. Click **Add Redirect**
3. Enter: `https://yoursite.com/discord/callback`
4. Save

### Step 4: Add Discord Configuration to BlizzCMS

Edit `/application/config/config.php` and add:

```php
// Discord OAuth Configuration
$config['discord_client_id'] = 'YOUR_CLIENT_ID_HERE';
$config['discord_client_secret'] = 'YOUR_CLIENT_SECRET_HERE';
$config['discord_redirect_uri'] = 'https://yoursite.com/discord/callback';
```

### Step 5: Configure in Admin Panel

1. Login to Admin Panel
2. Navigate to **Admin > Discord Settings**
3. Fill in:
   - **Client ID:** Your Discord Client ID
   - **Client Secret:** Your Discord Client Secret
   - **Redirect URI:** Your callback URL
   - **Enable Discord:** Toggle ON

### Step 6: Test Discord Integration

1. Go to `/discord` on your site
2. Click **Link Discord Account**
3. You should be redirected to Discord login
4. After authorization, you should be linked

**If authorization fails:**
- Verify Client ID and Secret are correct
- Check Redirect URI matches exactly (including protocol)
- Ensure Discord application is not in development mode
- Check firewall/CORS settings

---

## Phase 1D: Server Status Dashboard

### Step 1: Enable Server Status Module

1. Admin Panel > **Modules**
2. Find **Server Status**
3. Click **Enable**

### Step 2: Configure Server Status

1. Admin Panel > **Server Status > Settings**
2. Configure:
   - **Update Interval:** How often to refresh stats (seconds)
   - **Enable Caching:** Toggle for performance
   - **Cache Duration:** How long to cache stats

### Step 3: Test Server Status

1. Navigate to `/serverstatus`
2. You should see:
   - Online player count
   - Faction balance (Alliance/Horde)
   - Class distribution
   - Level distribution
   - Server uptime

**If stats don't show:**
- Verify character database connection
- Ensure characters table has data
- Check logs for database errors

---

## Phase 1 Testing Checklist

- [ ] Character database connection verified
- [ ] Realm configured and online
- [ ] Leaderboards showing rankings
- [ ] Discord OAuth credentials configured
- [ ] Discord account linking works
- [ ] Server Status dashboard displays stats
- [ ] All modules accessible from main menu

---

## Troubleshooting

### Leaderboards show "No data available"
- **Cause:** No realms configured or no characters in database
- **Fix:** Add realm and ensure characters exist with level >= 70

### Discord linking fails
- **Cause:** Invalid credentials or redirect URI
- **Fix:** Verify Client ID, Secret, and Redirect URI in Discord Developer Portal

### Server Status shows 0 players
- **Cause:** Character database not connected or empty
- **Fix:** Verify database configuration and character data exists

### Realm shows offline
- **Cause:** Connection credentials incorrect
- **Fix:** Test credentials manually, verify hostname/port

---

## Next Steps

After Phase 1 is complete:
1. Configure payment gateways for Shop module (PayPal, Stripe)
2. Setup email notifications
3. Configure analytics tracking
4. Enable additional modules (Events, Notifications, etc.)

---

*Last Updated: January 11, 2026*
