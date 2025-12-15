<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backup;
use App\Services\BackupService;
use App\Jobs\ProcessBackupJob;
use App\Models\BackupSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    protected $moduleName;
    protected $folderName;
    protected $routeName;

    protected BackupService $backupService;

    public function __construct(BackupService $backupService)
    {
        $this->moduleName = 'Backups';
        $this->folderName = 'backups';
        $this->routeName = 'backups';
        $this->backupService = $backupService;
        
        view()->share('moduleName', $this->moduleName);
        view()->share('folderName', $this->folderName);
        view()->share('routeName', $this->routeName);
    }

    /**
     * Display a listing of backups.
     */
    public function index()
    {
        $search = request()->input('search');
        $type = request()->input('type');
        $status = request()->input('status');
        
        $sort = request()->input('sort', 'id');
        $direction = strtolower(request()->input('direction', 'desc')) === 'asc' ? 'asc' : 'desc';
        
        $query = Backup::with('schedule');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                  ->orWhere('file_name', 'like', '%'.$search.'%');
            });
        }
        
        if ($type) {
            $query->where('type', $type);
        }
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $query->orderBy($sort, $direction);
        
        $backups = $query->paginate(config('custom.pagination_per_page'));
        
        return view('backend.' . $this->folderName . '.index', compact('backups'));
    }

    /**
     * Show the form for creating a new backup.
     */
    public function create()
    {
        $tables = $this->getDatabaseTables();
        $folders = $this->getProjectFolders();
        
        return view('backend.' . $this->folderName . '.create', compact('tables', 'folders'));
    }

    /**
     * Store a newly created backup.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:database,codebase,combined',
            'database_options' => 'nullable|array',
            'codebase_options' => 'nullable|array',
        ]);

        try {
            // Create backup record
            $backup = Backup::create([
                'name' => $request->name,
                'type' => $request->type,
                'status' => 'pending',
                'database_options' => $request->database_options ?? null,
                'codebase_options' => $request->codebase_options ?? null,
                'storage_disk' => BackupSetting::get('storage_disk', 'local'),
            ]);

            // Dispatch job if queue is enabled
            if (BackupSetting::get('use_queue', true)) {
                ProcessBackupJob::dispatch($backup);
                return redirect()->route($this->routeName . '.index')
                    ->with('success', 'Backup has been queued and will be processed shortly.');
            }

            // Run immediately
            $this->backupService->createBackup([
                'backup_schedule_id' => null,
                'name' => $request->name,
                'type' => $request->type,
                'database_options' => $request->database_options,
                'codebase_options' => $request->codebase_options,
            ]);

            return redirect()->route($this->routeName . '.index')
                ->with('success', 'Backup created successfully!');
        } catch (\Exception $e) {
            return redirect()->route($this->routeName . '.create')
                ->with('error', 'Failed to create backup: ' . $e->getMessage());
        }
    }

    /**
     * Download a backup file.
     */
    public function download($id)
    {
        $backup = Backup::findOrFail($id);
        
        if (!$backup->file_path || !Storage::disk($backup->storage_disk)->exists($backup->file_path)) {
            return redirect()->route($this->routeName . '.index')
                ->with('error', 'Backup file not found.');
        }

        return Storage::disk($backup->storage_disk)->download($backup->file_path, $backup->file_name);
    }

    /**
     * Delete a backup.
     */
    public function destroy($id)
    {
        try {
            $backup = Backup::findOrFail($id);
            $this->backupService->deleteBackup($backup);
            
            return redirect()->route($this->routeName . '.index')
                ->with('success', 'Backup deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route($this->routeName . '.index')
                ->with('error', 'Failed to delete backup: ' . $e->getMessage());
        }
    }

    /**
     * View backup logs.
     */
    public function logs($id)
    {
        $backup = Backup::with('logs')->findOrFail($id);
        
        return view('backend.' . $this->folderName . '.logs', compact('backup'));
    }

    /**
     * Get database tables.
     */
    protected function getDatabaseTables(): array
    {
        $tables = DB::select('SHOW TABLES');
        $tableKey = 'Tables_in_' . config('database.connections.' . config('database.default') . '.database');
        
        return array_map(function ($table) use ($tableKey) {
            return $table->$tableKey;
        }, $tables);
    }

    /**
     * Get project folders.
     */
    protected function getProjectFolders(): array
    {
        $basePath = base_path();
        $folders = [];
        
        $items = scandir($basePath);
        
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            
            $path = $basePath . '/' . $item;
            
            if (is_dir($path) && !in_array($item, ['.git', 'node_modules', 'vendor'])) {
                $folders[] = $item;
            }
        }
        
        return $folders;
    }
}

