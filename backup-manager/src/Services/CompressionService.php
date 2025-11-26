<?php

namespace Marinarch\BackupManager\Services;

class CompressionService
{
    public function compress(string $sourcePath, string $compression): string
    {
        $compression = strtolower($compression);

        return match ($compression) {
            'gz' => $this->compressGz($sourcePath),
            'zip' => $this->compressZip($sourcePath),
            default => $sourcePath,
        };
    }

    protected function compressGz(string $sourcePath): string
    {
        $destPath = $sourcePath . '.gz';

        $data = file_get_contents($sourcePath);
        $gz = gzopen($destPath, 'w9');
        gzwrite($gz, $data);
        gzclose($gz);

        return $destPath;
    }

    protected function compressZip(string $sourcePath): string
    {
        $zipPath = $sourcePath . '.zip';

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return $sourcePath;
        }

        $zip->addFile($sourcePath, basename($sourcePath));
        $zip->close();

        return $zipPath;
    }
}


