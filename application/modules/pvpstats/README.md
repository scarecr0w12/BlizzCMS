# PvP Stats Module for BlizzCMS

A comprehensive battleground statistics tracking and display system for BlizzCMS, based on the AzerothCore PvPstats system.

## Features

- **Battleground Tracking**: Automatically stores battleground match data including type, duration, winner, and bracket
- **Player Statistics**: Track individual player performance with detailed metrics:
  - Killing blows, deaths, honorable kills
  - Damage and healing done
  - Bonus honor earned
  - Win rates and averages
  - Statistics by battleground type
  
- **Guild Rankings**: View top performing guilds with aggregate statistics
- **Faction Statistics**: Track Alliance vs Horde win rates
- **Time Period Filtering**: View statistics for today, last 7 days, current month, or all time
- **Admin Dashboard**: Manage settings and view system statistics
- **Responsive Design**: Mobile-friendly interface using Bootstrap

## Installation

### 1. Module Setup

The module is already installed in `/application/modules/pvpstats/`. No additional setup is required beyond the database migration.

### 2. Database Migration

Run the migration to create the required database tables:

```bash
# Via CodeIgniter CLI (if available)
php spark migrate

# Or manually execute the migration in your admin panel
```

The migration creates three tables:
- `pvpstats_battlegrounds`: Stores battleground match data
- `pvpstats_players`: Stores individual player statistics per match
- `pvpstats_settings`: Stores module configuration

### 3. Server Configuration

For AzerothCore, enable battleground statistics in your `worldserver.conf`:

```
Battleground.StoreStatistics.Enable = 1
```

## Module Structure

```
pvpstats/
├── config/
│   ├── module.php          # Module metadata
│   ├── routes.php          # URL routing configuration
│   └── migration.php       # Database migration
├── controllers/
│   ├── Pvpstats.php        # Main controller for public views
│   └── Admin.php           # Admin dashboard controller
├── models/
│   ├── Pvpstats_battleground_model.php  # Battleground data model
│   └── Pvpstats_player_model.php        # Player statistics model
├── views/
│   ├── index.php           # Main dashboard
│   ├── battlegrounds.php   # Battlegrounds list
│   ├── battleground_detail.php  # Single battleground details
│   ├── players.php         # Top players list
│   ├── player_stats.php    # Individual player statistics
│   ├── guilds.php          # Top guilds list
│   ├── statistics.php      # Overall statistics page
│   └── admin/
│       ├── index.php       # Admin dashboard
│       └── settings.php    # Admin settings
├── language/
│   └── english/
│       └── pvpstats_lang.php  # Language strings
└── README.md               # This file
```

## Routes

### Public Routes

- `/pvpstats` - Main dashboard with top players and statistics
- `/pvpstats/battlegrounds` - List all battlegrounds
- `/pvpstats/battleground/{id}` - View specific battleground details
- `/pvpstats/players` - View top players ranking
- `/pvpstats/player/{name}` - View individual player statistics
- `/pvpstats/guilds` - View top guilds ranking
- `/pvpstats/statistics` - View detailed statistics with time period filters

### Admin Routes

- `/pvpstats/admin` - Admin dashboard
- `/pvpstats/admin/settings` - Module settings

### API Routes

- `/pvpstats/api/battlegrounds` - Get battlegrounds data (JSON)
- `/pvpstats/api/player/{name}` - Get player statistics (JSON)

## Database Schema

### pvpstats_battlegrounds

| Column | Type | Description |
|--------|------|-------------|
| id | INT UNSIGNED | Primary key |
| bracket_id | INT UNSIGNED | Level bracket (10-19, 20-29, etc.) |
| type | INT UNSIGNED | Battleground type ID |
| winner | INT UNSIGNED | Winning faction (0=Alliance, 1=Horde) |
| start_time | TIMESTAMP | Match start time |
| end_time | TIMESTAMP | Match end time |
| duration | INT UNSIGNED | Match duration in minutes |
| index | INT UNSIGNED | Match index |

### pvpstats_players

