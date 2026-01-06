# BlizzCMS Copilot Instructions

## Architecture Overview

BlizzCMS is a CodeIgniter 3-based CMS for World of Warcraft private server communities, extended with **HMVC (Hierarchical MVC)** via the MX (Modular Extensions) library.

### Core Components
- **Base Controllers**: `BS_Controller` (public) and `Admin_Controller` (admin panel) in [application/core/BS_Controller.php](application/core/BS_Controller.php)
- **Base Model**: `BS_Model` with auto-timestamps (`$setCreatedField`, `$setUpdatedField`) in [application/core/BS_Model.php](application/core/BS_Model.php)
- **Template Library**: Handles theming, layouts, partials, SEO meta via `$this->template->build('view', $data)`
- **Multilanguage**: Browser detection, session-based language switching in [application/libraries/Multilanguage.php](application/libraries/Multilanguage.php)

### Database Structure
- **CMS database** (`$db['cms']`): Application data (users, settings, modules)
- **Auth database** (`$db['auth']`): Game server authentication (WoW emulator)
- Configured in [application/config/database.php](application/config/database.php)

## Key Conventions

### Controller Patterns
```php
// Public controller - extend BS_Controller
class MyController extends BS_Controller {
    public function __construct() {
        parent::__construct();
        require_login();  // Require authentication
        $this->load->language('mymodule');
    }
}

// Admin controller - extend Admin_Controller (auto-loads admin layout)
class Admin extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        require_permission('view.myfeature', 'modulename');
    }
}
```

### Model Patterns
Models extend `BS_Model` and define `$table`. Override `insert()`/`update()` only when adding custom logic (e.g., password hashing in `User_model`).

### Permission System
- Use `require_permission('action.resource', 'module')` in controllers to enforce access
- Use `has_permission('action.resource', 'module')` in views for conditional display
- Special contexts: `:base:` for core features, `:page:` for custom pages

### View Rendering
```php
$this->template->title('Page Title', config_item('app_name'));
$this->template->set_seo_metas(['title' => '...', 'robots' => '...']);
$this->template->build('view_name', $data);
```

## Module System (HMVC)

Modules live in `application/modules/{name}/` with structure:
```
modules/mymodule/
├── config/routes.php    # Module routes (prefixed with module name)
├── controllers/         # Module controllers
├── language/           # Module translations
├── views/              # Module views
```

Check module installation: `is_module_installed('modulename', $showError = false)`

## Routing Conventions

Routes in [application/config/routes.php](application/config/routes.php) and module-specific `config/routes.php`:
- Use method constraints: `$route['path']['get']`, `$route['path']['post']`
- Admin routes: `admin/{feature}/{action}/(:num)`
- Module routes auto-prefixed with module name

## Helper Functions

Key helpers in `application/helpers/`:
- `is_logged_in()`, `require_login()`, `require_guest()` - Auth guards
- `user($column, $id)`, `user_avatar($id)` - User data access
- `current_date($format)`, `locate_date($date, $pattern)` - Datetime handling
- `config_item('key')` - Settings from database/config

## Language Files

Structure: `application/language/{lang}/` with files like `general_lang.php`, `form_validation_lang.php`
- Access: `lang('key')` or `lang_vars('key', [$var1])`
- Module languages: `application/modules/{name}/language/{lang}/`

## Development Setup

```bash
# Docker environment
docker-compose up -d

# Access points (configure .env)
# - Web: http://localhost:${APP_PORT}
# - phpMyAdmin: http://localhost:8080
```

## Form Validation

Use CI3 form validation with callback support:
```php
$this->form_validation->set_rules('field', lang('label'), 'trim|required|callback_custom_check');
// Callbacks work due to: $this->form_validation->CI =& $this; in BS_Controller
```

## Migrations

Migrations in `application/migrations/` use format `YYYYMMDDHHMMSS_description.php`. Run via admin panel or CLI.
