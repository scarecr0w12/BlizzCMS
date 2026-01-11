# Database Viewer Module

A comprehensive database viewer module for BlizzCMS similar to AoWoW/Wowhead. Browse items, spells, quests, creatures, zones, NPCs, and game objects from your WoW server database.

## Features

### Core Functionality
- **Items Browser**: Browse all items with filtering by class, quality, and level
- **Spells Browser**: Browse spells with filtering by school
- **Quests Browser**: Browse quests with level filtering
- **Creatures Browser**: Browse creatures with type filtering
- **Zones Browser**: Browse all game zones
- **NPCs Browser**: Browse vendor NPCs and their inventory
- **Objects Browser**: Browse game objects like chests, doors, nodes
- **Global Search**: Search across all database categories

### Admin Features
- Module settings management
- Items per page configuration
- Quality color display toggle
- Tooltip enable/disable
- Settings persistence

## Installation

1. The module is located in `/application/modules/database_viewer/`
2. Run migrations to create the settings table:
   ```
   php index.php migrate
   ```
3. Access the module at `/database` or `/database_viewer`

## Routes

### Public Routes
- `/database` - Main database viewer page
- `/database/search?q=query` - Search database
- `/database/items` - Browse items
- `/database/item/{id}` - View item details
- `/database/spells` - Browse spells
- `/database/spell/{id}` - View spell details
- `/database/quests` - Browse quests
- `/database/quest/{id}` - View quest details
- `/database/creatures` - Browse creatures
- `/database/creature/{id}` - View creature details
- `/database/zones` - Browse zones
- `/database/zone/{id}` - View zone details
- `/database/npcs` - Browse NPCs
- `/database/npc/{id}` - View NPC details
- `/database/objects` - Browse objects
- `/database/object/{id}` - View object details

### Admin Routes
- `/database_viewer/admin` - Admin dashboard
- `/database_viewer/admin/settings` - Module settings

## Model Methods

### Search Methods
- `search_items($query, $limit, $offset)` - Search items by name
- `search_spells($query, $limit, $offset)` - Search spells by name
- `search_quests($query, $limit, $offset)` - Search quests by title
- `search_creatures($query, $limit, $offset)` - Search creatures by name
- `search_zones($query, $limit, $offset)` - Search zones by name
- `search_npcs($query, $limit, $offset)` - Search NPCs by name
- `search_objects($query, $limit, $offset)` - Search objects by name
- `global_search($query, $limit)` - Search across all categories

### Retrieval Methods
- `get_item($entry)` - Get single item details
- `get_items($limit, $offset, $class, $subclass)` - Get paginated items
- `get_spell($id)` - Get single spell details
- `get_spells($limit, $offset, $school)` - Get paginated spells
- `get_quest($id)` - Get single quest details
- `get_quests($limit, $offset, $minlevel, $maxlevel)` - Get paginated quests
- `get_creature($entry)` - Get single creature details
- `get_creatures($limit, $offset, $type)` - Get paginated creatures
- `get_creature_loot($entry)` - Get creature loot table
- `get_zone($id)` - Get single zone details
- `get_zones($limit, $offset)` - Get paginated zones
- `get_npc($entry)` - Get single NPC details
- `get_npc_vendor($entry)` - Get NPC vendor items
- `get_object($entry)` - Get single object details
- `get_objects($limit, $offset, $type)` - Get paginated objects

### Count Methods
- `count_items($query)` - Count items (with optional search)
- `count_spells($query)` - Count spells (with optional search)
- `count_quests($query)` - Count quests (with optional search)
- `count_creatures($query)` - Count creatures (with optional search)
- `count_zones($query)` - Count zones (with optional search)
- `count_objects($query)` - Count objects (with optional search)

### Filter Methods
- `get_item_classes()` - Get all item classes
- `get_creature_types()` - Get all creature types
- `get_spell_schools()` - Get all spell schools

