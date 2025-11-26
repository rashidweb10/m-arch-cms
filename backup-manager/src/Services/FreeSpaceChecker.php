<?php

namespace Marinarch\BackupManager\Services;

class FreeSpaceChecker
{
    public function hasEnoughSpace(): bool
    {
        $minMb = (int) config('backup-manager.space.min_free_megabytes', 0);

        if ($minMb <= 0) {
            return true;
        }

        $path = base_path();
        $freeBytes = @disk_free_space($path);

        if ($freeBytes === false) {
            return true;
        }

        $freeMb = $freeBytes / 1024 / 1024;

        return $freeMb >= $minMb;
    }
}


