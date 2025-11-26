<?php

namespace Marinarch\BackupManager\Events;

use Marinarch\BackupManager\Models\Backup;

class BackupFailed
{
    public function __construct(public Backup $backup, public \Throwable $exception)
    {
    }
}


