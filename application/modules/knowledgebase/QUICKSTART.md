# Knowledge Base Module - Quick Start Guide

## 30-Second Setup

```bash
# 1. Run migration
cd /var/www/html
php index.php migrate --version=20260202000000

# 2. Clear cache
rm -rf application/cache/*

# 3. Access admin
# Go to: http://yoursite.com/kb/admin
```

## What You Get

✓ **Public Knowledge Base** at `/kb`
- Browse articles by category
- Full-text search
- View tracking
- Comments system

✓ **Admin Dashboard** at `/kb/admin`
- Manage categories
- Create/edit articles
- Tag management
- Comment moderation

## Database Tables Created

| Table | Purpose |
|-------|---------|
| `kb_categories` | Article categories |
| `kb_articles` | Article content |
| `kb_tags` | Tag definitions |
| `kb_article_tags` | Article-tag relationships |
| `kb_comments` | Reader comments |

## File Structure

```
knowledgebase/
├── config/
│   ├── module.php          ← Module metadata
│   ├── routes.php          ← URL routes
│   ├── migration.php       ← Database config
│   └── permissions.php     ← Role permissions
├── controllers/
│   ├── Knowledgebase.php   ← Public pages
│   └── Admin.php           ← Admin pages
├── models/
│   └── Knowledgebase_model.php ← Database operations
├── views/
│   ├── public/             ← Public pages
│   └── admin/              ← Admin pages
├── language/
│   └── english/            ← Translations
├── migrations/
│   └── 20260202000000_*.php ← Database schema
└── helpers/
    └── knowledgebase_helper.php ← Utility functions
```

## Routes

### Public Routes
- `GET /kb` - Knowledge base home
- `GET /kb/category/{id}` - View category
- `GET /kb/article/{id}` - View article
- `GET /kb/search?q={query}` - Search

### Admin Routes
- `GET /kb/admin` - Dashboard
- `GET /kb/admin/categories` - Manage categories
- `GET /kb/admin/articles` - Manage articles
- `GET /kb/admin/tags` - Manage tags

## Permissions

Required for admin access:
- `knowledgebase.admin` - Full admin access
- `knowledgebase.manage_articles` - Create/edit articles
- `knowledgebase.manage_categories` - Create/edit categories
- `knowledgebase.manage_tags` - Create/edit tags
- `knowledgebase.manage_comments` - Moderate comments

## First Steps

1. **Create a category:**
   - Go to `/kb/admin/categories`
   - Click "Add Category"
   - Enter name, description, icon
   - Save

2. **Create an article:**
   - Go to `/kb/admin/articles`
   - Click "Add Article"
   - Fill in title, content, category
   - Publish

3. **View your knowledge base:**
   - Go to `/kb`
   - See your articles displayed

## Common Tasks

### Add a Category
```
/kb/admin/categories/add
- Name: Getting Started
- Description: Beginner guides
- Icon: fas fa-book
- Active: Yes
```

### Create an Article
```
/kb/admin/articles/add
- Title: How to Get Started
- Category: Getting Started
- Content: Your article content
- Excerpt: Brief summary
- Published: Yes
```

### Create a Tag
```
/kb/admin/tags/add
- Name: Beginner
- Color: #3B82F6
```

### Search Articles
```
/kb/search?q=your+search+term
```

## Troubleshooting

**500 Error on /kb**
- Check error logs: `tail application/logs/*.log`
- Clear cache: `rm -rf application/cache/*`
- Verify migration ran: `SHOW TABLES LIKE 'kb_%';`

**404 on /kb/admin**
- Ensure logged in as admin
- Check admin has `knowledgebase.admin` permission
- Clear cache and refresh

**Database error**
- Verify migration completed
- Check database credentials in `.env`
- Ensure tables exist: `SHOW TABLES LIKE 'kb_%';`

## Features

✓ Categories with icons
✓ Articles with featured images
✓ Tag system with colors
✓ Full-text search
✓ Publishing workflow
✓ View tracking
✓ Comment system
✓ Admin dashboard
✓ Responsive design
✓ Permission system

## Documentation

- **README.md** - Full feature documentation
- **INSTALL.md** - Detailed installation guide
- **STRUCTURE.md** - Module architecture
- **DEPLOYMENT.md** - Production deployment guide
- **QUICKSTART.md** - This file

## Support

For detailed information, see:
- Installation: `INSTALL.md`
- Deployment: `DEPLOYMENT.md`
- Architecture: `STRUCTURE.md`
- Features: `README.md`

---

**Status:** ✓ Ready to Deploy
**Time to Setup:** ~5 minutes
**Database Tables:** 5
**Controllers:** 2
**Models:** 1
**Views:** 14
