<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

# Social Features Module - Testing Guide

## Pre-Testing Checklist

- [ ] Database migration has been run
- [ ] Social helper is loaded or autoloaded
- [ ] User authentication system is working
- [ ] At least 2 test users exist in the system
- [ ] Guild data exists in character database (optional for guild tests)

## Unit Testing

### Model Tests

#### Friends Management

```php
// Test adding a friend
$this->load->model('social/Social_model');
$result = $this->Social_model->add_friend(1, 2);
// Expected: true (success)

// Test getting friends
$friends = $this->Social_model->get_friends(1);
// Expected: array of friend objects

// Test getting friend requests
$requests = $this->Social_model->get_friend_requests(2);
// Expected: array containing user 1's request

// Test accepting friend request
$result = $this->Social_model->accept_friend(2, 1);
// Expected: true (success)

// Test friend count
$count = $this->Social_model->get_friend_count(1);
// Expected: 1

// Test is_friend check
$is_friend = $this->Social_model->is_friend(1, 2);
// Expected: true

// Test removing friend
$result = $this->Social_model->remove_friend(1, 2);
// Expected: true (success)
```

#### Messaging

```php
// Test sending message
$result = $this->Social_model->send_message(1, 2, 'Test Subject', 'Test message content');
// Expected: true (success)

// Test getting messages
$messages = $this->Social_model->get_messages(2, 20, 0);
// Expected: array with 1 message

// Test unread count
$unread = $this->Social_model->get_unread_count(2);
// Expected: 1

// Test marking message as read
$message_id = $messages[0]->id;
$result = $this->Social_model->mark_message_read($message_id, 2);
// Expected: true (success)

// Test getting sent messages
$sent = $this->Social_model->get_sent_messages(1, 20, 0);
// Expected: array with 1 message

// Test deleting message
$result = $this->Social_model->delete_message($message_id, 2);
// Expected: true (success)
```

#### Guild Features

```php
// Test getting guild
$guild = $this->Social_model->get_guild(1);
// Expected: guild object or null

// Test getting guild members
$members = $this->Social_model->get_guild_members(1);
// Expected: array of member objects

// Test getting top guilds
$top_guilds = $this->Social_model->get_top_guilds(10);
// Expected: array of guild objects sorted by member count

// Test guild count
$count = $this->Social_model->get_guild_count();
// Expected: integer >= 0
```

#### Activities

```php
// Test logging activity
$result = $this->Social_model->log_activity(1, 'achievement_unlocked', 'Legendary Achievement', 1);
// Expected: true (success)

// Test getting social feed
$feed = $this->Social_model->get_social_feed(1, 20, 0);
// Expected: array of activity objects

// Test activity count
$count = $this->Social_model->get_activity_count(1);
// Expected: integer >= 1
```

#### Settings

```php
// Test getting all settings
$settings = $this->Social_model->get_all_settings();
// Expected: array with keys: enable_friends, enable_messaging, etc.

// Test updating setting
$result = $this->Social_model->update_setting('max_friends', '150');
// Expected: true (success)

// Verify update
$settings = $this->Social_model->get_all_settings();
// Expected: max_friends = '150'
```

## Integration Testing

### Controller Routes

#### Friends Routes

```
GET /social/friends
- Expected: Friends list page loads
- Check: Friends and requests display correctly

GET /social/friends/add/2
- Expected: Friend request sent, redirect to /social/friends
- Check: Flashdata message shows success

GET /social/friends/accept/2
- Expected: Request accepted, redirect to /social/friends
- Check: User now appears in friends list

GET /social/friends/remove/2
- Expected: Friend removed, redirect to /social/friends
- Check: User no longer in friends list
```

#### Messages Routes

```
GET /social/messages
- Expected: Inbox page loads with messages
- Check: Pagination works correctly

POST /social/messages/send
- Data: to_id=2, subject=Test, message=Hello
- Expected: Message sent, redirect to /social/messages
- Check: Message appears in inbox for recipient

GET /social/messages/1
- Expected: Message details page loads
- Check: Message marked as read

GET /social/messages/sent
- Expected: Sent messages page loads
- Check: Sent message appears in list

GET /social/messages/delete/1
- Expected: Message deleted, redirect to /social/messages
- Check: Message no longer appears
```

#### Guild Routes

```
GET /social/guilds
- Expected: Guild list page loads
- Check: Guilds display with member counts

GET /social/guilds/1
- Expected: Guild details page loads
- Check: Guild info and members display

GET /social/guilds/1/members
- Expected: Guild members page loads
- Check: All members listed with details
```

#### Other Routes

```
GET /social/search?q=username
- Expected: Search results page loads
- Check: Matching users display

GET /social/profile/2
- Expected: User profile page loads
- Check: Friend count and activity count display

GET /social/feed
- Expected: Activity feed page loads
- Check: Friend activities display

GET /social/dashboard
- Expected: Dashboard page loads
- Check: All stats display correctly
```

