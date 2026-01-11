<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_fix_shop_permissions extends CI_Migration
{
    public function up()
    {
        $this->load->model('permission_model');

        // Map of old permission keys to new ones
        $permission_map = [
            'view.categories'      => 'view.shop.category',
            'add.categories'       => 'add.shop.category',
            'edit.categories'      => 'edit.shop.category',
            'delete.categories'    => 'delete.shop.category',
            'view.items'           => 'view.shop.item',
            'add.items'            => 'add.shop.item',
            'edit.items'           => 'edit.shop.item',
            'delete.items'         => 'delete.shop.item',
            'view.services'        => 'view.shop.service',
            'add.services'         => 'add.shop.service',
            'edit.services'        => 'edit.shop.service',
            'delete.services'      => 'delete.shop.service',
            'view.subscriptions'   => 'view.shop.subscription',
            'add.subscriptions'    => 'add.shop.subscription',
            'edit.subscriptions'   => 'edit.shop.subscription',
            'delete.subscriptions' => 'delete.shop.subscription',
            'view.orders'          => 'view.shop.order',
            'process.orders'       => 'process.shop.order',
            'view.payments'        => 'view.shop.payment',
            'edit.settings'        => 'edit.shop.settings'
        ];

        // Update existing permissions
        foreach ($permission_map as $old_key => $new_key) {
            $this->db->where('module', 'shop')
                ->where('key', $old_key)
                ->update('permissions', ['key' => $new_key]);
        }

        // Clear permission cache
        $this->load->driver('cache', ['adapter' => 'file']);
        $this->cache->clean();
    }

    public function down()
    {
        $this->load->model('permission_model');

        // Reverse map for rollback
        $permission_map = [
            'view.shop.category'      => 'view.categories',
            'add.shop.category'       => 'add.categories',
            'edit.shop.category'      => 'edit.categories',
            'delete.shop.category'    => 'delete.categories',
            'view.shop.item'          => 'view.items',
            'add.shop.item'           => 'add.items',
            'edit.shop.item'          => 'edit.items',
            'delete.shop.item'        => 'delete.items',
            'view.shop.service'       => 'view.services',
            'add.shop.service'        => 'add.services',
            'edit.shop.service'       => 'edit.services',
            'delete.shop.service'     => 'delete.services',
            'view.shop.subscription'  => 'view.subscriptions',
            'add.shop.subscription'   => 'add.subscriptions',
            'edit.shop.subscription'  => 'edit.subscriptions',
            'delete.shop.subscription' => 'delete.subscriptions',
            'view.shop.order'         => 'view.orders',
            'process.shop.order'      => 'process.orders',
            'view.shop.payment'       => 'view.payments',
            'edit.shop.settings'      => 'edit.settings'
        ];

        foreach ($permission_map as $new_key => $old_key) {
            $this->db->where('module', 'shop')
                ->where('key', $new_key)
                ->update('permissions', ['key' => $old_key]);
        }

        // Clear permission cache
        $this->load->driver('cache', ['adapter' => 'file']);
        $this->cache->clean();
    }
}
