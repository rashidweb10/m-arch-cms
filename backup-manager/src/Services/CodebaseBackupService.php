<?php

namespace Marinarch\BackupManager\Services;

use Illuminate\Filesystem\Filesystem;

class CodebaseBackupService
{
    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function createArchive(string $destinationDir): string
    {
        $config = config('backup-manager.codebase');

        if (! is_dir($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }

        $fileName = 'codebase-backup-' . date('Ymd_His') . '.zip';
        $path = rtrim($destinationDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $fileName;

        $zip = new \ZipArchive();
        if ($zip->open($path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('Could not create ZIP archive.');
        }

        $root = base_path();

        $includePaths = $config['full_codebase']
            ? ['.']
            : ($config['include_paths'] ?? []);

        $excludePaths = $config['exclude_paths'] ?? [];

        foreach ($includePaths as $relativePath) {
            $absolutePath = rtrim($root . DIRECTORY_SEPARATOR . $relativePath, DIRECTORY_SEPARATOR);

            if (! $this->files->exists($absolutePath)) {
                continue;
            }

            $this->addPathToZip($zip, $absolutePath, $root, $excludePaths);
        }

        $zip->close();

        if (! empty($config['compress']) && ($config['compression'] ?? null) === 'gz') {
            $path = app(CompressionService::class)->compress($path, 'gz');
        }

        return $path;
    }

    protected function addPathToZip(\ZipArchive $zip, string $path, string $root, array $excludePaths): void
    {
        if ($this->isExcluded($path, $excludePaths, $root)) {
            return;
        }

        if (is_dir($path)) {
            $files = $this->files->allFiles($path);

            foreach ($files as $file) {
                if ($this->isExcluded($file->getPathname(), $excludePaths, $root)) {
                    continue;
                }

                $relativeName = ltrim(str_replace($root, '', $file->getPathname()), DIRECTORY_SEPARATOR);
                $zip->addFile($file->getPathname(), $relativeName);
            }
        } else {
            $relativeName = ltrim(str_replace($root, '', $path), DIRECTORY_SEPARATOR);
            $zip->addFile($path, $relativeName);
        }
    }

    protected function isExcluded(string $path, array $excludePaths, string $root): bool
    {
        $normalized = ltrim(str_replace($root, '', $path), DIRECTORY_SEPARATOR);

        foreach ($excludePaths as $exclude) {
            $exclude = trim($exclude, DIRECTORY_SEPARATOR);
            if (str_starts_with($normalized, $exclude)) {
                return true;
            }
        }

        return false;
    }
}


