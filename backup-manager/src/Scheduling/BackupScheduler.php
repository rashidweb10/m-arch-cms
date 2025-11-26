<?php

namespace Marinarch\BackupManager\Scheduling;

use Illuminate\Console\Scheduling\Schedule;
use Marinarch\BackupManager\Jobs\RunBackupJob;

class BackupScheduler
{
    public function __construct(protected Schedule $schedule)
    {
    }

    public function schedule(): void
    {
        $schedules = config('backup-manager.schedules', []);

        foreach ($schedules as $key => $config) {
            if (empty($config['enabled']) || empty($config['cron'])) {
                continue;
            }

            $this->schedule->job(new RunBackupJob($key === 'minutely' ? 'full' : null))
                ->cron($config['cron'])
                ->name('backup-manager:' . $key)
                ->withoutOverlapping();
        }
    }
}


