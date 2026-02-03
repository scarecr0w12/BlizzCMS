<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_donate_permissions extends CI_Migration
{
    public function up()
    {
        $this->load->model('permission_model');
        $this->load->model('role_permission_model');

        // Insert donate permissions
        $this->permission_model->insert_batch([
            ['key' => 'view.donate', 'module' => 'donate', 'description' => 'Can view donate admin dashboard'],
            ['key' => 'view.packages', 'module' => 'donate', 'description' => 'Can view donation packages'],
            ['key' => 'add.packages', 'module' => 'donate', 'description' => 'Can add donation packages'],
            ['key' => 'edit.packages', 'module' => 'donate', 'description' => 'Can edit donation packages'],
            ['key' => 'delete.packages', 'module' => 'donate', 'description' => 'Can delete donation packages'],
            ['key' => 'view.gateways', 'module' => 'donate', 'description' => 'Can view payment gateways'],
            ['key' => 'edit.gateways', 'module' => 'donate', 'description' => 'Can edit payment gateways'],
            ['key' => 'view.logs', 'module' => 'donate', 'description' => 'Can view donation logs'],
            ['key' => 'edit.settings', 'module' => 'donate', 'description' => 'Can edit donation settings']
        ]);

        // Assign all donate permissions to Administrator role (role_id = 5)
        $donate_permissions = $this->permission_model->find_all(['module' => 'donate']);
        if (! empty($donate_permissions)) {
            $role_permissions = [];
            foreach ($donate_permissions as $permission) {
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
        $donate_permissions = $this->permission_model->find_all(['module' => 'donate'], 'array');
        $permission_ids = array_column($donate_permissions, 'id');
        if (! empty($permission_ids)) {
            $this->db->where_in('permission_id', $permission_ids)->delete('roles_permissions');
            $this->permission_model->delete_in('id', $permission_ids);
        }
    }
}
