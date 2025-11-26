<?php

namespace Marinarch\BackupManager\Storage;

use Illuminate\Support\Facades\Storage;
use Marinarch\BackupManager\Contracts\StorageDriver;

class S3StorageDriver implements StorageDriver
{
    protected string $disk;

    protected string $basePath;

    public function __construct()
    {
        $this->disk = config('backup-manager.destinations.s3.disk', 's3');
        $this->basePath = trim(config('backup-manager.destinations.s3.base_path', 'backups'), '/');
    }

    public function store(string $sourcePath, string $destinationPath): int
    {
        $disk = Storage::disk($this->disk);
        $path = $this->basePath . '/' . ltrim($destinationPath, '/');

        $stream = fopen($sourcePath, 'r');
        $disk->put($path, $stream);
        fclose($stream);

        return $disk->size($path);
    }

    public function testConnection(): bool
    {
        try {
            $disk = Storage::disk($this->disk);
            $testPath = $this->basePath . '/.backup-manager-test';
            $disk->put($testPath, 'ok');
            $disk->delete($testPath);

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function listBackups(string $prefix = ''): array
    {
        $disk = Storage::disk($this->disk);
        $path = trim($this->basePath . '/' . ltrim($prefix, '/'), '/');

        $allFiles = $disk->files($path);

        $files = [];
        foreach ($allFiles as $file) {
            $files[] = [
                'path' => $file,
                'size' => $disk->size($file),
                'created_at' => $disk->lastModified($file),
            ];
        }

        usort($files, static fn ($a, $b) => $a['created_at'] <=> $b['created_at']);

        return $files;
    }

    public function delete(string $path): bool
    {
        $disk = Storage::disk($this->disk);

        if ($disk->exists($path)) {
            return $disk->delete($path);
        }

        return true;
    }
}


