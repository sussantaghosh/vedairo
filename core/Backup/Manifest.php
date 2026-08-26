<?php
namespace Vedairo\Backup;
final class Manifest {
    /**
     * @param list<string> $files
     */
    public static function create(string $dir, array $files): string {
        $m = ['created_at' => date(DATE_ATOM), 'files' => $files];
        file_put_contents(rtrim($dir, '/') . '/manifest.json', json_encode($m, JSON_PRETTY_PRINT));
        return $dir . '/manifest.json';
    }
}
