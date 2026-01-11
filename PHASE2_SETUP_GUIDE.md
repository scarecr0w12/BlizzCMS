# Phase 2 Complete Setup Guide

This guide walks you through setting up Phase 2 modules: Notifications System and Events Calendar.

---

## Phase 2 Overview

**Phase 2 focuses on user engagement:**
1. **Notifications System** - In-app, email, and browser push notifications
2. **Events Calendar** - Event creation, RSVP management, and reminders

---

## Part 1: Notifications System Setup

### Step 1: Enable Notifications Module

1. Login to Admin Panel
2. Navigate to **Admin > Modules**
3. Find **Notifications**
4. Click **Enable**

### Step 2: Configure Notification Settings

1. Admin Panel > **Notifications > Settings**
2. Configure:
   - **Enable In-App Notifications:** Toggle ON
   - **Enable Email Notifications:** Toggle ON (requires email config)
   - **Enable Browser Push:** Toggle ON (requires HTTPS)
   - **Notification Retention Days:** How long to keep notifications (default 30)
   - **Max Notifications Per Page:** Pagination size (default 20)

### Step 3: Email Configuration (Optional)

For email notifications, ensure email is configured in `/application/config/email.php`:

```php
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com';  // or your email provider
$config['smtp_user'] = 'your-email@gmail.com';
$config['smtp_pass'] = 'your-app-password';
$config['smtp_port'] = 587;
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['wordwrap'] = true;
```

### Step 4: Browser Push Configuration (Optional)

For browser push notifications:

1. Generate VAPID keys (if not already done)
2. Add to `/application/config/config.php`:

```php
$config['vapid_public_key'] = 'YOUR_PUBLIC_KEY';
$config['vapid_private_key'] = 'YOUR_PRIVATE_KEY';
```

### Step 5: User Notification Preferences

Users can configure their preferences at `/notifications/preferences`:
- In-app notifications
- Email notifications
- Browser push notifications
- Notification types (donations, events, messages, etc.)

### Step 6: Test Notifications

#### Create a Test Notification
1. Admin Panel > **Notifications > Send**
2. Fill in:
   - **User/Group:** Select recipient
   - **Type:** Choose notification type
   - **Title:** Notification title
   - **Message:** Notification message
3. Click **Send**

#### Verify Notification Received
1. User logs in
2. Check notification bell icon (top right)
3. Should see notification in list
4. Click to mark as read

### Notification Types

| Type | Use Case | Icon |
|------|----------|------|
| info | General information | ℹ️ |
| success | Successful action | ✓ |
| warning | Warning message | ⚠️ |
| error | Error occurred | ✗ |
| donation | Donation received | 💝 |
| event | Event notification | 📅 |
| message | New message | 💬 |
| achievement | Achievement unlocked | 🏆 |
| system | System announcement | 🔔 |

### Notification API Endpoints

**Get User Notifications:**
```
GET /notifications/get_count
GET /notifications/get_recent
```

**Mark as Read:**
```
POST /notifications/mark_read/{id}
POST /notifications/mark_all_read
```

**Delete:**
```
POST /notifications/delete/{id}
```

---

## Part 2: Events Calendar Setup

### Step 1: Enable Events Module

1. Login to Admin Panel
2. Navigate to **Admin > Modules**
3. Find **Events**
4. Click **Enable**

### Step 2: Configure Event Settings

1. Admin Panel > **Events > Settings**
2. Configure:
   - **Enable Events:** Toggle ON
   - **Events Per Page:** Pagination size (default 12)
   - **Max Event Capacity:** Default max participants
   - **Enable RSVP:** Toggle ON
   - **Enable Reminders:** Toggle ON
   - **Reminder Hours Before:** When to send reminders (default 24)

### Step 3: Create Your First Event

1. Admin Panel > **Events > Create**
2. Fill in event details:
   - **Title:** Event name
   - **Description:** Event details
   - **Event Type:** Raid, Dungeon, PvP, Social, etc.
   - **Start Date/Time:** When event starts
   - **End Date/Time:** When event ends
   - **Location:** Event location (optional)
   - **Max Participants:** Capacity limit
   - **Realm:** Which realm (if multi-realm)
   - **Featured:** Highlight on calendar
3. Click **Create**

### Step 4: Event Management

#### View Events
- **User View:** `/events` - See upcoming events
- **Calendar View:** `/events/calendar` - Calendar grid
- **My Events:** `/events/my_events` - User's RSVPed events

#### Edit Event
1. Admin Panel > **Events > Edit**
2. Select event
3. Modify details
4. Click **Update**

#### Delete Event
1. Admin Panel > **Events > Delete**
2. Confirm deletion
3. All RSVPs automatically deleted

### Step 5: RSVP System

#### How RSVP Works

1. User views event at `/events/view/{event_id}`
2. Clicks **RSVP**
3. Selects:
   - **Status:** Attending, Tentative, or Declined
   - **Character:** Which character attending
   - **Notes:** Optional notes
4. RSVP recorded

#### RSVP Statuses

| Status | Meaning |
|--------|---------|
| Attending | User confirmed attending |
| Tentative | User might attend |
| Declined | User not attending |

#### View RSVPs

1. Admin Panel > **Events > View RSVPs**
2. See all RSVPs for event
3. View character details
4. Export RSVP list if needed

### Step 6: Event Reminders

#### Automatic Reminders

