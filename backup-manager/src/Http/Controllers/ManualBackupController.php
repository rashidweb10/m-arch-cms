<?php

namespace Marinarch\BackupManager\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Marinarch\BackupManager\Jobs\RunBackupJob;

class ManualBackupController extends Controller
{
    public function store(): RedirectResponse
    {
        RunBackupJob::dispatch('full');

        return redirect()
            ->back()
            ->with('backup_manager_success', 'Backup job dispatched to queue.');
    }
}


