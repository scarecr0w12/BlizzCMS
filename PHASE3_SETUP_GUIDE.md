# Phase 3 Complete Setup Guide

This guide walks you through setting up Phase 3 modules: Shop Enhanced, Profile Enhanced, and REST API.

---

## Phase 3 Overview

**Phase 3 focuses on advanced features:**
1. **Shop Enhanced** - Wishlist, cart, comparison, reviews, view tracking
2. **Profile Enhanced** - Timeline, achievements, customization, visit tracking
3. **REST API** - 30+ endpoints with JWT authentication

---

## Part 1: Shop Enhanced Setup

### Step 1: Enable Shop Enhanced Module

1. Login to Admin Panel
2. Navigate to **Admin > Modules**
3. Find **Shop Enhanced**
4. Click **Enable**

### Step 2: Configure Shop Enhanced Settings

1. Admin Panel > **Shop Enhanced > Settings**
2. Configure:
   - **Enable Wishlist:** Toggle ON
   - **Enable Shopping Cart:** Toggle ON
   - **Enable Reviews:** Toggle ON
   - **Enable Item Comparison:** Toggle ON
   - **Enable Item Preview:** Toggle ON
   - **Max Cart Items:** Maximum items in cart (default 50)
   - **Max Wishlist Items:** Maximum wishlist items (default 100)
   - **Max Compare Items:** Maximum comparison items (default 5)
   - **Require Purchase for Review:** Toggle ON/OFF
   - **Min Review Length:** Minimum characters (default 10)

### Step 3: Shop Enhanced Features

#### Wishlist
- Users can save items for later
- Access at `/shop/wishlist`
- Share wishlist with others
- Get notified of price drops

#### Shopping Cart
- Add items to cart
- View cart at `/shop/cart`
- Update quantities
- Remove items
- Proceed to checkout

#### Item Comparison
- Compare up to 5 items
- View side-by-side specifications
- Add to cart from comparison

#### Reviews & Ratings
- Users can review purchased items
- Rate 1-5 stars
- View average rating
- Filter by rating

#### View Tracking
- Track popular items
- See view count on items
- Admin dashboard shows trending items

### Step 4: Test Shop Enhanced

1. Add items to wishlist
2. Add items to cart
3. Compare items
4. Leave review on item
5. Check admin dashboard for statistics

---

## Part 2: Profile Enhanced Setup

### Step 1: Enable Profile Enhanced Module

1. Login to Admin Panel
2. Navigate to **Admin > Modules**
3. Find **Profile Enhanced**
4. Click **Enable**

### Step 2: Configure Profile Enhanced Settings

1. Admin Panel > **Profile Enhanced > Settings**
2. Configure:
   - **Enable Timeline:** Toggle ON
   - **Enable Achievements:** Toggle ON
   - **Enable Profile Visits:** Toggle ON
   - **Enable Character Gallery:** Toggle ON
   - **Enable Privacy Controls:** Toggle ON
   - **Max Timeline Items:** Items to display (default 20)
   - **Max Visitors:** Recent visitors to show (default 10)
   - **Max Characters:** Characters to display (default 12)

### Step 3: Profile Enhanced Features

#### User Profile
- Access at `/profile/{username}`
- Shows user information
- Displays statistics
- Shows activity timeline

#### Timeline
- Activity log of user actions
- Achievements unlocked
- Items purchased
- Events attended
- Messages sent

#### Achievement Showcase
- Display selected achievements
- Show achievement progress
- Unlock notifications

#### Character Gallery
- Display user's characters
- Show character stats
- Link to armory profiles
- Filter by realm

#### Visit Tracking
- Track profile visitors
- Show recent visitors
- Privacy controls available

#### Privacy Controls
- Hide profile from public
- Hide achievements
- Hide character gallery
- Hide visitor list

### Step 4: Test Profile Enhanced

1. Visit user profile at `/profile/username`
2. View timeline
3. View achievements
4. View character gallery
5. Check visitor tracking
6. Test privacy settings

---

## Part 3: REST API Setup

### Step 1: Enable REST API Module

1. Login to Admin Panel
2. Navigate to **Admin > Modules**
3. Find **REST API**
4. Click **Enable**

### Step 2: Configure API Settings

1. Admin Panel > **API > Settings**
2. Configure:
   - **Enable API:** Toggle ON
   - **API Version:** v1 (default)
   - **Rate Limiting:** Requests per minute (default 60)
   - **Token Expiry:** Hours (default 24)
   - **CORS Enabled:** Toggle ON/OFF
   - **CORS Origins:** Allowed domains

### Step 3: API Authentication

#### Get JWT Token

```bash
curl -X POST https://yoursite.com/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "username": "your_username",
    "password": "your_password"
  }'
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
    "user": {
      "id": 1,
      "username": "user",
      "email": "user@example.com"
    }
  }
}
```

#### Use Token in Requests

```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
  https://yoursite.com/api/v1/notifications
```

