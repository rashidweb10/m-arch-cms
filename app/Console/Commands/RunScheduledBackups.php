<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ScheduleService;
use App\Services\BackupService;
use App\Jobs\CleanupOldBackupsJob;

class RunScheduledBackups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:run-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all scheduled backups that are due';

    /**
     * Execute the console command.
     */
    public function handle(ScheduleService $scheduleService, BackupService $backupService): int
    {
        $this->info('Checking for scheduled backups...');

        try {
            // Update next run times for schedules that don't have one
            $scheduleService->updateNextRunTimes();

            // Run scheduled backups
            $results = $scheduleService->runScheduledBackups();

            if (empty($results)) {
                $this->info('No scheduled backups to run at this time.');
                return Command::SUCCESS;
            }

            $this->info('Processed ' . count($results) . ' schedule(s):');

            foreach ($results as $result) {
                if ($result['status'] === 'success') {
                    $this->info("  ✓ {$result['schedule_name']} - Backup ID: {$result['backup_id']}");
                } else {
                    $this->error("  ✗ {$result['schedule_name']} - Error: {$result['error']}");
                }
            }

            // Run cleanup job
            $this->info('Running cleanup of old backups...');
            CleanupOldBackupsJob::dispatch();

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error running scheduled backups: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}

