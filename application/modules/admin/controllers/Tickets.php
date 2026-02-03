<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('game_tickets_model');
    }

    /**
     * List all tickets
     *
     * @return void
     */
    public function index()
    {
        require_permission('view.tickets');

        $realm_id = $this->input->get('realm') ?? 1;
        $status_filter = $this->input->get('status');
        $search = $this->input->get('search');
        $page = $this->input->get('page') ?? 1;

        $perPage = 25;
        $offset = ($page - 1) * $perPage;

        $filters = [];
        if (!empty($status_filter) && is_numeric($status_filter)) {
            $filters['status'] = (int)$status_filter;
        }
        if (!empty($search)) {
            $filters['search'] = xss_clean($search);
        }

        try {
            $total = $this->game_tickets_model->count_tickets($realm_id, $filters);
            $tickets = $this->game_tickets_model->get_tickets($realm_id, $perPage, $offset, $filters);

            $this->pagination->initialize([
                'base_url'   => site_url('admin/tickets'),
                'total_rows' => $total,
                'per_page'   => $perPage,
                'query_string_segment' => 'page'
            ]);

            $data = [
                'tickets'      => $tickets,
                'pagination'   => $this->pagination->create_links(),
                'realms'       => $this->realm_model->find_all(),
                'realm_id'     => $realm_id,
                'status_filter' => $status_filter,
                'search'       => $search,
                'statuses'     => [
                    0 => 'Open',
                    1 => 'Completed'
                ]
            ];

            $this->template->title(lang('admin_panel'), config_item('app_name'));
            $this->template->build('tickets/index', $data);
        } catch (Exception $e) {
            log_message('error', 'Tickets Controller Error: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Error loading tickets: ' . $e->getMessage());
            redirect(site_url('admin'));
        }
    }

    /**
     * View single ticket
     *
     * @param int $ticket_id
     * @return void
     */
    public function view($ticket_id = null)
    {
        require_permission('view.tickets');

        if (empty($ticket_id) || !is_numeric($ticket_id)) {
            show_404();
        }

        $realm_id = $this->input->get('realm') ?? 1;

        try {
            $ticket = $this->game_tickets_model->get_ticket($realm_id, $ticket_id);

            if (empty($ticket)) {
                show_404();
            }

            $data = [
                'ticket'   => $ticket,
                'realm_id' => $realm_id,
                'realms'   => $this->realm_model->find_all(),
                'statuses' => [
                    0 => 'Open',
                    1 => 'Completed'
                ]
            ];

            $this->template->title(lang('admin_panel'), config_item('app_name'));
            $this->template->build('tickets/view', $data);
        } catch (Exception $e) {
            log_message('error', 'Tickets View Error: ' . $e->getMessage());
            show_404();
        }
    }

    /**
     * Add response to ticket
     *
     * @return void
     */
    public function respond()
    {
        require_permission('edit.tickets');

        if ($this->input->method() !== 'post') {
            show_404();
        }

        $ticket_id = $this->input->post('ticket_id');
        $realm_id = $this->input->post('realm_id');
        $response = $this->input->post('response');

        if (empty($ticket_id) || empty($realm_id) || empty($response)) {
            $this->session->set_flashdata('error', lang('all_fields_required'));
            redirect(site_url('admin/tickets/view/' . $ticket_id . '?realm=' . $realm_id));
        }

        try {
            $user = $this->session->userdata();
            $gm_name = $user['username'] ?? 'Admin';

            $this->game_tickets_model->add_response($realm_id, $ticket_id, $response, $gm_name);
            $this->game_tickets_model->update_ticket_status($realm_id, $ticket_id, 1); // Mark as in progress

            $this->log_model->create('tickets', 'respond', 'Responded to ticket #' . $ticket_id);

            $this->session->set_flashdata('success', lang('response_added_successfully'));
            redirect(site_url('admin/tickets/view/' . $ticket_id . '?realm=' . $realm_id));
        } catch (Exception $e) {
            log_message('error', 'Tickets Respond Error: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Error adding response: ' . $e->getMessage());
            redirect(site_url('admin/tickets/view/' . $ticket_id . '?realm=' . $realm_id));
        }
    }

    /**
     * Close ticket
     *
     * @return void
     */
    public function close()
    {
        require_permission('edit.tickets');

        if ($this->input->method() !== 'post') {
            show_404();
        }

        $ticket_id = $this->input->post('ticket_id');
        $realm_id = $this->input->post('realm_id');
        $response = $this->input->post('response') ?? '';

        if (empty($ticket_id) || empty($realm_id)) {
            $this->session->set_flashdata('error', lang('invalid_request'));
            redirect(site_url('admin/tickets'));
        }

        try {
            $user = $this->session->userdata();
            $gm_name = $user['username'] ?? 'Admin';

            $this->game_tickets_model->close_ticket($realm_id, $ticket_id, $response, $gm_name);

            $this->log_model->create('tickets', 'close', 'Closed ticket #' . $ticket_id);

            $this->session->set_flashdata('success', lang('ticket_closed_successfully'));
            redirect(site_url('admin/tickets'));
        } catch (Exception $e) {
            log_message('error', 'Tickets Close Error: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Error closing ticket: ' . $e->getMessage());
            redirect(site_url('admin/tickets'));
        }
    }

    /**
     * Update ticket status
     *
     * @return void
     */
    public function update_status()
    {
        require_permission('edit.tickets');

        if ($this->input->method() !== 'post') {
            show_404();
        }

        $ticket_id = $this->input->post('ticket_id');
        $realm_id = $this->input->post('realm_id');
        $status = $this->input->post('status');

        if (empty($ticket_id) || empty($realm_id) || !is_numeric($status)) {
            $this->session->set_flashdata('error', lang('invalid_request'));
            redirect(site_url('admin/tickets'));
        }

        try {
            $this->game_tickets_model->update_ticket_status($realm_id, $ticket_id, $status);

            $this->log_model->create('tickets', 'update_status', 'Updated ticket #' . $ticket_id . ' status to ' . $status);

            $this->session->set_flashdata('success', lang('ticket_updated_successfully'));
            redirect(site_url('admin/tickets/view/' . $ticket_id . '?realm=' . $realm_id));
        } catch (Exception $e) {
            log_message('error', 'Tickets Update Status Error: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Error updating ticket: ' . $e->getMessage());
            redirect(site_url('admin/tickets'));
        }
    }
}
