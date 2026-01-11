-- Fix Shop Module Permissions
-- This script updates the shop permission keys to match the controller requirements

UPDATE `permissions` SET `key` = 'view.shop.category' WHERE `module` = 'shop' AND `key` = 'view.categories';
UPDATE `permissions` SET `key` = 'add.shop.category' WHERE `module` = 'shop' AND `key` = 'add.categories';
UPDATE `permissions` SET `key` = 'edit.shop.category' WHERE `module` = 'shop' AND `key` = 'edit.categories';
UPDATE `permissions` SET `key` = 'delete.shop.category' WHERE `module` = 'shop' AND `key` = 'delete.categories';

UPDATE `permissions` SET `key` = 'view.shop.item' WHERE `module` = 'shop' AND `key` = 'view.items';
UPDATE `permissions` SET `key` = 'add.shop.item' WHERE `module` = 'shop' AND `key` = 'add.items';
UPDATE `permissions` SET `key` = 'edit.shop.item' WHERE `module` = 'shop' AND `key` = 'edit.items';
UPDATE `permissions` SET `key` = 'delete.shop.item' WHERE `module` = 'shop' AND `key` = 'delete.items';

UPDATE `permissions` SET `key` = 'view.shop.service' WHERE `module` = 'shop' AND `key` = 'view.services';
UPDATE `permissions` SET `key` = 'add.shop.service' WHERE `module` = 'shop' AND `key` = 'add.services';
UPDATE `permissions` SET `key` = 'edit.shop.service' WHERE `module` = 'shop' AND `key` = 'edit.services';
UPDATE `permissions` SET `key` = 'delete.shop.service' WHERE `module` = 'shop' AND `key` = 'delete.services';

UPDATE `permissions` SET `key` = 'view.shop.subscription' WHERE `module` = 'shop' AND `key` = 'view.subscriptions';
UPDATE `permissions` SET `key` = 'add.shop.subscription' WHERE `module` = 'shop' AND `key` = 'add.subscriptions';
UPDATE `permissions` SET `key` = 'edit.shop.subscription' WHERE `module` = 'shop' AND `key` = 'edit.subscriptions';
UPDATE `permissions` SET `key` = 'delete.shop.subscription' WHERE `module` = 'shop' AND `key` = 'delete.subscriptions';

UPDATE `permissions` SET `key` = 'view.shop.order' WHERE `module` = 'shop' AND `key` = 'view.orders';
UPDATE `permissions` SET `key` = 'process.shop.order' WHERE `module` = 'shop' AND `key` = 'process.orders';

UPDATE `permissions` SET `key` = 'view.shop.payment' WHERE `module` = 'shop' AND `key` = 'view.payments';
UPDATE `permissions` SET `key` = 'edit.shop.settings' WHERE `module` = 'shop' AND `key` = 'edit.settings';

-- Done! You can now refresh the page and the permissions should work correctly.
