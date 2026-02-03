<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('render_google_analytics')) {
    function render_google_analytics($tracking_id) {
        if (empty($tracking_id)) {
            return '';
        }
        
        $script = '<!-- Google Analytics -->' . "\n";
        $script .= '<script async src="https://www.googletagmanager.com/gtag/js?id=' . htmlspecialchars($tracking_id, ENT_QUOTES, 'UTF-8') . '"></script>' . "\n";
        $script .= '<script>' . "\n";
        $script .= 'window.dataLayer = window.dataLayer || [];' . "\n";
        $script .= 'function gtag(){dataLayer.push(arguments);}' . "\n";
        $script .= 'gtag(\'js\', new Date());' . "\n";
        $script .= 'gtag(\'config\', \'' . htmlspecialchars($tracking_id, ENT_QUOTES, 'UTF-8') . '\', {' . "\n";
        $script .= '  \'page_path\': window.location.pathname,' . "\n";
        $script .= '  \'anonymize_ip\': true' . "\n";
        $script .= '});' . "\n";
        $script .= '</script>' . "\n";
        
        return $script;
    }
}

if (!function_exists('render_google_search_console')) {
    function render_google_search_console($verification_code) {
        if (empty($verification_code)) {
            return '';
        }
        
        return '<meta name="google-site-verification" content="' . htmlspecialchars($verification_code, ENT_QUOTES, 'UTF-8') . '">' . "\n";
    }
}

if (!function_exists('render_bing_webmaster_tools')) {
    function render_bing_webmaster_tools($verification_code) {
        if (empty($verification_code)) {
            return '';
        }
        
        return '<meta name="msvalidate.01" content="' . htmlspecialchars($verification_code, ENT_QUOTES, 'UTF-8') . '">' . "\n";
    }
}

if (!function_exists('render_facebook_pixel')) {
    function render_facebook_pixel($pixel_id) {
        if (empty($pixel_id)) {
            return '';
        }
        
        $script = '<!-- Facebook Pixel Code -->' . "\n";
        $script .= '<script>' . "\n";
        $script .= '!function(f,b,e,v,n,t,s)' . "\n";
        $script .= '{if(f.fbq)return;n=f.fbq=function(){n.callMethod?' . "\n";
        $script .= 'n.callMethod.apply(n,arguments):n.queue.push(arguments)};' . "\n";
        $script .= 'if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version=\'2.0\';' . "\n";
        $script .= 'n.queue=[];t=b.createElement(e);t.async=!0;' . "\n";
        $script .= 't.src=v;s=b.getElementsByTagName(e)[0];' . "\n";
        $script .= 's.parentNode.insertBefore(t,s)}(window, document,\'script\',' . "\n";
        $script .= '\'https://connect.facebook.net/en_US/fbevents.js\');' . "\n";
        $script .= 'fbq(\'init\', \'' . htmlspecialchars($pixel_id, ENT_QUOTES, 'UTF-8') . '\');' . "\n";
        $script .= 'fbq(\'track\', \'PageView\');' . "\n";
        $script .= '</script>' . "\n";
        $script .= '<noscript><img height="1" width="1" style="display:none"' . "\n";
        $script .= 'src="https://www.facebook.com/tr?id=' . htmlspecialchars($pixel_id, ENT_QUOTES, 'UTF-8') . '&ev=PageView&noscript=1"' . "\n";
        $script .= '/></noscript>' . "\n";
        
        return $script;
    }
}

if (!function_exists('track_event')) {
    function track_event($event_name, $event_data = []) {
        $script = '<script>' . "\n";
        $script .= 'if (typeof gtag !== "undefined") {' . "\n";
        $script .= '  gtag("event", "' . htmlspecialchars($event_name, ENT_QUOTES, 'UTF-8') . '", ' . json_encode($event_data) . ');' . "\n";
        $script .= '}' . "\n";
        $script .= '</script>' . "\n";
        
        return $script;
    }
}