1. Enabled in settings
2. Sent X hours before event
3. Via notification system
4. Can be email or in-app

#### Manual Reminders

1. Admin Panel > **Events > Send Reminder**
2. Select event
3. Click **Send Reminder**
4. All RSVPs notified

### Step 7: Event Search

Users can search events at `/events/search`:
- **Search by Title:** Find events by name
- **Filter by Type:** Raid, Dungeon, PvP, etc.
- **Filter by Realm:** Multi-realm support
- **Date Range:** Search by date

---

## Integration: Notifications + Events

### Event Notifications

Events automatically send notifications for:
- **Event Created:** Admins notified
- **Event Updated:** RSVPs notified of changes
- **Event Reminder:** Attendees reminded before event
- **Event Cancelled:** All RSVPs notified

### Notification Preferences

Users can disable event notifications in preferences if desired.

---

## Testing Checklist

### Notifications Testing
- [ ] Notifications module enabled
- [ ] Can create notification
- [ ] Notification appears in user's list
- [ ] Can mark as read
- [ ] Can delete notification
- [ ] User preferences work
- [ ] Email notifications sent (if configured)
- [ ] Browser push works (if configured)

### Events Calendar Testing
- [ ] Events module enabled
- [ ] Can create event
- [ ] Event appears on calendar
- [ ] Can view event details
- [ ] Can RSVP to event
- [ ] Can change RSVP status
- [ ] Can view other RSVPs
- [ ] Event reminders sent
- [ ] Can search events
- [ ] Can edit event
- [ ] Can delete event

### Integration Testing
- [ ] Event creation sends notification
- [ ] Event update sends notification to RSVPs
- [ ] Event reminder sends notification
- [ ] Event cancellation sends notification
- [ ] User preferences respected

---

## Database Tables

### Notifications Tables

**notifications**
- id (PK)
- user_id (FK)
- type (varchar)
- title (varchar)
- message (text)
- link (varchar)
- icon (varchar)
- is_read (boolean)
- created_at (timestamp)
- read_at (timestamp)

**notification_preferences**
- id (PK)
- user_id (FK)
- email_notifications (boolean)
- browser_notifications (boolean)
- notify_donations (boolean)
- notify_events (boolean)
- notify_messages (boolean)
- notify_achievements (boolean)
- created_at (timestamp)

### Events Tables

**events**
- id (PK)
- title (varchar)
- description (text)
- event_type (varchar)
- start_date (datetime)
- end_date (datetime)
- location (varchar)
- max_participants (int)
- realm_id (FK)
- creator_id (FK)
- featured (boolean)
- created_at (timestamp)
- updated_at (timestamp)

**event_rsvps**
- id (PK)
- event_id (FK)
- user_id (FK)
- character_id (int)
- character_name (varchar)
- character_class (varchar)
- status (enum: attending, tentative, declined)
- notes (text)
- created_at (timestamp)
- updated_at (timestamp)

**event_settings**
- id (PK)
- setting_key (varchar)
- setting_value (text)
- created_at (timestamp)
- updated_at (timestamp)

---

## Troubleshooting

### Notifications Not Appearing
- **Cause:** Module not enabled
- **Fix:** Enable in Admin > Modules

### Email Notifications Not Sent
- **Cause:** Email not configured
- **Fix:** Configure SMTP in email.php

### Events Not Showing
- **Cause:** No events created or past date
- **Fix:** Create event with future date

### RSVP Not Working
- **Cause:** User not logged in
- **Fix:** Require login before RSVP

### Reminders Not Sent
- **Cause:** Reminders disabled or cron not running
- **Fix:** Enable reminders and setup cron job

---

## Advanced Configuration

### Cron Job for Reminders

Setup cron to send event reminders:

```bash
# Send reminders every hour
0 * * * * curl https://yoursite.com/events/cron/send_reminders
```

### Bulk Notifications

Send notifications to multiple users:

```php
$users = [1, 2, 3, 4, 5];
foreach ($users as $user_id) {
    $this->notifications_model->create_notification([
        'user_id' => $user_id,
        'type' => 'info',
        'title' => 'Server Maintenance',
        'message' => 'Server will be down for maintenance',
    ]);
}
```

### Custom Notification Types

Add custom notification types in admin settings:

```php
$config['notification_types'] = [
    'info' => 'Information',
    'success' => 'Success',
    'warning' => 'Warning',
    'error' => 'Error',
    'custom' => 'Custom Type',
];
```

---

## Performance Optimization

### Notification Cleanup

Automatically delete old notifications:

```php
// In cron job
$this->db->where('created_at <', date('Y-m-d H:i:s', strtotime('-30 days')))
    ->delete('notifications');
```

### Event Caching

Cache upcoming events for performance:

```php
$cache_key = 'upcoming_events_' . date('Y-m-d');
$events = $this->cache->get($cache_key);

if (!$events) {
    $events = $this->events_model->get_upcoming_events();
    $this->cache->save($cache_key, $events, 3600); // 1 hour
}
```

---

## Next Steps

After Phase 2 is complete:
1. Configure Phase 3 modules (Shop Enhanced, Profile Enhanced, REST API)
2. Setup analytics tracking
3. Configure additional integrations
4. Monitor system performance

---

## Support & Documentation

- **Notifications Module:** `/application/modules/notifications`
- **Events Module:** `/application/modules/events`
- **Admin Panel:** `/admin/notifications` and `/admin/events`

---

*Last Updated: January 11, 2026*
