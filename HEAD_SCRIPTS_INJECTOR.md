# Head Scripts Injector Documentation

The Head Scripts Injector is a system that allows you to easily add analytics, tags, and custom scripts to the `<head>` section of your pages without modifying the layout files.

## Features

- **Google Analytics Support**: Automatically generates GA4 tracking code
- **Google Tag Manager**: GTM container setup
- **Facebook Pixel**: Conversion tracking
- **Custom Meta Tags**: Add any meta tags you need
- **Custom Scripts**: Inline or external JavaScript
- **Easy Configuration**: Simple config file setup
- **Runtime Control**: Add/remove scripts dynamically from controllers

## Configuration

### Basic Setup

Edit `/application/config/head_scripts.php` to configure your scripts:

```php
$config['head_scripts'] = [
    'google_analytics' => [
        'enabled' => true,
        'type' => 'analytics',
        'analytics_type' => 'google_analytics',
        'content' => 'G-XXXXXXXXXX', // Your GA measurement ID
    ],
];
```

## Usage Examples

### 1. Google Analytics

```php
$config['head_scripts'] = [
    'google_analytics' => [
        'enabled' => true,
        'type' => 'analytics',
        'analytics_type' => 'google_analytics',
        'content' => 'G-XXXXXXXXXX',
    ],
];
```

### 2. Google Tag Manager

```php
$config['head_scripts'] = [
    'gtm' => [
        'enabled' => true,
        'type' => 'analytics',
        'analytics_type' => 'google_tag_manager',
        'content' => 'GTM-XXXXXX',
    ],
];
```

### 3. Facebook Pixel

```php
$config['head_scripts'] = [
    'facebook_pixel' => [
        'enabled' => true,
        'type' => 'analytics',
        'analytics_type' => 'facebook_pixel',
        'content' => '123456789',
    ],
];
```

### 4. Custom Meta Tags

```php
$config['head_scripts'] = [
    'theme_color' => [
        'enabled' => true,
        'type' => 'tag',
        'content' => '<meta name="theme-color" content="#1f2937">',
    ],
    'apple_touch_icon' => [
        'enabled' => true,
        'type' => 'tag',
        'content' => '<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png">',
    ],
];
```

### 5. External Scripts

```php
$config['head_scripts'] = [
    'custom_lib' => [
        'enabled' => true,
        'type' => 'script',
        'src' => 'https://example.com/library.js',
        'async' => true,
        'defer' => false,
    ],
];
```

### 6. Inline Scripts

```php
$config['head_scripts'] = [
    'custom_init' => [
        'enabled' => true,
        'type' => 'script',
        'content' => 'console.log("Site initialized");',
        'async' => false,
        'defer' => false,
    ],
];
```

## Runtime Control

You can add or remove scripts dynamically from your controllers:

### Using Helper Functions

```php
// In your controller
$this->load->helper('head_scripts');

// Add a script
add_head_script('my_script', [
    'src' => 'https://example.com/script.js',
    'async' => true,
]);

// Add a tag
add_head_tag('custom_meta', [
    'content' => '<meta name="custom" content="value">',
]);

// Add analytics
add_head_analytics('ga', [
    'type' => 'analytics',
    'analytics_type' => 'google_analytics',
    'content' => 'G-XXXXXXXXXX',
]);

// Remove a script
remove_head_script('my_script');

// Remove a tag
remove_head_tag('custom_meta');

// Remove analytics
remove_head_analytics('ga');
```

### Using the Library Directly

```php
// In your controller
$this->load->library('head_scripts');

// Add a script
$this->head_scripts->add_script('my_script', [
    'src' => 'https://example.com/script.js',
    'async' => true,
]);

// Add a tag
$this->head_scripts->add_tag('custom_meta', [
    'content' => '<meta name="custom" content="value">',
]);

// Add analytics
$this->head_scripts->add_analytics('ga', [
    'type' => 'analytics',
    'analytics_type' => 'google_analytics',
    'content' => 'G-XXXXXXXXXX',
]);

// Remove scripts
$this->head_scripts->remove_script('my_script');
$this->head_scripts->remove_tag('custom_meta');
$this->head_scripts->remove_analytics('ga');

// Get all scripts/tags/analytics
$scripts = $this->head_scripts->get_scripts();
$tags = $this->head_scripts->get_tags();
$analytics = $this->head_scripts->get_analytics();

// Render all head scripts
echo $this->head_scripts->render();
```

## Configuration Options

### Script Configuration

