# Backup Management Module

A complete, production-ready backup management system for Laravel applications. This module provides comprehensive backup functionality including database backups, codebase backups, scheduled backups, and a full admin UI.

## Features

### Backup Types
- **Database Backup**: Full database backup with options for structure only, data only, or both
- **Codebase Backup**: Backup selected folders or entire project with compression
- **Combined Backup**: Database + codebase in a single archive

### Scheduling System
- Manual backups (Run Now)
- Scheduled backups with multiple frequencies:
  - Minutely
  - Hourly
  - Daily
  - Weekly
  - Monthly
  - Custom cron expression
- Enable/disable schedules
- Automatic execution via Laravel scheduler

### Admin UI
- **Backup Management**: View, create, download, and delete backups
- **Schedule Management**: Create and manage backup schedules
- **Settings Page**: Configure all backup settings
- **Logs**: Detailed backup logs with status tracking

### Security & Performance
- Exclude sensitive files (.env, keys, etc.)
- Disk space checking before backup
- Queue-based execution
- Memory limit and timeout configuration
- Automatic cleanup of old backups

## Installation

### 1. Run Migrations

```bash
php artisan migrate
```

This will create the following tables:
- `backups` - Stores backup records
- `backup_schedules` - Stores backup schedules
- `backup_logs` - Stores detailed backup logs
- `backup_settings` - Stores backup configuration

### 2. Publish Configuration (Optional)

The configuration file is already created at `config/backup.php`. You can customize it if needed.

### 3. Set Up Cron Job

Add the following to your server's crontab to enable scheduled backups:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

This will run the Laravel scheduler every minute, which will execute scheduled backups.

### 4. Configure Queue (Recommended)

For better performance, configure a queue worker:

```bash
php artisan queue:work
```

Or use a process manager like Supervisor to keep it running.

## Usage

### Accessing the Module

Navigate to:
- **Backups**: `/backend/backups`
- **Schedules**: `/backend/backup-schedules`
- **Settings**: `/backend/backup-settings`

### Creating a Manual Backup

1. Go to `/backend/backups`
2. Click "Create Backup"
3. Select backup type (Database, Codebase, or Combined)
4. Configure options:
   - **Database**: Select tables, backup mode (structure/data/both)
   - **Codebase**: Select folders, compression type
5. Click "Create Backup"

### Creating a Scheduled Backup

1. Go to `/backend/backup-schedules`
2. Click "Create Schedule"
3. Fill in schedule details:
   - Name
   - Backup type
   - Frequency (or custom cron)
   - Backup options
4. Enable/disable the schedule
5. Click "Create Schedule"

### Configuring Settings

1. Go to `/backend/backup-settings`
2. Configure:
   - **General**: Enable/disable, name prefix, max backups, compression
   - **Storage**: Disk, path, disk space checking
   - **Security**: Encryption, exclude sensitive files
   - **Performance**: Memory limit, timeout, queue usage
   - **Notifications**: Email settings
3. Click "Save Settings"

## Configuration

### Environment Variables

You can set these in your `.env` file:

```env
BACKUP_ENABLED=true
BACKUP_NAME_PREFIX=backup
BACKUP_MAX_KEEP=10
BACKUP_AUTO_DELETE=true
BACKUP_COMPRESSION=zip
BACKUP_STORAGE_DISK=local
BACKUP_STORAGE_PATH=backups
BACKUP_CHECK_DISK_SPACE=true
BACKUP_MIN_DISK_SPACE_MB=100
BACKUP_ENCRYPT=false
BACKUP_EXCLUDE_ENV=true
BACKUP_EXCLUDE_SENSITIVE=true
BACKUP_MEMORY_LIMIT=512M
BACKUP_TIMEOUT=3600
BACKUP_USE_QUEUE=true
BACKUP_EMAIL_ON_FAILURE=true
BACKUP_EMAIL_ON_SUCCESS=false
BACKUP_NOTIFICATION_EMAIL=admin@example.com
```

### Storage Disks

By default, backups are stored on the `local` disk. You can configure additional disks in `config/filesystems.php`:

```php
'disks' => [
    'backups' => [
        'driver' => 'local',
        'root' => storage_path('app/backups'),
    ],
    // Or use S3, etc.
],
```

Then set `BACKUP_STORAGE_DISK=backups` in your `.env`.

## Database Backup Options

### Backup Modes
- **Structure + Data**: Full backup (default)
- **Structure Only**: Only table structures
- **Data Only**: Only table data

### Table Selection
- Leave empty to backup all tables
- Select specific tables to backup only those
- Use exclude option to backup all except selected

## Codebase Backup Options

### Folder Selection
- Leave empty to backup entire codebase
- Select specific folders to backup only those

