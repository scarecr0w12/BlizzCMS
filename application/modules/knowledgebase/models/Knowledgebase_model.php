<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Knowledgebase_model extends CI_Model
{
    private $categories_table = 'kb_categories';
    private $articles_table = 'kb_articles';
    private $tags_table = 'kb_tags';
    private $article_tags_table = 'kb_article_tags';
    private $comments_table = 'kb_comments';

    public function __construct()
    {
        parent::__construct();
    }

    // ==================== CATEGORIES ====================

    public function get_categories($active_only = true)
    {
        $this->db->from($this->categories_table);
        
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        
        $this->db->order_by('order', 'ASC');
        $this->db->order_by('name', 'ASC');
        
        return $this->db->get()->result();
    }

    public function get_category($id)
    {
        return $this->db->where('id', $id)
            ->get($this->categories_table)
            ->row();
    }

    public function get_category_by_slug($slug)
    {
        return $this->db->where('slug', $slug)
            ->where('is_active', 1)
            ->get($this->categories_table)
            ->row();
    }

    public function create_category($data)
    {
        if (!isset($data['slug'])) {
            $data['slug'] = url_title($data['name'], '-', true);
        }

        if ($this->db->insert($this->categories_table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function update_category($id, $data)
    {
        if (isset($data['name']) && !isset($data['slug'])) {
            $data['slug'] = url_title($data['name'], '-', true);
        }

        return $this->db->where('id', $id)
            ->update($this->categories_table, $data);
    }

    public function delete_category($id)
    {
        return $this->db->where('id', $id)
            ->delete($this->categories_table);
    }

    // ==================== ARTICLES ====================

    public function get_articles($limit = null, $offset = 0, $filters = [])
    {
        $this->db->from($this->articles_table);

        if (isset($filters['category_id']) && $filters['category_id']) {
            $this->db->where('category_id', $filters['category_id']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $search = '%' . $filters['search'] . '%';
            $this->db->group_start()
                ->like('title', $search)
                ->or_like('content', $search)
                ->or_like('excerpt', $search)
                ->group_end();
        }

        if (isset($filters['tag_id']) && $filters['tag_id']) {
            $this->db->join($this->article_tags_table, $this->article_tags_table . '.article_id = ' . $this->articles_table . '.id')
                ->where($this->article_tags_table . '.tag_id', $filters['tag_id']);
        }

        if (!isset($filters['include_unpublished']) || !$filters['include_unpublished']) {
            $this->db->where('is_published', 1);
        }

        $this->db->order_by($this->articles_table . '.order', 'ASC');
        $this->db->order_by($this->articles_table . '.published_at', 'DESC');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }

    public function get_article($id)
    {
        return $this->db->where('id', $id)
            ->get($this->articles_table)
            ->row();
    }

    public function get_article_by_slug($slug)
    {
        return $this->db->where('slug', $slug)
            ->where('is_published', 1)
            ->get($this->articles_table)
            ->row();
    }

    public function get_featured_articles($limit = 5)
    {
        return $this->db->where('is_published', 1)
            ->where('is_featured', 1)
            ->order_by('published_at', 'DESC')
            ->limit($limit)
            ->get($this->articles_table)
            ->result();
    }

    public function count_articles($filters = [])
    {
        $this->db->from($this->articles_table);

        if (isset($filters['category_id']) && $filters['category_id']) {
            $this->db->where('category_id', $filters['category_id']);
        }

        if (isset($filters['search']) && $filters['search']) {
            $search = '%' . $filters['search'] . '%';
            $this->db->group_start()
                ->like('title', $search)
                ->or_like('content', $search)
                ->or_like('excerpt', $search)
                ->group_end();
        }

        if (isset($filters['tag_id']) && $filters['tag_id']) {
            $this->db->join($this->article_tags_table, $this->article_tags_table . '.article_id = ' . $this->articles_table . '.id')
                ->where($this->article_tags_table . '.tag_id', $filters['tag_id']);
        }

        if (!isset($filters['include_unpublished']) || !$filters['include_unpublished']) {
            $this->db->where('is_published', 1);
        }

        return $this->db->count_all_results();
    }

    public function create_article($data)
    {
        if (!isset($data['slug'])) {
            $data['slug'] = url_title($data['title'], '-', true);
        }

        if ($this->db->insert($this->articles_table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function update_article($id, $data)
    {
        if (isset($data['title']) && !isset($data['slug'])) {
            $data['slug'] = url_title($data['title'], '-', true);
        }

        return $this->db->where('id', $id)
            ->update($this->articles_table, $data);
    }

    public function delete_article($id)
    {
        return $this->db->where('id', $id)
            ->delete($this->articles_table);
    }

    public function increment_views($article_id)
    {
        $this->db->set('views', 'views+1', false);
        return $this->db->where('id', $article_id)
            ->update($this->articles_table);
    }

    public function publish_article($id)
    {
        return $this->db->where('id', $id)
            ->update($this->articles_table, [
                'is_published' => 1,
                'published_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function unpublish_article($id)
    {
        return $this->db->where('id', $id)
            ->update($this->articles_table, [
                'is_published' => 0
            ]);
    }

    // ==================== TAGS ====================

    public function get_tags()
    {
        return $this->db->order_by('name', 'ASC')
            ->get($this->tags_table)
            ->result();
    }

    public function get_tag($id)
    {
        return $this->db->where('id', $id)
            ->get($this->tags_table)
            ->row();
    }

    public function get_tag_by_slug($slug)
    {
        return $this->db->where('slug', $slug)
            ->get($this->tags_table)
            ->row();
    }

    public function create_tag($data)
    {
        if (!isset($data['slug'])) {
            $data['slug'] = url_title($data['name'], '-', true);
        }

        if ($this->db->insert($this->tags_table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function update_tag($id, $data)
    {
        if (isset($data['name']) && !isset($data['slug'])) {
            $data['slug'] = url_title($data['name'], '-', true);
        }

        return $this->db->where('id', $id)
            ->update($this->tags_table, $data);
    }

    public function delete_tag($id)
    {
        return $this->db->where('id', $id)
            ->delete($this->tags_table);
    }

    // ==================== ARTICLE TAGS ====================

    public function get_article_tags($article_id)
    {
        return $this->db->select($this->tags_table . '.*')
            ->from($this->article_tags_table)
            ->join($this->tags_table, $this->tags_table . '.id = ' . $this->article_tags_table . '.tag_id')
            ->where($this->article_tags_table . '.article_id', $article_id)
            ->get()
            ->result();
    }

    public function set_article_tags($article_id, $tag_ids = [])
    {
        $this->db->where('article_id', $article_id)
            ->delete($this->article_tags_table);

        if (empty($tag_ids)) {
            return true;
        }

        $data = [];
        foreach ($tag_ids as $tag_id) {
            $data[] = [
                'article_id' => $article_id,
                'tag_id' => $tag_id
            ];
        }

        return $this->db->insert_batch($this->article_tags_table, $data);
    }

    // ==================== COMMENTS ====================

    public function get_article_comments($article_id, $approved_only = true)
    {
        $this->db->from($this->comments_table)
            ->where('article_id', $article_id);

        if ($approved_only) {
            $this->db->where('is_approved', 1);
        }

        $this->db->order_by('created_at', 'DESC');

        return $this->db->get()->result();
    }

    public function get_comment($id)
    {
        return $this->db->where('id', $id)
            ->get($this->comments_table)
            ->row();
    }

    public function create_comment($data)
    {
        if ($this->db->insert($this->comments_table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function update_comment($id, $data)
    {
        return $this->db->where('id', $id)
            ->update($this->comments_table, $data);
    }

    public function delete_comment($id)
    {
        return $this->db->where('id', $id)
            ->delete($this->comments_table);
    }

    public function approve_comment($id)
    {
        return $this->db->where('id', $id)
            ->update($this->comments_table, ['is_approved' => 1]);
    }

    public function get_pending_comments()
    {
        return $this->db->where('is_approved', 0)
            ->order_by('created_at', 'DESC')
            ->get($this->comments_table)
            ->result();
    }

    public function count_pending_comments()
    {
        return $this->db->where('is_approved', 0)
            ->count_all_results($this->comments_table);
    }
}
