-- Add Menu Items for All Modules
-- This script adds menu items for Server Status, Shop, Leaderboard, and other modules
-- Make sure to run this after the main BlizzCMS installation

-- ============================================
-- Add Menu Items to Main Navigation (menu_id = 1)
-- ============================================

-- Get the next sort order for main menu items
SET @next_sort = (SELECT IFNULL(MAX(sort), 0) + 1 FROM menu_items WHERE menu_id = 1 AND parent = 0);

-- Server Status Menu Item
INSERT INTO `menu_items` (`menu_id`, `name`, `url`, `icon`, `target`, `parent`, `sort`) 
VALUES (1, 'Server Status', 'serverstatus', 'fa-solid fa-server', '_self', 0, @next_sort);

SET @serverstatus_item_id = LAST_INSERT_ID();
SET @next_sort = @next_sort + 1;

-- Shop Menu Item
INSERT INTO `menu_items` (`menu_id`, `name`, `url`, `icon`, `target`, `parent`, `sort`) 
VALUES (1, 'Shop', 'shop', 'fa-solid fa-cart-shopping', '_self', 0, @next_sort);

SET @shop_item_id = LAST_INSERT_ID();
SET @next_sort = @next_sort + 1;

-- Leaderboards Menu Item
INSERT INTO `menu_items` (`menu_id`, `name`, `url`, `icon`, `target`, `parent`, `sort`) 
VALUES (1, 'Leaderboards', 'leaderboards', 'fa-solid fa-trophy', '_self', 0, @next_sort);

SET @leaderboards_item_id = LAST_INSERT_ID();
SET @next_sort = @next_sort + 1;

-- Armory Menu Item
INSERT INTO `menu_items` (`menu_id`, `name`, `url`, `icon`, `target`, `parent`, `sort`) 
VALUES (1, 'Armory', 'armory', 'fa-solid fa-shield-halved', '_self', 0, @next_sort);

SET @armory_item_id = LAST_INSERT_ID();
SET @next_sort = @next_sort + 1;

-- Events Menu Item
INSERT INTO `menu_items` (`menu_id`, `name`, `url`, `icon`, `target`, `parent`, `sort`) 
VALUES (1, 'Events', 'events', 'fa-solid fa-calendar-days', '_self', 0, @next_sort);

SET @events_item_id = LAST_INSERT_ID();
SET @next_sort = @next_sort + 1;

-- Vote Menu Item
INSERT INTO `menu_items` (`menu_id`, `name`, `url`, `icon`, `target`, `parent`, `sort`) 
VALUES (1, 'Vote', 'vote', 'fa-solid fa-thumbs-up', '_self', 0, @next_sort);

SET @vote_item_id = LAST_INSERT_ID();
SET @next_sort = @next_sort + 1;

-- Donate Menu Item
INSERT INTO `menu_items` (`menu_id`, `name`, `url`, `icon`, `target`, `parent`, `sort`) 
VALUES (1, 'Donate', 'donate', 'fa-solid fa-heart', '_self', 0, @next_sort);

SET @donate_item_id = LAST_INSERT_ID();
SET @next_sort = @next_sort + 1;

-- Player Map Menu Item
INSERT INTO `menu_items` (`menu_id`, `name`, `url`, `icon`, `target`, `parent`, `sort`) 
VALUES (1, 'Player Map', 'playermap', 'fa-solid fa-map-location-dot', '_self', 0, @next_sort);

SET @playermap_item_id = LAST_INSERT_ID();
SET @next_sort = @next_sort + 1;

-- World Boss Menu Item
INSERT INTO `menu_items` (`menu_id`, `name`, `url`, `icon`, `target`, `parent`, `sort`) 
VALUES (1, 'World Boss', 'worldboss', 'fa-solid fa-dragon', '_self', 0, @next_sort);

SET @worldboss_item_id = LAST_INSERT_ID();

-- ============================================
-- Optional: Create a "Community" Dropdown Menu with Sub-items
-- ============================================

-- Uncomment the following section if you want to group some items under a Community dropdown

-- SET @next_sort_community = (SELECT IFNULL(MAX(sort), 0) + 1 FROM menu_items WHERE menu_id = 1 AND parent = 0);

-- INSERT INTO `menu_items` (`menu_id`, `name`, `url`, `icon`, `target`, `parent`, `sort`) 
-- VALUES (1, 'Community', '#', 'fa-solid fa-users', '_self', 0, @next_sort_community);

-- SET @community_dropdown_id = LAST_INSERT_ID();

-- -- Add sub-items under Community dropdown
-- INSERT INTO `menu_items` (`menu_id`, `name`, `url`, `icon`, `target`, `parent`, `sort`) 
-- VALUES 
-- (1, 'Leaderboards', 'leaderboards', 'fa-solid fa-trophy', '_self', @community_dropdown_id, 1),
-- (1, 'Events', 'events', 'fa-solid fa-calendar-days', '_self', @community_dropdown_id, 2),
-- (1, 'Player Map', 'playermap', 'fa-solid fa-map-location-dot', '_self', @community_dropdown_id, 3),
-- (1, 'World Boss', 'worldboss', 'fa-solid fa-dragon', '_self', @community_dropdown_id, 4);

