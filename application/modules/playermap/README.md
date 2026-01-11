# Playermap Module for BlizzCMS

A live player map module for BlizzCMS that displays online players on interactive maps of Azeroth, Outland, and Northrend.

## Features

- Real-time display of online players on interactive maps
- Support for multiple continents: Eastern Kingdoms, Kalimdor, Outland, and Northrend
- Player grouping visualization (solo players, groups, instances)
- Faction-based player display (Alliance/Horde)
- GM visibility controls
- Server status information (uptime, max online)
- Multi-realm support
- Auto-refresh capability
- Responsive tooltip showing player information

## Installation

The module has been integrated into your BlizzCMS installation. To complete the setup:

### 1. Enable the Module

Go to your BlizzCMS Admin Panel:
- Navigate to **Modules** section
- Enable the **Playermap** module

### 2. Configure Settings

Edit the configuration file at:
`application/modules/playermap/config/playermap.php`

Key configuration options:

```php
// Server Type (0 = MaNGOS, 1 = AzerothCore/TrinityCore)
$config['playermap_server_type'] = 1;

// Default realm to show
$config['playermap_default_realm'] = 1;

// GM Display Options
$config['playermap_gm_show_online'] = true;      // Show GMs on map
$config['playermap_gm_include_count'] = true;    // Include GMs in player count
$config['playermap_gm_only_gmoff'] = true;       // Only show if GM mode is off
$config['playermap_gm_only_gmvisible'] = true;   // Only show if GM is visible
$config['playermap_gm_add_suffix'] = true;       // Add {GM} suffix to GM names

// Auto-update settings
$config['playermap_time'] = 5;  // Refresh interval in seconds (0 = disabled)
```

### 3. Add to Navigation Menu

In your BlizzCMS Admin Panel:
- Go to **Menus**
- Add a new menu item:
  - **Name**: Player Map (or your preferred title)
  - **URL**: `playermap`
  - **Icon**: Choose an appropriate icon

## Usage

Access the player map by navigating to:
```
http://yoursite.com/playermap
```

If you have multiple realms configured, you can specify a realm:
```
http://yoursite.com/playermap?realm=1
```

## Features Explained

### Map Switching
Click on the continent names at the bottom to switch between:
- Eastern Kingdoms & Kalimdor (Classic maps)
- Outland (Burning Crusade)
- Northrend (Wrath of the Lich King)

### Player Icons
- **Blue dots**: Alliance players
- **Red dots**: Horde players
- **Group icon**: Multiple players in the same location
- **Instance icon**: Players inside dungeons/raids

### Tooltips
- Hover over single player icons to see player details
- Click on group/instance icons to cycle through player lists

## Files Structure

```
application/modules/playermap/
├── config/
│   ├── playermap.php       # Module configuration
│   └── routes.php          # URL routes
├── controllers/
│   └── Playermap.php       # Main controller
├── models/
│   └── Playermap_model.php # Database queries
├── views/
│   └── index.php           # Map display view
├── language/
│   └── english/
│       └── playermap_lang.php  # Language strings
├── helpers/
│   └── playermap_zones_helper.php  # Zone name mappings
└── README.md

assets/
├── img/
│   ├── map/                # Map backgrounds and icons
│   └── c_icons/            # Character class/race icons
└── libs/
    └── js/JsHttpRequest/   # AJAX library
```

## Troubleshooting

### Players not showing
1. Verify your realm database connections are configured correctly
2. Check that characters are actually online
3. Ensure the `online` field in the `characters` table is set to 1

### Map not loading
1. Check browser console for JavaScript errors
2. Verify image assets are accessible in `assets/img/map/`
3. Ensure proper permissions on asset directories

### Database connection errors
1. Confirm realm database credentials in BlizzCMS settings
2. Test database connectivity from your web server
3. Check that the Server_characters_model and Server_auth_model are working

## Customization

### Changing Map Images
Replace the map images in:
- `assets/img/map/azeroth.jpg` (Eastern Kingdoms & Kalimdor)
- `assets/img/map/outland.jpg` (Outland)
- `assets/img/map/northrend.jpg` (Northrend)

### Styling
Modify the CSS in `application/modules/playermap/views/index.php`

### Language Translations
Add translations in `application/modules/playermap/language/[your_language]/playermap_lang.php`

## Project Information

**BlizzCMS Version:** 3.0  
**Module Status:** Complete & Production Ready  
**Last Updated:** January 11, 2026  
**Maintained By:** BlizzCMS Community

## Credits

- **Original Playermap**: Dmitry Koterov
- **AzerothCore Fork**: Helias and contributors
- **BlizzCMS Integration**: Community Contributors

## License

This module follows the MIT License in accordance with BlizzCMS licensing.

## Support

For issues specific to the BlizzCMS integration, please report them in your BlizzCMS project.
For more information, see the main README.md and CHANGELOG.md in the project root.
