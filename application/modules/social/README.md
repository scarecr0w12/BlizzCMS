# Social Features Module

A comprehensive social networking module for BlizzCMS that provides friends management, messaging, guild browsing, and social activity feeds.

## Features

### 1. Friends Management
- Add friends with pending request system
- Accept/decline friend requests
- View friend list
- Remove friends
- Friend count tracking

### 2. Messaging System
- Send private messages to other users
- Inbox with unread message tracking
- View individual messages
- Sent messages folder
- Delete messages
- Message pagination

### 3. Guild Features
- Browse all guilds
- View guild information
- View guild members with details
- Guild member count tracking
- Guild ranking by member count

### 4. Social Feed
- View activities from friends
- Public activity tracking
- Pagination support
- Activity logging system

### 5. User Search
- Search for users by username
- Quick friend request from search results
- User profile viewing

### 6. Admin Panel
- Enable/disable social features
- Configure maximum friends per user
- Set message retention period
- View module status

## Installation

1. Ensure the migration files are run to create the necessary database tables:
   - `user_friends` - Stores friend relationships
   - `user_messages` - Stores private messages
   - `user_activities` - Stores user activities
   - `social_settings` - Stores module configuration

2. The module will automatically create these tables on first migration.

## Database Tables

### user_friends
- `id` - Primary key
- `user_id` - User initiating the friend request
- `friend_id` - User receiving the friend request
- `status` - 'pending' or 'accepted'
- `created_at` - Timestamp

### user_messages
- `id` - Primary key
- `from_id` - Sender user ID
- `to_id` - Recipient user ID
- `subject` - Message subject
- `message` - Message content
- `is_read` - Read status (0/1)
- `created_at` - Timestamp

### user_activities
- `id` - Primary key
- `user_id` - User who performed the activity
- `activity_type` - Type of activity
- `activity_description` - Description of activity
- `is_public` - Public visibility (0/1)
- `created_at` - Timestamp

### social_settings
- `id` - Primary key
- `setting_key` - Setting name
- `setting_value` - Setting value
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

## Routes

### User Routes
- `/social` - Social dashboard
- `/social/dashboard` - Dashboard with stats
- `/social/friends` - Friends list and requests
- `/social/friends/add/{id}` - Add friend
- `/social/friends/accept/{id}` - Accept friend request
- `/social/friends/remove/{id}` - Remove friend
- `/social/messages` - Inbox
- `/social/messages/send` - Send message
- `/social/messages/sent` - Sent messages
- `/social/messages/{id}` - View message
- `/social/messages/delete/{id}` - Delete message
- `/social/search` - Search users
- `/social/profile/{id}` - View user profile
- `/social/guilds` - Browse guilds
- `/social/guilds/{id}` - View guild details
- `/social/guilds/{id}/members` - View guild members
- `/social/feed` - Social activity feed

### Admin Routes
- `/social/admin` - Admin dashboard
- `/social/admin/settings` - Module settings

## Helper Functions

The module provides several helper functions for easy integration:

```php
// Get unread message count
get_unread_message_count($user_id = null);

// Get friend count
get_friend_count($user_id = null);

// Get pending friend requests count
get_pending_friend_requests($user_id = null);

// Check if two users are friends
is_friend($user_id, $friend_id);

// Log user activity
log_user_activity($user_id, $activity_type, $activity_description = '', $is_public = 1);

// Get all social settings
get_social_settings();

// Check if a feature is enabled
is_social_feature_enabled($feature_key);
```

## Model Methods

### Friends
- `add_friend($user_id, $friend_id)` - Send friend request
- `get_friends($user_id)` - Get accepted friends
- `get_friend_requests($user_id)` - Get pending requests
- `accept_friend($user_id, $friend_id)` - Accept request
- `remove_friend($user_id, $friend_id)` - Remove friend
- `is_friend($user_id, $friend_id)` - Check if friends
- `get_friend_count($user_id)` - Get friend count
- `get_pending_requests_count($user_id)` - Get pending count

### Messaging
- `send_message($from_id, $to_id, $subject, $message)` - Send message
- `get_messages($user_id, $limit, $offset)` - Get inbox
- `get_sent_messages($user_id, $limit, $offset)` - Get sent messages
- `get_message($message_id, $user_id)` - Get single message
- `get_unread_count($user_id)` - Get unread count
- `mark_message_read($message_id, $user_id)` - Mark as read
- `delete_message($message_id, $user_id)` - Delete message
- `get_message_count($user_id)` - Get total messages

### Guilds
- `get_guild($guild_id)` - Get guild info
- `get_guild_members($guild_id)` - Get guild members
- `get_top_guilds($limit)` - Get top guilds by member count
- `get_guild_count()` - Get total guild count

### Activities & Feed
- `get_social_feed($user_id, $limit, $offset)` - Get friend activities
- `log_activity($user_id, $activity_type, $activity_description, $is_public)` - Log activity
- `get_activity_count($user_id)` - Get activity count

### Search & Profile
- `search_users($search_term, $limit)` - Search users
- `get_user_profile($user_id)` - Get user profile

### Settings
- `get_all_settings()` - Get all settings
- `update_setting($key, $value)` - Update setting

## Configuration

Default settings created on installation:
- `enable_friends` - Enable/disable friend system (default: 1)
- `enable_messaging` - Enable/disable messaging (default: 1)
- `enable_guild_features` - Enable/disable guild features (default: 1)
- `max_friends` - Maximum friends per user (default: 100)
- `message_retention_days` - Days to keep messages (default: 90)

## Usage Examples

### Check for unread messages in header
```php
<?php if (get_unread_message_count() > 0): ?>
    <span class="badge"><?php echo get_unread_message_count(); ?></span>
<?php endif; ?>
```

### Log user activity
```php
log_user_activity($user_id, 'achievement_unlocked', 'Unlocked achievement: Legendary', 1);
```

### Check if feature is enabled
```php
<?php if (is_social_feature_enabled('enable_messaging')): ?>
    <!-- Show messaging UI -->
<?php endif; ?>
```

## Security Considerations

- All user input is sanitized using CodeIgniter's built-in functions
- Friend requests are validated to prevent self-friending
- Messages are only accessible to sender/recipient
- Admin features require admin authentication
- CSRF protection is recommended for all forms

## Performance Tips

- Implement caching for frequently accessed data (top guilds, friend lists)
- Use pagination for large datasets
- Index database columns: `user_id`, `friend_id`, `to_id`, `from_id`
- Consider archiving old messages based on retention settings

## Future Enhancements

- Direct messaging notifications
- Friend request notifications
- Guild invitations
- Blocking users
- Activity filtering and preferences
- Social groups/clans
- Achievement sharing
- Friend activity notifications

---

## Project Information

**BlizzCMS Version:** 3.0  
**Module Status:** Complete & Production Ready  
**Last Updated:** January 11, 2026  
**Maintained By:** BlizzCMS Community

---

For more information, see the main README.md and CHANGELOG.md in the project root.
