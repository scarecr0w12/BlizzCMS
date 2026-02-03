# Knowledge Base Module - Deployment Guide

**Module Version:** 1.0.0
**Status:** Production Ready
**Last Updated:** February 2, 2026

## Pre-Deployment Checklist

- [x] All PHP files validated (no syntax errors)
- [x] Database migration created and tested
- [x] Controllers fixed for proper model loading
- [x] Views configured with correct paths
- [x] Language files complete
- [x] Helper functions implemented
- [x] Permissions defined
- [x] Documentation complete

## Quick Start (5 Minutes)

### 1. Verify Module Files
```bash
ls -la /var/www/html/application/modules/knowledgebase/
```

Expected structure:
```
knowledgebase/
├── config/
├── controllers/
├── models/
├── views/
├── language/
├── migrations/
├── helpers/
├── README.md
├── INSTALL.md
├── STRUCTURE.md
└── DEPLOYMENT.md
```

### 2. Run Database Migration
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

### 3. Verify Database Tables
```bash
mysql -u root -p your_database << EOF
SHOW TABLES LIKE 'kb_%';
DESCRIBE kb_categories;
DESCRIBE kb_articles;
DESCRIBE kb_tags;
DESCRIBE kb_article_tags;
DESCRIBE kb_comments;
EOF
```

### 4. Configure Admin Permissions
In BlizzCMS Admin Panel:
1. Go to **Users > Roles**
2. Edit **Admin** role
3. Add permission: `knowledgebase.admin`
4. Save

### 5. Access the Module
- **Public:** http://yoursite.com/kb
- **Admin:** http://yoursite.com/kb/admin

## Detailed Deployment Steps

### Step 1: Pre-Flight Checks

**Check file permissions:**
```bash
chmod -R 755 /var/www/html/application/modules/knowledgebase/
chmod -R 644 /var/www/html/application/modules/knowledgebase/*.php
chmod -R 644 /var/www/html/application/modules/knowledgebase/**/*.php
```

**Verify PHP syntax:**
```bash
php -l /var/www/html/application/modules/knowledgebase/config/module.php
php -l /var/www/html/application/modules/knowledgebase/config/migration.php
php -l /var/www/html/application/modules/knowledgebase/config/permissions.php
php -l /var/www/html/application/modules/knowledgebase/models/Knowledgebase_model.php
php -l /var/www/html/application/modules/knowledgebase/controllers/Knowledgebase.php
php -l /var/www/html/application/modules/knowledgebase/controllers/Admin.php
php -l /var/www/html/application/modules/knowledgebase/helpers/knowledgebase_helper.php
```

All should return: `No syntax errors detected`

### Step 2: Database Migration

**Run migration:**
```bash
cd /var/www/html
php index.php migrate --version=20260202000000
```

**Verify tables created:**
```sql
SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES 
WHERE TABLE_SCHEMA = 'your_database' 
AND TABLE_NAME LIKE 'kb_%';
```

Expected tables:
- kb_categories
- kb_articles
- kb_tags
- kb_article_tags
- kb_comments

### Step 3: Module Activation

The module is automatically detected by BlizzCMS. To verify:

1. Clear application cache:
```bash
rm -rf /var/www/html/application/cache/*
```

2. Access admin panel
3. Navigate to **Modules** or **Settings > Modules**
4. Verify "Knowledge Base" appears in the list

### Step 4: Permission Configuration

**Add permissions to admin role:**

In database:
```sql
INSERT INTO permissions (role_id, permission) VALUES 
(1, 'knowledgebase.admin'),
(1, 'knowledgebase.manage_articles'),
(1, 'knowledgebase.manage_categories'),
(1, 'knowledgebase.manage_tags'),
(1, 'knowledgebase.manage_comments');
```

Or via admin panel:
1. Go to **Users > Roles**
2. Click **Admin** role
3. Check these permissions:
   - [ ] knowledgebase.admin
   - [ ] knowledgebase.manage_articles
   - [ ] knowledgebase.manage_categories
   - [ ] knowledgebase.manage_tags
   - [ ] knowledgebase.manage_comments
4. Save

### Step 5: Initial Setup

**Create first category:**
1. Go to http://yoursite.com/kb/admin
2. Click "Categories"
3. Click "Add Category"
4. Fill in:
   - **Name:** Getting Started
   - **Description:** Beginner guides and tutorials
   - **Icon:** fas fa-book
   - **Active:** ✓ Checked
5. Save

**Create first article:**
1. Go to http://yoursite.com/kb/admin
2. Click "Articles"
3. Click "Add Article"
4. Fill in:
   - **Title:** Welcome to Our Knowledge Base
   - **Category:** Getting Started
   - **Content:** Welcome message
   - **Excerpt:** Brief welcome
   - **Published:** ✓ Checked
5. Save

### Step 6: Verify Installation

**Test public access:**
```bash
curl -I http://yoursite.com/kb
# Should return: HTTP/1.1 200 OK
```

