<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('notifications_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = [
            'statistics' => $this->notifications_model->get_statistics(),
        ];

        $this->template->title('Notifications Administration');
        $this->template->build('admin/index', $data);
    }

    public function settings()
    {
        if ($this->input->post()) {
            $settings = [
                'enable_email' => $this->input->post('enable_email'),
                'enable_browser_push' => $this->input->post('enable_browser_push'),
                'retention_days' => $this->input->post('retention_days'),
                'from_email' => $this->input->post('from_email'),
                'from_name' => $this->input->post('from_name'),
            ];

            foreach ($settings as $key => $value) {
                $this->notifications_model->update_setting($key, $value);
            }

            $this->session->set_flashdata('success', 'Settings saved successfully');
            redirect('notifications/admin/settings');
        }

        $data = [
            'settings' => $this->notifications_model->get_all_settings(),
        ];

        $this->template->title('Notification Settings');
        $this->template->build('admin/settings', $data);
    }

    public function send()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('message', 'Message', 'required');
            $this->form_validation->set_rules('type', 'Type', 'required');

            if ($this->form_validation->run()) {
                $send_to = $this->input->post('send_to');
                $notification_data = [
                    'type' => $this->input->post('type'),
                    'title' => $this->input->post('title'),
                    'message' => $this->input->post('message'),
                    'link' => $this->input->post('link'),
                ];

                if ($send_to === 'all') {
                    $this->load->model('user_model');
                    $users = $this->user_model->find_all();
                    $user_ids = array_column($users, 'id');
                    $this->notifications_model->send_bulk_notification($user_ids, $notification_data);
                } else {
                    $user_id = $this->input->post('user_id');
                    $notification_data['user_id'] = $user_id;
                    $this->notifications_model->create_notification($notification_data);
                }

                $this->session->set_flashdata('success', 'Notification sent successfully');
                redirect('notifications/admin/send');
            }
        }

        $this->template->title('Send Notification');
        $this->template->build('admin/send', []);
    }
}
