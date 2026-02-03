# BlizzCMS Production Setup Checklist

## Environment Configuration
- [ ] Update `.env` file with actual database credentials
  - `MYSQL_USER`: Database user for BlizzCMS
  - `MYSQL_PASS`: Strong password for BlizzCMS database
  - `MYSQL_DB`: Database name (default: blizzcms)
  - `AUTH_DB_HOST`: AzerothCore auth database host (localhost for same server)
  - `AUTH_DB_USER`: AzerothCore auth database user
  - `AUTH_DB_PASS`: AzerothCore auth database password
  - `AUTH_DB_NAME`: AzerothCore auth database name (default: acore_auth)

## Database Setup
- [ ] Create MySQL database and user for BlizzCMS
  ```sql
  CREATE DATABASE blizzcms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  CREATE USER 'blizzcms'@'localhost' IDENTIFIED BY 'your_strong_password';
  GRANT ALL PRIVILEGES ON blizzcms.* TO 'blizzcms'@'localhost';
  FLUSH PRIVILEGES;
  ```
- [ ] Ensure AzerothCore auth database is accessible and credentials are correct
- [ ] Run database migrations/initialization if needed
- [ ] Verify database connectivity from application

## File Permissions
- [ ] Set correct ownership: `chown -R www-data:www-data /var/www/html`
- [ ] Set correct permissions on directories: `chmod 755 /var/www/html`
- [ ] Set correct permissions on files: `chmod 644 /var/www/html/**/*.php`
- [ ] Ensure `uploads/` directory is writable: `chmod 775 /var/www/html/uploads`
- [ ] Ensure `application/` directory is readable by www-data

## Apache2 Configuration
- [ ] Verify virtual hosts are enabled:
  ```bash
  a2ensite oldmanwarcraft.com.conf
  a2ensite oldmanwarcraft.com-ssl.conf
  ```
- [ ] Enable required Apache modules:
  ```bash
  a2enmod rewrite
  a2enmod ssl
  a2enmod headers
  a2enmod proxy
  a2enmod proxy_fcgi
  ```
- [ ] Test Apache configuration: `apache2ctl configtest`
- [ ] Restart Apache: `systemctl restart apache2`

## PHP-FPM Configuration
- [ ] Verify PHP-FPM is running: `systemctl status php8.3-fpm`
- [ ] Check PHP-FPM socket exists: `ls -la /run/php/php8.3-fpm.sock`
- [ ] Verify socket permissions allow Apache access
- [ ] Check PHP version: `php -v`
- [ ] Verify required PHP extensions are installed:
  - mysqli (for database)
  - curl (for HTTP requests)
  - gd (for image processing)
  - openssl (for encryption)

## SSL/TLS Configuration
- [ ] Verify SSL certificates exist:
  ```bash
  ls -la /etc/letsencrypt/live/oldmanwarcraft.com/
  ```
- [ ] Test SSL configuration: `openssl s_client -connect oldmanwarcraft.com:443`
- [ ] Verify HTTP to HTTPS redirect is working
- [ ] Check SSL certificate expiration: `certbot certificates`
- [ ] Set up auto-renewal: `systemctl enable certbot.timer`

## Application Configuration
- [ ] Verify `index.php` has `ENVIRONMENT` set to `production`
- [ ] Check `.htaccess` is properly configured for URL rewriting
- [ ] Verify `application/config/config.php` base URL is correct
- [ ] Ensure error logging is configured (not displaying errors to users)
- [ ] Check that sensitive files are not accessible via web:
  - `.env` file should not be web-accessible
  - `application/` directory should not be directly accessible

## Security Hardening
- [ ] Verify security headers in Apache config:
  - X-Frame-Options: SAMEORIGIN
  - X-Content-Type-Options: nosniff
  - X-XSS-Protection: 1; mode=block
  - Referrer-Policy: strict-origin-when-cross-origin
  - Strict-Transport-Security (HSTS) on HTTPS
- [ ] Disable directory listing in `.htaccess`
- [ ] Protect `.htaccess` files from direct access
- [ ] Ensure `.env` file is in `.gitignore`
- [ ] Set strong database passwords
- [ ] Disable PHP execution in upload directory (if applicable)

## Testing & Verification
- [ ] Test application loads at https://oldmanwarcraft.com
- [ ] Verify database connectivity works
- [ ] Test user authentication (if applicable)
- [ ] Check error logs for issues:
  ```bash
  tail -f /var/log/apache2/oldmanwarcraft.com-error.log
  tail -f /var/log/apache2/oldmanwarcraft.com-access.log
  ```
- [ ] Verify all pages load correctly
- [ ] Test form submissions and database operations
- [ ] Check browser console for JavaScript errors
- [ ] Verify SSL certificate is valid (no warnings)

## Monitoring & Maintenance
- [ ] Set up log rotation for Apache logs
- [ ] Monitor disk space and database size
- [ ] Set up automated backups for database
- [ ] Monitor PHP-FPM performance
- [ ] Set up uptime monitoring
- [ ] Plan for SSL certificate renewal (auto-renewal via Certbot)

## Performance Optimization (Optional)
- [ ] Enable PHP opcode caching (OPcache)
- [ ] Configure database connection pooling if needed
- [ ] Set up caching headers for static assets
- [ ] Consider CDN for static content
- [ ] Monitor and optimize slow queries

## Deployment Notes
- **Domain**: oldmanwarcraft.com
- **Web Root**: /var/www/html
- **Web Server**: Apache2 with PHP-FPM (php8.3)
- **Database**: MySQL/MariaDB on localhost
- **SSL**: Let's Encrypt (auto-renewed via Certbot)
- **Framework**: CodeIgniter 3
