<?php

namespace Marinarch\BackupManager\Console;

use Illuminate\Console\Command;
use Marinarch\BackupManager\Jobs\RunBackupJob;

class RunBackupCommand extends Command
{
    protected $signature = 'backup:run {type? : Optionally specify database, codebase, or full}';

    protected $description = 'Run a backup (database, codebase, or full) via the queue.';

    public function handle(): int
    {
        $type = $this->argument('type');

        RunBackupJob::dispatch($type);

        $this->info('Backup job dispatched to queue.');

        return self::SUCCESS;
    }
}


