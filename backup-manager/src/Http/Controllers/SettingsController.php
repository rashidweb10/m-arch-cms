<?php

namespace Marinarch\BackupManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Marinarch\BackupManager\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $config = config('backup-manager');

        $settings = [
            'schedules' => Setting::getValue('schedules', $config['schedules']),
            'destinations' => Setting::getValue('destinations', $config['destinations']),
            'rotation' => Setting::getValue('rotation', $config['rotation']),
            'space' => Setting::getValue('space', $config['space']),
            'logging' => Setting::getValue('logging', $config['logging']),
        ];

        return view('backup-manager::settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'schedules' => 'array',
            'destinations' => 'array',
            'rotation' => 'array',
            'space' => 'array',
            'logging' => 'array',
        ]);

        foreach ($data as $key => $value) {
            Setting::setValue($key, $value);
        }

        return redirect()
            ->route('backup-manager.settings.index')
            ->with('backup_manager_success', 'Settings updated successfully.');
    }
}


