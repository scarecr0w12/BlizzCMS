<?php
/**
 * BlizzCMS
 *
 * @author WoW-CMS
 * @copyright Copyright (c) 2019 - 2023, WoW-CMS (https://wow-cms.com)
 * @license https://opensource.org/licenses/MIT MIT License
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('kb_can_manage')) {
    function kb_can_manage()
    {
        return is_admin();
    }
}

if (!function_exists('kb_can_view')) {
    function kb_can_view()
    {
        return true;
    }
}

if (!function_exists('kb_can_comment')) {
    function kb_can_comment()
    {
        return is_logged_in();
    }
}

if (!function_exists('kb_format_content')) {
    function kb_format_content($content)
    {
        $CI = &get_instance();
        $CI->load->library('markdown');
        return $CI->markdown->parse($content);
    }
}

if (!function_exists('kb_get_breadcrumb')) {
    function kb_get_breadcrumb($category = null, $article = null)
    {
        $breadcrumb = [];
        $breadcrumb[] = [
            'title' => 'Knowledge Base',
            'url' => site_url('kb')
        ];

        if ($category) {
            $breadcrumb[] = [
                'title' => $category->name,
                'url' => site_url('kb/category/' . $category->id)
            ];
        }

        if ($article) {
            $breadcrumb[] = [
                'title' => $article->title,
                'url' => site_url('kb/article/' . $article->id),
                'active' => true
            ];
        }

        return $breadcrumb;
    }
}

if (!function_exists('kb_excerpt')) {
    function kb_excerpt($text, $length = 150)
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . '...';
    }
}

if (!function_exists('kb_get_related_articles')) {
    function kb_get_related_articles($article_id, $limit = 3)
    {
        $CI = &get_instance();
        $CI->load->model('knowledgebase_model');

        $article = $CI->knowledgebase_model->get_article($article_id);
        if (!$article) {
            return [];
        }

        return $CI->knowledgebase_model->get_articles($limit, 0, [
            'category_id' => $article->category_id,
            'include_unpublished' => false
        ]);
    }
}