### Step 4: API Endpoints

#### Authentication Endpoints
- `POST /api/v1/auth/login` - Login and get token
- `POST /api/v1/auth/token` - Get token (long-lived)
- `POST /api/v1/auth/logout` - Logout

#### Notifications Endpoints
- `GET /api/v1/notifications` - List notifications
- `GET /api/v1/notifications/unread` - Get unread count
- `GET /api/v1/notifications/{id}` - Get single notification
- `POST /api/v1/notifications/{id}/read` - Mark as read
- `POST /api/v1/notifications/read-all` - Mark all as read
- `DELETE /api/v1/notifications/{id}` - Delete notification

#### Events Endpoints
- `GET /api/v1/events` - List all events
- `GET /api/v1/events/upcoming` - Get upcoming events
- `GET /api/v1/events/{id}` - Get event details
- `POST /api/v1/events/{id}/rsvp` - Submit RSVP
- `PUT /api/v1/events/{id}/rsvp` - Update RSVP
- `DELETE /api/v1/events/{id}/rsvp` - Cancel RSVP

#### Leaderboards Endpoints
- `GET /api/v1/leaderboards/pvp` - PvP rankings
- `GET /api/v1/leaderboards/honor` - Honor rankings
- `GET /api/v1/leaderboards/arena` - Arena rankings
- `GET /api/v1/leaderboards/achievements` - Achievement rankings
- `GET /api/v1/leaderboards/guilds` - Guild rankings

#### Server Status Endpoints
- `GET /api/v1/server/status` - Server status
- `GET /api/v1/server/players` - Online players
- `GET /api/v1/server/statistics` - Server statistics

#### Shop Endpoints
- `GET /api/v1/shop/items` - List items
- `GET /api/v1/shop/items/{id}` - Get item details
- `GET /api/v1/shop/wishlist` - Get user's wishlist
- `POST /api/v1/shop/wishlist` - Add to wishlist
- `DELETE /api/v1/shop/wishlist/{id}` - Remove from wishlist
- `GET /api/v1/shop/cart` - Get cart
- `POST /api/v1/shop/cart` - Add to cart
- `PUT /api/v1/shop/cart/{id}` - Update cart item
- `DELETE /api/v1/shop/cart/{id}` - Remove from cart

#### Profile Endpoints
- `GET /api/v1/profile/{username}` - Get user profile
- `GET /api/v1/profile/{username}/timeline` - Get timeline
- `GET /api/v1/profile/{username}/achievements` - Get achievements
- `GET /api/v1/profile/{username}/characters` - Get characters
- `GET /api/v1/profile/{username}/visitors` - Get visitors

#### Search Endpoints
- `GET /api/v1/search` - Global search
- `GET /api/v1/search/characters` - Search characters
- `GET /api/v1/search/guilds` - Search guilds
- `GET /api/v1/search/items` - Search items

### Step 5: API Response Format

All API responses follow this format:

```json
{
  "success": true,
  "message": "Operation successful",
  "data": {
    // Response data
  }
}
```

**Error Response:**
```json
{
  "success": false,
  "message": "Error message",
  "error_code": 400
}
```

### Step 6: Rate Limiting

API requests are rate-limited. Check headers:
- `X-RateLimit-Limit` - Total requests allowed
- `X-RateLimit-Remaining` - Requests remaining
- `X-RateLimit-Reset` - Unix timestamp when limit resets

### Step 7: Test API

#### Test Authentication
```bash
curl -X POST https://yoursite.com/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"username":"admin","password":"password"}'
```

#### Test Endpoint with Token
```bash
curl -H "Authorization: Bearer TOKEN" \
  https://yoursite.com/api/v1/notifications
```

#### Test Search
```bash
curl "https://yoursite.com/api/v1/search?q=sword"
```

---

## Integration: All Phase 3 Modules

### Shop Enhanced + Profile Enhanced
- User reviews linked to profile
- Wishlist visible on profile
- Purchase history on timeline

### Shop Enhanced + REST API
- Full shop API endpoints
- Wishlist management via API
- Cart operations via API

### Profile Enhanced + REST API
- Profile data via API
- Timeline via API
- Achievement data via API

### All + Notifications
- Purchase notifications
- Profile visit notifications
- Achievement unlock notifications

---

## Testing Checklist

### Shop Enhanced Testing
- [ ] Module enabled
- [ ] Can add to wishlist
- [ ] Can view wishlist
- [ ] Can add to cart
- [ ] Can view cart
- [ ] Can compare items
- [ ] Can leave review
- [ ] Can view statistics
- [ ] Settings saved correctly

### Profile Enhanced Testing
- [ ] Module enabled
- [ ] Can view profile
- [ ] Timeline displays
- [ ] Achievements show
- [ ] Character gallery displays
- [ ] Visitor tracking works
- [ ] Privacy settings work
- [ ] Settings saved correctly