**Test admin access:**
```bash
curl -I http://yoursite.com/kb/admin
# Should return: HTTP/1.1 200 OK (if logged in as admin)
```

## Troubleshooting

### 500 Error on /kb

**Check error logs:**
```bash
tail -50 /var/www/html/application/logs/*.log
```

**Common causes:**
1. Model not loading - Verify `knowledgebase/knowledgebase_model` path
2. Helper not loading - Check `knowledgebase/knowledgebase_helper` path
3. View path incorrect - Should be `knowledgebase/public/index`
4. Database tables missing - Run migration again

**Fix:**
```bash
# Clear cache
rm -rf /var/www/html/application/cache/*

# Run migration
php index.php migrate --version=20260202000000

# Check logs
tail -20 /var/www/html/application/logs/*.log
```

### 404 on /kb/admin

**Causes:**
1. Admin not logged in
2. Admin doesn't have permission
3. Routes not loaded

**Fix:**
1. Ensure logged in as admin user
2. Check user has `knowledgebase.admin` permission
3. Clear cache and refresh

### Database Connection Error

**Check database:**
```bash
mysql -u root -p -e "USE your_database; SHOW TABLES LIKE 'kb_%';"
```

**Verify credentials in .env:**
```bash
cat /var/www/html/.env | grep DB_
```

## Post-Deployment

### 1. Create Content Structure

Recommended categories:
- Getting Started
- Features & Guides
- Server Information
- Troubleshooting
- FAQ

### 2. Populate with Articles

Create articles for each category with:
- Clear titles
- Detailed content
- Relevant tags
- Featured images (optional)

### 3. Monitor Performance

**Check article views:**
```sql
SELECT title, views FROM kb_articles ORDER BY views DESC LIMIT 10;
```

**Check pending comments:**
```sql
SELECT COUNT(*) as pending FROM kb_comments WHERE is_approved = 0;
```

### 4. Regular Maintenance

**Weekly:**
- Review pending comments
- Check for broken links in articles
- Monitor article views

**Monthly:**
- Archive old articles
- Update outdated information
- Review search queries

## Rollback Instructions

If you need to remove the module:

### 1. Rollback Migration
```bash
cd /var/www/html
php index.php migrate --version=0
```

### 2. Delete Module Files
```bash
rm -rf /var/www/html/application/modules/knowledgebase/
```

### 3. Clear Cache
```bash
rm -rf /var/www/html/application/cache/*
```

### 4. Verify Removal
```bash
mysql -u root -p -e "USE your_database; SHOW TABLES LIKE 'kb_%';"
# Should return: Empty set
```

## Performance Optimization

### Database Indexes
All tables have proper indexes on:
- Primary keys
- Foreign keys
- Slug fields (for URL lookups)
- Published status (for filtering)

### Caching Recommendations

Add to your caching strategy:
```php
// Cache categories (rarely change)
$categories = $this->cache->get('kb_categories');
if (!$categories) {
    $categories = $this->knowledgebase_model->get_categories();
    $this->cache->save('kb_categories', $categories, 3600);
}

// Cache featured articles (update hourly)
$featured = $this->cache->get('kb_featured_articles');
if (!$featured) {
    $featured = $this->knowledgebase_model->get_featured_articles(6);
    $this->cache->save('kb_featured_articles', $featured, 3600);
}
```

### Query Optimization

The model uses:
- Proper WHERE clauses
- Indexed lookups
- Efficient pagination
- Minimal JOIN operations

## Security Considerations

### 1. Admin Access Control
- Requires `require_admin()` check
- Permission-based access
- Session validation

### 2. Input Validation
- Form validation rules
- XSS prevention via htmlspecialchars()
- SQL injection prevention via prepared statements

### 3. Data Protection
- Cascade delete for referential integrity
- Proper foreign key constraints
- User authentication required for comments

## Monitoring & Logging

### Enable Logging
```php
// In config/config.php
$config['log_threshold'] = 1; // Log everything
$config['log_path'] = APPPATH . 'logs/';
```

### Monitor These Metrics
- Article view counts
- Search query frequency
- Comment submission rate
- Admin action logs

## Support & Documentation

- **README.md** - Feature overview and usage
- **INSTALL.md** - Installation instructions
- **STRUCTURE.md** - Module architecture
- **DEPLOYMENT.md** - This file

## Version History

**v1.0.0** (2026-02-02)
- Initial release
- Categories, articles, tags, comments
- Admin dashboard
- Search functionality
- Responsive design

## Next Steps

1. ✓ Deploy module
2. ✓ Run migration
3. ✓ Configure permissions
4. Create initial content
5. Test all features
6. Train content editors
7. Monitor performance

## Contact & Support

For issues or questions:
1. Check documentation files
2. Review error logs
3. Verify database tables
4. Check file permissions
5. Contact BlizzCMS support

---

**Module Status:** ✓ PRODUCTION READY
**Last Verified:** February 2, 2026
**Deployment Time:** ~5 minutes
