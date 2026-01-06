<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_armory_permissions extends CI_Migration
{
    public function up()
    {
        $this->db->insert_batch('permissions', [
            [
                'key'         => 'view.armory.settings',
                'module'      => 'armory',
                'description' => 'View armory settings'
            ],
            [
                'key'         => 'edit.armory.settings',
                'module'      => 'armory',
                'description' => 'Edit armory settings'
            ]
        ]);

        // Grant permissions to administrator role (typically role id 1)
        $permissions = $this->db->where_in('key', [
            'view.armory.settings',
            'edit.armory.settings'
        ])->get('permissions')->result();

        $admin_role = $this->db->where('name', 'Administrator')->get('roles')->row();

        if ($admin_role && $permissions) {
            $role_permissions = [];
            foreach ($permissions as $permission) {
                $role_permissions[] = [
                    'role_id'       => $admin_role->id,
                    'permission_id' => $permission->id
                ];
            }
            $this->db->insert_batch('roles_permissions', $role_permissions);
        }
    }

    public function down()
    {
        $permissions = $this->db->where_in('key', [
            'view.armory.settings',
            'edit.armory.settings'
        ])->get('permissions')->result();

        if ($permissions) {
            $permission_ids = array_column($permissions, 'id');
            $this->db->where_in('permission_id', $permission_ids)->delete('roles_permissions');
        }

        $this->db->where('module', 'armory')->delete('permissions');
    }
}
