<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        is_module_installed('knowledgebase', true);
        require_permission('knowledgebase.admin');

        $this->load->language('knowledgebase/knowledgebase');
        $this->load->helper('knowledgebase/knowledgebase');
        $this->load->model('knowledgebase/knowledgebase_model');
    }

    public function index()
    {
        $data = [
            'total_categories' => $this->db->count_all('kb_categories'),
            'total_articles'   => $this->db->count_all('kb_articles'),
            'total_tags'       => $this->db->count_all('kb_tags'),
            'pending_comments' => $this->knowledgebase_model->count_pending_comments(),
            'featured_articles' => $this->knowledgebase_model->get_featured_articles(5)
        ];

        $this->template->set('title', lang('knowledgebase_admin') . ' - ' . config_item('app_name'));
        $this->template->build('knowledgebase/admin/index', $data);
    }

    // ==================== CATEGORIES ====================

    public function categories()
    {
        $data = [
            'categories' => $this->knowledgebase_model->get_categories(false)
        ];

        $this->template->set('title', lang('knowledgebase_categories') . ' - ' . lang('knowledgebase_admin') . ' - ' . config_item('app_name'));
        $this->template->build('knowledgebase/admin/categories', $data);
    }

    public function add_category()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name', lang('knowledgebase_category_name'), 'required|min_length[3]|max_length[255]');
            $this->form_validation->set_rules('description', lang('knowledgebase_description'), 'max_length[1000]');
            $this->form_validation->set_rules('icon', lang('knowledgebase_icon'), 'max_length[255]');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                $data = [
                    'name'        => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'icon'        => $this->input->post('icon'),
                    'is_active'   => $this->input->post('is_active') ? 1 : 0
                ];

                if ($this->knowledgebase_model->create_category($data)) {
                    $this->session->set_flashdata('success', lang('knowledgebase_category_created'));
                    $this->log_model->create('knowledgebase', 'category_create', 'Created category: ' . $data['name']);
                    redirect(site_url('kb/admin/categories'));
                } else {
                    $this->session->set_flashdata('error', lang('knowledgebase_error'));
                }
            }
        }

        $this->template->enable_parser_body(false);
        $this->template->set('title', lang('knowledgebase_add_category') . ' - ' . lang('knowledgebase_admin') . ' - ' . config_item('app_name'));
        $this->template->build('knowledgebase/admin/add_category');
    }

    public function edit_category($category_id)
    {
        $category = $this->knowledgebase_model->get_category($category_id);

        if (empty($category)) {
            show_404();
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name', lang('knowledgebase_category_name'), 'required|min_length[3]|max_length[255]');
            $this->form_validation->set_rules('description', lang('knowledgebase_description'), 'max_length[1000]');
            $this->form_validation->set_rules('icon', lang('knowledgebase_icon'), 'max_length[255]');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                $data = [
                    'name'        => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'icon'        => $this->input->post('icon'),
                    'is_active'   => $this->input->post('is_active') ? 1 : 0
                ];

                if ($this->knowledgebase_model->update_category($category_id, $data)) {
                    $this->session->set_flashdata('success', lang('knowledgebase_category_updated'));
                    $this->log_model->create('knowledgebase', 'category_update', 'Updated category: ' . $data['name']);
                    redirect(site_url('kb/admin/categories'));
                } else {
                    $this->session->set_flashdata('error', lang('knowledgebase_error'));
                }
            }
        }

        $data = ['category' => $category];

        $this->template->enable_parser_body(false);
        $this->template->set('title', lang('knowledgebase_edit_category') . ' - ' . lang('knowledgebase_admin') . ' - ' . config_item('app_name'));
        $this->template->build('knowledgebase/admin/edit_category', $data);
    }

    public function delete_category($category_id)
    {
        if ($this->input->method() !== 'post') {
            show_404();
        }

        $category = $this->knowledgebase_model->get_category($category_id);

        if (empty($category)) {
            show_404();
        }

        if ($this->knowledgebase_model->delete_category($category_id)) {
            $this->session->set_flashdata('success', lang('knowledgebase_category_deleted'));
            $this->log_model->create('knowledgebase', 'category_delete', 'Deleted category: ' . $category->name);
        } else {
            $this->session->set_flashdata('error', lang('knowledgebase_error'));
        }

        redirect(site_url('kb/admin/categories'));
    }

    // ==================== ARTICLES ====================

    public function articles()
    {
        $per_page = 20;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $per_page;

        $filters = [
            'include_unpublished' => true
        ];

        $data = [
            'articles'       => $this->knowledgebase_model->get_articles($per_page, $offset, $filters),
            'total_articles' => $this->knowledgebase_model->count_articles($filters),
            'per_page'       => $per_page,
            'current_page'   => $page
        ];

        $this->template->set('title', lang('knowledgebase_articles') . ' - ' . lang('knowledgebase_admin') . ' - ' . config_item('app_name'));
        $this->template->build('knowledgebase/admin/articles', $data);
    }

    public function add_article()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title', lang('knowledgebase_article_title'), 'required|min_length[3]|max_length[255]');
            $this->form_validation->set_rules('category_id', lang('knowledgebase_category'), 'required|numeric');
            $this->form_validation->set_rules('content', lang('knowledgebase_content'), 'required');
            $this->form_validation->set_rules('excerpt', lang('knowledgebase_excerpt'), 'max_length[1000]');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                $data = [
                    'title'       => $this->input->post('title'),
                    'category_id' => $this->input->post('category_id'),
                    'content'     => $this->input->post('content'),
                    'excerpt'     => $this->input->post('excerpt'),
                    'author_id'   => $this->session->userdata('user_id'),
                    'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                    'is_published' => $this->input->post('is_published') ? 1 : 0
                ];

                if ($this->input->post('is_published')) {
                    $data['published_at'] = date('Y-m-d H:i:s');
                }

                $article_id = $this->knowledgebase_model->create_article($data);

                if ($article_id) {
                    $tag_ids = $this->input->post('tags') ? explode(',', $this->input->post('tags')) : [];
                    if (!empty($tag_ids)) {
                        $this->knowledgebase_model->set_article_tags($article_id, array_map('intval', $tag_ids));
                    }

                    $this->session->set_flashdata('success', lang('knowledgebase_article_created'));
                    $this->log_model->create('knowledgebase', 'article_create', 'Created article: ' . $data['title']);
                    redirect(site_url('kb/admin/articles'));
                } else {
                    $this->session->set_flashdata('error', lang('knowledgebase_error'));
                }
            }
        }

        $data = [
            'categories' => $this->knowledgebase_model->get_categories(false),
            'tags'       => $this->knowledgebase_model->get_tags()
        ];

        $this->template->enable_parser_body(false);
        $this->template->set('title', lang('knowledgebase_add_article') . ' - ' . lang('knowledgebase_admin') . ' - ' . config_item('app_name'));
        $this->template->build('knowledgebase/admin/add_article', $data);
    }

    public function edit_article($article_id)
    {
        $article = $this->knowledgebase_model->get_article($article_id);

        if (empty($article)) {
            show_404();
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title', lang('knowledgebase_article_title'), 'required|min_length[3]|max_length[255]');
            $this->form_validation->set_rules('category_id', lang('knowledgebase_category'), 'required|numeric');
            $this->form_validation->set_rules('content', lang('knowledgebase_content'), 'required');
            $this->form_validation->set_rules('excerpt', lang('knowledgebase_excerpt'), 'max_length[1000]');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                $data = [
                    'title'       => $this->input->post('title'),
                    'category_id' => $this->input->post('category_id'),
                    'content'     => $this->input->post('content'),
                    'excerpt'     => $this->input->post('excerpt'),
                    'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                    'is_published' => $this->input->post('is_published') ? 1 : 0
                ];

                if ($this->input->post('is_published') && !$article->is_published) {
                    $data['published_at'] = date('Y-m-d H:i:s');
                }

                if ($this->knowledgebase_model->update_article($article_id, $data)) {
                    $tag_ids = $this->input->post('tags') ? (array)$this->input->post('tags') : [];
                    if (!empty($tag_ids)) {
                        $this->knowledgebase_model->set_article_tags($article_id, array_map('intval', $tag_ids));
                    } else {
                        $this->knowledgebase_model->set_article_tags($article_id, []);
                    }

                    $this->session->set_flashdata('success', lang('knowledgebase_article_updated'));
                    $this->log_model->create('knowledgebase', 'article_update', 'Updated article: ' . $data['title']);
                    redirect(site_url('kb/admin/articles'));
                } else {
                    $this->session->set_flashdata('error', lang('knowledgebase_error'));
                }
            }
        }

        $data = [
            'article'    => $article,
            'categories' => $this->knowledgebase_model->get_categories(false),
            'tags'       => $this->knowledgebase_model->get_tags(),
            'article_tags' => $this->knowledgebase_model->get_article_tags($article_id)
        ];

        $this->template->enable_parser_body(false);
        $this->template->set('title', lang('knowledgebase_edit_article') . ' - ' . lang('knowledgebase_admin') . ' - ' . config_item('app_name'));
        $this->template->build('knowledgebase/admin/edit_article', $data);
    }

    public function delete_article($article_id)
    {
        if ($this->input->method() !== 'post') {
            show_404();
        }

        $article = $this->knowledgebase_model->get_article($article_id);

        if (empty($article)) {
            show_404();
        }

        if ($this->knowledgebase_model->delete_article($article_id)) {
            $this->session->set_flashdata('success', lang('knowledgebase_article_deleted'));
            $this->log_model->create('knowledgebase', 'article_delete', 'Deleted article: ' . $article->title);
        } else {
            $this->session->set_flashdata('error', lang('knowledgebase_error'));
        }

        redirect(site_url('kb/admin/articles'));
    }

    public function publish_article($article_id)
    {
        if ($this->input->method() !== 'post') {
            show_404();
        }

        $article = $this->knowledgebase_model->get_article($article_id);

        if (empty($article)) {
            show_404();
        }

        if ($this->knowledgebase_model->publish_article($article_id)) {
            $this->session->set_flashdata('success', lang('knowledgebase_article_published'));
            $this->log_model->create('knowledgebase', 'article_publish', 'Published article: ' . $article->title);
        } else {
            $this->session->set_flashdata('error', lang('knowledgebase_error'));
        }

        redirect(site_url('kb/admin/articles'));
    }

    // ==================== TAGS ====================

    public function tags()
    {
        $data = [
            'tags' => $this->knowledgebase_model->get_tags()
        ];

        $this->template->set('title', lang('knowledgebase_tags') . ' - ' . lang('knowledgebase_admin') . ' - ' . config_item('app_name'));
        $this->template->build('knowledgebase/admin/tags', $data);
    }

    public function add_tag()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name', lang('knowledgebase_tag_name'), 'required|min_length[2]|max_length[255]|is_unique[kb_tags.name]');
            $this->form_validation->set_rules('color', lang('knowledgebase_color'), 'regex_match[/^#[0-9A-F]{6}$/i]');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                $data = [
                    'name'  => $this->input->post('name'),
                    'color' => $this->input->post('color') ?: '#6B7280'
                ];

                if ($this->knowledgebase_model->create_tag($data)) {
                    $this->session->set_flashdata('success', lang('knowledgebase_tag_created'));
                    $this->log_model->create('knowledgebase', 'tag_create', 'Created tag: ' . $data['name']);
                    redirect(site_url('kb/admin/tags'));
                } else {
                    $this->session->set_flashdata('error', lang('knowledgebase_error'));
                }
            }
        }

        $this->template->enable_parser_body(false);
        $this->template->set('title', lang('knowledgebase_add_tag') . ' - ' . lang('knowledgebase_admin') . ' - ' . config_item('app_name'));
        $this->template->build('knowledgebase/admin/add_tag');
    }

    public function edit_tag($tag_id)
    {
        $tag = $this->knowledgebase_model->get_tag($tag_id);

        if (empty($tag)) {
            show_404();
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name', lang('knowledgebase_tag_name'), 'required|min_length[2]|max_length[255]');
            $this->form_validation->set_rules('color', lang('knowledgebase_color'), 'regex_match[/^#[0-9A-F]{6}$/i]');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                $data = [
                    'name'  => $this->input->post('name'),
                    'color' => $this->input->post('color') ?: '#6B7280'
                ];

                if ($this->knowledgebase_model->update_tag($tag_id, $data)) {
                    $this->session->set_flashdata('success', lang('knowledgebase_tag_updated'));
                    $this->log_model->create('knowledgebase', 'tag_update', 'Updated tag: ' . $data['name']);
                    redirect(site_url('kb/admin/tags'));
                } else {
                    $this->session->set_flashdata('error', lang('knowledgebase_error'));
                }
            }
        }

        $data = ['tag' => $tag];

        $this->template->enable_parser_body(false);
        $this->template->set('title', lang('knowledgebase_edit_tag') . ' - ' . lang('knowledgebase_admin') . ' - ' . config_item('app_name'));
        $this->template->build('knowledgebase/admin/edit_tag', $data);
    }

    public function delete_tag($tag_id)
    {
        if ($this->input->method() !== 'post') {
            show_404();
        }

        $tag = $this->knowledgebase_model->get_tag($tag_id);

        if (empty($tag)) {
            show_404();
        }

        if ($this->knowledgebase_model->delete_tag($tag_id)) {
            $this->session->set_flashdata('success', lang('knowledgebase_tag_deleted'));
            $this->log_model->create('knowledgebase', 'tag_delete', 'Deleted tag: ' . $tag->name);
        } else {
            $this->session->set_flashdata('error', lang('knowledgebase_error'));
        }

        redirect(site_url('kb/admin/tags'));
    }
}
