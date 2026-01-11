<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database_viewer_model extends CI_Model
{
    private $world_db = 'world';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('realm_model');
    }

    public function get_setting($key, $default = null)
    {
        $setting = $this->db->where('setting_key', $key)->get('database_viewer_settings')->row();
        return $setting ? $setting->setting_value : $default;
    }

    public function update_setting($key, $value)
    {
        $existing = $this->db->where('setting_key', $key)->get('database_viewer_settings')->row();
        
        if ($existing) {
            return $this->db->where('setting_key', $key)->update('database_viewer_settings', ['setting_value' => $value]);
        } else {
            return $this->db->insert('database_viewer_settings', ['setting_key' => $key, 'setting_value' => $value]);
        }
    }

    public function search_items($query, $limit = 50, $offset = 0)
    {
        return $this->db
            ->select('entry, name, quality, itemlevel, class, subclass, inventorytype')
            ->from('item_template')
            ->where("name LIKE '%{$this->db->escape_like_str($query)}%'", NULL, FALSE)
            ->limit($limit, $offset)
            ->order_by('itemlevel DESC, quality DESC')
            ->get()
            ->result();
    }

    public function count_items($query = null)
    {
        if ($query) {
            $this->db->where("name LIKE '%{$this->db->escape_like_str($query)}%'", NULL, FALSE);
        }
        return $this->db->count_all_results('item_template');
    }

    public function get_item($entry)
    {
        return $this->db
            ->select('*')
            ->from('item_template')
            ->where('entry', $entry)
            ->get()
            ->row();
    }

    public function get_items($limit = 50, $offset = 0, $class = null, $subclass = null)
    {
        $query = $this->db->select('entry, name, quality, itemlevel, class, subclass, inventorytype')
            ->from('item_template');

        if ($class !== null) {
            $query->where('class', $class);
        }
        if ($subclass !== null) {
            $query->where('subclass', $subclass);
        }

        return $query
            ->limit($limit, $offset)
            ->order_by('itemlevel DESC, quality DESC')
            ->get()
            ->result();
    }

    public function search_spells($query, $limit = 50, $offset = 0)
    {
        return $this->db
            ->select('id, name, school, effect0, casttime, cooldown, range')
            ->from('spell')
            ->where("name LIKE '%{$this->db->escape_like_str($query)}%'", NULL, FALSE)
            ->limit($limit, $offset)
            ->order_by('id DESC')
            ->get()
            ->result();
    }

    public function count_spells($query = null)
    {
        if ($query) {
            $this->db->where("name LIKE '%{$this->db->escape_like_str($query)}%'", NULL, FALSE);
        }
        return $this->db->count_all_results('spell');
    }

    public function get_spell($id)
    {
        return $this->db
            ->select('*')
            ->from('spell')
            ->where('id', $id)
            ->get()
            ->row();
    }

    public function get_spells($limit = 50, $offset = 0, $school = null)
    {
        $query = $this->db->select('id, name, school, effect0, casttime, cooldown, range')
            ->from('spell');

        if ($school !== null) {
            $query->where('school', $school);
        }

        return $query
            ->limit($limit, $offset)
            ->order_by('id DESC')
            ->get()
            ->result();
    }

    public function search_quests($query, $limit = 50, $offset = 0)
    {
        return $this->db
            ->select('id, title, minlevel, qtype, questlevel')
            ->from('quest_template')
            ->where("title LIKE '%{$this->db->escape_like_str($query)}%'", NULL, FALSE)
            ->limit($limit, $offset)
            ->order_by('questlevel DESC')
            ->get()
            ->result();
    }

    public function count_quests($query = null)
    {
        if ($query) {
            $this->db->where("title LIKE '%{$this->db->escape_like_str($query)}%'", NULL, FALSE);
        }
        return $this->db->count_all_results('quest_template');
    }

    public function get_quest($id)
    {
        return $this->db
            ->select('*')
            ->from('quest_template')
            ->where('id', $id)
            ->get()
            ->row();
    }

    public function get_quests($limit = 50, $offset = 0, $minlevel = null, $maxlevel = null)
    {
        $query = $this->db->select('id, title, minlevel, qtype, questlevel')
            ->from('quest_template');

        if ($minlevel !== null) {
            $query->where('questlevel >=', $minlevel);
        }
        if ($maxlevel !== null) {
            $query->where('questlevel <=', $maxlevel);
        }

        return $query
            ->limit($limit, $offset)
            ->order_by('questlevel DESC')
            ->get()
            ->result();
    }

    public function search_creatures($query, $limit = 50, $offset = 0)
    {
        return $this->db
            ->select('entry, name, minlevel, maxlevel, type, rank')
            ->from('creature_template')
            ->where("name LIKE '%{$this->db->escape_like_str($query)}%'", NULL, FALSE)
            ->limit($limit, $offset)
            ->order_by('maxlevel DESC')
            ->get()
            ->result();
    }

    public function count_creatures($query = null)
    {
        if ($query) {
            $this->db->where("name LIKE '%{$this->db->escape_like_str($query)}%'", NULL, FALSE);
        }
        return $this->db->count_all_results('creature_template');
    }

    public function get_creature($entry)
    {
        return $this->db
            ->select('*')
            ->from('creature_template')
            ->where('entry', $entry)
            ->get()
            ->row();
    }

    public function get_creatures($limit = 50, $offset = 0, $type = null)
    {
        $query = $this->db->select('entry, name, minlevel, maxlevel, type, rank')
            ->from('creature_template');

        if ($type !== null) {
            $query->where('type', $type);
        }

        return $query
            ->limit($limit, $offset)
            ->order_by('maxlevel DESC')
            ->get()
            ->result();
    }

    public function get_creature_loot($entry)
    {
        return $this->db
            ->select('item, ChanceOrQuestChance, lootmode, groupid, mincountOrRef, maxcount')
            ->from('creature_loot_template')
            ->where('entry', $entry)
            ->order_by('groupid, ChanceOrQuestChance DESC')
            ->get()
            ->result();
    }

    public function search_zones($query, $limit = 50, $offset = 0)
    {
        return $this->db
            ->select('id, name, area_level, area_type')
            ->from('worldmap_area')
            ->where("name LIKE '%{$this->db->escape_like_str($query)}%'", NULL, FALSE)
            ->limit($limit, $offset)
            ->order_by('area_level DESC')
            ->get()
            ->result();
    }

    public function count_zones($query = null)
    {
        if ($query) {
            $this->db->where("name LIKE '%{$this->db->escape_like_str($query)}%'", NULL, FALSE);
        }
        return $this->db->count_all_results('worldmap_area');
    }

    public function get_zone($id)
    {
        return $this->db
            ->select('*')
            ->from('worldmap_area')
            ->where('id', $id)
            ->get()
            ->row();
    }

    public function get_zones($limit = 50, $offset = 0)
    {
        return $this->db
            ->select('id, name, area_level, area_type')
            ->from('worldmap_area')
            ->limit($limit, $offset)
            ->order_by('area_level DESC')
            ->get()
            ->result();
    }

    public function search_npcs($query, $limit = 50, $offset = 0)
    {
        return $this->db
            ->select('entry, name, minlevel, maxlevel, type, rank')
            ->from('creature_template')
            ->where("name LIKE '%{$this->db->escape_like_str($query)}%'", NULL, FALSE)
            ->where('type', 7)
            ->limit($limit, $offset)
            ->order_by('maxlevel DESC')
            ->get()
            ->result();
    }

    public function get_npc($entry)
    {
        return $this->db
            ->select('*')
            ->from('creature_template')
            ->where('entry', $entry)
            ->where('type', 7)
            ->get()
            ->row();
    }

    public function get_npc_vendor($entry)
    {
        return $this->db
            ->select('item, maxcount, incrtime, slot')
            ->from('npc_vendor')
            ->where('entry', $entry)
            ->order_by('slot')
            ->get()
            ->result();
    }

    public function search_objects($query, $limit = 50, $offset = 0)
    {
        return $this->db
            ->select('entry, name, type, displayId')
            ->from('gameobject_template')
            ->where("name LIKE '%{$this->db->escape_like_str($query)}%'", NULL, FALSE)
            ->limit($limit, $offset)
            ->order_by('entry DESC')
            ->get()
            ->result();
    }

    public function count_objects($query = null)
    {
        if ($query) {
            $this->db->where("name LIKE '%{$this->db->escape_like_str($query)}%'", NULL, FALSE);
        }
        return $this->db->count_all_results('gameobject_template');
    }

    public function get_object($entry)
    {
        return $this->db
            ->select('*')
            ->from('gameobject_template')
            ->where('entry', $entry)
            ->get()
            ->row();
    }

    public function get_objects($limit = 50, $offset = 0, $type = null)
    {
        $query = $this->db->select('entry, name, type, displayId')
            ->from('gameobject_template');

        if ($type !== null) {
            $query->where('type', $type);
        }

        return $query
            ->limit($limit, $offset)
            ->order_by('entry DESC')
            ->get()
            ->result();
    }

    public function get_item_classes()
    {
        return $this->db
            ->select('DISTINCT class')
            ->from('item_template')
            ->where('class >', 0)
            ->order_by('class')
            ->get()
            ->result();
    }

    public function get_creature_types()
    {
        return $this->db
            ->select('DISTINCT type')
            ->from('creature_template')
            ->where('type >', 0)
            ->order_by('type')
            ->get()
            ->result();
    }

    public function get_spell_schools()
    {
        return [
            0 => 'Physical',
            1 => 'Holy',
            2 => 'Fire',
            3 => 'Nature',
            4 => 'Frost',
            5 => 'Shadow',
            6 => 'Arcane',
        ];
    }

    public function global_search($query, $limit = 20)
    {
        $results = [
            'items' => [],
            'spells' => [],
            'quests' => [],
            'creatures' => [],
        ];

        $results['items'] = $this->search_items($query, $limit);
        $results['spells'] = $this->search_spells($query, $limit);
        $results['quests'] = $this->search_quests($query, $limit);
        $results['creatures'] = $this->search_creatures($query, $limit);

        return $results;
    }
}
