<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Head_scripts_manager
{
    private $CI;
    private $scripts = [];
    private $tags = [];
    private $analytics = [];

    public function __construct()
    {
        $this->CI =& get_instance();
        
        if (file_exists(APPPATH . 'config/head_scripts.php')) {
            $this->CI->config->load('head_scripts', true);
        }
        
        $this->load_configured_scripts();
    }

    private function load_configured_scripts()
    {
        $configured = $this->CI->config->item('head_scripts', 'head_scripts');

        if (!is_array($configured)) {
            return;
        }

        foreach ($configured as $key => $script) {
            if (!isset($script['enabled']) || !$script['enabled']) {
                continue;
            }

            $type = $script['type'] ?? 'script';

            switch ($type) {
                case 'analytics':
                    $this->add_analytics($key, $script);
                    break;
                case 'tag':
                    $this->add_tag($key, $script);
                    break;
                case 'script':
                default:
                    $this->add_script($key, $script);
                    break;
            }
        }
    }

    public function add_script($key, $config)
    {
        $script = [
            'key' => $key,
            'src' => $config['src'] ?? null,
            'content' => $config['content'] ?? null,
            'async' => $config['async'] ?? false,
            'defer' => $config['defer'] ?? false,
            'type' => $config['script_type'] ?? 'text/javascript',
            'attributes' => $config['attributes'] ?? [],
        ];

        $this->scripts[$key] = $script;
        return $this;
    }

    public function add_tag($key, $config)
    {
        $tag = [
            'key' => $key,
            'content' => $config['content'] ?? '',
        ];

        $this->tags[$key] = $tag;
        return $this;
    }

    public function add_analytics($key, $config)
    {
        $type = $config['analytics_type'] ?? 'google_analytics';
        $content = $config['content'] ?? '';

        switch ($type) {
            case 'google_analytics':
                $this->add_google_analytics($key, $content);
                break;
            case 'google_tag_manager':
                $this->add_google_tag_manager($key, $content);
                break;
            case 'facebook_pixel':
                $this->add_facebook_pixel($key, $content);
                break;
            default:
                $this->analytics[$key] = [
                    'key' => $key,
                    'type' => $type,
                    'content' => $content,
                ];
                break;
        }

        return $this;
    }

    private function add_google_analytics($key, $measurement_id)
    {
        $this->analytics[$key] = [
            'key' => $key,
            'type' => 'google_analytics',
            'measurement_id' => $measurement_id,
        ];
    }

    private function add_google_tag_manager($key, $gtm_id)
    {
        $this->analytics[$key] = [
            'key' => $key,
            'type' => 'google_tag_manager',
            'gtm_id' => $gtm_id,
        ];
    }

    private function add_facebook_pixel($key, $pixel_id)
    {
        $this->analytics[$key] = [
            'key' => $key,
            'type' => 'facebook_pixel',
            'pixel_id' => $pixel_id,
        ];
    }

    public function remove_script($key)
    {
        unset($this->scripts[$key]);
        return $this;
    }

    public function remove_tag($key)
    {
        unset($this->tags[$key]);
        return $this;
    }

    public function remove_analytics($key)
    {
        unset($this->analytics[$key]);
        return $this;
    }

    public function render()
    {
        $output = '';

        $output .= $this->render_tags();
        $output .= $this->render_analytics();
        $output .= $this->render_scripts();

        return $output;
    }

    private function render_tags()
    {
        $output = '';

        foreach ($this->tags as $tag) {
            $output .= $tag['content'] . "\n";
        }

        return $output;
    }

    private function render_analytics()
    {
        $output = '';

        foreach ($this->analytics as $analytics) {
            $output .= $this->render_analytics_code($analytics);
        }

        return $output;
    }

    private function render_analytics_code($analytics)
    {
        $type = $analytics['type'] ?? '';

        switch ($type) {
            case 'google_analytics':
                return $this->render_google_analytics($analytics);
            case 'google_tag_manager':
                return $this->render_google_tag_manager($analytics);
            case 'facebook_pixel':
                return $this->render_facebook_pixel($analytics);
            default:
                return $analytics['content'] . "\n";
        }
    }

    private function render_google_analytics($analytics)
    {
        $measurement_id = $analytics['measurement_id'] ?? '';

        if (empty($measurement_id)) {
            return '';
        }

        return <<<EOT
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={$measurement_id}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{$measurement_id}');
</script>

EOT;
    }

    private function render_google_tag_manager($analytics)
    {
        $gtm_id = $analytics['gtm_id'] ?? '';

        if (empty($gtm_id)) {
            return '';
        }

        return <<<EOT
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{$gtm_id}');</script>

EOT;
    }

    private function render_facebook_pixel($analytics)
    {
        $pixel_id = $analytics['pixel_id'] ?? '';

        if (empty($pixel_id)) {
            return '';
        }

        return <<<EOT
<!-- Facebook Pixel -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '{$pixel_id}');
  fbq('track', 'PageView');
</script>

EOT;
    }

    private function render_scripts()
    {
        $output = '';

        foreach ($this->scripts as $script) {
            $output .= $this->render_script_tag($script);
        }

        return $output;
    }

    private function render_script_tag($script)
    {
        if (!empty($script['src'])) {
            return $this->render_external_script($script);
        } elseif (!empty($script['content'])) {
            return $this->render_inline_script($script);
        }

        return '';
    }

    private function render_external_script($script)
    {
        $attributes = $this->build_attributes($script);
        return "<script src=\"{$script['src']}\"{$attributes}></script>\n";
    }

    private function render_inline_script($script)
    {
        $attributes = $this->build_attributes($script);
        return "<script{$attributes}>\n{$script['content']}\n</script>\n";
    }

    private function build_attributes($script)
    {
        $attributes = '';

        if ($script['async']) {
            $attributes .= ' async';
        }

        if ($script['defer']) {
            $attributes .= ' defer';
        }

        if (!empty($script['type']) && $script['type'] !== 'text/javascript') {
            $attributes .= ' type="' . htmlspecialchars($script['type']) . '"';
        }

        foreach ($script['attributes'] as $key => $value) {
            if ($value === true) {
                $attributes .= ' ' . htmlspecialchars($key);
            } elseif ($value !== false && $value !== null) {
                $attributes .= ' ' . htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
            }
        }

        return $attributes;
    }

    public function get_scripts()
    {
        return $this->scripts;
    }

    public function get_tags()
    {
        return $this->tags;
    }

    public function get_analytics()
    {
        return $this->analytics;
    }
}
