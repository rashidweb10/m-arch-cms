<?php

namespace App\Services;

use App\Models\Backup;
use App\Models\BackupLog;
use App\Models\BackupSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Exception;

class BackupService
{
    protected DatabaseBackupService $databaseService;
    protected FileBackupService $fileService;

    public function __construct()
    {
        $this->databaseService = new DatabaseBackupService();
        $this->fileService = new FileBackupService();
    }

    /**
     * Create a backup.
     */
    public function createBackup(array $data): Backup
    {
        // Check if backups are enabled
        if (!BackupSetting::get('backup_enabled', true)) {
            throw new Exception('Backup system is disabled.');
        }

        // Check disk space
        $this->checkDiskSpace();

        // Get or create backup record (if ID is provided, use existing record)
        $backup = null;
        if (!empty($data['backup_id'])) {
            $backup = Backup::findOrFail($data['backup_id']);
            $backup->update([
                'status' => 'running',
                'started_at' => now(),
            ]);
        } else {
            $backup = Backup::create([
                'backup_schedule_id' => $data['backup_schedule_id'] ?? null,
                'name' => $data['name'],
                'type' => $data['type'],
                'status' => 'running',
                'database_options' => $data['database_options'] ?? null,
                'codebase_options' => $data['codebase_options'] ?? null,
                'storage_disk' => BackupSetting::get('storage_disk', 'local'),
                'started_at' => now(),
            ]);
        }

        try {
            $this->log($backup, 'info', 'Backup started');

            $filePath = $this->generateFilePath($backup);
            $backupFile = null;

            switch ($data['type']) {
                case 'database':
                    $backupFile = $this->createDatabaseBackup($backup, $filePath);
                    break;

                case 'codebase':
                    $backupFile = $this->createCodebaseBackup($backup, $filePath);
                    break;

                case 'combined':
                    $backupFile = $this->createCombinedBackup($backup, $filePath);
                    break;

                default:
                    throw new Exception("Invalid backup type: {$data['type']}");
            }

            // Update backup record
            $fileSize = Storage::disk($backup->storage_disk)->size($backupFile);
            $duration = now()->diffInSeconds($backup->started_at);

            $backup->update([
                'status' => 'success',
                'file_path' => $backupFile,
                'file_name' => basename($backupFile),
                'file_size' => $fileSize,
                'completed_at' => now(),
                'duration_seconds' => $duration,
            ]);

            $this->log($backup, 'success', 'Backup completed successfully', [
                'file_size' => $fileSize,
                'duration' => $duration,
            ]);

            return $backup;
        } catch (Exception $e) {
            $backup->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'completed_at' => now(),
                'duration_seconds' => now()->diffInSeconds($backup->started_at),
            ]);

            $this->log($backup, 'error', 'Backup failed: ' . $e->getMessage());