| Column | Type | Description |
|--------|------|-------------|
| id | INT UNSIGNED | Primary key |
| battleground_id | INT UNSIGNED | Foreign key to battlegrounds |
| guid | INT UNSIGNED | Character GUID |
| name | VARCHAR(255) | Character name |
| race | INT UNSIGNED | Character race |
| class | INT UNSIGNED | Character class |
| level | INT UNSIGNED | Character level |
| faction | INT UNSIGNED | Character faction |
| killing_blows | INT UNSIGNED | Number of killing blows |
| deaths | INT UNSIGNED | Number of deaths |
| honorable_kills | INT UNSIGNED | Number of honorable kills |
| bonus_honor | INT UNSIGNED | Bonus honor earned |
| damage_done | BIGINT UNSIGNED | Total damage done |
| healing_done | BIGINT UNSIGNED | Total healing done |
| flag_captures | INT UNSIGNED | Flags captured (WSG) |
| flag_returns | INT UNSIGNED | Flags returned (WSG) |
| bases_assaulted | INT UNSIGNED | Bases assaulted (AB) |
| bases_defended | INT UNSIGNED | Bases defended (AB) |
| nodes_captured | INT UNSIGNED | Nodes captured (EoTS) |
| nodes_assaulted | INT UNSIGNED | Nodes assaulted (EoTS) |
| towers_assaulted | INT UNSIGNED | Towers assaulted (SoA) |
| towers_defended | INT UNSIGNED | Towers defended (SoA) |
| mines_captured | INT UNSIGNED | Mines captured (IoC) |
| farms_captured | INT UNSIGNED | Farms captured (IoC) |
| graveyards_assaulted | INT UNSIGNED | Graveyards assaulted (IoC) |
| graveyards_defended | INT UNSIGNED | Graveyards defended (IoC) |
| team | INT UNSIGNED | Team ID (0=Alliance, 1=Horde) |

### pvpstats_settings

| Column | Type | Description |
|--------|------|-------------|
| id | INT UNSIGNED | Primary key |
| setting_key | VARCHAR(255) | Setting identifier |
| setting_value | LONGTEXT | Setting value |
| created_at | TIMESTAMP | Creation timestamp |
| updated_at | TIMESTAMP | Last update timestamp |

## Configuration

### Admin Settings

Access settings at `/pvpstats/admin/settings`:

- **Enable PvP Statistics**: Toggle module on/off
- **Show Detailed Information**: Display detailed battleground info
- **Top Players Limit**: Number of top players to display (default: 20)
- **Top Guilds Limit**: Number of top guilds to display (default: 5)

## Usage Examples

### View Main Dashboard
Navigate to `/pvpstats` to see:
- Today's battleground statistics
- Top 10 players for today
- All-time top 20 players
- Top 5 guilds

### Search Player Statistics
1. Go to `/pvpstats/players`
2. Click on a player name
3. View detailed statistics including:
   - Overall performance metrics
   - Statistics by battleground type
   - Recent match history
   - Win rate

### View Battleground Details
1. Go to `/pvpstats/battlegrounds`
2. Click "View" on a specific battleground
3. See all players who participated with their individual stats

### Filter Statistics
Use `/pvpstats/statistics` to view stats filtered by:
- Today
- Last 7 days
- Current month
- All time

## API Usage

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

### Get Player Statistics
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

## Language Support

The module includes English language strings. To add additional languages:

1. Create a new language file: `/language/{language_code}/pvpstats_lang.php`
2. Copy strings from the English version
3. Translate all strings

## Troubleshooting

### No data appears
- Verify `Battleground.StoreStatistics.Enable = 1` in worldserver.conf
- Check that battlegrounds have been completed on the server
- Verify database tables were created by the migration

### Statistics not updating
- Ensure the world server is running and configured correctly
- Check database connection in BlizzCMS configuration
- Verify user permissions for database access

### Performance issues with large datasets
- Add indexes to frequently queried columns (already done in migration)
- Consider archiving old battleground data
- Adjust pagination limits in admin settings

## Contributing

To extend this module:

1. **Add new statistics**: Modify models in `/models/`
2. **Create new views**: Add PHP files in `/views/`
3. **Add languages**: Create new language files in `/language/`
4. **Modify routes**: Update `/config/routes.php`

## License

This module is part of BlizzCMS and follows the same MIT License.

## Support

For issues or feature requests, please refer to the BlizzCMS community resources.

## Credits

Based on the AzerothCore PvPstats system by Francesco Borzi.
Adapted for BlizzCMS by the BlizzCMS Community.
