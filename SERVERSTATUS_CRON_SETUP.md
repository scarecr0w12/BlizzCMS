# Serverstatus Module - Cron Job Setup

## Overview
The serverstatus module automatically records server statistics (online players, faction balance) to track historical data. A cron job has been configured to run every 5 minutes.

## Current Setup

### Cron Job Configuration
```
*/5 * * * * curl -s http://localhost/serverstatus/cron/record_stats > /dev/null 2>&1
```

**Schedule**: Every 5 minutes
**Endpoint**: `/serverstatus/cron/record_stats`
**Function**: Records online player count and faction balance for all configured realms

### What Gets Recorded
For each realm, the following data is recorded:
- `online_players` - Total number of online characters
- `alliance_count` - Number of online Alliance characters
- `horde_count` - Number of online Horde characters
- `timestamp` - When the record was created

### Database Table
Data is stored in the `serverstatus_history` table with the following structure:
- `id` - Primary key
- `realm_id` - Reference to the realm
- `timestamp` - Record creation time
- `online_players` - Total online count
- `alliance_count` - Alliance faction count
- `horde_count` - Horde faction count
- `uptime_seconds` - Server uptime (reserved for future use)

## Viewing Cron Job Status

### Check if cron is running
```bash
crontab -l
```

### View cron logs (Linux)
```bash
grep CRON /var/log/syslog
# or
journalctl -u cron
```

### Manual Testing
To manually trigger the cron job:
```bash
curl http://localhost/serverstatus/cron/record_stats
```

## Admin Dashboard
The recorded statistics are displayed in the admin dashboard at `/serverstatus/admin`:
- **Total Records** - Total number of history records
- **Realms Tracked** - Number of configured realms
- **Recent History** - Table showing last 24 hours of records

## Customizing the Schedule

To change the cron schedule, edit the crontab:
```bash
crontab -e
```

Common schedules:
- `*/5 * * * *` - Every 5 minutes (current)
- `*/10 * * * *` - Every 10 minutes
- `*/15 * * * *` - Every 15 minutes
- `0 * * * *` - Every hour
- `0 */6 * * *` - Every 6 hours

## Troubleshooting

### Cron job not running
1. Verify cron service is running: `sudo systemctl status cron`
2. Check crontab is properly configured: `crontab -l`
3. Verify curl is installed: `which curl`
4. Check web server is accessible: `curl http://localhost/`

### No data in history table
1. Verify cron job has executed: Check application logs
2. Verify realms are configured: Check `/serverstatus/admin`
3. Manually trigger cron: `curl http://localhost/serverstatus/cron/record_stats`

### High disk usage
If the history table grows too large, consider:
1. Increasing cron interval (e.g., every 15 minutes instead of 5)
2. Implementing data retention policy (delete records older than 30 days)
3. Archiving old data to separate table

## Data Retention

Currently, all historical data is retained indefinitely. To implement data retention, you can add a cleanup cron job:

```bash
# Delete records older than 30 days (add to crontab)
0 2 * * * curl -s http://localhost/serverstatus/cron/cleanup_old_records > /dev/null 2>&1
```

(Cleanup endpoint would need to be implemented in the Cron controller)

## Notes
- The cron job uses curl to make HTTP requests to the web server
- Ensure the web server is running and accessible at `http://localhost`
- The cron job runs silently (output redirected to /dev/null)
- No authentication is required for the cron endpoint (runs on localhost)
