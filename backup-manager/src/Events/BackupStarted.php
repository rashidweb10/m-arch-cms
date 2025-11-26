<?php

namespace Marinarch\BackupManager\Events;

use Marinarch\BackupManager\Models\Backup;

class BackupStarted
{
    public function __construct(public Backup $backup)
    {
    }
}


