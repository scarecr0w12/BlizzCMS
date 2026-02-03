<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('generate_meta_description')) {
    function generate_meta_description($text, $length = 160) {
        $text = strip_tags($text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        
        if (strlen($text) > $length) {
            $text = substr($text, 0, $length);
            $text = substr($text, 0, strrpos($text, ' ')) . '...';
        }
        
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('generate_slug')) {
    function generate_slug($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = preg_replace('~-+~', '-', $text);
        $text = trim($text, '-');
        return strtolower($text);
    }
}

if (!function_exists('get_structured_data')) {
    function get_structured_data($type = 'Organization', $data = []) {
        $ci =& get_instance();
        
        $base_schema = [
            '@context' => 'https://schema.org',
            '@type' => $type,
            'name' => config_item('app_name'),
            'url' => site_url(),
            'description' => config_item('seo_description_tag'),
        ];
        
        if (!empty(config_item('social_facebook'))) {
            $base_schema['sameAs'][] = 'https://facebook.com/groups/' . config_item('social_facebook');
        }
        if (!empty(config_item('social_twitch'))) {
            $base_schema['sameAs'][] = 'https://twitch.tv/' . config_item('social_twitch');
        }
        if (!empty(config_item('social_youtube'))) {
            $base_schema['sameAs'][] = 'https://youtube.com/@' . config_item('social_youtube');
        }
        if (!empty(config_item('social_x'))) {
            $base_schema['sameAs'][] = 'https://x.com/@' . config_item('social_x');
        }
        
        return array_merge($base_schema, $data);
    }
}

if (!function_exists('get_article_schema')) {
    function get_article_schema($article) {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => $article->title,
            'description' => $article->summary,
            'image' => base_url('uploads/' . $article->image),
            'datePublished' => $article->created_at,
            'dateModified' => $article->updated_at ?? $article->created_at,
            'author' => [
                '@type' => 'Person',
                'name' => config_item('app_name')
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config_item('app_name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => base_url('assets/img/favicon.ico')
                ]
            ]
        ];
        
        return $schema;
    }
}

if (!function_exists('get_breadcrumb_schema')) {
    function get_breadcrumb_schema($breadcrumbs) {
        $items = [];
        $position = 1;
        
        foreach ($breadcrumbs as $name => $url) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $name,
                'item' => $url
            ];
            $position++;
        }
        
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        ];
    }
}

if (!function_exists('get_faq_schema')) {
    function get_faq_schema($faqs) {
        $items = [];
        
        foreach ($faqs as $faq) {
            $items[] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer']
                ]
            ];
        }
        
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $items
        ];
    }
}

if (!function_exists('get_product_schema')) {
    function get_product_schema($product) {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => $product->description,
            'image' => base_url('uploads/' . $product->image),
            'brand' => [
                '@type' => 'Brand',
                'name' => config_item('app_name')
            ]
        ];
        
        if (isset($product->price)) {
            $schema['offers'] = [
                '@type' => 'Offer',
                'price' => $product->price,
                'priceCurrency' => 'USD',
                'availability' => 'https://schema.org/InStock'
            ];
        }
        
        return $schema;
    }
}

if (!function_exists('render_schema_json')) {
    function render_schema_json($schema) {
        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }
}

if (!function_exists('get_og_tags')) {
    function get_og_tags($data = []) {
        $defaults = [
            'og:title' => config_item('app_name'),
            'og:description' => config_item('seo_description_tag'),
            'og:url' => current_url(),
            'og:type' => 'website',
            'og:image' => base_url('assets/img/favicon.ico'),
            'twitter:card' => 'summary_large_image',
            'twitter:title' => config_item('app_name'),
            'twitter:description' => config_item('seo_description_tag'),
            'twitter:image' => base_url('assets/img/favicon.ico')
        ];
        
        return array_merge($defaults, $data);
    }
}

if (!function_exists('render_og_tags')) {
    function render_og_tags($tags) {
        $output = '';
        foreach ($tags as $property => $content) {
            if (strpos($property, 'twitter:') === 0) {
                $output .= '<meta name="' . htmlspecialchars($property, ENT_QUOTES, 'UTF-8') . '" content="' . htmlspecialchars($content, ENT_QUOTES, 'UTF-8') . '">' . "\n";
            } else {
                $output .= '<meta property="' . htmlspecialchars($property, ENT_QUOTES, 'UTF-8') . '" content="' . htmlspecialchars($content, ENT_QUOTES, 'UTF-8') . '">' . "\n";
            }
        }
        return $output;
    }
}

if (!function_exists('get_canonical_url')) {
    function get_canonical_url($url = null) {
        if ($url === null) {
            $url = current_url();
        }
        return htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('render_canonical_tag')) {
    function render_canonical_tag($url = null) {
        return '<link rel="canonical" href="' . get_canonical_url($url) . '">' . "\n";
    }
}

if (!function_exists('get_hreflang_tags')) {
    function get_hreflang_tags($ci) {
        $output = '';
        $languages = $ci->multilanguage->languages();
        $current_uri = $ci->uri->uri_string();
        
        foreach ($languages as $lang) {
            $url = site_url($current_uri);
            $output .= '<link rel="alternate" hreflang="' . $lang['locale'] . '" href="' . $url . '">' . "\n";
        }
        
        return $output;
    }
}
