<?php

namespace Marinarch\BackupManager\Events;

use Marinarch\BackupManager\Models\Backup;

class BackupCompleted
{
    public function __construct(public Backup $backup)
    {
    }
}