```php
[
    'enabled' => true,                    // Enable/disable this script
    'type' => 'script',                   // Type: 'script', 'tag', or 'analytics'
    'src' => 'https://example.com/lib.js', // External script URL (optional)
    'content' => 'console.log("hi");',    // Inline script content (optional)
    'async' => false,                     // Load asynchronously
    'defer' => false,                     // Defer loading
    'script_type' => 'text/javascript',   // Script type (default: text/javascript)
    'attributes' => [                     // Custom attributes
        'data-custom' => 'value',
        'integrity' => 'sha384-...',
    ],
]
```

### Tag Configuration

```php
[
    'enabled' => true,
    'type' => 'tag',
    'content' => '<meta name="..." content="...">',
]
```

### Analytics Configuration

```php
[
    'enabled' => true,
    'type' => 'analytics',
    'analytics_type' => 'google_analytics', // or 'google_tag_manager', 'facebook_pixel'
    'content' => 'MEASUREMENT_ID',         // ID or tracking code
]
```

## Supported Analytics Types

- **google_analytics**: Google Analytics 4 (GA4)
- **google_tag_manager**: Google Tag Manager
- **facebook_pixel**: Facebook Conversion Pixel
- **custom**: Custom analytics code (use 'content' field directly)

## How It Works

1. **Configuration Loading**: The `Head_scripts` library loads configuration from `head_scripts.php`
2. **Script Registration**: Configured scripts are registered during library initialization
3. **Rendering**: Scripts are rendered in the `<head>` section via the layout files
4. **Order**: Tags → Analytics → Scripts (in that order)

## Integration Points

The head scripts injector is integrated into:

- `/application/views/layouts/layout.php` (Frontend layout)
- `/application/views/layouts/admin_layout.php` (Admin layout)

## Best Practices

1. **Use Configuration for Static Scripts**: Put permanent analytics in `head_scripts.php`
2. **Use Runtime Control for Dynamic Scripts**: Add scripts conditionally in controllers
3. **Security**: Always sanitize user input if adding scripts dynamically
4. **Performance**: Use `async` and `defer` attributes appropriately
5. **Testing**: Test analytics tracking in development before deploying

## Troubleshooting

### Scripts Not Appearing

1. Verify `enabled` is set to `true` in config
2. Check that the library is loaded in the layout
3. Ensure the layout file is being used

### Analytics Not Tracking

1. Verify the tracking ID/code is correct
2. Check browser console for JavaScript errors
3. Verify the analytics service is accessible

### Script Conflicts

1. Use unique keys for each script
2. Check for duplicate script loading
3. Verify script load order with `async` and `defer` attributes

## Examples

### Complete Configuration Example

```php
$config['head_scripts'] = [
    // Google Analytics
    'google_analytics' => [
        'enabled' => true,
        'type' => 'analytics',
        'analytics_type' => 'google_analytics',
        'content' => 'G-XXXXXXXXXX',
    ],
    
    // Google Tag Manager
    'gtm' => [
        'enabled' => false, // Disabled for now
        'type' => 'analytics',
        'analytics_type' => 'google_tag_manager',
        'content' => 'GTM-XXXXXX',
    ],
    
    // Theme Color Meta Tag
    'theme_color' => [
        'enabled' => true,
        'type' => 'tag',
        'content' => '<meta name="theme-color" content="#1f2937">',
    ],
    
    // Custom Library
    'custom_lib' => [
        'enabled' => true,
        'type' => 'script',
        'src' => 'https://cdn.example.com/library.min.js',
        'async' => true,
        'attributes' => [
            'integrity' => 'sha384-abc123...',
            'crossorigin' => 'anonymous',
        ],
    ],
    
    // Inline Initialization Script
    'site_init' => [
        'enabled' => true,
        'type' => 'script',
        'content' => 'window.siteConfig = { debug: false };',
        'defer' => true,
    ],
];
```

### Controller Example

```php
<?php
class Home extends BS_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('head_scripts');
    }
    
    public function index()
    {
        // Conditionally add a script
        if ($this->input->get('debug')) {
            add_head_script('debug_console', [
                'src' => 'https://cdn.example.com/debug.js',
                'async' => true,
            ]);
        }
        
        // Add custom tracking
        add_head_analytics('custom_tracker', [
            'type' => 'analytics',
            'analytics_type' => 'custom',
            'content' => 'window.tracker = new Tracker();',
        ]);
        
        $this->template->render('home');
    }
}
```

## Files Modified/Created

- **Created**: `/application/config/head_scripts.php` - Configuration file
- **Created**: `/application/libraries/Head_scripts.php` - Main library
- **Created**: `/application/helpers/head_scripts_helper.php` - Helper functions
- **Modified**: `/application/views/layouts/layout.php` - Added head scripts rendering
- **Modified**: `/application/views/layouts/admin_layout.php` - Added head scripts rendering
