<?php

use Illuminate\Support\Facades\Schedule;
use Marinarch\BackupManager\Scheduling\BackupScheduler;

// Helper to auto-register backup schedules based on config.

Schedule::call(function () {
    app(BackupScheduler::class)->schedule();
})->name('backup-manager:dynamic-schedule')->withoutOverlapping();


