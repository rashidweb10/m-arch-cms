<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('backup_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, boolean, integer, json
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('backup_settings')->insert([
            ['key' => 'backup_enabled', 'value' => '1', 'type' => 'boolean', 'description' => 'Enable/disable backup system'],
            ['key' => 'backup_name_prefix', 'value' => 'backup', 'type' => 'string', 'description' => 'Prefix for backup file names'],
            ['key' => 'max_backups_to_keep', 'value' => '10', 'type' => 'integer', 'description' => 'Maximum number of backups to keep'],
            ['key' => 'auto_delete_old_backups', 'value' => '1', 'type' => 'boolean', 'description' => 'Automatically delete old backups'],
            ['key' => 'compression_type', 'value' => 'zip', 'type' => 'string', 'description' => 'Compression type: zip or tar.gz'],
            ['key' => 'storage_disk', 'value' => 'local', 'type' => 'string', 'description' => 'Storage disk for backups'],
            ['key' => 'storage_path', 'value' => 'backups', 'type' => 'string', 'description' => 'Storage path for backups'],
            ['key' => 'check_disk_space', 'value' => '1', 'type' => 'boolean', 'description' => 'Check disk space before backup'],
            ['key' => 'min_disk_space_mb', 'value' => '100', 'type' => 'integer', 'description' => 'Minimum disk space required (MB)'],
            ['key' => 'encrypt_backups', 'value' => '0', 'type' => 'boolean', 'description' => 'Encrypt backup files'],
            ['key' => 'exclude_env_file', 'value' => '1', 'type' => 'boolean', 'description' => 'Exclude .env file from backups'],
            ['key' => 'exclude_sensitive_files', 'value' => '1', 'type' => 'boolean', 'description' => 'Exclude sensitive files'],
            ['key' => 'memory_limit', 'value' => '512M', 'type' => 'string', 'description' => 'Memory limit for backup process'],
            ['key' => 'timeout', 'value' => '3600', 'type' => 'integer', 'description' => 'Backup timeout in seconds'],
            ['key' => 'use_queue', 'value' => '1', 'type' => 'boolean', 'description' => 'Run backups via queue'],
            ['key' => 'email_on_failure', 'value' => '1', 'type' => 'boolean', 'description' => 'Send email notification on failure'],
            ['key' => 'email_on_success', 'value' => '0', 'type' => 'boolean', 'description' => 'Send email notification on success'],
            ['key' => 'notification_email', 'value' => '', 'type' => 'string', 'description' => 'Email address for notifications'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backup_settings');
    }
};

