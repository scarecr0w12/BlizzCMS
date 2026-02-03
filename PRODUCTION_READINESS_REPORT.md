# BlizzCMS Production Readiness Report

**Generated**: 2026-02-01  
**Domain**: oldmanwarcraft.com  
**Framework**: CodeIgniter 3  
**Web Server**: Apache2 with PHP-FPM (8.3)  
**Database**: MySQL/MariaDB

---

## ✅ Completed Setup Items

### Environment Configuration
- [x] Created `.env` file with environment variable structure
- [x] Updated `application/config/database.php` to use environment variables
- [x] Database configuration supports both CMS and AzerothCore auth databases

### Web Server
- [x] Apache2 is running and enabled
- [x] Virtual hosts configured for oldmanwarcraft.com
- [x] HTTP to HTTPS redirect in place
- [x] Required Apache modules enabled:
  - rewrite_module ✓
  - ssl_module ✓
  - headers_module ✓
  - proxy_module ✓
  - proxy_fcgi_module ✓

### PHP Configuration
- [x] PHP 8.3.6 installed and running
- [x] PHP-FPM service running (php8.3-fpm)
- [x] Required PHP extensions installed:
  - mysqli ✓
  - curl ✓
  - gd ✓
  - openssl ✓
- [x] OPcache enabled for performance

### SSL/TLS
- [x] Let's Encrypt certificate installed
- [x] Certificate valid until: May 1, 2026
- [x] Certbot auto-renewal timer configured
- [x] HSTS header configured for HTTPS

### Application Code
- [x] Environment set to 'production' in index.php
- [x] Error reporting disabled for production
- [x] .htaccess configured for URL rewriting
- [x] Security headers configured in Apache

---

## ⚠️ Issues Identified & Actions Required

### 1. **PHP Memory Limit**
**Status**: CRITICAL  
**Issue**: PHP memory exhaustion (128MB limit too low)  
**Action Required**:
```bash
# Edit PHP-FPM configuration
sudo nano /etc/php/8.3/fpm/php.ini
# Find: memory_limit = 128M
# Change to: memory_limit = 256M
# Then restart PHP-FPM:
sudo systemctl restart php8.3-fpm
```

### 2. **SSL Certificate Warning**
**Status**: WARNING  
**Issue**: Certificate shows CA flag warning (BasicConstraints: CA == TRUE)  
**Action Required**:
- The certificate is still valid and functional
- Monitor for renewal issues
- If renewal fails, re-issue certificate:
```bash
sudo certbot revoke --cert-path /etc/letsencrypt/live/oldmanwarcraft.com/cert.pem
sudo certbot certonly --apache -d oldmanwarcraft.com -d www.oldmanwarcraft.com
```

### 3. **File Permissions**
**Status**: NEEDS ATTENTION  
**Current**: Root ownership on /var/www/html  
**Action Required**:
```bash
# Set correct ownership for web server
sudo chown -R www-data:www-data /var/www/html

# Set correct permissions
sudo chmod 755 /var/www/html
sudo chmod 644 /var/www/html/*.php
sudo chmod 755 /var/www/html/application
sudo chmod 755 /var/www/html/uploads

# Ensure .env is not world-readable
sudo chmod 600 /var/www/html/.env
```

### 4. **Database Credentials**
**Status**: REQUIRES USER INPUT  
**Action Required**:
```bash
# Edit .env file with actual credentials
sudo nano /var/www/html/.env

# Update these values:
MYSQL_USER=blizzcms
MYSQL_PASS=your_strong_password_here
MYSQL_DB=blizzcms

AUTH_DB_HOST=localhost
AUTH_DB_USER=acore
AUTH_DB_PASS=your_acore_password_here
AUTH_DB_NAME=acore_auth
```

### 5. **MySQL Database Setup**
**Status**: REQUIRES USER INPUT  
**Action Required**:
```sql
-- Connect to MySQL as root
mysql -u root -p

-- Create BlizzCMS database and user
CREATE DATABASE blizzcms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'blizzcms'@'localhost' IDENTIFIED BY 'your_strong_password_here';
GRANT ALL PRIVILEGES ON blizzcms.* TO 'blizzcms'@'localhost';

-- If using AzerothCore auth on same server
-- (verify these users/databases exist)
-- GRANT SELECT ON acore_auth.* TO 'blizzcms'@'localhost';

FLUSH PRIVILEGES;
EXIT;
```

