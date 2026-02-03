<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_vote_permissions extends CI_Migration
{
    public function up()
    {
        $this->load->model('permission_model');
        $this->load->model('role_permission_model');

        // Insert vote permissions
        $this->permission_model->insert_batch([
            ['key' => 'view.vote', 'module' => 'vote', 'description' => 'Can view vote admin dashboard'],
            ['key' => 'view.sites', 'module' => 'vote', 'description' => 'Can view vote sites'],
            ['key' => 'add.sites', 'module' => 'vote', 'description' => 'Can add new vote sites'],
            ['key' => 'edit.sites', 'module' => 'vote', 'description' => 'Can edit vote sites'],
            ['key' => 'delete.sites', 'module' => 'vote', 'description' => 'Can delete vote sites'],
            ['key' => 'view.logs', 'module' => 'vote', 'description' => 'Can view vote logs'],
            ['key' => 'edit.settings', 'module' => 'vote', 'description' => 'Can edit vote settings']
        ]);

        // Assign all vote permissions to Administrator role (role_id = 5)
        $vote_permissions = $this->permission_model->find_all(['module' => 'vote']);
        if (! empty($vote_permissions)) {
            $role_permissions = [];
            foreach ($vote_permissions as $permission) {
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
        $vote_permissions = $this->permission_model->find_all(['module' => 'vote'], 'array');
        $permission_ids = array_column($vote_permissions, 'id');
        if (! empty($permission_ids)) {
            $this->db->where_in('permission_id', $permission_ids)->delete('roles_permissions');
            $this->permission_model->delete_in('id', $permission_ids);
        }
    }
}
