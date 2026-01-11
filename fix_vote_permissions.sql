-- Fix Vote Module Permissions
-- Run this SQL to fix the vote permission issues

-- Insert permissions into the correct table
INSERT INTO permissions (`key`, `module`, `description`) VALUES
('view.vote', 'vote', 'Can view vote admin dashboard'),
('add.vote', 'vote', 'Can add vote sites'),
('edit.vote', 'vote', 'Can edit vote sites'),
('delete.vote', 'vote', 'Can delete vote sites')
ON DUPLICATE KEY UPDATE `key`=`key`;

-- Assign all vote permissions to Administrator role
INSERT INTO roles_permissions (role_id, permission_id)
SELECT r.id, p.id 
FROM roles r, permissions p 
WHERE r.name = 'Administrator' 
AND p.module = 'vote'
AND NOT EXISTS (
    SELECT 1 FROM roles_permissions rp 
    WHERE rp.role_id = r.id AND rp.permission_id = p.id
);

-- Show what was created
SELECT 'Permissions created:' as status;
SELECT * FROM permissions WHERE module = 'vote';

SELECT 'Role permissions assigned:' as status;
SELECT rp.*, r.name as role_name, p.key as permission_key
FROM roles_permissions rp
JOIN roles r ON r.id = rp.role_id
JOIN permissions p ON p.id = rp.permission_id
WHERE p.module = 'vote';
