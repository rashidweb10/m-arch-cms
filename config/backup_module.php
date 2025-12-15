<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Backup System Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the default configuration for the backup management
    | system. These settings can be overridden via the admin UI.
    |
    */

    'enabled' => env('BACKUP_ENABLED', true),

    'name_prefix' => env('BACKUP_NAME_PREFIX', 'backup'),

    'max_backups_to_keep' => env('BACKUP_MAX_KEEP', 10),

    'auto_delete_old_backups' => env('BACKUP_AUTO_DELETE', true),

    'compression_type' => env('BACKUP_COMPRESSION', 'zip'), // zip or tar.gz

    'storage' => [
        'disk' => env('BACKUP_STORAGE_DISK', 'local'),
        'path' => env('BACKUP_STORAGE_PATH', 'backups'),
    ],

    'disk_space' => [
        'check_before_backup' => env('BACKUP_CHECK_DISK_SPACE', true),
        'min_space_mb' => env('BACKUP_MIN_DISK_SPACE_MB', 100),
    ],

    'security' => [
        'encrypt_backups' => env('BACKUP_ENCRYPT', false),
        'exclude_env_file' => env('BACKUP_EXCLUDE_ENV', true),
        'exclude_sensitive_files' => env('BACKUP_EXCLUDE_SENSITIVE', true),
        'sensitive_patterns' => [
            '.env',
            '.env.*',
            '*.key',
            '*.pem',
            'storage/logs/*',
            'storage/framework/cache/*',
            'storage/framework/sessions/*',
            'storage/framework/views/*',
        ],
    ],

    'performance' => [
        'memory_limit' => env('BACKUP_MEMORY_LIMIT', '512M'),
        'timeout' => env('BACKUP_TIMEOUT', 3600), // seconds
        'use_queue' => env('BACKUP_USE_QUEUE', true),
        'queue_connection' => env('BACKUP_QUEUE_CONNECTION', 'default'),
    ],

    'notifications' => [
        'email_on_failure' => env('BACKUP_EMAIL_ON_FAILURE', true),
        'email_on_success' => env('BACKUP_EMAIL_ON_SUCCESS', false),
        'notification_email' => env('BACKUP_NOTIFICATION_EMAIL', env('MAIL_FROM_ADDRESS')),
    ],

    'database' => [
        'default_connection' => env('DB_CONNECTION', 'mysql'),
        'chunk_size' => env('BACKUP_DB_CHUNK_SIZE', 1000),
        'use_mysqldump' => env('BACKUP_USE_MYSQLDUMP', true),
        'mysqldump_path' => env('MYSQLDUMP_PATH', 'mysqldump'),
    ],

    'codebase' => [
        'default_exclude' => [
            'vendor',
            'node_modules',
            'storage/logs',
            'storage/framework/cache',
            'storage/framework/sessions',
            'storage/framework/views',
            '.git',
            '.idea',
            '.vscode',
            'tests',
            'bootstrap/cache',
        ],
    ],
];

