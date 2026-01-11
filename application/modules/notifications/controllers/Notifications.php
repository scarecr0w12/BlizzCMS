<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('notifications_model');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $page = $this->input->get('page') ?: 1;
        $per_page = 20;
        $offset = ($page - 1) * $per_page;

        $data = [
            'notifications' => $this->notifications_model->get_user_notifications($user_id, $per_page, $offset),
            'unread_count' => $this->notifications_model->get_unread_count($user_id),
            'current_page' => $page,
            'per_page' => $per_page,
        ];

        $this->template->title(lang('notifications_title'));
        $this->template->build('index', $data);
    }

    public function get_count()
    {
        $user_id = $this->session->userdata('user_id');
        $count = $this->notifications_model->get_unread_count($user_id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['count' => $count]));
    }

    public function get_recent()
    {
        $user_id = $this->session->userdata('user_id');
        $notifications = $this->notifications_model->get_recent_unread($user_id, 5);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['notifications' => $notifications]));
    }

    public function mark_read($notification_id)
    {
        $user_id = $this->session->userdata('user_id');
        $this->notifications_model->mark_as_read($notification_id, $user_id);

        if ($this->input->is_ajax_request()) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true]));
        } else {
            redirect('notifications');
        }
    }

    public function mark_all_read()
    {
        $user_id = $this->session->userdata('user_id');
        $this->notifications_model->mark_all_read($user_id);

        $this->session->set_flashdata('success', lang('notifications_marked_read'));
        redirect('notifications');
    }

    public function delete($notification_id)
    {
        $user_id = $this->session->userdata('user_id');
        $this->notifications_model->delete_notification($notification_id, $user_id);

        if ($this->input->is_ajax_request()) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => true]));
        } else {
            $this->session->set_flashdata('success', lang('notifications_deleted'));
            redirect('notifications');
        }
    }

    public function preferences()
    {
        $user_id = $this->session->userdata('user_id');

        if ($this->input->post()) {
            $preferences = [
                'email_notifications' => $this->input->post('email_notifications') ? 1 : 0,
                'browser_notifications' => $this->input->post('browser_notifications') ? 1 : 0,
                'notify_donations' => $this->input->post('notify_donations') ? 1 : 0,
                'notify_shop' => $this->input->post('notify_shop') ? 1 : 0,
                'notify_votes' => $this->input->post('notify_votes') ? 1 : 0,
                'notify_news' => $this->input->post('notify_news') ? 1 : 0,
                'notify_events' => $this->input->post('notify_events') ? 1 : 0,
                'notify_system' => $this->input->post('notify_system') ? 1 : 0,
            ];

            $this->notifications_model->update_preferences($user_id, $preferences);
            $this->session->set_flashdata('success', lang('notifications_preferences_saved'));
            redirect('notifications/preferences');
        }

        $data = [
            'preferences' => $this->notifications_model->get_user_preferences($user_id),
        ];

        $this->template->title(lang('notifications_preferences'));
        $this->template->build('preferences', $data);
    }
}
