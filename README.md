# BlizzCMS - World of Warcraft Private Server Management System

**Current Version:** 3.0  
**Last Updated:** January 11, 2026  
**Status:** ✅ Production Ready

---

## 🎯 Overview

BlizzCMS is a comprehensive content management system designed specifically for World of Warcraft private servers. It provides a complete suite of tools for server management, player engagement, and community building.

### What's Included

- **Server Management** - Real-time server status, player statistics, and monitoring
- **Leaderboards** - PvP, Honor, Arena, Achievements, Professions, Guilds, and Firsts
- **Shop System** - Item sales, character services, payments via PayPal & Stripe
- **Social Features** - Friends, messaging, guilds, activity feed, and profiles
- **Events Calendar** - Event creation, RSVP management, and reminders
- **Notifications** - In-app, email, and browser push notifications
- **Enhanced Profiles** - User profiles with timelines, achievements, and visitor tracking
- **REST API** - 30+ endpoints for third-party integrations
- **Discord Integration** - OAuth login and account linking

---

## 🚀 Quick Start

### 1. Installation

```bash
cd /home/scarecrow/BlizzCMS
composer install
php index.php migrate
```

### 2. Configuration

Edit `/application/config/config.php` and set:
- Database credentials
- Character database connection
- API keys (PayPal, Stripe, Discord)

### 3. Enable Modules

1. Login to admin panel
2. Go to **Modules**
3. Enable desired modules

### 4. Add Menu Items

Add navigation links to your theme for:
- `/serverstatus` - Server Status
- `/leaderboards` - Leaderboards
- `/shop` - Shop
- `/social` - Social Features
- `/events` - Events Calendar
- `/profile` - User Profiles

---

## 📦 Core Modules

### Phase 1: Foundation (Complete ✅)

#### Server Status Dashboard
- Real-time player counts and statistics
- Faction balance visualization
- Class and level distribution charts
- Peak player tracking
- Uptime monitoring

**Access:** `/serverstatus`

#### Leaderboards System
- PvP kill rankings
- Honor point rankings
- Arena team ratings (2v2, 3v3, 5v5)
- Achievement leaderboards
- Profession rankings
- Guild rankings
- Server firsts tracking

**Access:** `/leaderboards`

#### Discord Integration
- OAuth2 secure login
- Account linking system
- Discord widget embed
- Webhook notifications
- Event automation

**Access:** `/discord`

---

### Phase 2: Engagement (Complete ✅)

#### Notifications System
- In-app notification center
- Email notifications
- Browser push notifications
- User notification preferences
- Unread count tracking
- Admin bulk notification sending

**Access:** `/notifications`

#### Events Calendar
- Event creation and management
- Calendar grid view
- RSVP system with status tracking
- Event search and filtering
- Featured events
- Event reminders
- Multi-realm support

**Access:** `/events`

---

### Phase 3: Enhancement (Complete ✅)

#### Shop Enhanced
- Wishlist management
- Shopping cart system
- Item comparison (up to 5 items)
- Reviews & ratings (1-5 stars)
- View tracking and trending
- Admin statistics dashboard

**Access:** `/shop`

#### Profile Enhanced
- User profile pages with customization
- Activity timeline
- Achievement showcase
- Character gallery
- Profile visitor tracking
- Privacy controls
- User statistics

**Access:** `/profile/{username}`

#### REST API
- JWT authentication
- 30+ API endpoints
- Rate limiting and throttling
- CORS support
- Comprehensive error handling
- Request logging and monitoring
- Webhook support

**Access:** `/api/v1/`

---

### Social Features (Complete ✅)

- Friends management (add, accept, remove)
- Private messaging system
- Guild browsing and member viewing
- Social activity feed
- User search and profiles
- Admin settings panel

**Access:** `/social`

---

## ⚙️ Configuration Guide

### Database Setup

Configure your character database connection in `/application/config/config.php`:

```php
$config['character_db'] = array(
    'dsn' => 'mysql:host=localhost;dbname=characters',
    'username' => 'root',
    'password' => 'password',
    'driver' => 'pdo'
);
```

### Payment Gateway Setup

#### PayPal
```php
$config['paypal_mode'] = 'sandbox'; // or 'production'
$config['paypal_client_id'] = 'YOUR_CLIENT_ID';
$config['paypal_secret'] = 'YOUR_SECRET';
```

#### Stripe
```php
$config['stripe_public_key'] = 'pk_test_YOUR_KEY';
$config['stripe_secret_key'] = 'sk_test_YOUR_KEY';
```

