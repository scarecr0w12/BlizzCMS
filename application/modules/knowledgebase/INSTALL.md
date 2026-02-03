# Knowledge Base Module Installation Guide

## Prerequisites

- BlizzCMS 2.0+
- PHP 7.4+
- MySQL 5.7+
- Admin access to BlizzCMS

## Step-by-Step Installation

### Step 1: Extract Module Files

The module files should be in:
```
/application/modules/knowledgebase/
```

Verify the following structure exists:
```
knowledgebase/
├── config/
│   ├── module.php
│   ├── routes.php
│   ├── migration.php
│   └── permissions.php
├── controllers/
│   ├── Knowledgebase.php
│   └── Admin.php
├── models/
│   └── Knowledgebase_model.php
├── views/
│   ├── admin/
│   └── public/
├── language/
│   └── english/
│       └── knowledgebase_lang.php
├── migrations/
│   └── 20260202000000_create_knowledgebase_tables.php
├── helpers/
│   └── knowledgebase_helper.php
└── index.html
```

### Step 2: Run Database Migration

Access your BlizzCMS admin panel and navigate to:
**Settings > Database > Migrations**

Or run via command line:
```bash
cd /var/www/html
php index.php migrate --version=20260202000000
```

Expected output:
```
Migration: 20260202000000_create_knowledgebase_tables
Migrating up...
✓ Migration successful
```

### Step 3: Verify Database Tables

Check that these tables were created:
- `kb_categories`
- `kb_articles`
- `kb_tags`
- `kb_article_tags`
- `kb_comments`

Using MySQL:
```sql
SHOW TABLES LIKE 'kb_%';
```

### Step 4: Configure Permissions

In BlizzCMS admin panel:
1. Go to **Users > Roles**
2. Edit the admin role
3. Add these permissions:
   - `knowledgebase.admin`
   - `knowledgebase.manage_articles`
   - `knowledgebase.manage_categories`
   - `knowledgebase.manage_tags`
   - `knowledgebase.manage_comments`

### Step 5: Access the Module

**Public Knowledge Base:**
```
http://yoursite.com/kb
```

**Admin Dashboard:**
```
http://yoursite.com/kb/admin
```

## Post-Installation

### Create Initial Categories

1. Go to `/kb/admin/categories`
2. Click "Add Category"
3. Fill in:
   - **Name**: e.g., "Getting Started"
   - **Description**: Brief description
   - **Icon**: FontAwesome class (e.g., `fas fa-book`)
   - **Active**: Check to enable

### Create Tags (Optional)

1. Go to `/kb/admin/tags`
2. Click "Add Tag"
3. Fill in:
   - **Name**: e.g., "Beginner", "Advanced"
   - **Color**: Choose a color

### Create First Article

1. Go to `/kb/admin/articles`
2. Click "Add Article"
3. Fill in:
   - **Title**: Article title
   - **Category**: Select category
   - **Content**: Article content (HTML supported)
   - **Excerpt**: Brief summary
   - **Tags**: Select relevant tags
   - **Published**: Check to publish

## Troubleshooting

### Migration Fails

**Error: "Table already exists"**
- Tables may already exist from a previous installation
- Drop tables manually or use a different migration timestamp

**Error: "Foreign key constraint fails"**
- Ensure `kb_categories` table is created before `kb_articles`
- Check database user has ALTER TABLE permissions

### Module Not Appearing

**Module not visible in admin:**
1. Clear application cache: `/application/cache/`
2. Verify `config/module.php` exists
3. Check file permissions (755 for directories, 644 for files)

**Routes not working:**
1. Verify `.htaccess` is present in root
2. Check `config/routes.php` syntax
3. Clear URL routing cache

### Permission Issues

**"Access Denied" error:**
1. Verify user role has `knowledgebase.admin` permission
2. Check `is_admin()` returns true
3. Verify permissions.php is loaded

### Database Connection

**"Unable to connect to database":**
1. Check database credentials in `.env`
2. Verify database user has CREATE TABLE permissions
3. Test connection with: `php index.php dbtest`

## Uninstallation

To remove the module:

### Step 1: Rollback Migration

```bash
php index.php migrate --version=0
```

This will drop all knowledge base tables.

### Step 2: Delete Module Files

```bash
rm -rf /application/modules/knowledgebase/
```

### Step 3: Clear Cache

```bash
rm -rf /application/cache/*
```

## Support

For additional help:
- Check BlizzCMS documentation
- Review module README.md
- Contact BlizzCMS support team

## Version History

**v1.0.0** (2026-02-02)
- Initial release
- Categories, articles, tags, comments
- Admin dashboard
- Search functionality
- Responsive design
