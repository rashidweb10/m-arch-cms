<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Process;
use Exception;

class DatabaseBackupService
{
    protected string $connection;
    protected array $options;

    public function __construct(string $connection = null, array $options = [])
    {
        $this->connection = $connection ?? config('database.default');
        $this->options = $options;
    }

    /**
     * Create a database backup.
     */
    public function createBackup(string $filePath): string
    {
        $config = config("database.connections.{$this->connection}");

        if (!$config) {
            throw new Exception("Database connection '{$this->connection}' not found.");
        }

        // Use mysqldump if available and enabled
        if (config('backup_module.database.use_mysqldump', true) && $this->isMysqldumpAvailable()) {
            return $this->createBackupWithMysqldump($config, $filePath);
        }

        // Fallback to PHP-based backup
        return $this->createBackupWithPHP($config, $filePath);
    }

    /**
     * Check if mysqldump is available.
     */
    protected function isMysqldumpAvailable(): bool
    {
        $mysqldumpPath = config('backup_module.database.mysqldump_path', 'mysqldump');
        
        try {
            $result = Process::run("{$mysqldumpPath} --version");
            return $result->successful();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Create backup using mysqldump.
     */
    protected function createBackupWithMysqldump(array $config, string $filePath): string
    {
        $mysqldumpPath = config('backup_module.database.mysqldump_path', 'mysqldump');
        $database = $config['database'];
        $host = $config['host'];
        $port = $config['port'] ?? 3306;
        $username = $config['username'];
        $password = $config['password'];

        // Build mysqldump command
        $command = sprintf(
            '%s --host=%s --port=%s --user=%s --password=%s %s',
            escapeshellarg($mysqldumpPath),
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database)
        );

        // Add table selection
        if (!empty($this->options['tables'])) {
            $tables = array_map('escapeshellarg', $this->options['tables']);
            $command .= ' ' . implode(' ', $tables);
        } elseif (!empty($this->options['exclude_tables'])) {
            // For exclude, we need to get all tables first
            $allTables = $this->getAllTables();
            $tables = array_diff($allTables, $this->options['exclude_tables']);
            if (!empty($tables)) {
                $tables = array_map('escapeshellarg', $tables);
                $command .= ' ' . implode(' ', $tables);
            }
        }

        // Add structure/data options
        if (!empty($this->options['structure_only'])) {
            $command .= ' --no-data';
        } elseif (!empty($this->options['data_only'])) {
            $command .= ' --no-create-info';
        }

        // Add additional options
        $command .= ' --single-transaction --quick --lock-tables=false';

        // Execute mysqldump and save to file
        $disk = Storage::disk(config('backup_module.storage.disk'));
        $fullPath = $disk->path($filePath);

        // Ensure directory exists
        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $result = Process::run($command)->output();
        
        if (file_put_contents($fullPath, $result) === false) {
            throw new Exception("Failed to write backup file to: {$fullPath}");
        }

        return $filePath;
    }

    /**
     * Create backup using PHP (fallback method).
     */
    protected function createBackupWithPHP(array $config, string $filePath): string
    {
        $disk = Storage::disk(config('backup_module.storage.disk'));
        $fullPath = $disk->path($filePath);

        // Ensure directory exists
        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $handle = fopen($fullPath, 'w');

        if (!$handle) {
            throw new Exception("Failed to create backup file: {$fullPath}");
        }

        try {
            // Write header
            fwrite($handle, "-- Database Backup\n");
            fwrite($handle, "-- Generated: " . now()->toDateTimeString() . "\n");
            fwrite($handle, "-- Connection: {$this->connection}\n\n");
            fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n\n");

            // Get tables to backup
            $tables = $this->getTablesToBackup();

            foreach ($tables as $table) {
                $this->backupTable($handle, $table);
            }

            fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");

            fclose($handle);

            return $filePath;
        } catch (Exception $e) {
            fclose($handle);
            @unlink($fullPath);
            throw $e;
        }
    }

    /**
     * Get tables to backup based on options.
     */
    protected function getTablesToBackup(): array
    {
        $allTables = $this->getAllTables();

        if (!empty($this->options['tables'])) {
            return array_intersect($allTables, $this->options['tables']);
        }

        if (!empty($this->options['exclude_tables'])) {
            return array_diff($allTables, $this->options['exclude_tables']);
        }

        return $allTables;
    }

    /**
     * Get all tables in the database.
     */
    protected function getAllTables(): array
    {
        $tables = DB::connection($this->connection)
            ->select('SHOW TABLES');

        $tableKey = 'Tables_in_' . config("database.connections.{$this->connection}.database");

        return array_map(function ($table) use ($tableKey) {
            return $table->$tableKey;
        }, $tables);
    }

    /**
     * Backup a single table.
     */
    protected function backupTable($handle, string $table): void
    {
        $structureOnly = !empty($this->options['structure_only']);
        $dataOnly = !empty($this->options['data_only']);

        // Backup structure
        if (!$dataOnly) {
            $createTable = DB::connection($this->connection)
                ->select("SHOW CREATE TABLE `{$table}`");

            if (!empty($createTable)) {
                $createTableSql = $createTable[0]->{'Create Table'};
                fwrite($handle, "-- Table structure for `{$table}`\n");
                fwrite($handle, "DROP TABLE IF EXISTS `{$table}`;\n");
                fwrite($handle, $createTableSql . ";\n\n");
            }
        }

        // Backup data
        if (!$structureOnly) {
            $chunkSize = config('backup_module.database.chunk_size', 1000);
            $offset = 0;

            fwrite($handle, "-- Data for table `{$table}`\n");

            while (true) {
                $rows = DB::connection($this->connection)
                    ->table($table)
                    ->offset($offset)
                    ->limit($chunkSize)
                    ->get();

                if ($rows->isEmpty()) {
                    break;
                }

                foreach ($rows as $row) {
                    $values = array_map(function ($value) {
                        if ($value === null) {
                            return 'NULL';
                        }
                        return "'" . addslashes($value) . "'";
                    }, (array) $row);

                    $columns = implode('`, `', array_keys((array) $row));
                    $valuesStr = implode(', ', $values);

                    fwrite($handle, "INSERT INTO `{$table}` (`{$columns}`) VALUES ({$valuesStr});\n");
                }

                $offset += $chunkSize;
            }

            fwrite($handle, "\n");
        }
    }
}

