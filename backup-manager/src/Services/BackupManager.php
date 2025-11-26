<?php

namespace Marinarch\BackupManager\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Marinarch\BackupManager\Contracts\StorageDriver;
use Marinarch\BackupManager\Events\BackupCompleted;
use Marinarch\BackupManager\Events\BackupFailed;
use Marinarch\BackupManager\Events\BackupStarted;
use Marinarch\BackupManager\Models\Backup;

class BackupManager
{
    public function __construct(
        protected DatabaseBackupService $databaseBackup,
        protected CodebaseBackupService $codebaseBackup,
        protected FreeSpaceChecker $freeSpaceChecker,
        protected RotationService $rotationService,
    ) {
    }

    public function run(?string $type = null): Backup
    {
        $logChannel = config('backup-manager.logging.channel', 'stack');

        if (! $this->freeSpaceChecker->hasEnoughSpace()) {
            $backup = Backup::create([
                'type' => $type ?: 'auto',
                'status' => 'failed',
                'message' => 'Insufficient free disk space for backup.',
            ]);

            Log::channel($logChannel)->warning('Backup skipped due to insufficient disk space.', ['backup_id' => $backup->id]);

            event(new BackupFailed($backup, new \RuntimeException('Insufficient disk space.')));

            return $backup;
        }

        $backup = Backup::create([
            'type' => $type ?: 'full',
            'status' => 'running',
        ]);

        event(new BackupStarted($backup));

        try {
            $tempDir = storage_path('app/backup-manager/tmp/' . $backup->id);
            if (! is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $paths = [];

            if (config('backup-manager.database.enabled')) {
                $paths['database'] = $this->databaseBackup->createDump($tempDir);
            }

            if (config('backup-manager.codebase.enabled')) {
                $paths['codebase'] = $this->codebaseBackup->createArchive($tempDir);
            }

            $destinationsConfig = config('backup-manager.destinations', []);
            $destinationsUsed = [];
            $sizeTotal = 0;

            foreach ($destinationsConfig as $key => $destination) {
                if (empty($destination['enabled'])) {
                    continue;
                }

                $driverClass = Arr::get($destination, 'driver');
                if (! $driverClass || ! class_exists($driverClass)) {
                    continue;
                }

                /** @var StorageDriver $driver */
                $driver = app($driverClass);

                foreach ($paths as $kind => $sourcePath) {
                    $fileName = $backup->id . '-' . $kind . '-' . basename($sourcePath);
                    $wrote = $driver->store($sourcePath, date('Y/m/d') . '/' . $fileName);
                    $sizeTotal += $wrote;

                    $this->rotationService->rotate($driver, '');
                }

                $destinationsUsed[] = $key;
            }

            $backup->update([
                'destinations' => $destinationsUsed,
                'size_bytes' => $sizeTotal,
                'status' => 'success',
                'message' => 'Backup completed successfully.',
            ]);

            Log::channel($logChannel)->info('Backup completed successfully.', ['backup_id' => $backup->id]);

            event(new BackupCompleted($backup));
        } catch (\Throwable $e) {
            $backup->update([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ]);

            Log::channel($logChannel)->error('Backup failed.', [
                'backup_id' => $backup->id,
                'exception' => $e,
            ]);

            event(new BackupFailed($backup, $e));
        }

        return $backup;
    }
}


