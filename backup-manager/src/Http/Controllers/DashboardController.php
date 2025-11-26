<?php

namespace Marinarch\BackupManager\Http\Controllers;

use Illuminate\Routing\Controller;
use Marinarch\BackupManager\Models\Backup;

class DashboardController extends Controller
{
    public function index()
    {
        $recentBackups = Backup::orderByDesc('created_at')->limit(10)->get();

        $last = $recentBackups->first();

        $summary = [
            'last_backup_at' => optional($last)->created_at,
            'last_backup_status' => optional($last)->status,
            'total_backups' => Backup::count(),
            'used_space' => $this->formatBytes(Backup::sum('size_bytes')),
        ];

        return view('backup-manager::dashboard.index', compact('summary', 'recentBackups'));
    }

    protected function formatBytes(int $bytes): string
    {
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = (int) floor(log($bytes, 1024));
        $power = min($power, count($units) - 1);

        return number_format($bytes / (1024 ** $power), 2) . ' ' . $units[$power];
    }
}


