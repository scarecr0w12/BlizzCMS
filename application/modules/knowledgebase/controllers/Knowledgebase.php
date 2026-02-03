<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Knowledgebase extends BS_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_module_installed('knowledgebase', true);

        $this->load->language('knowledgebase/knowledgebase');
        $this->load->helper('knowledgebase/knowledgebase');
        $this->load->model('knowledgebase/knowledgebase_model');
    }

    public function index()
    {
        $per_page = 12;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $per_page;

        $filters = [
            'search' => $this->input->get('search')
        ];

        $data = [
            'categories'      => $this->knowledgebase_model->get_categories(),
            'featured_articles' => $this->knowledgebase_model->get_featured_articles(6),
            'articles'        => $this->knowledgebase_model->get_articles($per_page, $offset, $filters),
            'total_articles'  => $this->knowledgebase_model->count_articles($filters),
            'per_page'        => $per_page,
            'current_page'    => $page,
            'search_query'    => $filters['search']
        ];

        $this->template->set('title', lang('knowledgebase') . ' - ' . config_item('app_name'));
        $this->template->build('knowledgebase/public/index', $data);
    }

    public function category($category_id)
    {
        $category = $this->knowledgebase_model->get_category($category_id);

        if (empty($category) || !$category->is_active) {
            show_404();
        }

        $per_page = 12;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $per_page;

        $filters = [
            'category_id' => $category_id,
            'search' => $this->input->get('search')
        ];

        $data = [
            'category'        => $category,
            'categories'      => $this->knowledgebase_model->get_categories(),
            'articles'        => $this->knowledgebase_model->get_articles($per_page, $offset, $filters),
            'total_articles'  => $this->knowledgebase_model->count_articles($filters),
            'per_page'        => $per_page,
            'current_page'    => $page,
            'search_query'    => $filters['search']
        ];

        $this->template->set('title', $category->name . ' - ' . lang('knowledgebase') . ' - ' . config_item('app_name'));
        $this->template->build('knowledgebase/public/category', $data);
    }

    public function article($article_id)
    {
        $article = $this->knowledgebase_model->get_article($article_id);

        if (empty($article) || !$article->is_published) {
            show_404();
        }

        $this->knowledgebase_model->increment_views($article_id);

        $category = $this->knowledgebase_model->get_category($article->category_id);
        $tags = $this->knowledgebase_model->get_article_tags($article_id);
        $comments = $this->knowledgebase_model->get_article_comments($article_id);

        $data = [
            'article'     => $article,
            'category'    => $category,
            'categories'  => $this->knowledgebase_model->get_categories(),
            'tags'        => $tags,
            'comments'    => $comments,
            'all_tags'    => $this->knowledgebase_model->get_tags()
        ];

        $this->template->set('title', $article->title . ' - ' . lang('knowledgebase') . ' - ' . config_item('app_name'));
        $this->template->build('knowledgebase/public/article', $data);
    }

    public function search()
    {
        $search_query = $this->input->get('q');

        if (empty($search_query)) {
            redirect(site_url('kb'));
        }

        $per_page = 12;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $per_page;

        $filters = [
            'search' => $search_query
        ];

        $data = [
            'categories'      => $this->knowledgebase_model->get_categories(),
            'articles'        => $this->knowledgebase_model->get_articles($per_page, $offset, $filters),
            'total_articles'  => $this->knowledgebase_model->count_articles($filters),
            'per_page'        => $per_page,
            'current_page'    => $page,
            'search_query'    => $search_query
        ];

        $this->template->set('title', lang('knowledgebase_search') . ': ' . $search_query . ' - ' . config_item('app_name'));
        $this->template->build('knowledgebase/public/search', $data);
    }
}
