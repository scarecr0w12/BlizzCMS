<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('render_image_seo')) {
    function render_image_seo($src, $alt, $title = '', $class = '', $loading = 'lazy', $width = null, $height = null) {
        $img = '<img src="' . htmlspecialchars($src, ENT_QUOTES, 'UTF-8') . '" ';
        $img .= 'alt="' . htmlspecialchars($alt, ENT_QUOTES, 'UTF-8') . '" ';
        
        if (!empty($title)) {
            $img .= 'title="' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '" ';
        }
        
        if (!empty($class)) {
            $img .= 'class="' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '" ';
        }
        
        $img .= 'loading="' . htmlspecialchars($loading, ENT_QUOTES, 'UTF-8') . '" ';
        
        if ($width !== null) {
            $img .= 'width="' . intval($width) . '" ';
        }
        
        if ($height !== null) {
            $img .= 'height="' . intval($height) . '" ';
        }
        
        $img .= '>';
        
        return $img;
    }
}

if (!function_exists('render_responsive_image')) {
    function render_responsive_image($src, $alt, $srcset = [], $sizes = '', $class = '', $title = '') {
        $img = '<img src="' . htmlspecialchars($src, ENT_QUOTES, 'UTF-8') . '" ';
        $img .= 'alt="' . htmlspecialchars($alt, ENT_QUOTES, 'UTF-8') . '" ';
        
        if (!empty($title)) {
            $img .= 'title="' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '" ';
        }
        
        if (!empty($srcset)) {
            $srcset_str = '';
            foreach ($srcset as $url => $descriptor) {
                $srcset_str .= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($descriptor, ENT_QUOTES, 'UTF-8') . ', ';
            }
            $srcset_str = rtrim($srcset_str, ', ');
            $img .= 'srcset="' . $srcset_str . '" ';
        }
        
        if (!empty($sizes)) {
            $img .= 'sizes="' . htmlspecialchars($sizes, ENT_QUOTES, 'UTF-8') . '" ';
        }
        
        if (!empty($class)) {
            $img .= 'class="' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '" ';
        }
        
        $img .= 'loading="lazy">';
        
        return $img;
    }
}

if (!function_exists('get_image_schema')) {
    function get_image_schema($url, $name = '', $description = '', $width = null, $height = null) {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'ImageObject',
            'url' => htmlspecialchars($url, ENT_QUOTES, 'UTF-8')
        ];
        
        if (!empty($name)) {
            $schema['name'] = $name;
        }
        
        if (!empty($description)) {
            $schema['description'] = $description;
        }
        
        if ($width !== null && $height !== null) {
            $schema['width'] = intval($width);
            $schema['height'] = intval($height);
        }
        
        return $schema;
    }
}
