<?php

namespace Marinarch\BackupManager\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseBackupService
{
    public function createDump(string $destinationDir): string
    {
        $config = config('backup-manager.database');

        if (! is_dir($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }

        $fileName = 'db-backup-' . date('Ymd_His') . '.sql';
        $path = rtrim($destinationDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $fileName;

        if ($config['use_mysqldump'] && config('database.default') === 'mysql') {
            $this->runMysqldump($path);
        } else {
            $this->runLaravelDump($path, $config['tables'] ?? []);
        }

        if (! empty($config['compress'])) {
            $compression = $config['compression'] ?? 'gz';
            $path = app(CompressionService::class)->compress($path, $compression);
        }

        return $path;
    }

    protected function runMysqldump(string $path): void
    {
        $connection = DB::connection();
        $config = $connection->getConfig();

        $user = $config['username'];
        $pass = $config['password'];
        $host = $config['host'];
        $db = $config['database'];

        $command = sprintf(
            '%s --user=%s --password=%s --host=%s %s > %s',
            escapeshellcmd(config('backup-manager.database.mysqldump_path', 'mysqldump')),
            escapeshellarg($user),
            escapeshellarg($pass),
            escapeshellarg($host),
            escapeshellarg($db),
            escapeshellarg($path)
        );

        if (stripos(PHP_OS, 'WIN') === 0) {
            $command = 'cmd /C ' . $command;
        }

        exec($command);
    }

    protected function runLaravelDump(string $path, array $tables = []): void
    {
        $connection = DB::connection();
        $schemaManager = $connection->getDoctrineSchemaManager();
        $platform = $schemaManager->getDatabasePlatform();

        $sql = '';

        if (empty($tables)) {
            $tables = $schemaManager->listTableNames();
        }

        foreach ($tables as $table) {
            $sql .= sprintf("DROP TABLE IF EXISTS `%s`;\n", $table);
            $createTable = $schemaManager->listTableDetails($table);
            $sql .= $platform->getCreateTableSQL($createTable)[0] . ";\n\n";

            $rows = $connection->table($table)->get();
            foreach ($rows as $row) {
                $values = array_map(static fn ($value) => is_null($value)
                    ? 'NULL'
                    : "'" . str_replace("'", "''", (string) $value) . "'", (array) $row);
                $sql .= sprintf(
                    "INSERT INTO `%s` (%s) VALUES (%s);\n",
                    $table,
                    implode(',', array_map(static fn ($col) => "`{$col}`", array_keys((array) $row))),
                    implode(',', $values)
                );
            }

            $sql .= "\n\n";
        }

        File::put($path, $sql);
    }
}


