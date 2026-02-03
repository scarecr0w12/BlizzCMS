<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_ticket_permissions extends CI_Migration
{
    public function up()
    {
        $this->load->model('permission_model');

        $this->permission_model->insert_batch([
            ['key' => 'view.tickets', 'module' => 'admin', 'description' => 'Can view game tickets'],
            ['key' => 'edit.tickets', 'module' => 'admin', 'description' => 'Can respond to and manage game tickets']
        ]);
    }

    public function down()
    {
        $this->db->where_in('key', ['view.tickets', 'edit.tickets'])
            ->where('module', 'admin')
            ->delete('permissions');
    }
}
