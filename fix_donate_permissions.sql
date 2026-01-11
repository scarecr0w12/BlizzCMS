-- Add missing donate permissions that the controller is checking for

INSERT INTO permissions (`key`, `module`, `description`) VALUES
('add.donate', 'donate', 'Can add donation items'),
('edit.donate', 'donate', 'Can edit donation items'),
('delete.donate', 'donate', 'Can delete donation items')
ON DUPLICATE KEY UPDATE `key`=`key`;

-- Assign new permissions to Administrator role
INSERT IGNORE INTO roles_permissions (role_id, permission_id)
SELECT r.id, p.id 
FROM roles r, permissions p 
WHERE r.name = 'Administrator' 
AND p.module = 'donate'
AND p.key IN ('add.donate', 'edit.donate', 'delete.donate');

-- Show all donate permissions
SELECT 'All donate permissions:' as status;
SELECT * FROM permissions WHERE module = 'donate' ORDER BY id;

-- Show Administrator donate permissions
SELECT 'Administrator donate permissions:' as status;
SELECT rp.*, p.key as permission_key
FROM roles_permissions rp
JOIN permissions p ON p.id = rp.permission_id
WHERE p.module = 'donate' 
AND rp.role_id = (SELECT id FROM roles WHERE name = 'Administrator');
