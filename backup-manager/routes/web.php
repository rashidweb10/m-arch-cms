<?php

use Illuminate\Support\Facades\Route;
use Marinarch\BackupManager\Http\Controllers\DashboardController;
use Marinarch\BackupManager\Http\Controllers\SettingsController;
use Marinarch\BackupManager\Http\Controllers\HistoryController;
use Marinarch\BackupManager\Http\Controllers\LogController;
use Marinarch\BackupManager\Http\Controllers\ManualBackupController;
use Marinarch\BackupManager\Http\Controllers\StorageTestController;

Route::name('backup-manager.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');

        Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

        Route::post('/run', [ManualBackupController::class, 'store'])->name('run.store');

        Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

        Route::post('/storage/{driver}/test', [StorageTestController::class, 'store'])
            ->name('storage.test');
    });


