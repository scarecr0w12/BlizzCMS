<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('events_model');
        $this->load->helper(['form', 'url']);
        $this->load->library('form_validation');
    }

    public function index()
    {
        $stats = $this->events_model->get_statistics();
        
        $data = [
            'stats' => $stats,
            'upcoming_events' => $this->events_model->get_upcoming_events(5),
            'recent_events' => $this->db->order_by('created_at', 'DESC')->limit(5)->get('events')->result(),
        ];

        $this->template->title('Events Calendar Administration');
        $this->template->build('admin/index', $data);
    }

    public function create()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|max_length[255]');
            $this->form_validation->set_rules('event_type', 'Event Type', 'required');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');

            if ($this->form_validation->run()) {
                $data = [
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'event_type' => $this->input->post('event_type'),
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('end_date') ?: null,
                    'location' => $this->input->post('location') ?: null,
                    'max_participants' => $this->input->post('max_participants') ?: null,
                    'require_rsvp' => $this->input->post('require_rsvp') ? 1 : 0,
                    'featured' => $this->input->post('featured') ? 1 : 0,
                    'realm_id' => $this->input->post('realm_id') ?: null,
                    'created_by' => $this->session->userdata('user_id'),
                ];

                if ($this->events_model->create_event($data)) {
                    $this->session->set_flashdata('success', 'Event created successfully');
                    redirect('events/admin');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create event');
                }
            }
        }

        $data = [
            'event_types' => ['raid', 'dungeon', 'pvp', 'tournament', 'guild', 'other'],
            'realms' => $this->db->get('realms')->result(),
        ];

        $this->template->title('Create Event');
        $this->template->build('admin/create', $data);
    }

    public function edit($event_id)
    {
        $event = $this->events_model->get_event($event_id);
        
        if (!$event) {
            $this->session->set_flashdata('error', 'Event not found');
            redirect('events/admin');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|max_length[255]');
            $this->form_validation->set_rules('event_type', 'Event Type', 'required');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');

            if ($this->form_validation->run()) {
                $data = [
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'event_type' => $this->input->post('event_type'),
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('end_date') ?: null,
                    'location' => $this->input->post('location') ?: null,
                    'max_participants' => $this->input->post('max_participants') ?: null,
                    'require_rsvp' => $this->input->post('require_rsvp') ? 1 : 0,
                    'featured' => $this->input->post('featured') ? 1 : 0,
                    'realm_id' => $this->input->post('realm_id') ?: null,
                ];

                if ($this->events_model->update_event($event_id, $data)) {
                    $this->session->set_flashdata('success', 'Event updated successfully');
                    redirect('events/admin');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update event');
                }
            }
        }

        $data = [
            'event' => $event,
            'event_types' => ['raid', 'dungeon', 'pvp', 'tournament', 'guild', 'other'],
            'realms' => $this->db->get('realms')->result(),
            'rsvps' => $this->events_model->get_rsvps($event_id),
        ];

        $this->template->title('Edit Event');
        $this->template->build('admin/edit', $data);
    }

    public function delete($event_id)
    {
        $event = $this->events_model->get_event($event_id);
        
        if (!$event) {
            $this->session->set_flashdata('error', 'Event not found');
            redirect('events/admin');
        }

        if ($this->events_model->delete_event($event_id)) {
            $this->session->set_flashdata('success', 'Event deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete event');
        }

        redirect('events/admin');
    }

    public function settings()
    {
        if ($this->input->post()) {
            $settings = [
                'enable_rsvp' => $this->input->post('enable_rsvp'),
                'enable_reminders' => $this->input->post('enable_reminders'),
                'reminder_hours' => $this->input->post('reminder_hours'),
                'default_event_length' => $this->input->post('default_event_length'),
                'events_per_page' => $this->input->post('events_per_page'),
            ];

            foreach ($settings as $key => $value) {
                $this->events_model->update_setting($key, $value);
            }

            $this->session->set_flashdata('success', 'Settings saved successfully');
            redirect('events/admin/settings');
        }

        $data = [
            'settings' => $this->events_model->get_all_settings(),
        ];

        $this->template->title('Events Calendar Settings');
        $this->template->build('admin/settings', $data);
    }
}
