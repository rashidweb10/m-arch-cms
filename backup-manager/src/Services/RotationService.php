<?php

namespace Marinarch\BackupManager\Services;

use Marinarch\BackupManager\Contracts\StorageDriver;

class RotationService
{
    public function rotate(StorageDriver $driver, string $prefix): void
    {
        $config = config('backup-manager.rotation');

        if (empty($config['enabled'])) {
            return;
        }

        $keepLast = (int) ($config['keep_last'] ?? 10);

        $files = $driver->listBackups($prefix);

        if (count($files) <= $keepLast) {
            return;
        }

        $toDelete = array_slice($files, 0, count($files) - $keepLast);

        foreach ($toDelete as $file) {
            $driver->delete($file['path']);
        }
    }
}


