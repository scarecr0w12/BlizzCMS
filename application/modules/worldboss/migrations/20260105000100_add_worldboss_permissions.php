<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_worldboss_permissions extends CI_Migration
{
    public function up()
    {
        $this->load->model('permission_model');
        $this->load->model('role_permission_model');

        // Insert world boss permissions
        $this->permission_model->insert_batch([
            ['key' => 'view.worldboss.settings', 'module' => 'worldboss', 'description' => 'Can view world boss admin dashboard'],
            ['key' => 'view.rankings', 'module' => 'worldboss', 'description' => 'Can view world boss rankings'],
            ['key' => 'manage.data', 'module' => 'worldboss', 'description' => 'Can manage world boss data'],
            ['key' => 'edit.worldboss.settings', 'module' => 'worldboss', 'description' => 'Can edit world boss settings'],
            ['key' => 'view.logs', 'module' => 'worldboss', 'description' => 'Can view world boss logs']
        ]);

        // Assign all world boss permissions to Administrator role (role_id = 5)
        $worldboss_permissions = $this->permission_model->find_all(['module' => 'worldboss']);
        if (! empty($worldboss_permissions)) {
            $role_permissions = [];
            foreach ($worldboss_permissions as $permission) {
                $role_permissions[] = [
                    'role_id' => 5,
                    'permission_id' => $permission->id
                ];
            }
            $this->db->insert_batch('roles_permissions', $role_permissions);
        }
    }

    public function down()
    {
        $this->load->model('permission_model');

        // Remove permissions and role assignments
        $worldboss_permissions = $this->permission_model->find_all(['module' => 'worldboss'], 'array');
        $permission_ids = array_column($worldboss_permissions, 'id');
        if (! empty($permission_ids)) {
            $this->db->where_in('permission_id', $permission_ids)->delete('roles_permissions');
            $this->permission_model->delete_in('id', $permission_ids);
        }
    }
}
