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
        $this->output->set_header('Content-Type: application/xml; charset=utf-8');
        
        $sitemaps = [];
        
        $sitemaps[] = site_url('sitemap/core');
        $sitemaps[] = site_url('sitemap/news');
        
        if (is_module_installed('shop')) {
            $sitemaps[] = site_url('sitemap/shop');
        }
        
        if (is_module_installed('armory')) {
            $sitemaps[] = site_url('sitemap/armory');
        }
        
        if (is_module_installed('knowledgebase')) {
            $sitemaps[] = site_url('sitemap/knowledgebase');
        }
        
        if (is_module_installed('donate')) {
            $sitemaps[] = site_url('sitemap/donate');
        }
        
        if (is_module_installed('pvpstats')) {
            $sitemaps[] = site_url('sitemap/pvpstats');
        }
        
        if (is_module_installed('vote')) {
            $sitemaps[] = site_url('sitemap/vote');
        }
        
        if (is_module_installed('worldboss')) {
            $sitemaps[] = site_url('sitemap/worldboss');
        }
        
        $data = ['sitemaps' => $sitemaps];
        $this->load->view('sitemap_index', $data);
    }

    public function core()
    {
        header('Content-Type: application/xml; charset=utf-8');
        $this->output->set_header('Content-Type: application/xml; charset=utf-8');
        
        $urls = [];
        
        $urls[] = [
            'loc' => site_url(),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '1.0'
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
        
        $urls[] = [
            'loc' => site_url('forgot-password'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.6'
        ];
        
        $pages = $this->page_model->find_all();
        foreach ($pages as $page) {
            $urls[] = [
                'loc' => site_url('page/' . $page->slug),
                'lastmod' => $page->updated_at ?? $page->created_at,
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ];
        }
        
        $data = ['urls' => $urls];
        $this->load->view('sitemap', $data);
    }

    public function news()
    {
        header('Content-Type: application/xml; charset=utf-8');
        $this->output->set_header('Content-Type: application/xml; charset=utf-8');
        
        $urls = [];
        
        $urls[] = [
            'loc' => site_url('news'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '0.9'
        ];
        
        $articles = $this->news_model->find_all();
        foreach ($articles as $article) {
            $urls[] = [
                'loc' => site_url('news/' . $article->id . '/' . $article->slug),
                'lastmod' => $article->updated_at ?? $article->created_at,
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ];
        }
        
        $data = ['urls' => $urls];
        $this->load->view('sitemap', $data);
    }

    public function shop()
    {
        if (!is_module_installed('shop')) {
            show_404();
        }
        
        header('Content-Type: application/xml; charset=utf-8');
        $this->output->set_header('Content-Type: application/xml; charset=utf-8');
        
        $this->load->model('shop/shop_category_model');
        $this->load->model('shop/shop_item_model');
        $this->load->model('shop/shop_service_model');
        $this->load->model('shop/shop_subscription_model');
        
        $urls = [];
        
        $urls[] = [
            'loc' => site_url('shop'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '0.9'
        ];
        
        $categories = $this->shop_category_model->find_all();
        foreach ($categories as $category) {
            $urls[] = [
                'loc' => site_url('shop/category/' . $category->id),
                'lastmod' => $category->updated_at ?? $category->created_at,
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ];
        }
        
        $items = $this->shop_item_model->find_all();
        foreach ($items as $item) {
            $urls[] = [
                'loc' => site_url('shop/item/' . $item->id),
                'lastmod' => $item->updated_at ?? $item->created_at,
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        }
        
        $services = $this->shop_service_model->find_all();
        foreach ($services as $service) {
            $urls[] = [
                'loc' => site_url('shop/service/' . $service->id),
                'lastmod' => $service->updated_at ?? $service->created_at,
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        }
        
        $subscriptions = $this->shop_subscription_model->find_all();
        foreach ($subscriptions as $subscription) {
            $urls[] = [
                'loc' => site_url('shop/subscriptions/' . $subscription->id),
                'lastmod' => $subscription->updated_at ?? $subscription->created_at,
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        }
        
        $urls[] = [
            'loc' => site_url('shop/cart'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '0.6'
        ];
        
        $data = ['urls' => $urls];
        $this->load->view('sitemap', $data);
    }

    public function armory()
    {
        if (!is_module_installed('armory')) {
            show_404();
        }
        
        header('Content-Type: application/xml; charset=utf-8');
        $this->output->set_header('Content-Type: application/xml; charset=utf-8');
        
        $urls = [];
        
        $urls[] = [
            'loc' => site_url('armory'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'hourly',
            'priority' => '0.9'
        ];
        
        $urls[] = [
            'loc' => site_url('armory/search'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'hourly',
            'priority' => '0.8'
        ];
        
        $this->load->database();
        $db = $this->db;
        
        $characters = $db->select('id, name, realm_id')
            ->from('characters')
            ->limit(5000)
            ->get()
            ->result();
        
        foreach ($characters as $char) {
            $urls[] = [
                'loc' => site_url('armory/character/' . $char->realm_id . '/' . urlencode($char->name)),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.6'
            ];
        }
        
        $guilds = $db->select('id, name, realm_id')
            ->from('guild')
            ->limit(1000)
            ->get()
            ->result();
        
        foreach ($guilds as $guild) {
            $urls[] = [
                'loc' => site_url('armory/guild/' . $guild->realm_id . '/' . urlencode($guild->name)),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.6'
            ];
        }
        
        $realms = $this->realm_model->find_all();
        foreach ($realms as $realm) {
            $urls[] = [
                'loc' => site_url('armory/arena/' . $realm->id),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.7'
            ];
        }
        
        $data = ['urls' => $urls];
        $this->load->view('sitemap', $data);
    }

    public function knowledgebase()
    {
        if (!is_module_installed('knowledgebase')) {
            show_404();
        }
        
        header('Content-Type: application/xml; charset=utf-8');
        $this->output->set_header('Content-Type: application/xml; charset=utf-8');
        
        $this->load->model('knowledgebase/knowledgebase_category_model');
        $this->load->model('knowledgebase/knowledgebase_article_model');
        
        $urls = [];
        
        $urls[] = [
            'loc' => site_url('kb'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '0.9'
        ];
        
        $categories = $this->knowledgebase_category_model->find_all();
        foreach ($categories as $category) {
            $urls[] = [
                'loc' => site_url('kb/category/' . $category->id),
                'lastmod' => $category->updated_at ?? $category->created_at,
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ];
        }
        
        $articles = $this->knowledgebase_article_model->find_all();
        foreach ($articles as $article) {
            $urls[] = [
                'loc' => site_url('kb/article/' . $article->id),
                'lastmod' => $article->updated_at ?? $article->created_at,
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ];
        }
        
        $urls[] = [
            'loc' => site_url('kb/search'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '0.6'
        ];
        
        $data = ['urls' => $urls];
        $this->load->view('sitemap', $data);
    }

    public function donate()
    {
        if (!is_module_installed('donate')) {
            show_404();
        }
        
        header('Content-Type: application/xml; charset=utf-8');
        $this->output->set_header('Content-Type: application/xml; charset=utf-8');
        
        $this->load->model('donate/donate_package_model');
        
        $urls = [];
        
        $urls[] = [
            'loc' => site_url('donate'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '0.9'
        ];
        
        $urls[] = [
            'loc' => site_url('donate/packages'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '0.8'
        ];
        
        $packages = $this->donate_package_model->find_all();
        foreach ($packages as $package) {
            $urls[] = [
                'loc' => site_url('donate/package/' . $package->id),
                'lastmod' => $package->updated_at ?? $package->created_at,
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        }
        
        $urls[] = [
            'loc' => site_url('donate/top'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '0.7'
        ];
        
        $data = ['urls' => $urls];
        $this->load->view('sitemap', $data);
    }

    public function pvpstats()
    {
        if (!is_module_installed('pvpstats')) {
            show_404();
        }
        
        header('Content-Type: application/xml; charset=utf-8');
        $this->output->set_header('Content-Type: application/xml; charset=utf-8');
        
        $urls = [];
        
        $urls[] = [
            'loc' => site_url('pvpstats'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '0.9'
        ];
        
        $urls[] = [
            'loc' => site_url('pvpstats/battlegrounds'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '0.8'
        ];
        
        $urls[] = [
            'loc' => site_url('pvpstats/players'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '0.8'
        ];
        
        $urls[] = [
            'loc' => site_url('pvpstats/guilds'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '0.8'
        ];
        
        $urls[] = [
            'loc' => site_url('pvpstats/statistics'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '0.7'
        ];
        
        $data = ['urls' => $urls];
        $this->load->view('sitemap', $data);
    }

    public function vote()
    {
        if (!is_module_installed('vote')) {
            show_404();
        }
        
        header('Content-Type: application/xml; charset=utf-8');
        $this->output->set_header('Content-Type: application/xml; charset=utf-8');
        
        $this->load->model('vote/vote_site_model');
        
        $urls = [];
        
        $urls[] = [
            'loc' => site_url('vote'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '0.9'
        ];
        
        $sites = $this->vote_site_model->find_all();
        foreach ($sites as $site) {
            $urls[] = [
                'loc' => site_url('vote/site/' . $site->id),
                'lastmod' => $site->updated_at ?? $site->created_at,
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        }
        
        $urls[] = [
            'loc' => site_url('vote/top'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '0.7'
        ];
        
        $data = ['urls' => $urls];
        $this->load->view('sitemap', $data);
    }

    public function worldboss()
    {
        if (!is_module_installed('worldboss')) {
            show_404();
        }
        
        header('Content-Type: application/xml; charset=utf-8');
        $this->output->set_header('Content-Type: application/xml; charset=utf-8');
        
        $urls = [];
        
        $urls[] = [
            'loc' => site_url('worldboss'),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '0.9'
        ];
        
        $this->load->database();
        $db = $this->db;
        
        $bosses = $db->select('id')
            ->from('worldboss_encounters')
            ->limit(1000)
            ->get()
            ->result();
        
        foreach ($bosses as $boss) {
            $urls[] = [
                'loc' => site_url('worldboss/boss/' . $boss->id),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        }
        
        $data = ['urls' => $urls];
        $this->load->view('sitemap', $data);
    }

    public function index_xml()
    {
        header('Content-Type: application/xml; charset=utf-8');
        $this->output->set_header('Content-Type: application/xml; charset=utf-8');
        
        $sitemaps = [];
        
        $sitemaps[] = site_url('sitemap/core');
        $sitemaps[] = site_url('sitemap/news');
        
        if (is_module_installed('shop')) {
            $sitemaps[] = site_url('sitemap/shop');
        }
        
        if (is_module_installed('armory')) {
            $sitemaps[] = site_url('sitemap/armory');
        }
        
        if (is_module_installed('knowledgebase')) {
            $sitemaps[] = site_url('sitemap/knowledgebase');
        }
        
        if (is_module_installed('donate')) {
            $sitemaps[] = site_url('sitemap/donate');
        }
        
        if (is_module_installed('pvpstats')) {
            $sitemaps[] = site_url('sitemap/pvpstats');
        }
        
        if (is_module_installed('vote')) {
            $sitemaps[] = site_url('sitemap/vote');
        }
        
        if (is_module_installed('worldboss')) {
            $sitemaps[] = site_url('sitemap/worldboss');
        }
        
        $data = ['sitemaps' => $sitemaps];
        $this->load->view('sitemap_index', $data);
    }
}
