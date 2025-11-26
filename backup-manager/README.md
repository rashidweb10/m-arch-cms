## Laravel Backup Manager

Laravel Backup Manager is a reusable package for **Laravel 9, 10, 11, and 12** that provides:

- **Web UI panel** (Tailwind + Blade) under its own layout.
- **Database + codebase backups** (select tables/folders, compression).
- **Multiple storage destinations**: Local, S3, Google Drive (and custom drivers).
- **Queue-based execution**, **automatic scheduling**, **rotation**, **free-space checks**, and **events**.

This guide shows you how to install and use it in **any Laravel application**.

---

### 1. Requirements

- **PHP**: >= 8.0  
- **Laravel**: 9, 10, 11, or 12  
- A working **database connection**  
- A working **queue** (e.g. `database`, `redis`, `sqs`, etc.)

---

### 2. Installation Options

You can install the package either from **Packagist/VCS** or as a **local path package**.

#### 2.1. Normal installation (Packagist / Git)

When this package is published on Packagist (or via a Git repository), installation is simply:

```bash
composer require marinarch/laravel-backup-manager
```

That’s it – Laravel will auto-discover the service provider:

```php
Marinarch\BackupManager\BackupManagerServiceProvider
```

#### 2.2. Local path installation (for development)

If you have the package **inside your Laravel app** under `backup-manager/`, add this to your app’s `composer.json`:

```json
"repositories": [
  {
    "type": "path",
    "url": "backup-manager"
  }
],
"require": {
  "marinarch/laravel-backup-manager": "*"
}
```

Then run:

```bash
composer update marinarch/laravel-backup-manager
```

> This tells Composer to treat the `backup-manager` folder as the source of the `marinarch/laravel-backup-manager` package.

---

### 3. Publish Config & Assets (optional but recommended)

Publish the config file and Blade views/assets into your app so you can customize them:

```bash
php artisan vendor:publish --provider="Marinarch\\BackupManager\\BackupManagerServiceProvider" --tag=backup-manager-config
php artisan vendor:publish --provider="Marinarch\\BackupManager\\BackupManagerServiceProvider" --tag=backup-manager-assets
```

This will create:

- `config/backup-manager.php`
- `resources/views/vendor/backup-manager/...`
- `public/vendor/backup-manager/...` (if any public assets are added)

---

### 4. Database Migrations

Run migrations so the package tables are created:

```bash
php artisan migrate
```

This adds the tables:

- `backup_manager_backups`
- `backup_manager_settings`

If you ever need to run only this package’s migrations (not normally required), you can:

```bash
php artisan migrate --path=backup-manager/database/migrations
```

---

### 5. Accessing the Web UI Panel

By default, the package registers routes with:

```php
'route_prefix' => 'admin/backup-manager',
'middleware'   => ['web', 'auth'],
```

So the main panel URL is:

- **`/admin/backup-manager`**

Typical local example:

- `http://localhost:8000/admin/backup-manager`

You must:

- Be **logged in** (because of the `auth` middleware).  
- Have the default `web` middleware enabled.

#### 5.1. Changing URL prefix or middleware

In `config/backup-manager.php`:

```php
'route_prefix' => 'admin/backups',     // e.g. becomes /admin/backups
'middleware'   => ['web'],            // no auth, panel is public
```

Then clear & reload routes:

```bash
php artisan route:clear
php artisan config:clear
```

---

### 6. Queue Setup (important)

Backups run through the **queue** (they can be heavy), via the `RunBackupJob` job.

Make sure your queue worker is running:

```bash
php artisan queue:work
```

Configure the default queue connection in `config/queue.php` (e.g. `database`, `redis`, etc.) and your `.env`:

```env
QUEUE_CONNECTION=database
```

---

### 7. Running Backups via CLI

- **Run a full backup (database + codebase, queued)**:

```bash
php artisan backup:run
```

- **Run specific backup type**:

```bash
php artisan backup:run database
php artisan backup:run codebase
```

This dispatches `Marinarch\BackupManager\Jobs\RunBackupJob`, which calls the `BackupManager` service and records a row in `backup_manager_backups`.

---

### 8. Automatic Scheduling (CRON)

The package includes a **scheduler helper** that reads your frequencies from the config / settings table.

In your app’s `app/Console/Kernel.php`:

```php
use Illuminate\Console\Scheduling\Schedule;
use Marinarch\BackupManager\Scheduling\BackupScheduler;

protected function schedule(Schedule $schedule)
{
    app(BackupScheduler::class)->schedule();
}
```

Then configure your system CRON to run Laravel’s scheduler every minute:

