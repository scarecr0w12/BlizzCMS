<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_module_menu_items extends CI_Migration
{
    public function up()
    {
        $items = [
            ['menu_id' => 1, 'name' => 'Shop', 'url' => 'shop', 'icon' => 'fa-solid fa-store', 'target' => '_self', 'type' => 'link', 'parent' => 0, 'sort' => 2],
            ['menu_id' => 1, 'name' => 'Vote', 'url' => 'vote', 'icon' => 'fa-solid fa-thumbs-up', 'target' => '_self', 'type' => 'link', 'parent' => 0, 'sort' => 3],
            ['menu_id' => 1, 'name' => 'Donate', 'url' => 'donate', 'icon' => 'fa-solid fa-heart', 'target' => '_self', 'type' => 'link', 'parent' => 0, 'sort' => 4],
            ['menu_id' => 1, 'name' => 'World Boss', 'url' => 'worldboss', 'icon' => 'fa-solid fa-dragon', 'target' => '_self', 'type' => 'link', 'parent' => 0, 'sort' => 5],
            ['menu_id' => 1, 'name' => 'Armory', 'url' => 'armory', 'icon' => 'fa-solid fa-shield', 'target' => '_self', 'type' => 'link', 'parent' => 0, 'sort' => 6],
        ];

        $this->menu_item_model->insert_batch($items);

        $newItems = $this->menu_item_model->find_all(['menu_id' => 1], 'array');
        $permsItems = [];

        foreach ($newItems as $item) {
            if ($item['id'] > 4) {
                $permsItems[] = [
                    'key'         => $item['id'],
                    'module'      => ':menu-item:',
                    'description' => "Can view {$item['name']} {$item['type']} item"
                ];
            }
        }

        if (!empty($permsItems)) {
            $this->permission_model->insert_batch($permsItems);

            $permissions = $this->permission_model->find_all(['module' => ':menu-item:']);
            $permsLinked = [];

            foreach ($permissions as $permission) {
                if ($permission->key > 4) {
                    $permsLinked[] = ['role_id' => '1', 'permission_id' => $permission->id];
                    $permsLinked[] = ['role_id' => '2', 'permission_id' => $permission->id];
                    $permsLinked[] = ['role_id' => '3', 'permission_id' => $permission->id];
                    $permsLinked[] = ['role_id' => '4', 'permission_id' => $permission->id];
                    $permsLinked[] = ['role_id' => '5', 'permission_id' => $permission->id];
                }
            }

            if (!empty($permsLinked)) {
                $this->role_permission_model->insert_batch($permsLinked);
            }
        }

        $this->cache->delete('menu_*');
        $this->cache->delete('permission_*');
    }

    public function down()
    {
        $items = $this->menu_item_model->find_all(['menu_id' => 1], 'array');
        $itemIds = [];

        foreach ($items as $item) {
            if ($item['id'] > 4) {
                $itemIds[] = $item['id'];
            }
        }

        if (!empty($itemIds)) {
            $this->menu_item_model->delete_in('id', $itemIds);

            $permissions = $this->permission_model->find_all(['module' => ':menu-item:'], 'array');
            $permissionsToDelete = [];

            foreach ($permissions as $permission) {
                if (in_array($permission['key'], $itemIds)) {
                    $permissionsToDelete[] = $permission['id'];
                }
            }

            if (!empty($permissionsToDelete)) {
                $this->role_permission_model->delete_in('permission_id', $permissionsToDelete);
                $this->permission_model->delete_in('id', $permissionsToDelete);
            }
        }

        $this->cache->delete('menu_*');
        $this->cache->delete('permission_*');
    }
}
