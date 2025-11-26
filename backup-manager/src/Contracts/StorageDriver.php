<?php

namespace Marinarch\BackupManager\Contracts;

interface StorageDriver
{
    /**
    * Store a backup file at the desired destination.
    *
    * @param  string  $sourcePath  Absolute path to the local file.
    * @param  string  $destinationPath  Path relative to the destination root.
    * @return int  Number of bytes written.
    */
    public function store(string $sourcePath, string $destinationPath): int;

    /**
    * Test if the storage destination is reachable and writeable.
    */
    public function testConnection(): bool;

    /**
    * List backup files for rotation purposes.
    *
    * @return array<int, array{path:string,size:int,created_at:int}>
    */
    public function listBackups(string $prefix = ''): array;

    /**
    * Delete a backup file by its path.
    */
    public function delete(string $path): bool;
}


