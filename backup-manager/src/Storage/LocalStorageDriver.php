<?php

namespace Marinarch\BackupManager\Storage;

use Illuminate\Filesystem\Filesystem;
use Marinarch\BackupManager\Contracts\StorageDriver;

class LocalStorageDriver implements StorageDriver
{
    protected Filesystem $files;

    protected string $rootPath;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        $this->rootPath = config('backup-manager.destinations.local.root_path', storage_path('app/backups'));
    }

    public function store(string $sourcePath, string $destinationPath): int
    {
        $fullPath = rtrim($this->rootPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . ltrim($destinationPath, DIRECTORY_SEPARATOR);

        $directory = dirname($fullPath);
        if (! $this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }

        $this->files->copy($sourcePath, $fullPath);

        return $this->files->size($fullPath);
    }

    public function testConnection(): bool
    {
        $testDir = rtrim($this->rootPath, DIRECTORY_SEPARATOR);

        if (! $this->files->exists($testDir)) {
            $this->files->makeDirectory($testDir, 0755, true);
        }

        $testFile = $testDir . DIRECTORY_SEPARATOR . '.backup-manager-test';

        try {
            $this->files->put($testFile, 'ok');
            $this->files->delete($testFile);

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function listBackups(string $prefix = ''): array
    {
        $base = rtrim($this->rootPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . ltrim($prefix, DIRECTORY_SEPARATOR);

        if (! $this->files->isDirectory($base)) {
            return [];
        }

        $files = [];
        foreach ($this->files->files($base) as $file) {
            $files[] = [
                'path' => $file->getPathname(),
                'size' => $file->getSize(),
                'created_at' => $file->getMTime(),
            ];
        }

        usort($files, static fn ($a, $b) => $a['created_at'] <=> $b['created_at']);

        return $files;
    }

    public function delete(string $path): bool
    {
        $fullPath = $this->files->isDirectory($this->rootPath)
            ? $path
            : rtrim($this->rootPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);

        if ($this->files->exists($fullPath)) {
            return $this->files->delete($fullPath);
        }

        return true;
    }
}


