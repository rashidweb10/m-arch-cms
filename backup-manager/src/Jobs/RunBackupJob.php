<?php

namespace Marinarch\BackupManager\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Marinarch\BackupManager\Services\BackupManager;

class RunBackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ?string $type;

    public function __construct(?string $type = null)
    {
        $this->type = $type;
    }

    public function handle(BackupManager $manager): void
    {
        $manager->run($this->type);
    }
}


