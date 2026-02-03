<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Robots extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        header('Content-Type: text/plain; charset=utf-8');
        
        $robots = "# BlizzCMS Robots.txt\n";
        $robots .= "# Generated dynamically for SEO optimization\n";
        $robots .= "# Last updated: " . date('Y-m-d H:i:s') . "\n\n";
        
        $robots .= "User-agent: *\n";
        $robots .= "Allow: /\n";
        $robots .= "Disallow: /admin/\n";
        $robots .= "Disallow: /application/\n";
        $robots .= "Disallow: /system/\n";
        $robots .= "Disallow: /vendor/\n";
        $robots .= "Disallow: /install/\n";
        $robots .= "Disallow: /login\n";
        $robots .= "Disallow: /register\n";
        $robots .= "Disallow: /logout\n";
        $robots .= "Disallow: /forgot-password\n";
        $robots .= "Disallow: /reset-password\n";
        $robots .= "Disallow: /user/\n";
        $robots .= "Disallow: /*?*\n";
        $robots .= "Disallow: /*.php\n";
        $robots .= "\n";
        
        $robots .= "User-agent: Googlebot\n";
        $robots .= "Allow: /\n";
        $robots .= "Crawl-delay: 0\n";
        $robots .= "\n";
        
        $robots .= "User-agent: Bingbot\n";
        $robots .= "Allow: /\n";
        $robots .= "Crawl-delay: 1\n";
        $robots .= "\n";
        
        $robots .= "User-agent: *\n";
        $robots .= "Crawl-delay: 1\n";
        $robots .= "Request-rate: 30/1m\n";
        $robots .= "\n";
        
        $robots .= "Sitemap: " . site_url('sitemap') . "\n";
        
        echo $robots;
    }
}
