<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game_tickets_model extends CI_Model
{
    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Connect to game world database
     *
     * @param int $realm
     * @return object
     */
    public function connect($realm)
    {
        $row = $this->realm_model->find(['id' => $realm]);

        if (empty($row)) {
            show_error(lang('error_characters_db_not_found'));
        }

        $database = $this->load->database([
            'hostname' => $row->char_hostname,
            'username' => $row->char_username,
            'password' => decrypt($row->char_password),
            'database' => $row->char_database,
            'port'     => $row->char_port,
            'dbdriver' => 'mysqli',
            'pconnect' => FALSE,
            'char_set' => 'utf8mb4',
            'dbcollat' => 'utf8mb4_unicode_ci'
        ], true);

        if ($database->conn_id === false) {
            show_error(lang('error_world_connection'));
        }

        return $database;
    }

    /**
     * Get all tickets from a realm
     *
     * @param int $realm
     * @param int $limit
     * @param int $offset
     * @param array $filters
     * @return array
     */
    public function get_tickets($realm, $limit = 50, $offset = 0, $filters = [])
    {
        $db = $this->connect($realm);
        $query = $db->from('gm_ticket');

        if (!empty($filters['status'])) {
            $query->where('completed', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->group_start()
                ->like('name', $search)
                ->or_like('description', $search)
                ->group_end();
        }

        $query->order_by('createTime', 'DESC');
        $query->limit($limit, $offset);

        return $query->get()->result();
    }

    /**
     * Count total tickets
     *
     * @param int $realm
     * @param array $filters
     * @return int
     */
    public function count_tickets($realm, $filters = [])
    {
        $db = $this->connect($realm);
        $query = $db->from('gm_ticket');

        if (!empty($filters['status'])) {
            $query->where('completed', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->group_start()
                ->like('name', $search)
                ->or_like('description', $search)
                ->group_end();
        }

        return $query->count_all_results();
    }

    /**
     * Get single ticket
     *
     * @param int $realm
     * @param int $ticket_id
     * @return object|null
     */
    public function get_ticket($realm, $ticket_id)
    {
        $db = $this->connect($realm);
        return $db->where('id', $ticket_id)
            ->get('gm_ticket')
            ->row();
    }

    /**
     * Update ticket status
     *
     * @param int $realm
     * @param int $ticket_id
     * @param int $status
     * @return bool
     */
    public function update_ticket_status($realm, $ticket_id, $status)
    {
        $db = $this->connect($realm);
        return $db->update('gm_ticket', [
            'completed' => $status,
            'lastModifiedTime' => time()
        ], ['id' => $ticket_id]);
    }

    /**
     * Add response to ticket
     *
     * @param int $realm
     * @param int $ticket_id
     * @param string $response
     * @param string $gm_name
     * @return bool
     */
    public function add_response($realm, $ticket_id, $response, $gm_name)
    {
        $db = $this->connect($realm);
        
        $ticket = $this->get_ticket($realm, $ticket_id);
        if (empty($ticket)) {
            return false;
        }

        $updated_response = $ticket->response ?? '';
        $updated_response .= "\n\n[" . date('Y-m-d H:i:s') . "] " . $gm_name . ": " . $response;

        return $db->update('gm_ticket', [
            'response' => $updated_response,
            'lastModifiedTime' => time()
        ], ['id' => $ticket_id]);
    }

    /**
     * Close ticket
     *
     * @param int $realm
     * @param int $ticket_id
     * @param string $response
     * @param string $gm_name
     * @return bool
     */
    public function close_ticket($realm, $ticket_id, $response = '', $gm_name = '')
    {
        if (!empty($response)) {
            $this->add_response($realm, $ticket_id, $response, $gm_name);
        }

        return $this->update_ticket_status($realm, $ticket_id, 1); // 1 = completed
    }

    /**
     * Get ticket status name
     *
     * @param int $status
     * @return string
     */
    public function get_status_name($status)
    {
        $statuses = [
            0 => 'Open',
            1 => 'In Progress',
            2 => 'Closed'
        ];

        return $statuses[$status] ?? 'Unknown';
    }

    /**
     * Get ticket priority name
     *
     * @param int $priority
     * @return string
     */
    public function get_priority_name($priority)
    {
        $priorities = [
            0 => 'Low',
            1 => 'Medium',
            2 => 'High',
            3 => 'Urgent'
        ];

        return $priorities[$priority] ?? 'Unknown';
    }
}
