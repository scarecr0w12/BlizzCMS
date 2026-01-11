<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('database_viewer_model');
        $this->load->language('database_viewer');
    }

    public function index()
    {
        $data = [
            'categories' => [
                'items' => lang('database_items'),
                'spells' => lang('database_spells'),
                'quests' => lang('database_quests'),
                'creatures' => lang('database_creatures'),
                'zones' => lang('database_zones'),
                'npcs' => lang('database_npcs'),
                'objects' => lang('database_objects'),
            ]
        ];

        $this->template->title(lang('database_title'));
        $this->template->build('index', $data);
    }

    public function search()
    {
        $query = $this->input->get('q');
        $type = $this->input->get('type') ?: 'all';

        if (!$query || strlen($query) < 2) {
            $data = ['error' => 'Search query too short'];
            $this->template->build('search', $data);
            return;
        }

        $per_page = $this->database_viewer_model->get_setting('database_viewer_items_per_page', 50);
        $page = $this->input->get('page') ?: 1;
        $offset = ($page - 1) * $per_page;

        $data = [
            'query' => $query,
            'type' => $type,
            'page' => $page,
            'per_page' => $per_page,
        ];

        if ($type === 'all' || $type === 'items') {
            $data['items'] = $this->database_viewer_model->search_items($query, $per_page, $offset);
            $data['items_total'] = $this->database_viewer_model->count_items($query);
        }

        if ($type === 'all' || $type === 'spells') {
            $data['spells'] = $this->database_viewer_model->search_spells($query, $per_page, $offset);
            $data['spells_total'] = $this->database_viewer_model->count_spells($query);
        }

        if ($type === 'all' || $type === 'quests') {
            $data['quests'] = $this->database_viewer_model->search_quests($query, $per_page, $offset);
            $data['quests_total'] = $this->database_viewer_model->count_quests($query);
        }

        if ($type === 'all' || $type === 'creatures') {
            $data['creatures'] = $this->database_viewer_model->search_creatures($query, $per_page, $offset);
            $data['creatures_total'] = $this->database_viewer_model->count_creatures($query);
        }

        $this->template->title(lang('database_search') . ' - ' . $query);
        $this->template->build('search', $data);
    }

    public function items()
    {
        $per_page = $this->database_viewer_model->get_setting('database_viewer_items_per_page', 50);
        $page = $this->input->get('page') ?: 1;
        $offset = ($page - 1) * $per_page;
        $class = $this->input->get('class');

        $data = [
            'items' => $this->database_viewer_model->get_items($per_page, $offset, $class),
            'total' => $this->database_viewer_model->count_items(),
            'page' => $page,
            'per_page' => $per_page,
            'class' => $class,
            'classes' => $this->database_viewer_model->get_item_classes(),
        ];

        $this->template->title(lang('database_items'));
        $this->template->build('items', $data);
    }

    public function item($entry)
    {
        $item = $this->database_viewer_model->get_item($entry);

        if (!$item) {
            show_404();
            return;
        }

        $data = [
            'item' => $item,
        ];

        $this->template->title($item->name);
        $this->template->build('item_detail', $data);
    }

    public function spells()
    {
        $per_page = $this->database_viewer_model->get_setting('database_viewer_items_per_page', 50);
        $page = $this->input->get('page') ?: 1;
        $offset = ($page - 1) * $per_page;
        $school = $this->input->get('school');

        $data = [
            'spells' => $this->database_viewer_model->get_spells($per_page, $offset, $school),
            'total' => $this->database_viewer_model->count_spells(),
            'page' => $page,
            'per_page' => $per_page,
            'school' => $school,
            'schools' => $this->database_viewer_model->get_spell_schools(),
        ];

        $this->template->title(lang('database_spells'));
        $this->template->build('spells', $data);
    }

    public function spell($id)
    {
        $spell = $this->database_viewer_model->get_spell($id);

        if (!$spell) {
            show_404();
            return;
        }

        $data = [
            'spell' => $spell,
            'schools' => $this->database_viewer_model->get_spell_schools(),
        ];

        $this->template->title($spell->name);
        $this->template->build('spell_detail', $data);
    }

    public function quests()
    {
        $per_page = $this->database_viewer_model->get_setting('database_viewer_items_per_page', 50);
        $page = $this->input->get('page') ?: 1;
        $offset = ($page - 1) * $per_page;
        $minlevel = $this->input->get('minlevel');
        $maxlevel = $this->input->get('maxlevel');

        $data = [
            'quests' => $this->database_viewer_model->get_quests($per_page, $offset, $minlevel, $maxlevel),
            'total' => $this->database_viewer_model->count_quests(),
            'page' => $page,
            'per_page' => $per_page,
            'minlevel' => $minlevel,
            'maxlevel' => $maxlevel,
        ];

        $this->template->title(lang('database_quests'));
        $this->template->build('quests', $data);
    }

    public function quest($id)
    {
        $quest = $this->database_viewer_model->get_quest($id);

        if (!$quest) {
            show_404();
            return;
        }

        $data = [
            'quest' => $quest,
        ];

        $this->template->title($quest->title);
        $this->template->build('quest_detail', $data);
    }

    public function creatures()
    {
        $per_page = $this->database_viewer_model->get_setting('database_viewer_items_per_page', 50);
        $page = $this->input->get('page') ?: 1;
        $offset = ($page - 1) * $per_page;
        $type = $this->input->get('type');

        $data = [
            'creatures' => $this->database_viewer_model->get_creatures($per_page, $offset, $type),
            'total' => $this->database_viewer_model->count_creatures(),
            'page' => $page,
            'per_page' => $per_page,
            'type' => $type,
            'types' => $this->database_viewer_model->get_creature_types(),
        ];

        $this->template->title(lang('database_creatures'));
        $this->template->build('creatures', $data);
    }

    public function creature($entry)
    {
        $creature = $this->database_viewer_model->get_creature($entry);

        if (!$creature) {
            show_404();
            return;
        }

        $loot = $this->database_viewer_model->get_creature_loot($entry);

        $data = [
            'creature' => $creature,
            'loot' => $loot,
        ];

        $this->template->title($creature->name);
        $this->template->build('creature_detail', $data);
    }

    public function zones()
    {
        $per_page = $this->database_viewer_model->get_setting('database_viewer_items_per_page', 50);
        $page = $this->input->get('page') ?: 1;
        $offset = ($page - 1) * $per_page;

        $data = [
            'zones' => $this->database_viewer_model->get_zones($per_page, $offset),
            'total' => $this->database_viewer_model->count_zones(),
            'page' => $page,
            'per_page' => $per_page,
        ];

        $this->template->title(lang('database_zones'));
        $this->template->build('zones', $data);
    }

    public function zone($id)
    {
        $zone = $this->database_viewer_model->get_zone($id);

        if (!$zone) {
            show_404();
            return;
        }

        $data = [
            'zone' => $zone,
        ];

        $this->template->title($zone->name);
        $this->template->build('zone_detail', $data);
    }

    public function npcs()
    {
        $per_page = $this->database_viewer_model->get_setting('database_viewer_items_per_page', 50);
        $page = $this->input->get('page') ?: 1;
        $offset = ($page - 1) * $per_page;

        $data = [
            'npcs' => $this->database_viewer_model->get_creatures($per_page, $offset),
            'total' => $this->database_viewer_model->count_creatures(),
            'page' => $page,
            'per_page' => $per_page,
        ];

        $this->template->title(lang('database_npcs'));
        $this->template->build('npcs', $data);
    }

    public function npc($entry)
    {
        $npc = $this->database_viewer_model->get_npc($entry);

        if (!$npc) {
            show_404();
            return;
        }

        $vendor_items = $this->database_viewer_model->get_npc_vendor($entry);

        $data = [
            'npc' => $npc,
            'vendor_items' => $vendor_items,
        ];

        $this->template->title($npc->name);
        $this->template->build('npc_detail', $data);
    }

    public function objects()
    {
        $per_page = $this->database_viewer_model->get_setting('database_viewer_items_per_page', 50);
        $page = $this->input->get('page') ?: 1;
        $offset = ($page - 1) * $per_page;
        $type = $this->input->get('type');

        $data = [
            'objects' => $this->database_viewer_model->get_objects($per_page, $offset, $type),
            'total' => $this->database_viewer_model->count_objects(),
            'page' => $page,
            'per_page' => $per_page,
            'type' => $type,
        ];

        $this->template->title(lang('database_objects'));
        $this->template->build('objects', $data);
    }

    public function object($entry)
    {
        $object = $this->database_viewer_model->get_object($entry);

        if (!$object) {
            show_404();
            return;
        }

        $data = [
            'object' => $object,
        ];

        $this->template->title($object->name);
        $this->template->build('object_detail', $data);
    }
}