### REST API Testing
- [ ] Module enabled
- [ ] Can get JWT token
- [ ] Can use token in requests
- [ ] Notifications endpoint works
- [ ] Events endpoint works
- [ ] Leaderboards endpoint works
- [ ] Shop endpoint works
- [ ] Profile endpoint works
- [ ] Search endpoint works
- [ ] Rate limiting works
- [ ] Error handling works

---

## Database Tables

### Shop Enhanced Tables

**shop_wishlists**
- id (PK)
- user_id (FK)
- item_id (FK)
- created_at (timestamp)

**shop_reviews**
- id (PK)
- item_id (FK)
- user_id (FK)
- rating (1-5)
- title (varchar)
- content (text)
- helpful_count (int)
- created_at (timestamp)

**shop_views**
- id (PK)
- item_id (FK)
- user_id (FK)
- created_at (timestamp)

**shop_comparisons**
- id (PK)
- user_id (FK)
- items (json)
- created_at (timestamp)

### Profile Enhanced Tables

**profile_enhanced**
- id (PK)
- user_id (FK)
- bio (text)
- avatar (varchar)
- banner (varchar)
- theme (varchar)
- privacy_level (enum)
- created_at (timestamp)

**profile_timeline**
- id (PK)
- user_id (FK)
- action_type (varchar)
- action_data (json)
- created_at (timestamp)

**profile_visitors**
- id (PK)
- profile_user_id (FK)
- visitor_user_id (FK)
- visited_at (timestamp)

**profile_achievements**
- id (PK)
- user_id (FK)
- achievement_id (int)
- showcased (boolean)
- unlocked_at (timestamp)

### REST API Tables

**api_tokens**
- id (PK)
- user_id (FK)
- token (text)
- expires_at (timestamp)
- created_at (timestamp)

**api_logs**
- id (PK)
- user_id (FK)
- endpoint (varchar)
- method (varchar)
- status_code (int)
- created_at (timestamp)

---

## Troubleshooting

### Shop Enhanced Issues

**Wishlist not saving:**
- Verify module enabled
- Check user logged in
- Verify database tables exist

**Reviews not appearing:**
- Check reviews enabled in settings
- Verify user purchased item (if required)
- Check review length minimum

### Profile Enhanced Issues

**Profile not showing:**
- Verify username correct
- Check user exists
- Verify module enabled

**Timeline empty:**
- Check timeline enabled in settings
- Verify user has activities
- Check privacy settings

### REST API Issues

**Token not working:**
- Verify token not expired
- Check Authorization header format
- Verify token in Bearer format

**Rate limiting:**
- Check X-RateLimit headers
- Wait for reset time
- Contact admin for limit increase

**CORS errors:**
- Verify CORS enabled in settings
- Add domain to allowed origins
- Check request headers

---

## Advanced Configuration

### Custom API Endpoints

Add custom endpoints in `/application/modules/api/controllers/`:

```php
public function custom_endpoint()
{
    $data = [
        'custom' => 'data'
    ];
    
    $this->api_response->success($data);
}
```

### Webhook Integration

Setup webhooks for events:

```php
// In config
$config['webhooks'] = [
    'purchase' => 'https://external.com/webhook/purchase',
    'achievement' => 'https://external.com/webhook/achievement',
];
```

### API Caching

Cache API responses for performance:

```php
$cache_key = 'api_leaderboards_pvp';
$data = $this->cache->get($cache_key);

if (!$data) {
    $data = $this->leaderboards_model->get_pvp_rankings();
    $this->cache->save($cache_key, $data, 3600);
}
```

---

## Security Considerations

1. **API Keys:** Store securely, never expose in client code
2. **HTTPS:** Always use HTTPS for API calls
3. **Rate Limiting:** Prevent abuse with rate limits
4. **Input Validation:** Validate all API input
5. **CORS:** Restrict to trusted domains only
6. **Token Expiry:** Set appropriate token expiration
7. **Logging:** Log all API access for audit trail

---

## Performance Optimization

### Pagination

All list endpoints support pagination:

```bash
curl "https://yoursite.com/api/v1/notifications?page=1&per_page=20"
```

### Filtering

Filter results:

```bash
curl "https://yoursite.com/api/v1/events?type=raid&realm=1"
```

### Caching

API responses are cached where appropriate. Cache headers:
- `Cache-Control: max-age=3600` - Cache for 1 hour
- `ETag` - For conditional requests

---

## Next Steps

After Phase 3 is complete:
1. Setup additional modules (Donate, Vote, World Boss, etc.)
2. Configure analytics and monitoring
3. Setup backup and disaster recovery
4. Performance tuning and optimization
5. Security hardening

---

## Support & Documentation

- **Shop Enhanced:** `/application/modules/shop_enhanced`
- **Profile Enhanced:** `/application/modules/profile_enhanced`
- **REST API:** `/application/modules/api`
- **API Docs:** `/api/v1/docs` (if available)

---

*Last Updated: January 11, 2026*
