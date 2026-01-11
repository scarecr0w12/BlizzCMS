# Quick Menu Update - TL;DR

## 🚀 Quick Setup (3 Steps)

### 1. Run the SQL Script
```bash
mysql -u your_username -p your_database_name < add_menu_items.sql
```

### 2. Clear Cache
```bash
rm -rf application/cache/menu_*
```

### 3. Refresh Your Website
Open your website and the new menu items will appear!

---

## 📋 What Gets Added

✅ **Server Status** - `/serverstatus` - Shows server online status and stats  
✅ **Shop** - `/shop` - Browse and buy items  
✅ **Leaderboards** - `/leaderboards` - Player rankings (PvP, Honor, Arena, etc.)  
✅ **Armory** - `/armory` - Character search and profiles  
✅ **Events** - `/events` - Upcoming server events calendar  
✅ **Vote** - `/vote` - Vote for the server and earn rewards  
✅ **Donate** - `/donate` - Support the server  
✅ **Player Map** - `/playermap` - Real-time player location map  
✅ **World Boss** - `/worldboss` - World boss spawn timers  

All menu items are visible to all user roles (Guest, User, Moderator, Admin) by default.

---

## 🎨 Alternative: Manual Add via Admin Panel

If you prefer to add menu items manually:

1. Login to Admin Panel
2. Go to **Appearance → Menus**
3. Select "main" menu
4. Click **Add** button
5. Fill in the form and save

Example for Server Status:
- **Name**: Server Status
- **URL**: serverstatus
- **Icon**: fa-solid fa-server
- **Target**: _self
- **Type**: link
- **Parent**: No parent
- Select all roles in permissions

---

## 📖 Full Documentation

See `MENU_UPDATE_GUIDE.md` for:
- Complete setup instructions
- Troubleshooting guide
- Creating dropdown menus
- Permission management
- Rollback instructions

---

## ✅ Verification

After running the script, check your database:

```sql
SELECT name, url, icon, sort 
FROM menus_items 
WHERE menu_id = 1 
ORDER BY sort;
```

You should see all 9 new menu items listed.