### Settings Methods
- `get_setting($key, $default)` - Get a setting value
- `update_setting($key, $value)` - Update a setting value

## Helper Functions

### Formatting Functions
- `get_item_quality_color($quality)` - Get hex color for item quality
- `get_item_quality_name($quality)` - Get name for item quality
- `get_creature_rank_name($rank)` - Get name for creature rank
- `get_creature_type_name($type)` - Get name for creature type
- `get_spell_school_name($school)` - Get name for spell school
- `get_quest_type_name($type)` - Get name for quest type
- `format_item_name($item, $show_color)` - Format item name with color
- `format_creature_name($creature)` - Format creature name with type and rank

### Settings Functions
- `get_database_viewer_enabled()` - Check if module is enabled
- `get_database_viewer_setting($key, $default)` - Get module setting

## Language Keys

All language strings are defined in `language/english/database_viewer_lang.php`:
- `database_title` - Module title
- `database_items` - Items label
- `database_spells` - Spells label
- `database_quests` - Quests label
- `database_creatures` - Creatures label
- `database_zones` - Zones label
- `database_npcs` - NPCs label
- `database_objects` - Objects label
- `database_search` - Search label
- And many more...

## Configuration

### Settings Table
The module uses the `database_viewer_settings` table with the following keys:
- `database_viewer_enabled` - Enable/disable the module (default: 1)
- `database_viewer_items_per_page` - Items per page (default: 50)
- `database_viewer_show_quality_colors` - Show item quality colors (default: 1)
- `database_viewer_enable_tooltips` - Enable item tooltips (default: 1)

## Database Tables Used

The module reads from the following WoW database tables:
- `item_template` - Item data
- `spell` - Spell data
- `quest_template` - Quest data
- `creature_template` - Creature/NPC data
- `creature_loot_template` - Creature loot tables
- `worldmap_area` - Zone data
- `npc_vendor` - NPC vendor items
- `gameobject_template` - Game object data

## Views

### Public Views
- `index.php` - Main database viewer page
- `search.php` - Search results page
- `items.php` - Items list view
- `item_detail.php` - Item detail view
- `spells.php` - Spells list view
- `spell_detail.php` - Spell detail view
- `quests.php` - Quests list view
- `quest_detail.php` - Quest detail view
- `creatures.php` - Creatures list view
- `creature_detail.php` - Creature detail view
- `zones.php` - Zones list view
- `zone_detail.php` - Zone detail view
- `npcs.php` - NPCs list view
- `npc_detail.php` - NPC detail view
- `objects.php` - Objects list view
- `object_detail.php` - Object detail view

### Admin Views
- `admin/index.php` - Admin dashboard
- `admin/settings.php` - Settings management

## Usage Examples

### Search for Items
```
GET /database/search?q=sword
```

### Browse Items by Class
```
GET /database/items?class=4
```

### View Item Details
```
GET /database/item/12345
```

### Search Spells by School
```
GET /database/spells?school=2
```

### View Creature Loot
```
GET /database/creature/1234
```

## Pagination

All list views support pagination with configurable items per page:
- Default: 50 items per page
- Configurable via admin settings
- Pagination links automatically generated

## Security

- Admin routes require admin authentication
- All user input is properly escaped
- SQL injection protection via CodeIgniter's query builder
- XSS protection via htmlspecialchars()

## Performance

- Uses CodeIgniter's query builder for efficient queries
- Supports database indexing on frequently searched columns
- Pagination reduces memory usage for large datasets
- Settings cached in memory during request

## Future Enhancements

Potential additions:
- Item tooltips on hover
- Advanced filtering options
- Item comparison tool
- Quest chains visualization
- NPC location maps
- Creature spawn locations
- Loot drop rate statistics
- User favorites/bookmarks
- Database export functionality

## Support

For issues or questions about this module, please refer to the BlizzCMS documentation or community forums.

## License

MIT License - See LICENSE file for details
