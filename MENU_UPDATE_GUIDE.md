# Menu Update Guide

This guide explains how to add menu items for all BlizzCMS modules to your navigation.

## Quick Start

1. **Run the SQL script** to add menu items:
```bash
mysql -u your_username -p your_database < add_menu_items.sql
```

2. **Clear the cache** (if using file-based cache):
```bash
rm -rf application/cache/menu_*
```

3. **Refresh your website** - the new menu items should appear in the navigation bar.

## Menu Items Added

The following menu items will be added to your main navigation (menu_id = 1):

| Name | URL | Icon | Description |
|------|-----|------|-------------|
| Server Status | `serverstatus` | fa-server | View server status and statistics |
| Shop | `shop` | fa-cart-shopping | Browse and purchase items |
| Leaderboards | `leaderboards` | fa-trophy | View player rankings |
| Armory | `armory` | fa-shield-halved | Search and view characters |
| Events | `events` | fa-calendar-days | Browse upcoming events |
| Vote | `vote` | fa-thumbs-up | Vote for the server |
| Donate | `donate` | fa-heart | Support the server |
| Player Map | `playermap` | fa-map-location-dot | View online players on map |
| World Boss | `worldboss` | fa-dragon | Track world boss timers |

## Manual Menu Management

You can also add menu items manually through the admin panel:

1. Navigate to **Admin Panel → Appearance → Menus**
2. Select the **main** menu
3. Click **Add** button
4. Fill in the form:
   - **Name**: Display name for the menu item
   - **URL**: Module route (e.g., `serverstatus`, `shop`, etc.)
   - **Icon**: FontAwesome icon class (e.g., `fa-solid fa-server`)
   - **Target**: `_self` (same tab) or `_blank` (new tab)
   - **Type**: `link` or `dropdown`
   - **Parent**: Select parent if creating a sub-menu
5. Set permissions for which roles can see the menu item
6. Click **Add**

## Creating Dropdown Menus

If you want to group menu items under a dropdown (e.g., "Community"):

1. Create a parent item with type `dropdown`:
   - **Name**: Community
   - **URL**: `#` (or leave empty)
   - **Type**: dropdown
   - **Parent**: No parent

2. Create child items under the dropdown:
   - **Name**: Events
   - **URL**: `events`
   - **Type**: link
   - **Parent**: Select "Community"

The SQL script includes commented-out code for a Community dropdown example.

## Permissions

All menu items are assigned view permissions for all user roles by default:
- **Guest** (role_id = 1)
- **User** (role_id = 2)
- **Moderator** (role_id = 3)
- **Admin** (role_id = 4)

To modify permissions:
1. Go to **Admin Panel → Appearance → Menus**
2. Select the menu
3. Click **Edit** on the menu item
4. Toggle the role permissions
5. Save changes

## Module Routes

Make sure the following modules are installed and their routes are configured:

| Module | Route File | Controller |
|--------|------------|------------|
| Server Status | `application/modules/serverstatus/config/routes.php` | `Serverstatus` |
| Shop | `application/modules/shop/config/routes.php` | `Shop` |
| Leaderboards | `application/modules/leaderboards/config/routes.php` | `Leaderboards` |
| Armory | `application/modules/armory/config/routes.php` | `Armory` |
| Events | `application/modules/events/config/routes.php` | `Events` |
| Vote | `application/modules/vote/config/routes.php` | `Vote` |
| Donate | `application/modules/donate/config/routes.php` | `Donate` |
| Player Map | `application/modules/playermap/config/routes.php` | `Playermap` |
| World Boss | `application/modules/worldboss/config/routes.php` | `Worldboss` |

## Troubleshooting

### Menu items not appearing
1. **Clear cache**: Delete cache files in `application/cache/`
2. **Check permissions**: Verify menu item permissions in admin panel
3. **Verify database**: Run the verification query from the SQL script
4. **Check module installation**: Ensure modules are properly installed

### 404 errors on menu items
1. **Check routes**: Verify route configuration in each module
2. **Check controllers**: Ensure controller files exist
3. **Module permissions**: Check if module permissions are set correctly

### Cache issues
If menu changes don't appear immediately:
```php
// In application/config/config.php, temporarily disable caching:
$config['cache_expiration'] = 0;
```

Or manually delete cache:
```bash
rm -rf application/cache/menu_*
```

## Advanced Customization

### Custom Icons
Use any FontAwesome 6 icon:
- Browse icons at https://fontawesome.com/icons
- Use format: `fa-solid fa-icon-name` or `fa-brands fa-icon-name`

### External Links
To link to external sites:
- Set URL to full URL (e.g., `https://example.com`)
- Set Target to `_blank` to open in new tab

### Menu Order
Change menu order by:
1. Using up/down arrows in admin panel
2. Or by updating the `sort` column in `menus_items` table

## Verification

After running the SQL script, verify the installation:

```sql
-- Check menu items
SELECT mi.id, mi.name, mi.url, mi.icon, mi.type, mi.parent, mi.sort 
FROM menus_items mi 
WHERE mi.menu_id = 1 
ORDER BY mi.parent, mi.sort;

-- Check permissions
SELECT p.id, p.key, p.module, p.description 
FROM permissions p 
WHERE p.module = ':menu-item:' 
ORDER BY p.id DESC 
LIMIT 10;

-- Check role assignments
SELECT rp.role_id, r.name as role_name, p.description 
FROM roles_permissions rp
JOIN roles r ON r.id = rp.role_id
JOIN permissions p ON p.id = rp.permission_id
WHERE p.module = ':menu-item:'
ORDER BY rp.permission_id DESC, rp.role_id;
```

## Rollback

If you need to remove the menu items:

```sql
-- Get the IDs of menu items to remove
SELECT id FROM menus_items WHERE menu_id = 1 AND name IN (
    'Server Status', 'Shop', 'Leaderboards', 'Armory', 
    'Events', 'Vote', 'Donate', 'Player Map', 'World Boss'
);

-- Delete permissions first
DELETE p FROM permissions p
INNER JOIN menus_items mi ON p.key = mi.id
WHERE mi.menu_id = 1 AND mi.name IN (
    'Server Status', 'Shop', 'Leaderboards', 'Armory', 
    'Events', 'Vote', 'Donate', 'Player Map', 'World Boss'
);

-- Delete menu items
DELETE FROM menus_items WHERE menu_id = 1 AND name IN (
    'Server Status', 'Shop', 'Leaderboards', 'Armory', 
    'Events', 'Vote', 'Donate', 'Player Map', 'World Boss'
);
```

## Support

For issues or questions:
- Check BlizzCMS documentation: https://wow-cms.com
- Review the menu management controller: `application/modules/admin/controllers/Menus.php`
- Check the menu model: `application/models/Menu_model.php`
