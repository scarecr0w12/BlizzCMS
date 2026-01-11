# BlizzCMS Copilot Instructions

## Architecture Overview

BlizzCMS is a **CodeIgniter 3 CMS** with **HMVC** (Modular Extensions/MX library) for WoW private server communities.

### Core Layers
- **Core classes** (`application/core/`): `BS_Controller`, `Admin_Controller`, `BS_Model` - extend these, never CI base classes
- **Modules** (`application/modules/{name}/`): Self-contained features (shop, vote, donate, user, armory)
- **Dual database**: `$db['cms']` (app data) + `$db['auth']` (WoW emulator auth)

## Controller Patterns

```php
// Public pages - extend BS_Controller
class MyController extends BS_Controller {
    public function __construct() {
        parent::__construct();
        require_login();                    // Auth guard
        $this->load->language('mymodule');  // Load translations
    }
}

// Admin panel - extend Admin_Controller (auto-sets admin layout)
class Admin extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        require_permission('view.shop', 'shop');  // Permission check first
        $this->load->model(['shop/shop_model']);  // Module models use path prefix
    }
}
```

## Permission System

Permission keys follow `action.resource` pattern with module context:
```php
// Controllers - blocks access with 403
require_permission('view.shop', 'shop');
require_permission('edit.vote', 'vote');
require_permission('delete.newscomments', ':base:');  // Core feature

// Views - conditional display
<?php if (has_permission('edit.newscomments', ':base:')): ?>
```
Special modules: `:base:` (core), `:page:` (custom pages), `:menu-item:` (menus)

## Model Conventions

```php
class Item_model extends BS_Model {
    protected $table = 'items';
    protected $setCreatedField = true;  // Auto-fills created_at on insert
    protected $setUpdatedField = true;  // Auto-fills updated_at on update
}
```
Override `insert()`/`update()` only for custom logic (see `User_model` for password hashing example).

## Module Structure

```
application/modules/shop/
├── config/routes.php    # Routes auto-prefixed: 'shop/cart' → shop/cart
├── controllers/
│   ├── Shop.php         # Public controller (default)
│   └── Admin.php        # Admin panel (convention: class Admin)
├── models/              # Module-specific models
├── language/english/    # Module translations
├── migrations/          # Module-specific migrations
└── views/
```
Check module status: `is_module_installed('shop', $showError = false)`

## Routing

Routes support HTTP method constraints:
```php
$route['shop/cart']['get'] = 'shop/cart';
$route['shop/cart/add']['post'] = 'shop/add_to_cart';
$route['shop/admin/items/edit/(:num)']['get'] = 'admin/edit_item/$1';
```

## View Rendering

```php
$this->template->title('Page Title', config_item('app_name'));
$this->template->build('view_name', ['items' => $items]);  // Renders with layout
```

## Key Helpers

```php
// Auth (application/helpers/base_helper.php)
is_logged_in(), require_login(), require_guest()
user('column'), user('column', $user_id), user_avatar($id)

// Dates (application/helpers/extra_helper.php)
current_date('Y-m-d H:i:s')  // Auto-used by BS_Model timestamps
locate_date($date, lang('datetime_pattern'))  // Localized display

// Settings
config_item('app_name')  // From database settings table
```

## Development

```bash
docker-compose up -d    # Start environment
# Web: http://localhost (via nginx)
# phpMyAdmin: http://localhost:${APP_DB_ADMIN_PORT}
```

## Migrations

Format: `YYYYMMDDHHMMSS_description.php` in `application/migrations/` or `application/modules/{name}/migrations/`

## Form Validation

Callback methods work due to `$this->form_validation->CI =& $this;` in BS_Controller:
```php
$this->form_validation->set_rules('field', lang('label'), 'trim|required|callback_my_check');
```