```cron
* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

#### 8.1. Frequency & CRON examples

In `config/backup-manager.php` (or via the UI **Settings** page), you can enable and customize:

```php
'schedules' => [
    'minutely' => [
        'enabled' => false,
        'cron' => '* * * * *',
    ],
    'hourly' => [
        'enabled' => true,
        'cron' => '0 * * * *',
    ],
    'daily' => [
        'enabled' => true,
        'cron' => '0 2 * * *',   // every day at 02:00
    ],
    'weekly' => [
        'enabled' => false,
        'cron' => '0 3 * * 0',   // Sunday at 03:00
    ],
    'monthly' => [
        'enabled' => false,
        'cron' => '0 4 1 * *',   // 1st of each month at 04:00
    ],
],
```

The package will register jobs according to these CRON expressions.

---

### 9. Configuration Overview

Open `config/backup-manager.php` (after publishing) for full settings. Key sections:

- **Frequencies**: `schedules[...]` – enable/disable and set CRON per frequency.
- **Database backup**: connection, specific tables, `mysqldump` path, compression (`gz`/`zip`).
- **Codebase backup**: included paths, excluded paths, full-codebase flag, compression.
- **Destinations**:
  - `local` (root path on server)
  - `s3` (filesystem disk + base path)
  - `google` (filesystem disk + base path)
- **Rotation**: keep last N backups per destination.
- **Space**: minimum free space (in MB) required to run backup.
- **Logging**: log channel + optional dedicated log file path.

You can also edit all of this from the **Settings** page in the UI.

---

### 10. Storage Drivers

- **Local**: `Marinarch\BackupManager\Storage\LocalStorageDriver`
  - Uses `root_path` from config (default: `storage/app/backups`).

- **S3**: `Marinarch\BackupManager\Storage\S3StorageDriver`
  - Uses Laravel filesystem disk (e.g. `s3`) and `base_path`.

- **Google Drive**: `Marinarch\BackupManager\Storage\GoogleDriveStorageDriver`
  - Uses Laravel filesystem disk (e.g. `google`) and `base_path`.

Each driver implements the `Marinarch\BackupManager\Contracts\StorageDriver` interface and supports **Test Connection** from the Settings UI.

#### 10.1. Creating a custom storage driver

1. Create a class that implements:

```php
Marinarch\BackupManager\Contracts\StorageDriver
```

2. Implement:

- `store(string $sourcePath, string $destinationPath): int`
- `testConnection(): bool`
- `listBackups(string $prefix = ''): array`
- `delete(string $path): bool`

3. Register your driver in `config/backup-manager.php` under `destinations`:

```php
'destinations' => [
    'my_custom' => [
        'enabled' => true,
        'driver' => App\Backups\MyCustomDriver::class,
        // any other config you need...
    ],
],
```

Now `my_custom` will be treated just like local/S3/Google and appear in the Settings UI.

---

### 11. Backup Types & Behaviour

- **Database backup**
  - Can be restricted to specific tables via `config('backup-manager.database.tables')`.
  - Uses `mysqldump` if enabled and database driver is `mysql` (configurable path).
  - Falls back to a Laravel/Doctrine-based SQL export when `mysqldump` is disabled.
  - Can be compressed as `.gz` or `.zip`.

- **Codebase backup**
  - Archives selected folders (`app`, `config`, `routes`, `resources`, etc.) or full codebase.
  - Excludes `vendor`, `node_modules`, and `storage/logs` by default (can be changed).
  - Primary compression is `.zip`, with optional extra `.gz` step.

Each backup run is recorded in `backup_manager_backups` with:

- Type, destinations, size (bytes), status (`pending`, `running`, `success`, `failed`), and message.

---

### 12. Space Checks and Rotation

- **Free space restriction**:

```php
'space' => [
    'min_free_megabytes' => 512,
],
```

If server free space (under `base_path()`) is less than this value, backup is **skipped** and a log entry is written.

- **Rotation**:

```php
'rotation' => [
    'enabled' => true,
    'keep_last' => 10,
],
```

Per destination, older backups are automatically deleted to keep only the last **N**.

---

### 13. Events

The package fires the following events:

- `Marinarch\BackupManager\Events\BackupStarted`
- `Marinarch\BackupManager\Events\BackupCompleted`
- `Marinarch\BackupManager\Events\BackupFailed`

You can listen to them in your app (e.g. send notifications, Slack alerts, etc.).

Example in `EventServiceProvider`:

```php
protected $listen = [
    \Marinarch\BackupManager\Events\BackupCompleted::class => [
        App\Listeners\NotifyBackupCompleted::class,
    ],
];
```

---

### 14. Troubleshooting

- **404 when opening `/admin/backup-manager`**
  - Ensure the package is installed (`composer show marinarch/laravel-backup-manager`).
  - Ensure migrations have run: `php artisan migrate`.
  - Check `php artisan route:list | grep backup-manager` (or `findstr` on Windows).
  - Verify you are logged in if `auth` middleware is used.

- **Backups not appearing in history**
  - Make sure `php artisan queue:work` is running.
  - Check that `QUEUE_CONNECTION` is configured correctly.

- **Storage connection issues**
  - Use the **Test Connection** button in the Settings page for each destination.
  - Verify your filesystem disks (`config/filesystems.php`) for S3/Google.

- **Debugging errors**
  - Check your Laravel log channel (e.g. `storage/logs/laravel.log`).
  - Check the package-specific log file (`storage/logs/backup-manager.log` by default).

This README should give you everything you need to **drop the package into any Laravel app** and get backups running with both CLI and UI control.

