-- Clean up duplicate and incorrect vote permissions

-- Remove role permissions for incorrect old permissions
DELETE FROM roles_permissions WHERE permission_id IN (42, 43, 44, 45, 46, 47, 48);

-- Remove incorrect old permissions
DELETE FROM permissions WHERE id IN (42, 43, 44, 45, 46, 47, 48);

-- Verify only correct permissions remain
SELECT 'Remaining vote permissions:' as status;
SELECT * FROM permissions WHERE module = 'vote';

-- Re-assign correct permissions to Administrator role
INSERT IGNORE INTO roles_permissions (role_id, permission_id)
SELECT r.id, p.id 
FROM roles r, permissions p 
WHERE r.name = 'Administrator' 
AND p.module = 'vote';

-- Show final role permissions
SELECT 'Administrator vote permissions:' as status;
SELECT rp.*, r.name as role_name, p.key as permission_key
FROM roles_permissions rp
JOIN roles r ON r.id = rp.role_id
JOIN permissions p ON p.id = rp.permission_id
WHERE p.module = 'vote' AND r.name = 'Administrator';