            throw $e;
        }
    }

    /**
     * Create database backup.
     */
    protected function createDatabaseBackup(Backup $backup, string $filePath): string
    {
        $this->log($backup, 'info', 'Starting database backup');

        $databaseService = new DatabaseBackupService(
            null,
            $backup->database_options ?? []
        );

        $backupFile = $databaseService->createBackup($filePath);

        $this->log($backup, 'info', 'Database backup completed');

        return $backupFile;
    }

    /**
     * Create codebase backup.
     */
    protected function createCodebaseBackup(Backup $backup, string $filePath): string
    {
        $this->log($backup, 'info', 'Starting codebase backup');

        $fileService = new FileBackupService($backup->codebase_options ?? []);
        $backupFile = $fileService->createBackup($filePath);

        $this->log($backup, 'info', 'Codebase backup completed');

        return $backupFile;
    }

    /**
     * Create combined backup.
     */
    protected function createCombinedBackup(Backup $backup, string $filePath): string
    {
        $this->log($backup, 'info', 'Starting combined backup');

        // Create temporary directory in storage
        $tempPath = 'temp/backup_' . $backup->id;
        $disk = Storage::disk('local');
        
        if (!$disk->exists($tempPath)) {
            $disk->makeDirectory($tempPath);
        }

        try {
            // Backup database to temp location
            $dbTempPath = $tempPath . '/database.sql';
            $databaseService = new DatabaseBackupService(null, $backup->database_options ?? []);
            $databaseService->createBackup($dbTempPath);
            $this->log($backup, 'info', 'Database backup completed');

            // Backup codebase to temp location
            $codebaseTempPath = $tempPath . '/codebase.zip';
            $fileService = new FileBackupService($backup->codebase_options ?? []);
            $fileService->createBackup($codebaseTempPath);
            $this->log($backup, 'info', 'Codebase backup completed');

            // Create final combined archive
            $compression = $backup->codebase_options['compression'] ?? config('backup_module.compression_type', 'zip');
            $backupDisk = Storage::disk($backup->storage_disk);
            $fullPath = $backupDisk->path($filePath);

            // Ensure directory exists
            $directory = dirname($fullPath);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            if ($compression === 'zip') {
                $zip = new \ZipArchive();
                if ($zip->open($fullPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
                    $zip->addFile($disk->path($dbTempPath), 'database.sql');
                    $zip->addFile($disk->path($codebaseTempPath), 'codebase.zip');
                    $zip->close();
                } else {
                    throw new Exception('Failed to create combined ZIP archive');
                }
            } else {
                throw new Exception('TAR.GZ compression not yet supported for combined backups');
            }

            // Cleanup temp directory
            $disk->deleteDirectory($tempPath);

            $this->log($backup, 'info', 'Combined backup completed');

            return $filePath;
        } catch (Exception $e) {
            // Cleanup temp directory on error
            if ($disk->exists($tempPath)) {
                $disk->deleteDirectory($tempPath);
            }
            throw $e;
        }
    }

    /**
     * Generate file path for backup.
     */
    protected function generateFilePath(Backup $backup): string
    {
        $prefix = BackupSetting::get('backup_name_prefix', 'backup');
        $storagePath = BackupSetting::get('storage_path', 'backups');
        $timestamp = now()->format('Y-m-d_His');
        $extension = $backup->type === 'database' ? 'sql' : 'zip';

        $fileName = "{$prefix}_{$backup->type}_{$timestamp}.{$extension}";

        return rtrim($storagePath, '/') . '/' . $fileName;
    }

    /**
     * Check available disk space.
     */
    protected function checkDiskSpace(): void
    {
        if (!BackupSetting::get('check_disk_space', true)) {
            return;
        }

        $disk = Storage::disk(BackupSetting::get('storage_disk', 'local'));
        $minSpaceMB = BackupSetting::get('min_disk_space_mb', 100);

        // Get free space
        $freeSpace = disk_free_space($disk->path(''));
        $freeSpaceMB = $freeSpace / (1024 * 1024);

        if ($freeSpaceMB < $minSpaceMB) {
            throw new Exception("Insufficient disk space. Required: {$minSpaceMB}MB, Available: " . round($freeSpaceMB, 2) . "MB");
        }
    }

    /**
     * Log a message for backup.
     */
    protected function log(Backup $backup, string $level, string $message, array $context = []): void
    {
        BackupLog::create([
            'backup_id' => $backup->id,
            'level' => $level,
            'message' => $message,
            'context' => $context,
            'logged_at' => now(),
        ]);
    }

    /**
     * Delete a backup.
     */
    public function deleteBackup(Backup $backup): bool
    {
        try {
            // Delete file
            if ($backup->file_path) {
                Storage::disk($backup->storage_disk)->delete($backup->file_path);
            }

            // Delete logs
            $backup->logs()->delete();

            // Delete backup record
            $backup->delete();

            return true;
        } catch (Exception $e) {
            throw new Exception("Failed to delete backup: " . $e->getMessage());
        }
    }

    /**
     * Cleanup old backups.
     */
    public function cleanupOldBackups(): int
    {
        if (!BackupSetting::get('auto_delete_old_backups', true)) {
            return 0;
        }

        $maxBackups = BackupSetting::get('max_backups_to_keep', 10);

        $backups = Backup::where('status', 'success')
            ->orderBy('created_at', 'desc')
            ->skip($maxBackups)
            ->get();

        $deleted = 0;

        foreach ($backups as $backup) {
            try {
                $this->deleteBackup($backup);
                $deleted++;
            } catch (Exception $e) {
                // Log error but continue
                \Log::error("Failed to delete old backup {$backup->id}: " . $e->getMessage());
            }
        }

        return $deleted;
    }
}

