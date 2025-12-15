<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BackupSetting;
use Illuminate\Http\Request;

class BackupSettingsController extends Controller
{
    protected $moduleName;
    protected $folderName;
    protected $routeName;

    public function __construct()
    {
        $this->moduleName = 'Backup Settings';
        $this->folderName = 'backups';
        $this->routeName = 'backup-settings';
        
        view()->share('moduleName', $this->moduleName);
        view()->share('folderName', $this->folderName);
        view()->share('routeName', $this->routeName);
    }

    /**
     * Display backup settings.
     */
    public function index()
    {
        $settings = BackupSetting::allAsArray();
        
        return view('backend.' . $this->folderName . '.settings', compact('settings'));
    }

    /**
     * Update backup settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'backup_enabled' => 'boolean',
            'backup_name_prefix' => 'required|string|max:50',
            'max_backups_to_keep' => 'required|integer|min:1|max:1000',
            'auto_delete_old_backups' => 'boolean',
            'compression_type' => 'required|in:zip,tar.gz',
            'storage_disk' => 'required|string',
            'storage_path' => 'required|string|max:255',
            'check_disk_space' => 'boolean',
            'min_disk_space_mb' => 'required|integer|min:1',
            'encrypt_backups' => 'boolean',
            'exclude_env_file' => 'boolean',
            'exclude_sensitive_files' => 'boolean',
            'memory_limit' => 'required|string',
            'timeout' => 'required|integer|min:60',
            'use_queue' => 'boolean',
            'email_on_failure' => 'boolean',
            'email_on_success' => 'boolean',
            'notification_email' => 'nullable|email',
        ]);

        try {
            foreach ($validated as $key => $value) {
                $type = $this->getSettingType($key);
                BackupSetting::set($key, $value, $type);
            }

            return redirect()->route($this->routeName . '.index')
                ->with('success', 'Settings updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route($this->routeName . '.index')
                ->with('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }

    /**
     * Get setting type based on key.
     */
    protected function getSettingType(string $key): string
    {
        $booleanKeys = [
            'backup_enabled',
            'auto_delete_old_backups',
            'check_disk_space',
            'encrypt_backups',
            'exclude_env_file',
            'exclude_sensitive_files',
            'use_queue',
            'email_on_failure',
            'email_on_success',
        ];

        $integerKeys = [
            'max_backups_to_keep',
            'min_disk_space_mb',
            'timeout',
        ];

        if (in_array($key, $booleanKeys)) {
            return 'boolean';
        }

        if (in_array($key, $integerKeys)) {
            return 'integer';
        }

        return 'string';
    }
}

