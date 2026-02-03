# Knowledge Base Module for BlizzCMS

A comprehensive knowledge base system for managing server information, features, guides, and FAQs.

## Features

- **Categories**: Organize articles with icons and descriptions
- **Articles**: Rich content with featured images, excerpts, and view tracking
- **Tags**: Color-coded tagging system for better organization
- **Search**: Full-text search across articles
- **Publishing Workflow**: Draft/published status management
- **Comments**: Reader engagement with approval system
- **Admin Dashboard**: Quick statistics and management interface
- **Responsive Design**: Tailwind CSS styling throughout

## Installation

### 1. Database Migration

Run the database migration to create all necessary tables:

```bash
php index.php migrate --version=20260202000000
```

This creates the following tables:
- `kb_categories` - Article categories
- `kb_articles` - Article content
- `kb_tags` - Tag definitions
- `kb_article_tags` - Article-tag relationships
- `kb_comments` - Reader comments

### 2. Module Activation

The module is automatically detected by BlizzCMS. Access the admin panel to activate it.

### 3. Permissions

The following permissions are available:
- `knowledgebase.view` - View knowledge base
- `knowledgebase.comment` - Comment on articles
- `knowledgebase.manage_articles` - Manage articles
- `knowledgebase.manage_categories` - Manage categories
- `knowledgebase.manage_tags` - Manage tags
- `knowledgebase.manage_comments` - Manage comments
- `knowledgebase.admin` - Full admin access

## Usage

### Public Routes

- `/kb` - Knowledge base home
- `/kb/category/{id}` - View category
- `/kb/article/{id}` - View article
- `/kb/search?q={query}` - Search articles

### Admin Routes

- `/kb/admin` - Dashboard
- `/kb/admin/categories` - Manage categories
- `/kb/admin/articles` - Manage articles
- `/kb/admin/tags` - Manage tags

## Database Schema

### kb_categories
```sql
CREATE TABLE kb_categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    icon VARCHAR(255),
    order INT DEFAULT 0,
    is_active TINYINT DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY slug (slug)
);
```

### kb_articles
```sql
CREATE TABLE kb_articles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content LONGTEXT NOT NULL,
    excerpt TEXT,
    featured_image VARCHAR(255),
    author_id INT UNSIGNED,
    views INT DEFAULT 0,
    is_published TINYINT DEFAULT 0,
    is_featured TINYINT DEFAULT 0,
    order INT DEFAULT 0,
    published_at DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY category_id (category_id),
    KEY slug (slug),
    KEY is_published (is_published),
    FOREIGN KEY (category_id) REFERENCES kb_categories(id) ON DELETE CASCADE
);
```

### kb_tags
```sql
CREATE TABLE kb_tags (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    slug VARCHAR(255) NOT NULL UNIQUE,
    color VARCHAR(7) DEFAULT '#6B7280',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    KEY slug (slug)
);
```

### kb_article_tags
```sql
CREATE TABLE kb_article_tags (
    article_id INT UNSIGNED NOT NULL,
    tag_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (article_id, tag_id),
    FOREIGN KEY (article_id) REFERENCES kb_articles(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES kb_tags(id) ON DELETE CASCADE
);
```

### kb_comments
```sql
CREATE TABLE kb_comments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    article_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED,
    author_name VARCHAR(255),
    author_email VARCHAR(255),
    content TEXT NOT NULL,
    is_approved TINYINT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    KEY article_id (article_id),
    KEY user_id (user_id),
    FOREIGN KEY (article_id) REFERENCES kb_articles(id) ON DELETE CASCADE
);
```

## Configuration

### Language Files

Located in `language/english/knowledgebase_lang.php`

All UI strings are translatable and can be customized.

### Routes

Located in `config/routes.php`

Customize URL patterns as needed:
- Public routes: `/kb/*`
- Admin routes: `/kb/admin/*`

## Models

### Knowledgebase_model

Main model for all database operations:

```php
// Get all categories
$categories = $this->knowledgebase_model->get_categories();

// Get published articles
$articles = $this->knowledgebase_model->get_articles($limit, $offset, $filters);

// Get single article
$article = $this->knowledgebase_model->get_article($id);

// Create article
$article_id = $this->knowledgebase_model->create_article($data);

// Update article
$this->knowledgebase_model->update_article($id, $data);

// Delete article
$this->knowledgebase_model->delete_article($id);

// Get article tags
$tags = $this->knowledgebase_model->get_article_tags($article_id);

// Set article tags
$this->knowledgebase_model->set_article_tags($article_id, $tag_ids);
```

## Helpers

### knowledgebase_helper.php

Utility functions for the knowledge base:

```php
// Check if user can manage KB
kb_can_manage();

// Check if user can view KB
kb_can_view();

// Check if user can comment
kb_can_comment();

// Get breadcrumb navigation
kb_get_breadcrumb($category, $article);

// Truncate text
kb_excerpt($text, $length);

// Get related articles
kb_get_related_articles($article_id, $limit);
```

## Controllers

### Knowledgebase.php

Public-facing controller:

- `index()` - Display all articles
- `category($id)` - Display category articles
- `article($id)` - Display single article
- `search()` - Search articles

### Admin.php

Admin controller:

- `index()` - Admin dashboard
- `categories()` - List categories
- `add_category()` - Create category
- `edit_category($id)` - Edit category
- `delete_category($id)` - Delete category
- `articles()` - List articles
- `add_article()` - Create article
- `edit_article($id)` - Edit article
- `delete_article($id)` - Delete article
- `publish_article($id)` - Publish article
- `tags()` - List tags
- `add_tag()` - Create tag
- `edit_tag($id)` - Edit tag
- `delete_tag($id)` - Delete tag

## Troubleshooting

### Migration Issues

If migration fails:

1. Verify database connection
2. Check table prefix in config
3. Ensure proper permissions on database user

### Permission Denied

If you get permission errors:

1. Check user role has `knowledgebase.admin` permission
2. Verify admin status with `is_admin()` function

### Articles Not Showing

1. Verify articles are published (`is_published = 1`)
2. Check category is active (`is_active = 1`)
3. Verify article date is set

## Support

For issues or questions, refer to the BlizzCMS documentation or contact support.

## License

MIT License - See LICENSE file in root directory
