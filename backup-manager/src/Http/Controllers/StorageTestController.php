<?php

namespace Marinarch\BackupManager\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Marinarch\BackupManager\Contracts\StorageDriver;

class StorageTestController extends Controller
{
    public function store(string $driver): JsonResponse
    {
        $destinations = config('backup-manager.destinations', []);

        if (! isset($destinations[$driver])) {
            return response()->json(['message' => 'Unknown storage driver.'], 404);
        }

        $driverClass = $destinations[$driver]['driver'] ?? null;

        if (! $driverClass || ! class_exists($driverClass)) {
            return response()->json(['message' => 'Driver class not found.'], 500);
        }

        /** @var StorageDriver $instance */
        $instance = app($driverClass);

        $ok = $instance->testConnection();

        return response()->json([
            'ok' => $ok,
            'message' => $ok ? 'Connection successful.' : 'Connection failed.',
        ]);
    }
}


