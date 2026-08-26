<?php
namespace Vedairo\Storage;

class Storage {
    public static function put(string $name, string $contents): string {
        $path = base_path('storage/uploads/' . ltrim($name, '/\\'));
        $dir = dirname($path);
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        file_put_contents($path, $contents, LOCK_EX);
        return $path;
    }

    public static function delete(string $name): void {
        @unlink(base_path('storage/uploads/' . ltrim($name, '/\\')));
    }
}

