<?php

namespace App\Jobs;

use App\Services\BackupService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CleanupOldBackupsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(BackupService $backupService): void
    {
        try {
            $deleted = $backupService->cleanupOldBackups();
            
            Log::info("Cleanup job completed. Deleted {$deleted} old backup(s).");
        } catch (\Exception $e) {
            Log::error("Cleanup job failed: " . $e->getMessage());
            throw $e;
        }
    }
}

