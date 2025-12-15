<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Exception;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class FileBackupService
{
    protected array $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * Create a codebase backup.
     */
    public function createBackup(string $filePath): string
    {
        $compression = $this->options['compression'] ?? config('backup_module.compression_type', 'zip');
        $basePath = base_path();

        if ($compression === 'zip') {
            return $this->createZipBackup($basePath, $filePath);
        }

        return $this->createTarBackup($basePath, $filePath);
    }

    /**
     * Create a ZIP backup.
     */
    protected function createZipBackup(string $basePath, string $filePath): string
    {
        $disk = Storage::disk(config('backup_module.storage.disk'));
        $fullPath = $disk->path($filePath);

        // Ensure directory exists
        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $zip = new ZipArchive();

        if ($zip->open($fullPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new Exception("Failed to create ZIP archive: {$fullPath}");
        }

        try {
            $foldersToInclude = $this->getFoldersToInclude();
            $foldersToExclude = $this->getFoldersToExclude();

            if (empty($foldersToInclude)) {
                // Backup entire codebase
                $this->addDirectoryToZip($zip, $basePath, '', $foldersToExclude);
            } else {
                // Backup only selected folders
                foreach ($foldersToInclude as $folder) {
                    $folderPath = $basePath . '/' . $folder;
                    if (is_dir($folderPath)) {
                        $this->addDirectoryToZip($zip, $folderPath, $folder, $foldersToExclude);
                    }
                }
            }

            $zip->close();

            return $filePath;
        } catch (Exception $e) {
            $zip->close();
            @unlink($fullPath);
            throw $e;
        }
    }

    /**
     * Create a TAR.GZ backup.
     */
    protected function createTarBackup(string $basePath, string $filePath): string
    {
        // For tar.gz, we'll use PHP's PharData or shell command
        // This is a simplified version - in production, you might want to use shell commands
        throw new Exception("TAR.GZ compression is not yet implemented. Please use ZIP compression.");
    }

    /**
     * Add directory to ZIP archive.
     */
    protected function addDirectoryToZip(ZipArchive $zip, string $dir, string $zipPath, array $excludeFolders): void
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            $filePath = $file->getRealPath();
            $relativePath = $zipPath . '/' . str_replace($dir . '/', '', $filePath);

            // Skip excluded folders
            if ($this->shouldExcludePath($relativePath, $excludeFolders)) {
                continue;
            }

            // Skip sensitive files
            if ($this->isSensitiveFile($relativePath)) {
                continue;
            }

            if ($file->isDir()) {
                $zip->addEmptyDir($relativePath);
            } else {
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    /**
     * Get folders to include.
     */
    protected function getFoldersToInclude(): array
    {
        return $this->options['folders'] ?? [];
    }

    /**
     * Get folders to exclude.
     */
    protected function getFoldersToExclude(): array
    {
        $exclude = $this->options['exclude_folders'] ?? [];
        
        // Add default excludes
        $defaultExcludes = config('backup_module.codebase.default_exclude', []);
        
        return array_unique(array_merge($exclude, $defaultExcludes));
    }

    /**
     * Check if path should be excluded.
     */
    protected function shouldExcludePath(string $path, array $excludeFolders): bool
    {
        foreach ($excludeFolders as $exclude) {
            if (strpos($path, $exclude) === 0 || strpos($path, '/' . $exclude . '/') !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if file is sensitive and should be excluded.
     */
    protected function isSensitiveFile(string $path): bool
    {
        if (!config('backup_module.security.exclude_sensitive_files', true)) {
            return false;
        }

        $sensitivePatterns = config('backup_module.security.sensitive_patterns', []);

        foreach ($sensitivePatterns as $pattern) {
            if (fnmatch($pattern, $path) || fnmatch($pattern, basename($path))) {
                return true;
            }
        }

        // Check .env exclusion
        if (config('backup_module.security.exclude_env_file', true)) {
            if (basename($path) === '.env' || preg_match('/\.env\./', $path)) {
                return true;
            }
        }

        return false;
    }
}

