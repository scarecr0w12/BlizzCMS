<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('news_model');
        $this->load->model('page_model');
        $this->load->model('realm_model');
    }

    public function index()
    {
        header('Content-Type: application/xml; charset=utf-8');
        
        $urls = [];
        
        $urls[] = [
            'loc' => site_url(),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '1.0'
        ];
        
        $urls[] = [
            'loc' => site_url('news'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '0.9'
        ];
        
        $urls[] = [
            'loc' => site_url('login'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.8'
        ];
        
        $urls[] = [
            'loc' => site_url('register'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.8'
        ];
        
        if (is_module_installed('shop')) {
            $urls[] = [
                'loc' => site_url('shop'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.9'
            ];
        }
        
        if (is_module_installed('armory')) {
            $urls[] = [
                'loc' => site_url('armory'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'hourly',
                'priority' => '0.8'
            ];
        }
        
        $articles = $this->news_model->find_all();
        foreach ($articles as $article) {
            $urls[] = [
                'loc' => site_url('news/' . $article->id . '/' . $article->slug),
                'lastmod' => $article->updated_at ?? $article->created_at,
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        }
        
        $pages = $this->page_model->find_all();
        foreach ($pages as $page) {
            $urls[] = [
                'loc' => site_url('page/' . $page->slug),
                'lastmod' => $page->updated_at ?? $page->created_at,
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ];
        }
        
        $data = ['urls' => $urls];
        $this->load->view('sitemap', $data);
    }

    public function index_xml()
    {
        header('Content-Type: application/xml; charset=utf-8');
        
        $sitemaps = [
            site_url('sitemap/index'),
        ];
        
        $data = ['sitemaps' => $sitemaps];
        $this->load->view('sitemap_index', $data);
    }
}
