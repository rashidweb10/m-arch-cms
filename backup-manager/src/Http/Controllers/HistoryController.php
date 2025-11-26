<?php

namespace Marinarch\BackupManager\Http\Controllers;

use Illuminate\Routing\Controller;
use Marinarch\BackupManager\Models\Backup;

class HistoryController extends Controller
{
    public function index()
    {
        $backups = Backup::orderByDesc('created_at')->paginate(50);

        return view('backup-manager::history.index', compact('backups'));
    }
}