### Default Excluded Folders
- `vendor`
- `node_modules`
- `storage/logs`
- `storage/framework/cache`
- `storage/framework/sessions`
- `storage/framework/views`
- `.git`
- `.idea`
- `.vscode`
- `tests`
- `bootstrap/cache`

### Compression
- **ZIP**: Standard ZIP compression (recommended)
- **TAR.GZ**: TAR.GZ compression (not yet fully implemented)

## Scheduling

### Frequency Options

- **Minutely**: Every minute (`* * * * *`)
- **Hourly**: Every hour at minute 0 (`0 * * * *`)
- **Daily**: Every day at midnight (`0 0 * * *`)
- **Weekly**: Every Sunday at midnight (`0 0 * * 0`)
- **Monthly**: First day of month at midnight (`0 0 1 * *`)
- **Custom**: Use custom cron expression

### Custom Cron Expression

Format: `minute hour day month weekday`

Examples:
- `0 2 * * *` - Daily at 2 AM
- `0 */6 * * *` - Every 6 hours
- `0 0 * * 1` - Every Monday at midnight
- `30 3 1 * *` - First day of month at 3:30 AM

## API / Programmatic Usage

### Create Backup Programmatically

```php
use App\Services\BackupService;

$backupService = app(BackupService::class);

$backup = $backupService->createBackup([
    'name' => 'Manual Backup',
    'type' => 'database',
    'database_options' => [
        'tables' => ['users', 'posts'],
        'structure_only' => false,
        'data_only' => false,
    ],
]);
```

### Run Scheduled Backups

```php
use App\Services\ScheduleService;

$scheduleService = app(ScheduleService::class);
$results = $scheduleService->runScheduledBackups();
```

### Cleanup Old Backups

```php
use App\Services\BackupService;

$backupService = app(BackupService::class);
$deleted = $backupService->cleanupOldBackups();
```

## Console Commands

### Run Scheduled Backups

```bash
php artisan backup:run-scheduled
```

This command is automatically scheduled to run every minute via Laravel's scheduler.

## Troubleshooting

### Backups Not Running

1. Check if backups are enabled in settings
2. Verify cron job is running: `php artisan schedule:list`
3. Check queue worker is running if using queue
4. Check logs: `storage/logs/laravel.log`

### Out of Memory Errors

Increase memory limit in settings or `php.ini`:
```php
ini_set('memory_limit', '1024M');
```

### Disk Space Issues

- Check available disk space
- Reduce `max_backups_to_keep` setting
- Manually delete old backups
- Increase `min_disk_space_mb` threshold

### MySQL Dump Not Working

1. Ensure `mysqldump` is installed and in PATH
2. Check MySQL credentials in `.env`
3. Verify user has backup permissions
4. System will fallback to PHP-based backup if mysqldump unavailable

## Security Considerations

1. **File Permissions**: Ensure backup files have proper permissions
2. **Storage Location**: Store backups in secure location (not web-accessible)
3. **Encryption**: Enable encryption for sensitive backups
4. **Access Control**: Ensure only authorized users can access backup UI
5. **.env Exclusion**: Always exclude `.env` file from backups

## Performance Tips

1. **Use Queue**: Enable queue for large backups
2. **Selective Backups**: Only backup necessary tables/folders
3. **Schedule Off-Peak**: Run backups during low-traffic periods
4. **Monitor Disk Space**: Set appropriate cleanup policies
5. **Compression**: Use ZIP compression for better performance

## File Structure

```
app/
├── Console/Commands/
│   └── RunScheduledBackups.php
├── Http/Controllers/Backend/
│   ├── BackupController.php
│   ├── BackupScheduleController.php
│   └── BackupSettingsController.php
├── Jobs/
│   ├── ProcessBackupJob.php
│   └── CleanupOldBackupsJob.php
├── Models/
│   ├── Backup.php
│   ├── BackupLog.php
│   ├── BackupSchedule.php
│   └── BackupSetting.php
└── Services/
    ├── BackupService.php
    ├── DatabaseBackupService.php
    ├── FileBackupService.php
    └── ScheduleService.php

config/
└── backup.php

database/migrations/
├── 2024_01_01_000001_create_backup_schedules_table.php
├── 2024_01_01_000002_create_backups_table.php
├── 2024_01_01_000003_create_backup_logs_table.php
└── 2024_01_01_000004_create_backup_settings_table.php

resources/views/backend/backups/
├── index.blade.php
├── create.blade.php
├── logs.blade.php
├── schedules/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
└── settings.blade.php
```

## Support

For issues or questions, please check:
1. Laravel logs: `storage/logs/laravel.log`
2. Backup logs in the admin UI
3. Queue failed jobs: `php artisan queue:failed`

## License

This module is part of your Laravel application and follows the same license.

