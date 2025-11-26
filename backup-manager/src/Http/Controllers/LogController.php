<?php

namespace Marinarch\BackupManager\Http\Controllers;

use Illuminate\Routing\Controller;

class LogController extends Controller
{
    public function index()
    {
        $logPath = config('backup-manager.logging.log_path', storage_path('logs/backup-manager.log'));

        $logContent = is_file($logPath) ? file_get_contents($logPath) : '';

        return view('backup-manager::logs.index', compact('logContent'));
    }
}


