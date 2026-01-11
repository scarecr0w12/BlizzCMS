<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends MX_Controller
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
        $page = $this->input->get('page') ?: 1;
        $settings = $this->events_model->get_all_settings();
        $per_page = isset($settings['events_per_page']) ? (int)$settings['events_per_page'] : 12;
        $offset = ($page - 1) * $per_page;

        $total_events = $this->db->where('start_date >=', date('Y-m-d H:i:s'))->count_all_results('events');
        $events = $this->events_model->get_upcoming_events($per_page, $offset);

        $data = [
            'events' => $events,
            'featured_events' => $this->events_model->get_featured_events(),
            'page' => $page,
            'per_page' => $per_page,
            'total_events' => $total_events,
            'total_pages' => ceil($total_events / $per_page),
        ];

        $this->template->title('Events Calendar');
        $this->template->build('index', $data);
    }

    public function calendar()
    {
        $month = $this->input->get('month') ?: date('m');
        $year = $this->input->get('year') ?: date('Y');

        $start_date = date('Y-m-d H:i:s', mktime(0, 0, 0, $month, 1, $year));
        $end_date = date('Y-m-d H:i:s', mktime(23, 59, 59, $month + 1, 0, $year));

        $events = $this->events_model->get_events_by_date_range($start_date, $end_date);

        $data = [
            'events' => $events,
            'month' => $month,
            'year' => $year,
            'current_month' => date('F Y', mktime(0, 0, 0, $month, 1, $year)),
            'calendar_days' => $this->_generate_calendar($month, $year, $events),
        ];

        $this->template->title('Events Calendar - ' . $data['current_month']);
        $this->template->build('calendar', $data);
    }

    public function view($event_id)
    {
        $event = $this->events_model->get_event($event_id);

        if (!$event) {
            $this->session->set_flashdata('error', 'Event not found');
            redirect('events');
        }

        $user_id = $this->session->userdata('user_id');
        $user_rsvp = $user_id ? $this->events_model->get_user_rsvp($event_id, $user_id) : null;
        $rsvp_count = $this->events_model->get_rsvp_count($event_id);
        $rsvps = $this->events_model->get_rsvps($event_id);

        $data = [
            'event' => $event,
            'user_rsvp' => $user_rsvp,
            'rsvp_count' => $rsvp_count,
            'rsvps' => $rsvps,
            'is_logged_in' => (bool)$user_id,
            'user_id' => $user_id,
        ];

        $this->template->title($event->title);
        $this->template->build('view', $data);
    }

    public function rsvp($event_id)
    {
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You must be logged in to RSVP');
            redirect('events/view/' . $event_id);
        }

        $event = $this->events_model->get_event($event_id);

        if (!$event) {
            $this->session->set_flashdata('error', 'Event not found');
            redirect('events');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('status', 'RSVP Status', 'required|in_list[attending,tentative,declined]');
            $this->form_validation->set_rules('character_name', 'Character Name', 'max_length[100]');
            $this->form_validation->set_rules('character_class', 'Character Class', 'max_length[50]');
            $this->form_validation->set_rules('notes', 'Notes', 'max_length[500]');

            if ($this->form_validation->run()) {
                $rsvp_data = [
                    'event_id' => $event_id,
                    'user_id' => $this->session->userdata('user_id'),
                    'status' => $this->input->post('status'),
                    'character_name' => $this->input->post('character_name') ?: null,
                    'character_class' => $this->input->post('character_class') ?: null,
                    'notes' => $this->input->post('notes') ?: null,
                ];

                if ($this->events_model->create_rsvp($rsvp_data)) {
                    $this->session->set_flashdata('success', 'RSVP submitted successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed to submit RSVP');
                }
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }
        }

        redirect('events/view/' . $event_id);
    }

    public function cancel_rsvp($event_id)
    {
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You must be logged in');
            redirect('events/view/' . $event_id);
        }

        $event = $this->events_model->get_event($event_id);

        if (!$event) {
            $this->session->set_flashdata('error', 'Event not found');
            redirect('events');
        }

        if ($this->events_model->delete_rsvp($event_id, $this->session->userdata('user_id'))) {
            $this->session->set_flashdata('success', 'RSVP cancelled successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to cancel RSVP');
        }

        redirect('events/view/' . $event_id);
    }

    public function my_events()
    {
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You must be logged in to view your events');
            redirect('events');
        }

        $user_id = $this->session->userdata('user_id');
        $events = $this->events_model->get_user_events($user_id);

        $data = [
            'events' => $events,
            'user_id' => $user_id,
        ];

        $this->template->title('My Events');
        $this->template->build('my_events', $data);
    }

    public function search()
    {
        $query = $this->input->get('q');
        $type = $this->input->get('type');

        $events = [];

        if ($query) {
            $this->db->like('title', $query);
            $this->db->or_like('description', $query);
            $this->db->where('start_date >=', date('Y-m-d H:i:s'));

            if ($type && $type !== 'all') {
                $this->db->where('event_type', $type);
            }

            $events = $this->db->order_by('start_date', 'ASC')->get('events')->result();
        }

        $data = [
            'events' => $events,
            'query' => $query,
            'type' => $type,
        ];

        $this->template->title('Search Events');
        $this->template->build('search', $data);
    }

    private function _generate_calendar($month, $year, $events)
    {
        $calendar = [];
        $first_day = mktime(0, 0, 0, $month, 1, $year);
        $last_day = mktime(23, 59, 59, $month + 1, 0, $year);
        $days_in_month = date('t', $first_day);
        $start_day = date('w', $first_day);

        $events_by_day = [];
        foreach ($events as $event) {
            $day = date('d', strtotime($event->start_date));
            if (!isset($events_by_day[$day])) {
                $events_by_day[$day] = [];
            }
            $events_by_day[$day][] = $event;
        }

        $day = 1;
        for ($i = 0; $i < 6; $i++) {
            $week = [];
            for ($j = 0; $j < 7; $j++) {
                if (($i == 0 && $j < $start_day) || $day > $days_in_month) {
                    $week[] = ['day' => null, 'events' => []];
                } else {
                    $week[] = [
                        'day' => $day,
                        'events' => isset($events_by_day[$day]) ? $events_by_day[$day] : []
                    ];
                    $day++;
                }
            }
            $calendar[] = $week;
        }

        return $calendar;
    }
}
