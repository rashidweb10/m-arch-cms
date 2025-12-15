<?php

namespace App\Services;

use App\Models\BackupSchedule;
use App\Models\Backup;
use App\Services\BackupService;
use Exception;

class ScheduleService
{
    protected BackupService $backupService;

    public function __construct(BackupService $backupService)
    {
        $this->backupService = $backupService;
    }

    /**
     * Run scheduled backups.
     */
    public function runScheduledBackups(): array
    {
        $schedules = BackupSchedule::where('is_enabled', true)->get();
        $results = [];

        foreach ($schedules as $schedule) {
            if ($schedule->shouldRun()) {
                try {
                    $backup = $this->runSchedule($schedule);
                    $results[] = [
                        'schedule_id' => $schedule->id,
                        'schedule_name' => $schedule->name,
                        'status' => 'success',
                        'backup_id' => $backup->id,
                    ];
                } catch (Exception $e) {
                    $schedule->update([
                        'last_status' => 'failed',
                        'last_error' => $e->getMessage(),
                    ]);

                    $results[] = [
                        'schedule_id' => $schedule->id,
                        'schedule_name' => $schedule->name,
                        'status' => 'failed',
                        'error' => $e->getMessage(),
                    ];
                }
            }
        }

        return $results;
    }

    /**
     * Run a specific schedule.
     */
    public function runSchedule(BackupSchedule $schedule): Backup
    {
        // Update schedule status
        $schedule->update([
            'last_run_at' => now(),
            'last_status' => 'running',
        ]);

        try {
            // Create backup
            $backup = $this->backupService->createBackup([
                'backup_schedule_id' => $schedule->id,
                'name' => $schedule->name . ' - ' . now()->format('Y-m-d H:i:s'),
                'type' => $schedule->type,
                'database_options' => $schedule->database_options,
                'codebase_options' => $schedule->codebase_options,
            ]);

            // Update schedule with success
            $schedule->update([
                'last_status' => 'success',
                'last_error' => null,
                'next_run_at' => $schedule->calculateNextRun(),
            ]);

            return $backup;
        } catch (Exception $e) {
            // Update schedule with failure
            $schedule->update([
                'last_status' => 'failed',
                'last_error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Update next run times for all schedules.
     */
    public function updateNextRunTimes(): void
    {
        $schedules = BackupSchedule::where('is_enabled', true)->get();

        foreach ($schedules as $schedule) {
            if (!$schedule->next_run_at) {
                $schedule->updateNextRun();
            }
        }
    }
}