#### Discord OAuth
```php
$config['discord_client_id'] = 'YOUR_CLIENT_ID';
$config['discord_client_secret'] = 'YOUR_SECRET';
$config['discord_redirect_uri'] = 'https://yoursite.com/discord/callback';
```

### Email Configuration

For notifications and event reminders:

```php
$config['email_protocol'] = 'smtp';
$config['email_smtp_host'] = 'smtp.gmail.com';
$config['email_smtp_port'] = 587;
$config['email_smtp_user'] = 'your-email@gmail.com';
$config['email_smtp_pass'] = 'your-app-password';
```

---

## 📚 Documentation

### Setup Guides
- `PHASE1_SETUP_GUIDE.md` - Server Status, Leaderboards, Discord
- `SHOP_PAYMENT_SETUP_GUIDE.md` - Shop and payment gateway configuration
- `PHASE2_SETUP_GUIDE.md` - Notifications and Events Calendar
- `PHASE3_SETUP_GUIDE.md` - Shop Enhanced, Profiles, REST API

### Module Documentation
- `application/modules/social/README.md` - Social features
- `application/modules/playermap/README.md` - Player map module

### Completion Summaries
- `PHASE1_AND_SHOP_COMPLETION_SUMMARY.md` - Phase 1 and Shop implementation details
- `PHASE2_COMPLETION_SUMMARY.md` - Notifications and Events implementation
- `PHASE3_COMPLETION_SUMMARY.md` - Shop Enhanced, Profiles, and API implementation

---

## 🔌 API Endpoints

### Authentication
- `POST /api/v1/auth/login` - Get JWT token
- `POST /api/v1/auth/token` - Long-lived token
- `POST /api/v1/auth/logout` - Logout

### Notifications
- `GET /api/v1/notifications` - List notifications
- `GET /api/v1/notifications/unread` - Get unread count
- `GET /api/v1/notifications/{id}` - Get single notification
- `POST /api/v1/notifications/{id}/read` - Mark as read
- `POST /api/v1/notifications/read-all` - Mark all as read
- `DELETE /api/v1/notifications/{id}` - Delete notification

### Events
- `GET /api/v1/events` - List events
- `GET /api/v1/events/upcoming` - Upcoming events
- `GET /api/v1/events/{id}` - Event details
- `POST /api/v1/events/{id}/rsvp` - Create RSVP
- `PUT /api/v1/events/{id}/rsvp` - Update RSVP
- `DELETE /api/v1/events/{id}/rsvp` - Cancel RSVP

### Leaderboards
- `GET /api/v1/leaderboards/pvp` - PvP rankings
- `GET /api/v1/leaderboards/honor` - Honor rankings
- `GET /api/v1/leaderboards/arena` - Arena rankings
- `GET /api/v1/leaderboards/achievements` - Achievement rankings
- `GET /api/v1/leaderboards/guilds` - Guild rankings

### Server Status
- `GET /api/v1/server/status` - Server status
- `GET /api/v1/server/players` - Player statistics
- `GET /api/v1/server/statistics` - Detailed statistics

### Shop
- `GET /api/v1/shop/items` - List items
- `GET /api/v1/shop/items/{id}` - Item details
- `GET /api/v1/shop/wishlist` - User wishlist
- `POST /api/v1/shop/wishlist` - Add to wishlist
- `DELETE /api/v1/shop/wishlist/{id}` - Remove from wishlist
- `GET /api/v1/shop/cart` - User cart
- `POST /api/v1/shop/cart` - Add to cart
- `PUT /api/v1/shop/cart/{id}` - Update cart item
- `DELETE /api/v1/shop/cart/{id}` - Remove from cart

### Profiles
- `GET /api/v1/profile/{username}` - User profile
- `GET /api/v1/profile/{username}/timeline` - User timeline
- `GET /api/v1/profile/{username}/achievements` - User achievements
- `GET /api/v1/profile/{username}/characters` - User characters
- `GET /api/v1/profile/{username}/visitors` - Profile visitors

### Search
- `GET /api/v1/search` - Global search
- `GET /api/v1/search/characters` - Character search
- `GET /api/v1/search/guilds` - Guild search
- `GET /api/v1/search/items` - Item search

---

## 🔐 Security Features

- JWT token-based API authentication
- CSRF protection on all forms
- SQL injection prevention (prepared statements)
- Input validation and sanitization
- Rate limiting and throttling
- CORS validation
- User ownership verification
- Permission-based access control
- Secure password hashing
- HTTPS enforcement for sensitive operations

---