-- ============================================
-- Create Permissions for Each Menu Item
-- ============================================

-- Server Status Permission
INSERT INTO `permissions` (`key`, `module`, `description`) 
VALUES (@serverstatus_item_id, ':menu-item:', 'Can view Server Status link item');

SET @serverstatus_perm_id = LAST_INSERT_ID();

-- Shop Permission
INSERT INTO `permissions` (`key`, `module`, `description`) 
VALUES (@shop_item_id, ':menu-item:', 'Can view Shop link item');

SET @shop_perm_id = LAST_INSERT_ID();

-- Leaderboards Permission
INSERT INTO `permissions` (`key`, `module`, `description`) 
VALUES (@leaderboards_item_id, ':menu-item:', 'Can view Leaderboards link item');

SET @leaderboards_perm_id = LAST_INSERT_ID();

-- Armory Permission
INSERT INTO `permissions` (`key`, `module`, `description`) 
VALUES (@armory_item_id, ':menu-item:', 'Can view Armory link item');

SET @armory_perm_id = LAST_INSERT_ID();

-- Events Permission
INSERT INTO `permissions` (`key`, `module`, `description`) 
VALUES (@events_item_id, ':menu-item:', 'Can view Events link item');

SET @events_perm_id = LAST_INSERT_ID();

-- Vote Permission
INSERT INTO `permissions` (`key`, `module`, `description`) 
VALUES (@vote_item_id, ':menu-item:', 'Can view Vote link item');

SET @vote_perm_id = LAST_INSERT_ID();

-- Donate Permission
INSERT INTO `permissions` (`key`, `module`, `description`) 
VALUES (@donate_item_id, ':menu-item:', 'Can view Donate link item');

SET @donate_perm_id = LAST_INSERT_ID();

-- Player Map Permission
INSERT INTO `permissions` (`key`, `module`, `description`) 
VALUES (@playermap_item_id, ':menu-item:', 'Can view Player Map link item');

SET @playermap_perm_id = LAST_INSERT_ID();

-- World Boss Permission
INSERT INTO `permissions` (`key`, `module`, `description`) 
VALUES (@worldboss_item_id, ':menu-item:', 'Can view World Boss link item');

SET @worldboss_perm_id = LAST_INSERT_ID();

-- ============================================
-- Assign Permissions to All Roles (1=Guest, 2=User, 3=Moderator, 4=Admin)
-- ============================================

-- Assign Server Status to all roles
INSERT INTO `role_permissions` (`role_id`, `permission_id`) 
SELECT r.id, @serverstatus_perm_id FROM roles r;

-- Assign Shop to all roles
INSERT INTO `role_permissions` (`role_id`, `permission_id`) 
SELECT r.id, @shop_perm_id FROM roles r;

-- Assign Leaderboards to all roles
INSERT INTO `role_permissions` (`role_id`, `permission_id`) 
SELECT r.id, @leaderboards_perm_id FROM roles r;

-- Assign Armory to all roles
INSERT INTO `role_permissions` (`role_id`, `permission_id`) 
SELECT r.id, @armory_perm_id FROM roles r;

-- Assign Events to all roles
INSERT INTO `role_permissions` (`role_id`, `permission_id`) 
SELECT r.id, @events_perm_id FROM roles r;

-- Assign Vote to all roles
INSERT INTO `role_permissions` (`role_id`, `permission_id`) 
SELECT r.id, @vote_perm_id FROM roles r;

-- Assign Donate to all roles
INSERT INTO `role_permissions` (`role_id`, `permission_id`) 
SELECT r.id, @donate_perm_id FROM roles r;

-- Assign Player Map to all roles
INSERT INTO `role_permissions` (`role_id`, `permission_id`) 
SELECT r.id, @playermap_perm_id FROM roles r;

-- Assign World Boss to all roles
INSERT INTO `role_permissions` (`role_id`, `permission_id`) 
SELECT r.id, @worldboss_perm_id FROM roles r;

-- ============================================
-- Clear Menu Cache
-- ============================================
-- Note: The menu cache is stored with keys like 'menu_main'
-- You may need to manually clear the cache or restart your application
-- DELETE FROM `cache` WHERE name LIKE 'menu_%';

-- ============================================
-- Verification Query
-- ============================================
-- Run this to verify the menu items were added successfully:
-- SELECT mi.id, mi.name, mi.url, mi.icon, mi.parent, mi.sort 
-- FROM menu_items mi 
-- WHERE mi.menu_id = 1 
-- ORDER BY mi.parent, mi.sort;
