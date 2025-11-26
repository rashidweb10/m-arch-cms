<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Backup Frequencies
    |--------------------------------------------------------------------------
    |
    | Enable/disable available backup schedules and customize their CRON
    | expressions. You can attach these to Laravel's scheduler using the
    | helper shown in the documentation.
    |
    */

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
            'cron' => '0 2 * * *',
        ],
        'weekly' => [
            'enabled' => false,
            'cron' => '0 3 * * 0',
        ],
        'monthly' => [
            'enabled' => false,
            'cron' => '0 4 1 * *',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Backup Types
    |--------------------------------------------------------------------------
    */

    'database' => [
        'enabled' => true,
        'connection' => env('DB_CONNECTION', 'mysql'),
        'tables' => [
            // leave empty for full database, or list table names
        ],
        'use_mysqldump' => env('BACKUP_MANAGER_USE_MYSQLDUMP', true),
        'mysqldump_path' => env('BACKUP_MANAGER_MYSQLDUMP_PATH', 'mysqldump'),
        'compress' => true,
        'compression' => env('BACKUP_MANAGER_DB_COMPRESSION', 'gz'), // gz or zip
    ],

    'codebase' => [
        'enabled' => true,
        'include_paths' => [
            'app',
            'config',
            'routes',
            'resources',
        ],
        'exclude_paths' => [
            'vendor',
            'node_modules',
            'storage/logs',
        ],
        'full_codebase' => false,
        'compress' => true,
        'compression' => env('BACKUP_MANAGER_CODE_COMPRESSION', 'zip'), // zip or gz
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage Destinations
    |--------------------------------------------------------------------------
    |
    | Configure where backups should be stored. Multiple destinations can
    | be enabled at the same time. Each must implement the StorageDriver
    | interface.
    |
    */

    'destinations' => [
        'local' => [
            'enabled' => true,
            'driver' => Marinarch\BackupManager\Storage\LocalStorageDriver::class,
            'root_path' => storage_path('app/backups'),
        ],
        's3' => [
            'enabled' => false,
            'driver' => Marinarch\BackupManager\Storage\S3StorageDriver::class,
            'disk' => env('BACKUP_MANAGER_S3_DISK', 's3'),
            'base_path' => env('BACKUP_MANAGER_S3_PATH', 'backups'),
        ],
        'google' => [
            'enabled' => false,
            'driver' => Marinarch\BackupManager\Storage\GoogleDriveStorageDriver::class,
            'disk' => env('BACKUP_MANAGER_GOOGLE_DISK', 'google'),
            'base_path' => env('BACKUP_MANAGER_GOOGLE_PATH', 'backups'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global Backup Settings
    |--------------------------------------------------------------------------
    */

    'rotation' => [
        'enabled' => true,
        'keep_last' => 10,
    ],

    'space' => [
        'min_free_megabytes' => 512,
    ],

    'logging' => [
        'channel' => env('BACKUP_MANAGER_LOG_CHANNEL', 'stack'),
        'separate_log_file' => true,
        'log_path' => storage_path('logs/backup-manager.log'),
    ],

    'route_prefix' => 'admin/backup-manager',

    'middleware' => ['web', 'auth'],
];


