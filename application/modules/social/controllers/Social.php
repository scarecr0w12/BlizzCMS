<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Social extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('social/Social_model');
        $this->load->library('session');
        $this->load->helper('social');
    }

    public function index()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $data['page_title'] = 'Social Features';
        $this->load->view('social/index', $data);
    }

    public function friends()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $user_id = $this->session->userdata('user_id');
        
        $data['friends'] = $this->Social_model->get_friends($user_id);
        $data['friend_requests'] = $this->Social_model->get_friend_requests($user_id);
        $data['page_title'] = 'Friends';
        
        $this->load->view('social/friends', $data);
    }

    public function add_friend($friend_id)
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $user_id = $this->session->userdata('user_id');
        
        if ($this->Social_model->add_friend($user_id, $friend_id)) {
            $this->session->set_flashdata('success', 'Friend request sent successfully!');
        } else {
            $this->session->set_flashdata('error', 'Could not send friend request.');
        }
        
        redirect('social/friends');
    }

    public function accept_friend($friend_id)
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $user_id = $this->session->userdata('user_id');
        
        if ($this->Social_model->accept_friend($user_id, $friend_id)) {
            $this->session->set_flashdata('success', 'Friend request accepted!');
        } else {
            $this->session->set_flashdata('error', 'Could not accept friend request.');
        }
        
        redirect('social/friends');
    }

    public function remove_friend($friend_id)
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $user_id = $this->session->userdata('user_id');
        
        if ($this->Social_model->remove_friend($user_id, $friend_id)) {
            $this->session->set_flashdata('success', 'Friend removed successfully!');
        } else {
            $this->session->set_flashdata('error', 'Could not remove friend.');
        }
        
        redirect('social/friends');
    }

    public function messages()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $user_id = $this->session->userdata('user_id');
        
        $page = $this->input->get('page') ?: 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $messages = $this->Social_model->get_messages($user_id, $limit, $offset);
        $total = $this->db->where('to_id', $user_id)->count_all_results('user_messages');
        
        $data['messages'] = $messages;
        $data['unread_count'] = $this->Social_model->get_unread_count($user_id);
        $data['page'] = $page;
        $data['total'] = $total;
        $data['limit'] = $limit;
        $data['page_title'] = 'Messages';
        
        $this->load->view('social/messages', $data);
    }

    public function view_message($message_id)
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $user_id = $this->session->userdata('user_id');
        
        $message = $this->db->where('id', $message_id)
            ->where('to_id', $user_id)
            ->get('user_messages')
            ->row();
        
        if (!$message) {
            show_404();
        }
        
        $this->Social_model->mark_message_read($message_id, $user_id);
        
        $sender = $this->db->where('id', $message->from_id)->get('users')->row();
        
        $data['message'] = $message;
        $data['sender'] = $sender;
        $data['page_title'] = 'View Message';
        
        $this->load->view('social/view_message', $data);
    }

    public function send_message()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $user_id = $this->session->userdata('user_id');
        
        if ($this->input->method() === 'post') {
            $to_id = $this->input->post('to_id');
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');
            
            if ($this->Social_model->send_message($user_id, $to_id, $subject, $message)) {
                $this->session->set_flashdata('success', 'Message sent successfully!');
                redirect('social/messages');
            } else {
                $this->session->set_flashdata('error', 'Could not send message.');
            }
        }
        
        $data['page_title'] = 'Send Message';
        $this->load->view('social/send_message', $data);
    }

    public function guilds()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $guilds = $this->Social_model->get_top_guilds(50);
        
        $data['guilds'] = $guilds;
        $data['page_title'] = 'Guilds';
        
        $this->load->view('social/guilds', $data);
    }

    public function view_guild($guild_id)
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $guild = $this->Social_model->get_guild($guild_id);
        
        if (!$guild) {
            show_404();
        }
        
        $members = $this->Social_model->get_guild_members($guild_id);
        
        $data['guild'] = $guild;
        $data['members'] = $members;
        $data['page_title'] = 'Guild: ' . $guild->name;
        
        $this->load->view('social/view_guild', $data);
    }

    public function guild_members($guild_id)
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $guild = $this->Social_model->get_guild($guild_id);
        
        if (!$guild) {
            show_404();
        }
        
        $members = $this->Social_model->get_guild_members($guild_id);
        
        $data['guild'] = $guild;
        $data['members'] = $members;
        $data['page_title'] = 'Guild Members: ' . $guild->name;
        
        $this->load->view('social/guild_members', $data);
    }

    public function feed()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $user_id = $this->session->userdata('user_id');
        
        $page = $this->input->get('page') ?: 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $activities = $this->Social_model->get_social_feed($user_id, $limit, $offset);
        $total = $this->db->where('is_public', 1)->count_all_results('user_activities');
        
        $data['activities'] = $activities;
        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['total'] = $total;
        $data['page_title'] = 'Social Feed';
        
        $this->load->view('social/feed', $data);
    }

    public function search()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $search_term = $this->input->get('q');
        
        if (empty($search_term)) {
            redirect('social/friends');
        }
        
        $users = $this->Social_model->search_users($search_term, 50);
        
        $data['users'] = $users;
        $data['search_term'] = $search_term;
        $data['page_title'] = 'Search Users';
        
        $this->load->view('social/search', $data);
    }

    public function delete_message($message_id)
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $user_id = $this->session->userdata('user_id');
        
        if ($this->Social_model->delete_message($message_id, $user_id)) {
            $this->session->set_flashdata('success', 'Message deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Could not delete message.');
        }
        
        redirect('social/messages');
    }

    public function sent_messages()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $user_id = $this->session->userdata('user_id');
        
        $page = $this->input->get('page') ?: 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $messages = $this->Social_model->get_sent_messages($user_id, $limit, $offset);
        $total = $this->db->where('from_id', $user_id)->count_all_results('user_messages');
        
        $data['messages'] = $messages;
        $data['page'] = $page;
        $data['total'] = $total;
        $data['limit'] = $limit;
        $data['page_title'] = 'Sent Messages';
        
        $this->load->view('social/sent_messages', $data);
    }

    public function profile($user_id)
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $user = $this->Social_model->get_user_profile($user_id);
        
        if (!$user) {
            show_404();
        }
        
        $friend_count = $this->Social_model->get_friend_count($user_id);
        $activity_count = $this->Social_model->get_activity_count($user_id);
        
        $data['user'] = $user;
        $data['friend_count'] = $friend_count;
        $data['activity_count'] = $activity_count;
        $data['page_title'] = 'Profile: ' . $user->username;
        
        $this->load->view('social/profile', $data);
    }

    public function dashboard()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $user_id = $this->session->userdata('user_id');
        
        $data['unread_messages'] = $this->Social_model->get_unread_count($user_id);
        $data['friend_count'] = $this->Social_model->get_friend_count($user_id);
        $data['pending_requests'] = $this->Social_model->get_pending_requests_count($user_id);
        $data['guild_count'] = $this->Social_model->get_guild_count();
        $data['recent_friends'] = array_slice($this->Social_model->get_friends($user_id), 0, 5);
        $data['page_title'] = 'Social Dashboard';
        
        $this->load->view('social/dashboard', $data);
    }
}
