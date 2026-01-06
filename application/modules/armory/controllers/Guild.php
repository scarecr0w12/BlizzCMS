<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Guild extends BS_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->language('armory');
        $this->load->model('armory_guild_model');
        $this->load->helper('wow');
    }

    /**
     * Guild profile page
     *
     * @param int $realm
     * @param string $name
     * @return void
     */
    public function profile($realm, $name)
    {
        $name = urldecode($name);

        if (! $this->realm_model->exists($realm)) {
            show_404();
        }

        $guild = $this->armory_guild_model->get_guild_by_name($realm, $name);

        if (empty($guild)) {
            show_404();
        }

        $members     = $this->armory_guild_model->get_members($realm, $guild->guildid, 10);
        $member_count = $this->armory_guild_model->count_members($realm, $guild->guildid);
        $realm_info  = $this->realm_model->find(['id' => $realm]);

        $data = [
            'guild'        => $guild,
            'members'      => $members,
            'member_count' => $member_count,
            'realm'        => $realm_info,
            'realm_id'     => $realm
        ];

        $this->template->title($guild->name, lang('guild'), lang('armory'), config_item('app_name'));

        $this->template->build('guild/profile', $data);
    }

    /**
     * Guild members page
     *
     * @param int $realm
     * @param string $name
     * @return void
     */
    public function members($realm, $name)
    {
        $name = urldecode($name);

        if (! $this->realm_model->exists($realm)) {
            show_404();
        }

        $guild = $this->armory_guild_model->get_guild_by_name($realm, $name);

        if (empty($guild)) {
            show_404();
        }

        $page   = $this->input->get('page', true) ?: 1;
        $limit  = 50;
        $offset = ($page - 1) * $limit;

        $members      = $this->armory_guild_model->get_members($realm, $guild->guildid, $limit, $offset);
        $member_count = $this->armory_guild_model->count_members($realm, $guild->guildid);
        $realm_info   = $this->realm_model->find(['id' => $realm]);

        $data = [
            'guild'        => $guild,
            'members'      => $members,
            'member_count' => $member_count,
            'realm'        => $realm_info,
            'realm_id'     => $realm,
            'page'         => $page,
            'total_pages'  => ceil($member_count / $limit)
        ];

        $this->template->title($guild->name, lang('members'), lang('armory'), config_item('app_name'));

        $this->template->build('guild/members', $data);
    }
}