### 6. **Application Initialization**
**Status**: REQUIRES USER INPUT  
**Action Required**:
- Run any database migrations or initialization scripts
- Verify application loads without errors
- Test database connectivity

---

## 📋 Pre-Production Verification Checklist

### Database
- [ ] MySQL/MariaDB is running and accessible
- [ ] BlizzCMS database created with correct charset
- [ ] Database user created with proper permissions
- [ ] AzerothCore auth database accessible (if on same server)
- [ ] Database credentials in `.env` are correct
- [ ] Application can connect to both databases

### File System
- [ ] `/var/www/html` owned by www-data:www-data
- [ ] `.env` file exists with production credentials
- [ ] `.env` file is not world-readable (chmod 600)
- [ ] `uploads/` directory is writable by www-data
- [ ] `application/` directory is readable by www-data

### Web Server
- [ ] Apache configuration test passes: `apache2ctl configtest`
- [ ] Both HTTP and HTTPS virtual hosts enabled
- [ ] HTTP to HTTPS redirect working
- [ ] SSL certificate valid and not expired

### PHP
- [ ] PHP memory limit set to at least 256M
- [ ] PHP-FPM socket exists and has correct permissions
- [ ] All required PHP extensions loaded
- [ ] Error logging configured (not displaying to users)

### Application
- [ ] Application loads without 500 errors
- [ ] Database queries execute successfully
- [ ] User authentication works (if applicable)
- [ ] All pages load and render correctly
- [ ] Forms submit and process data correctly

### Security
- [ ] `.env` file is in `.gitignore`
- [ ] Sensitive files not accessible via web
- [ ] Security headers present in responses
- [ ] HTTPS redirect working
- [ ] SSL certificate valid

### Monitoring
- [ ] Error logs configured and monitored
- [ ] Access logs being recorded
- [ ] Log rotation configured
- [ ] Uptime monitoring in place (optional)

---

## 🔧 Quick Setup Commands

```bash
# 1. Update PHP memory limit
sudo sed -i 's/memory_limit = 128M/memory_limit = 256M/' /etc/php/8.3/fpm/php.ini

# 2. Fix file permissions
sudo chown -R www-data:www-data /var/www/html
sudo chmod 755 /var/www/html
sudo chmod 600 /var/www/html/.env

# 3. Restart services
sudo systemctl restart php8.3-fpm
sudo systemctl restart apache2

# 4. Verify configuration
apache2ctl configtest
php -v
systemctl status php8.3-fpm --no-pager
systemctl status apache2 --no-pager

# 5. Test application
curl -I https://oldmanwarcraft.com
```

---

## 📝 Next Steps

1. **Update `.env` file** with actual database credentials
2. **Create MySQL database and user** with provided SQL commands
3. **Fix file permissions** using the commands above
4. **Increase PHP memory limit** to 256M
5. **Restart services** to apply changes
6. **Test application** by accessing https://oldmanwarcraft.com
7. **Monitor error logs** for any issues
8. **Run through verification checklist** before going live

---

## 📞 Support Resources

- **Apache Documentation**: https://httpd.apache.org/docs/2.4/
- **PHP-FPM Documentation**: https://www.php.net/manual/en/install.fpm.php
- **Let's Encrypt**: https://letsencrypt.org/
- **CodeIgniter 3**: https://codeigniter.com/userguide3/
- **MySQL Documentation**: https://dev.mysql.com/doc/

---

## 🔐 Security Reminders

- Keep `.env` file secure and never commit to version control
- Use strong, unique passwords for database users
- Regularly update system packages and PHP
- Monitor error logs for suspicious activity
- Set up automated backups for the database
- Keep SSL certificates renewed (auto-renewal via Certbot)
- Implement rate limiting if experiencing abuse
