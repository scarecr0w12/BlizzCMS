<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Vote extends BS_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_module_installed('vote', true);

        $this->load->language('vote/vote');
        $this->load->model(['vote/vote_model', 'user_model']);

        // Settings are loaded via hook after constructor, so check directly from model
        if ($this->setting_model->get_value('vote_enabled') !== true) {
            show_error(lang('vote_disabled'), 403, lang('error'));
        }
    }

    /**
     * Vote index page - list all vote sites
     *
     * @return void
     */
    public function index()
    {
        $user_id = $this->session->userdata('id');
        
        $data = [
            'sites'       => $this->vote_model->get_sites(),
            'top_voters'  => $this->vote_model->get_top_voters(5),
            'vote_status' => $user_id ? $this->vote_model->get_user_vote_status($user_id) : []
        ];

        $this->template->title(lang('vote'), config_item('app_name'));
        $this->template->build('index', $data);
    }

    /**
     * Redirect to vote site
     *
     * @param int $site_id
     * @return void
     */
    public function site($site_id)
    {
        require_login();

        $site = $this->vote_model->get_site($site_id);

        if (empty($site) || !$site->is_active) {
            show_404();
        }

        $user_id = $this->session->userdata('id');

        // Check cooldown
        if (!$this->vote_model->can_vote($user_id, $site_id)) {
            $remaining = $this->vote_model->get_cooldown_remaining($user_id, $site_id);
            $hours = floor($remaining / 3600);
            $minutes = floor(($remaining % 3600) / 60);
            
            $this->session->set_flashdata('warning', sprintf(lang('vote_cooldown_active'), $hours, $minutes));
            redirect('vote');
            return;
        }

        // Store vote info in session for callback
        $this->session->set_userdata('vote_site_id', $site_id);
        $this->session->set_userdata('vote_timestamp', time());

        // Build vote URL
        $user = $this->user_model->find(['id' => $user_id]);
        $username = $user->username ?? '';
        $vote_url = str_replace('{username}', urlencode($username), $site->url);
        $vote_url = str_replace('{user_id}', $user_id, $vote_url);

        // Redirect to vote site
        redirect($vote_url);
    }

    /**
     * Vote callback - called after user votes
     *
     * @param int $site_id
     * @return void
     */
    public function callback($site_id)
    {
        require_login();

        $site = $this->vote_model->get_site($site_id);

        if (empty($site) || !$site->is_active) {
            show_404();
        }

        $user_id = $this->session->userdata('id');

        // Verify this is a valid callback
        $stored_site_id = $this->session->userdata('vote_site_id');
        $vote_timestamp = $this->session->userdata('vote_timestamp');

        // Clear session data
        $this->session->unset_userdata(['vote_site_id', 'vote_timestamp']);

        // Basic validation - make sure they came from our redirect
        if ($stored_site_id != $site_id || empty($vote_timestamp)) {
            $this->session->set_flashdata('error', lang('vote_invalid_callback'));
            redirect('vote');
            return;
        }

        // Check if vote was within reasonable time (5 minutes to 1 hour)
        $elapsed = time() - $vote_timestamp;
        if ($elapsed < 5 || $elapsed > 3600) {
            $this->session->set_flashdata('error', lang('vote_invalid_callback'));
            redirect('vote');
            return;
        }

        // Check cooldown again
        if (!$this->vote_model->can_vote($user_id, $site_id)) {
            $this->session->set_flashdata('warning', lang('vote_already_voted'));
            redirect('vote');
            return;
        }

        // Award vote points
        $vp_reward = $site->vp_reward;
        
        // Log the vote
        $this->vote_model->log_vote($user_id, $site_id, $vp_reward);

        // Update user's VP
        $user = $this->user_model->find(['id' => $user_id]);
        if ($user) {
            $new_vp = $user->vp + $vp_reward;
            $this->user_model->update(['vp' => $new_vp], ['id' => $user_id]);
        }

        $this->session->set_flashdata('success', sprintf(lang('vote_success'), $vp_reward));
        redirect('vote');
    }

    /**
     * Vote history page
     *
     * @return void
     */
    public function history()
    {
        require_login();

        $per_page = 20;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $per_page;

        $user_id = $this->session->userdata('id');

        $data = [
            'logs'         => $this->vote_model->get_user_logs($user_id, $per_page, $offset),
            'total'        => $this->vote_model->count_user_logs($user_id),
            'per_page'     => $per_page,
            'current_page' => $page
        ];

        $this->template->title(lang('vote_history'), config_item('app_name'));
        $this->template->build('history', $data);
    }

    /**
     * Top voters page
     *
     * @return void
     */
    public function top_voters()
    {
        $data = [
            'voters' => $this->vote_model->get_top_voters(50)
        ];

        $this->template->title(lang('vote_top_voters'), config_item('app_name'));
        $this->template->build('top_voters', $data);
    }
}
