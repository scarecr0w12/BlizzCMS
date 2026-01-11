# Social Features Module - Installation Guide

## Prerequisites

- BlizzCMS installation with CodeIgniter framework
- Database access with migration support
- User authentication system already in place

## Installation Steps

### Step 1: Run Database Migration

Execute the migration to create all necessary tables:

```bash
php index.php migrate
```

This will create:
- `user_friends` - Stores friend relationships
- `user_messages` - Stores private messages
- `user_activities` - Stores user activities
- `social_settings` - Stores module configuration

### Step 2: Enable Helper in Controllers

To use helper functions throughout your application, load the social helper in your controllers:

```php
$this->load->helper('social');
```

Or autoload it in `application/config/autoload.php`:

```php
$autoload['helpers'] = array('social');
```

### Step 3: Access the Module

The module is now accessible at:
- User area: `/social`
- Admin area: `/social/admin`

## Quick Start

### For Users

1. Navigate to `/social` to access the social dashboard
2. Use the navigation to:
   - Manage friends at `/social/friends`
   - Send/receive messages at `/social/messages`
   - Browse guilds at `/social/guilds`
   - View activity feed at `/social/feed`

### For Administrators

1. Navigate to `/social/admin` to access the admin dashboard
2. Go to `/social/admin/settings` to configure:
   - Enable/disable social features
   - Set maximum friends per user
   - Configure message retention period

## Configuration

Default settings are automatically created during migration:

| Setting | Default | Description |
|---------|---------|-------------|
| enable_friends | 1 | Enable friend system |
| enable_messaging | 1 | Enable messaging |
| enable_guild_features | 1 | Enable guild features |
| max_friends | 100 | Max friends per user |
| message_retention_days | 90 | Days to keep messages |

To modify settings, use the admin panel or update directly in the database:

```php
$this->load->model('social/Social_model');
$this->Social_model->update_setting('max_friends', '200');
```

## Using Helper Functions

### Check Unread Messages

```php
<?php if (get_unread_message_count() > 0): ?>
    <span class="badge"><?php echo get_unread_message_count(); ?> new messages</span>
<?php endif; ?>
```

### Get Friend Count

```php
<?php echo get_friend_count(); ?> friends
```

### Check Pending Requests

```php
<?php if (get_pending_friend_requests() > 0): ?>
    <span class="badge"><?php echo get_pending_friend_requests(); ?> friend requests</span>
<?php endif; ?>
```

### Log User Activity

```php
log_user_activity(
    $user_id,
    'achievement_unlocked',
    'Unlocked achievement: Legendary',
    1  // 1 = public, 0 = private
);
```

### Check Feature Status

```php
<?php if (is_social_feature_enabled('enable_messaging')): ?>
    <!-- Show messaging UI -->
<?php endif; ?>
```

### Check if Users are Friends

```php
<?php if (is_friend($user_id, $friend_id)): ?>
    <p>You are friends!</p>
<?php endif; ?>
```

## Integration Points

### Header/Navigation

Add unread message count to your header:

```php
<?php 
$this->load->helper('social');
$unread = get_unread_message_count();
?>
<a href="<?php echo site_url('social/messages'); ?>">
    Messages <?php if ($unread > 0): ?><span class="badge"><?php echo $unread; ?></span><?php endif; ?>
</a>
```

### User Profile

Add social stats to user profiles:

```php
<?php 
$this->load->model('social/Social_model');
$friend_count = $this->Social_model->get_friend_count($user_id);
$activity_count = $this->Social_model->get_activity_count($user_id);
?>
<p>Friends: <?php echo $friend_count; ?></p>
<p>Activities: <?php echo $activity_count; ?></p>
```

### Dashboard

Add social widgets to user dashboard:

```php
<?php 
$this->load->helper('social');
$unread = get_unread_message_count();
$friends = get_friend_count();
$requests = get_pending_friend_requests();
?>
<div class="social-widgets">
    <div class="widget">
        <h3>Messages</h3>
        <p><?php echo $unread; ?> unread</p>
        <a href="<?php echo site_url('social/messages'); ?>">View</a>
    </div>
    <div class="widget">
        <h3>Friends</h3>
        <p><?php echo $friends; ?> total</p>
        <a href="<?php echo site_url('social/friends'); ?>">Manage</a>
    </div>
    <div class="widget">
        <h3>Requests</h3>
        <p><?php echo $requests; ?> pending</p>
        <a href="<?php echo site_url('social/friends'); ?>">Review</a>
    </div>
</div>
```

## Database Queries

### Get User's Friends

```php
$this->load->model('social/Social_model');
$friends = $this->Social_model->get_friends($user_id);
```

### Get Unread Messages

```php
$messages = $this->Social_model->get_messages($user_id, 20, 0);
$unread_count = $this->Social_model->get_unread_count($user_id);
```

### Get Guild Information

```php
$guild = $this->Social_model->get_guild($guild_id);
$members = $this->Social_model->get_guild_members($guild_id);
```

### Get Social Feed

```php
$activities = $this->Social_model->get_social_feed($user_id, 20, 0);
```

## Troubleshooting

### Messages Not Showing

1. Verify migration ran successfully
2. Check `user_messages` table exists
3. Ensure user is authenticated
4. Check message recipient ID is valid

### Friends Not Appearing

1. Verify `user_friends` table exists
2. Check friend status is 'accepted'
3. Ensure both users exist in `users` table

### Guilds Not Displaying

1. Verify guild data exists in character database
2. Check guild table connection in model
3. Ensure realm is properly configured

### Settings Not Saving

1. Verify `social_settings` table exists
2. Check admin user has proper permissions
3. Verify setting_key matches expected values

## Performance Optimization

### Enable Caching

```php
// Cache friend list for 1 hour
$friends = $this->cache->get('user_' . $user_id . '_friends');
if (!$friends) {
    $friends = $this->Social_model->get_friends($user_id);
    $this->cache->save('user_' . $user_id . '_friends', $friends, 3600);
}
```

### Database Indexes

The migration automatically creates indexes on:
- `user_friends.user_id`
- `user_friends.friend_id`
- `user_messages.to_id`
- `user_messages.is_read`
- `user_activities.user_id`
- `user_activities.created_at`

### Pagination

Always use pagination for large datasets:

```php
$page = $this->input->get('page') ?: 1;
$limit = 20;
$offset = ($page - 1) * $limit;
$messages = $this->Social_model->get_messages($user_id, $limit, $offset);
```

## Security Best Practices

1. Always check user authentication before showing social features
2. Validate user IDs before operations
3. Use CodeIgniter's built-in sanitization
4. Implement CSRF protection on forms
5. Never trust user input directly
6. Log sensitive operations for audit trail

## Support & Documentation

For detailed API documentation, see `README.md` in the module directory.

For implementation details, see `SOCIAL_MODULE_COMPLETION_SUMMARY.md`.

## Version Information

- **Module Version:** 1.0.0
- **Created:** January 11, 2026
- **Status:** Production Ready
- **License:** Same as BlizzCMS
