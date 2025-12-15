<?php

namespace App\Jobs;

use App\Models\Backup;
use App\Services\BackupService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Exception;

class ProcessBackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout;
    public int $tries = 1;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Backup $backup
    ) {
        $this->timeout = config('backup_module.performance.timeout', 3600);
    }

    /**
     * Execute the job.
     */
    public function handle(BackupService $backupService): void
    {
        try {
            // Set memory limit
            $memoryLimit = config('backup_module.performance.memory_limit', '512M');
            ini_set('memory_limit', $memoryLimit);

            // Update backup status
            $this->backup->update(['status' => 'running']);

            // Create backup data array
            $backupData = [
                'backup_id' => $this->backup->id,
                'backup_schedule_id' => $this->backup->backup_schedule_id,
                'name' => $this->backup->name,
                'type' => $this->backup->type,
                'database_options' => $this->backup->database_options,
                'codebase_options' => $this->backup->codebase_options,
            ];

            // Create the backup
            $backupService->createBackup($backupData);

            Log::info("Backup job completed successfully for backup ID: {$this->backup->id}");
        } catch (Exception $e) {
            Log::error("Backup job failed for backup ID: {$this->backup->id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->backup->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'completed_at' => now(),
            ]);

            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Exception $exception): void
    {
        $this->backup->update([
            'status' => 'failed',
            'error_message' => $exception ? $exception->getMessage() : 'Unknown error',
            'completed_at' => now(),
        ]);

        Log::error("Backup job failed permanently for backup ID: {$this->backup->id}", [
            'error' => $exception ? $exception->getMessage() : 'Unknown error',
        ]);
    }
}

