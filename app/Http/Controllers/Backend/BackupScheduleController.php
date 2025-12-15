<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BackupSchedule;
use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackupScheduleController extends Controller
{
    protected $moduleName;
    protected $folderName;
    protected $routeName;

    protected ScheduleService $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->moduleName = 'Backup Schedules';
        $this->folderName = 'backups';
        $this->routeName = 'backup-schedules';
        $this->scheduleService = $scheduleService;
        
        view()->share('moduleName', $this->moduleName);
        view()->share('folderName', $this->folderName);
        view()->share('routeName', $this->routeName);
    }

    /**
     * Display a listing of schedules.
     */
    public function index()
    {
        $search = request()->input('search');
        $sort = request()->input('sort', 'id');
        $direction = strtolower(request()->input('direction', 'desc')) === 'asc' ? 'asc' : 'desc';
        
        $query = BackupSchedule::withCount('backups');
        
        if ($search) {
            $query->where('name', 'like', '%'.$search.'%');
        }
        
        $query->orderBy($sort, $direction);
        
        $schedules = $query->paginate(config('custom.pagination_per_page'));
        
        return view('backend.' . $this->folderName . '.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create()
    {
        $tables = $this->getDatabaseTables();
        $folders = $this->getProjectFolders();
        
        return view('backend.' . $this->folderName . '.schedules.create', compact('tables', 'folders'));
    }

    /**
     * Store a newly created schedule.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:database,codebase,combined',
            'frequency' => 'required|in:minutely,hourly,daily,weekly,monthly,custom',
            'cron_expression' => 'required_if:frequency,custom|nullable|string',
            'is_enabled' => 'boolean',
            'database_options' => 'nullable|array',
            'codebase_options' => 'nullable|array',
        ]);

        try {
            $schedule = BackupSchedule::create([
                'name' => $request->name,
                'type' => $request->type,
                'frequency' => $request->frequency,
                'cron_expression' => $request->cron_expression,
                'is_enabled' => $request->has('is_enabled'),
                'database_options' => $request->database_options ?? null,
                'codebase_options' => $request->codebase_options ?? null,
                'next_run_at' => (new BackupSchedule($request->all()))->calculateNextRun(),
            ]);

            return redirect()->route($this->routeName . '.index')
                ->with('success', 'Schedule created successfully!');
        } catch (\Exception $e) {
            return redirect()->route($this->routeName . '.create')
                ->with('error', 'Failed to create schedule: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing a schedule.
     */
    public function edit($id)
    {
        $schedule = BackupSchedule::findOrFail($id);
        $tables = $this->getDatabaseTables();
        $folders = $this->getProjectFolders();
        
        return view('backend.' . $this->folderName . '.schedules.edit', compact('schedule', 'tables', 'folders'));
    }

    /**
     * Update a schedule.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:database,codebase,combined',
            'frequency' => 'required|in:minutely,hourly,daily,weekly,monthly,custom',
            'cron_expression' => 'required_if:frequency,custom|nullable|string',
            'is_enabled' => 'boolean',
            'database_options' => 'nullable|array',
            'codebase_options' => 'nullable|array',
        ]);

        try {
            $schedule = BackupSchedule::findOrFail($id);
            $schedule->update([
                'name' => $request->name,
                'type' => $request->type,
                'frequency' => $request->frequency,
                'cron_expression' => $request->cron_expression,
                'is_enabled' => $request->has('is_enabled'),
                'database_options' => $request->database_options ?? null,
                'codebase_options' => $request->codebase_options ?? null,
            ]);

            // Recalculate next run time
            $schedule->updateNextRun();

            return redirect()->route($this->routeName . '.edit', $id)
                ->with('success', 'Schedule updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route($this->routeName . '.edit', $id)
                ->with('error', 'Failed to update schedule: ' . $e->getMessage());
        }
    }

    /**
     * Delete a schedule.
     */
    public function destroy($id)
    {
        try {
            $schedule = BackupSchedule::findOrFail($id);
            $schedule->delete();
            
            return redirect()->route($this->routeName . '.index')
                ->with('success', 'Schedule deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route($this->routeName . '.index')
                ->with('error', 'Failed to delete schedule: ' . $e->getMessage());
        }
    }

    /**
     * Run a schedule manually.
     */
    public function run($id)
    {
        try {
            $schedule = BackupSchedule::findOrFail($id);
            $this->scheduleService->runSchedule($schedule);
            
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Schedule executed successfully!']);
            }
            
            return redirect()->route($this->routeName . '.index')
                ->with('success', 'Schedule executed successfully!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            
            return redirect()->route($this->routeName . '.index')
                ->with('error', 'Failed to run schedule: ' . $e->getMessage());
        }
    }

    /**
     * Toggle schedule enabled status.
     */
    public function toggle($id)
    {
        try {
            $schedule = BackupSchedule::findOrFail($id);
            $schedule->update([
                'is_enabled' => !$schedule->is_enabled,
            ]);
            
            if ($schedule->is_enabled) {
                $schedule->updateNextRun();
            }
            
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Schedule status updated!']);
            }
            
            return redirect()->route($this->routeName . '.index')
                ->with('success', 'Schedule status updated!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            
            return redirect()->route($this->routeName . '.index')
                ->with('error', 'Failed to update schedule: ' . $e->getMessage());
        }
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

