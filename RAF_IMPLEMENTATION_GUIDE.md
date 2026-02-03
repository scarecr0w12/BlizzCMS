# Recruit a Friend (RAF) System Implementation Guide

## Overview

This guide explains how to implement the Recruit a Friend system using the **55Honey/Acore_RecruitAFriend** Lua module integrated with BlizzCMS.

The system allows players to recruit friends, and when recruits reach a target level within a time limit, the recruiter receives rewards. The integration connects the CMS registration form with the game server via SOAP commands.

---

## Prerequisites

### Server Requirements

1. **AzerothCore** compiled with **ElunaLua** module enabled
   - [AzerothCore](https://github.com/azerothcore/azerothcore-wotlk)
   - [Eluna Lua Module](https://www.azerothcore.org/catalogue-details.html?id=131435473)

2. **BlizzCMS** with SOAP connectivity configured
   - SOAP console access must be enabled on your worldserver
   - Realm configuration must include valid SOAP credentials

3. **Database Access**
   - Access to both auth and character databases

### Files Needed

- `recruit_a_friend.lua` - Download from [55Honey/Acore_RecruitAFriend](https://github.com/55Honey/Acore_RecruitAFriend)

---

## Step 1: Install the Lua Script

### 1.1 Place the Lua Script

```bash
# Copy the recruit_a_friend.lua to your lua_scripts directory
cp recruit_a_friend.lua /path/to/azerothcore/lua_scripts/
```

### 1.2 Configure the Lua Script

Edit `recruit_a_friend.lua` and adjust the configuration flags at the top:

```lua
Config = {}
Config.enabled = true
Config.minGMRankForBind = 3  -- GM rank required to use .bindraf command
Config.maxDays = 30          -- Days to reach target level (default: 30)
Config.targetLevel = 39      -- Level recruit must reach for reward (default: 39)
Config.checkSameIP = true    -- Check for same IP abuse (default: true)
Config.autoEndSameIP = false -- Auto-end RAF if same IP (default: false)
Config.dbName = 'acore_world' -- Database name for RAF tables
Config.abuseTreshold = 50    -- Actions before kick for abuse
```

### 1.3 Verify Eluna Configuration

Check your worldserver.conf:

```conf
Eluna.Enabled = 1
Eluna.ScriptPath = "lua_scripts"
```

Restart the worldserver to load the Lua script.

---

## Step 2: BlizzCMS Integration (Already Implemented)

The following changes have been made to your BlizzCMS installation:

### 2.1 Registration Form Update

**File:** `@/var/www/html/application/views/auth/register.php:60-68`

A new "Recruiter Username (Optional)" field has been added to the registration form, allowing new players to specify their recruiter's account username.

### 2.2 Auth Controller Logic

**File:** `@/var/www/html/application/controllers/Auth.php`

The registration process now:

1. **Validates the recruiter username** (lines 172-181)
   - Checks if the recruiter account exists in the auth database
   - Returns error if recruiter not found

2. **Stores recruiter ID in confirmation token** (line 198)
   - If email confirmation is enabled, the recruiter_id is saved in the token data

3. **Executes SOAP command on account creation** (lines 216-223, 268-275)
   - Calls `.bindraf <new_account_id> <recruiter_id>` on all online realms
   - Only executes if recruiter was specified
   - Handles both direct registration and email-confirmed registration

---

## Step 3: How It Works

### Registration Flow

```
User fills registration form
    ↓
User enters optional "Recruiter Username"
    ↓
CMS validates recruiter exists in auth.account
    ↓
Account created in auth database
    ↓
SOAP command executed: .bindraf <new_id> <recruiter_id>
    ↓
Lua script creates RAF link in database
    ↓
User can now play and recruit is tracked
```

### Player Commands (In-Game)

Once linked, players can use:

```
.raf                 - Shows account ID and RAF help
.raf help            - Shows RAF help
.raf list            - Shows all recruits (for recruiter only)
.raf summon          - Recruiter summons recruit to current location
```

### Reward System

When a recruit reaches the target level (default: 39) within the time limit (default: 30 days):

- **1st recruit:** Mini-Thor pet
- **2nd recruit:** 14-slot bag
- **5th recruit:** Diablos-Stone pet
- **10th recruit:** Tyrael's Hilt pet
- **4th, 6th-9th, 10+:** Potions/Elixirs (4 stacks)

Recruiter receives a mail with the reward items.

---

## Step 4: Testing the Integration

### 4.1 Verify Lua Script is Loaded

In-game, as a GM:

```
.lua_engine reload
```

Check server logs for any Lua errors.

### 4.2 Test Registration with Recruiter

1. Create a recruiter account (or use existing)
2. Note the recruiter's username
3. Register a new account and specify the recruiter username
4. Check if the SOAP command executed successfully

### 4.3 Verify RAF Link in Database

Query the character database:

```sql
SELECT * FROM recruit_a_friend_links;
```

You should see a new row with:
- `recruiter_account_id` = recruiter's account ID
- `recruit_account_id` = new account ID
- `time_stamp` = current time
- `reward_level` = 0 (no rewards yet)

### 4.4 Test In-Game Commands

Log in as the recruiter:

```
.raf
```

Should display account ID and help text.

```
.raf list
```

Should show the newly linked recruit's account ID.

---

## Step 5: Troubleshooting

### Issue: "Recruiter account not found" error

**Cause:** Username doesn't exist in auth.account table

**Solution:** 
- Verify the recruiter username is correct (case-sensitive)
- Ensure the recruiter account exists: `SELECT id, username FROM account WHERE username = 'recruiter_name';`

### Issue: SOAP command not executing

**Cause:** Realm is offline or SOAP credentials are invalid

**Solution:**
- Check realm is online in admin panel
- Verify SOAP console credentials in realm configuration
- Check worldserver logs for SOAP errors
- Ensure `.bindraf` command is recognized by the Lua script

### Issue: RAF link not appearing in database

**Cause:** Lua script not loaded or database name misconfigured

**Solution:**
- Verify `Config.dbName` in Lua script matches your database name
- Check server logs: `tail -f azerothcore/logs/world.log | grep -i recruit`
- Reload Lua engine: `.lua_engine reload`

### Issue: Players can't use RAF commands

**Cause:** Lua script not properly initialized

**Solution:**
- Restart worldserver
- Check Eluna is enabled in worldserver.conf
- Verify lua_scripts directory path is correct

---

## Step 6: Advanced Configuration

### Customize Rewards

Edit `recruit_a_friend.lua` and modify the reward table:

```lua
Config.rewards = {
    [1] = { items = { { id = 33818, count = 1 } } },  -- Mini-Thor
    [2] = { items = { { id = 32853, count = 1 } } },  -- 14-slot bag
    [5] = { items = { { id = 37460, count = 1 } } },  -- Diablos-Stone
    [10] = { items = { { id = 37462, count = 1 } } }  -- Tyrael's Hilt
}
```

### Customize Reward Mail

Modify the mail text in the Lua script:

```lua
Config.mailSubject = "Recruit a Friend Reward"
Config.mailBody = "Congratulations! Your recruit has reached level " .. Config.targetLevel
```

### Allow Multiple Realms

The CMS integration automatically handles multiple realms by:
1. Fetching all configured realms
2. Checking if each realm is online
3. Executing the SOAP command on each online realm

No additional configuration needed.

---

## Step 7: Monitoring RAF Activity

### View RAF Links

```sql
SELECT 
    raf.recruiter_account_id,
    raf.recruit_account_id,
    FROM_UNIXTIME(raf.time_stamp) as created_date,
    raf.reward_level,
    raf.ip_abuse_counter,
    raf.kick_counter
FROM recruit_a_friend_links raf
ORDER BY raf.time_stamp DESC;
```

### View RAF Rewards Given

```sql
SELECT 
    rar.recruiter_account_id,
    rar.recruit_account_id,
    FROM_UNIXTIME(rar.time_stamp) as reward_date
FROM recruit_a_friend_rewards rar
ORDER BY rar.time_stamp DESC;
```

---

## Step 8: Security Considerations

### IP Abuse Detection

The system logs IP abuse attempts:
- If recruiter and recruit share the same IP, it's logged
- Summoning is blocked if same IP is detected
- `ip_abuse_counter` tracks violations

### Kick System

Players can be kicked for excessive abuse:
- Tracked by `kick_counter` in database
- Threshold set by `Config.abuseTreshold`
- Helps prevent multi-accounting exploitation

### GM Commands

Only GMs with rank >= `Config.minGMRankForBind` can use:
- `.bindraf` - Manually bind accounts
- `.forcebindraf` - Force bind (ignores previous binds)

---

## Step 9: Optional: acore_cms RAF Module

For a full web-based RAF management interface, you can install the [acore_cms RAF module](https://github.com/azerothcore/acore-cms) which provides:

- Web interface to view RAF links
- Monitor recruit progress
- Manage rewards
- View statistics

This is optional but recommended for server administrators.

---

## Summary

You now have a fully integrated Recruit a Friend system that:

✅ Allows players to specify a recruiter during registration  
✅ Automatically links accounts via SOAP commands  
✅ Tracks RAF links in the database  
✅ Rewards recruiters when recruits reach target level  
✅ Prevents IP abuse  
✅ Provides in-game commands for players  

The system is production-ready and requires minimal ongoing maintenance.

---

## Support & Resources

- **55Honey/Acore_RecruitAFriend:** https://github.com/55Honey/Acore_RecruitAFriend
- **AzerothCore Docs:** https://www.azerothcore.org/
- **Eluna Lua Documentation:** https://www.azerothcore.org/catalogue-details.html?id=131435473
- **ChromieCraft (Live Example):** https://www.chromiecraft.com/