#### Admin Routes

```
GET /social/admin
- Expected: Admin dashboard loads (admin only)
- Check: Module status displays

GET /social/admin/settings
- Expected: Settings form loads (admin only)
- Check: Current settings display

POST /social/admin/settings
- Data: enable_friends=1, max_friends=150, etc.
- Expected: Settings updated, redirect to settings
- Check: Flashdata message shows success
```

## Helper Function Testing

```php
// Load helper
$this->load->helper('social');

// Test get_unread_message_count
$count = get_unread_message_count();
// Expected: integer >= 0

// Test get_friend_count
$count = get_friend_count();
// Expected: integer >= 0

// Test get_pending_friend_requests
$count = get_pending_friend_requests();
// Expected: integer >= 0

// Test is_friend
$result = is_friend(1, 2);
// Expected: boolean

// Test log_user_activity
$result = log_user_activity(1, 'test_activity', 'Test description', 1);
// Expected: true

// Test get_social_settings
$settings = get_social_settings();
// Expected: array with setting keys

// Test is_social_feature_enabled
$enabled = is_social_feature_enabled('enable_messaging');
// Expected: boolean
```

## User Experience Testing

### Scenario 1: Friend Request Flow

1. User A logs in
2. User A searches for User B
3. User A sends friend request to User B
4. User B logs in
5. User B sees friend request from User A
6. User B accepts request
7. Both users see each other in friends list
8. User A removes User B from friends
9. User B no longer sees User A in friends list

**Expected Result:** All steps complete successfully

### Scenario 2: Messaging Flow

1. User A logs in
2. User A composes message to User B
3. User A sends message
4. User B logs in
5. User B sees unread message count
6. User B opens inbox
7. User B views message (marked as read)
8. User B replies to message
9. User A sees reply in inbox
10. User A deletes message

**Expected Result:** All steps complete successfully

### Scenario 3: Guild Browsing

1. User logs in
2. User navigates to guilds
3. User sees list of guilds
4. User clicks on guild
5. User sees guild details
6. User views guild members
7. User returns to guild list

**Expected Result:** All pages load and display correctly

### Scenario 4: Social Feed

1. User A and User B are friends
2. User A logs activity
3. User B logs in
4. User B views social feed
5. User B sees User A's activity

**Expected Result:** Activity appears in feed

## Security Testing

### Authentication Tests

```
Test 1: Access /social without login
- Expected: Redirect to login page

Test 2: Access /social/admin without admin role
- Expected: Redirect to login or access denied

Test 3: View another user's message
- Expected: 404 error or access denied

Test 4: Delete another user's message
- Expected: Failure, message not deleted
```

### Input Validation Tests

```
Test 1: Send message with empty subject
- Expected: Form validation error

Test 2: Send message with empty body
- Expected: Form validation error

Test 3: Add self as friend
- Expected: Failure, cannot friend self

Test 4: Send message to non-existent user
- Expected: Failure or validation error
```

## Performance Testing

### Load Testing

```
Test 1: Load friends list with 100+ friends
- Expected: Page loads within 2 seconds

Test 2: Load inbox with 100+ messages
- Expected: Page loads within 2 seconds with pagination

Test 3: Load guild list with 50+ guilds
- Expected: Page loads within 2 seconds

Test 4: Load social feed with 100+ activities
- Expected: Page loads within 2 seconds with pagination
```

### Database Query Testing

```
Test 1: Check query count for friends page
- Expected: < 5 queries

Test 2: Check query count for messages page
- Expected: < 5 queries

Test 3: Check query count for guilds page
- Expected: < 5 queries
```

## Browser Compatibility Testing

- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile browsers

## Regression Testing

After any updates, verify:

- [ ] All routes still work
- [ ] All views render correctly
- [ ] All database operations succeed
- [ ] All helper functions work
- [ ] Admin settings still apply
- [ ] Authentication still enforced

## Test Results Template

```
Test Date: [DATE]
Tester: [NAME]
Module Version: 1.0.0

PASSED TESTS:
- [Test name]
- [Test name]

FAILED TESTS:
- [Test name]: [Issue description]
- [Test name]: [Issue description]

NOTES:
[Any additional notes]

Overall Status: [PASS/FAIL]
```

## Known Limitations

1. Guild data depends on character database connection
2. Message retention is manual (not auto-deleted)
3. No real-time notifications (requires additional setup)
4. No message search (can be added as enhancement)

## Deployment Checklist

- [ ] All tests passed
- [ ] Database migration successful
- [ ] Helper functions working
- [ ] All routes accessible
- [ ] Admin panel functional
- [ ] Security checks passed
- [ ] Performance acceptable
- [ ] Documentation complete
- [ ] Backup created
- [ ] Deployment approved

---

**Last Updated:** January 11, 2026
**Version:** 1.0.0