## 📊 Database Schema

### Core Tables
- `users` - User accounts
- `characters` - Character data
- `guilds` - Guild information
- `orders` - Shop orders
- `cart_items` - Shopping cart

### Feature Tables
- `notifications` - User notifications
- `notification_preferences` - User notification settings
- `events` - Event calendar
- `event_rsvps` - Event RSVPs
- `user_friends` - Friend relationships
- `user_messages` - Private messages
- `user_activities` - Activity feed
- `profile_enhanced` - Enhanced profile data
- `profile_timeline` - User timeline
- `profile_visitors` - Profile visitor tracking
- `shop_wishlists` - Wishlist items
- `shop_reviews` - Item reviews
- `shop_views` - Item view tracking
- `api_tokens` - JWT tokens
- `api_logs` - API request logs

---

## 🧪 Testing

### Manual Testing Checklist

- [ ] All modules visible in admin panel
- [ ] Database migrations completed
- [ ] Server status displays player counts
- [ ] Leaderboards show data from character database
- [ ] Shop checkout completes successfully
- [ ] Notifications send and display correctly
- [ ] Events calendar displays and RSVP works
- [ ] User profiles display with timeline
- [ ] API endpoints respond with correct data
- [ ] Discord OAuth login works
- [ ] Email notifications send (if configured)

### API Testing

Use tools like Postman or cURL to test endpoints:

```bash
# Get JWT token
curl -X POST http://yoursite.com/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"username":"user","password":"pass"}'

# Get notifications
curl -X GET http://yoursite.com/api/v1/notifications \
  -H "Authorization: Bearer YOUR_JWT_TOKEN"
```

---

## 🐛 Troubleshooting

### Common Issues

**Leaderboards show "No data available"**
- Ensure character database is configured correctly
- Add at least one realm in Admin > Realms
- Verify character database has players with level >= 70

**Shop checkout fails**
- Verify PayPal/Stripe API credentials are correct
- Check that HTTPS is enabled
- Review error logs in `/application/logs/`

**Notifications not sending**
- Verify email configuration in config.php
- Check that SMTP credentials are correct
- Review notification settings in admin panel

**API endpoints return 401 Unauthorized**
- Verify JWT token is valid
- Check token expiration
- Ensure Authorization header is set correctly

### Debug Mode

Enable debug mode in `/application/config/config.php`:

```php
define('ENVIRONMENT', 'development');
```

This will display detailed error messages and log all errors to `/application/logs/`.

---

## 📈 Performance Optimization

### Database Optimization
- Ensure all tables have proper indexes
- Run `OPTIMIZE TABLE` periodically
- Monitor slow query log

### Caching
- Enable query result caching
- Use Redis for session storage
- Cache API responses when appropriate

### Server Configuration
- Enable gzip compression
- Use CDN for static assets
- Configure proper cache headers
- Enable opcache for PHP

---

## 🔄 Maintenance

### Regular Tasks
- Monitor error logs weekly
- Review API logs for suspicious activity
- Update dependencies monthly
- Backup database daily
- Test disaster recovery procedures

### Database Maintenance
```bash
# Optimize all tables
php index.php optimize_database

# Cleanup old logs
php index.php cleanup_logs

# Verify database integrity
php index.php verify_database
```

---

## 📝 Changelog

See `CHANGELOG.md` for detailed version history and updates.

---

## 🤝 Support

For issues, questions, or feature requests:

1. Check the relevant setup guide
2. Review module documentation
3. Check error logs in `/application/logs/`
4. Review API documentation for endpoint-specific issues

---

## 📄 License

BlizzCMS is provided as-is for private server use. Ensure compliance with World of Warcraft terms of service.

---

## 🎉 Features Summary

### ✅ Complete & Production Ready
- Server Status Dashboard
- Leaderboards System (7 types)
- Shop with Payment Gateways
- Notifications System
- Events Calendar
- Social Features
- Enhanced Profiles
- REST API (30+ endpoints)
- Discord Integration

### 🔧 Fully Configurable
- Module enable/disable
- Payment gateway selection
- Email configuration
- API rate limiting
- CORS settings
- Notification preferences

### 🛡️ Security First
- JWT authentication
- CSRF protection
- Input validation
- Rate limiting
- Permission checks
- Secure API endpoints

### 📱 Responsive Design
- Mobile-friendly interfaces
- Bootstrap 4+ styling
- Font Awesome icons
- Adaptive layouts

---

**Ready to get started?** Check the setup guides in the documentation folder!

**Version 3.0** - January 11, 2026
