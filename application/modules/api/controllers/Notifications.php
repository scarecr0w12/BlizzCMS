<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('api_response');
        $this->load->library('api_auth');
        $this->load->model('notifications/notifications_model');
        
        $this->verify_token();
    }

    public function index()
    {
        $user_id = $this->current_user['user_id'];
        $page = $this->input->get('page') ?: 1;
        $per_page = $this->input->get('per_page') ?: 20;
        $offset = ($page - 1) * $per_page;

        $notifications = $this->notifications_model->get_user_notifications($user_id, $per_page, $offset);
        $total = $this->db->where('user_id', $user_id)->count_all_results('notifications');

        $this->api_response->paginated($notifications, $total, $page, $per_page);
    }

    public function unread()
    {
        $user_id = $this->current_user['user_id'];
        $count = $this->notifications_model->get_unread_count($user_id);
        $notifications = $this->notifications_model->get_recent_unread($user_id, 5);

        $this->api_response->success([
            'count' => $count,
            'notifications' => $notifications,
        ]);
    }

    public function get($notification_id)
    {
        $user_id = $this->current_user['user_id'];
        $notification = $this->db->where('id', $notification_id)
            ->where('user_id', $user_id)
            ->get('notifications')
            ->row();

        if (!$notification) {
            return $this->api_response->error('Notification not found', 404);
        }

        $this->api_response->success($notification);
    }

    public function mark_read($notification_id)
    {
        $user_id = $this->current_user['user_id'];
        $this->notifications_model->mark_as_read($notification_id, $user_id);

        $this->api_response->success(null, 'Notification marked as read');
    }

    public function mark_all_read()
    {
        $user_id = $this->current_user['user_id'];
        $this->notifications_model->mark_all_read($user_id);

        $this->api_response->success(null, 'All notifications marked as read');
    }

    private function verify_token()
    {
        $token = $this->api_auth->get_token_from_header();

        if (!$token) {
            $this->api_response->error('Unauthorized', 401);
            exit;
        }

        $payload = $this->api_auth->verify_token($token);

        if (!$payload) {
            $this->api_response->error('Invalid or expired token', 401);
            exit;
        }

        $this->current_user = $payload;
    }
}
