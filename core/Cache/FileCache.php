<?php
namespace Vedairo\Cache;

class FileCache {
    private string $dir;

    public function __construct() {
        $this->dir = base_path('storage/cache');
        if (!is_dir($this->dir)) {
            @mkdir($this->dir, 0775, true);
        }
    }

    private function f(string $k): string {
        return $this->dir . '/' . sha1($k) . '.cache';
    }

    public function put(string $k, mixed $v, int $ttl = 3600): void {
        if (!is_dir($this->dir)) {
            @mkdir($this->dir, 0775, true);
        }
        file_put_contents($this->f($k), serialize(['e' => time() + $ttl, 'v' => $v]), LOCK_EX);
    }

    public function get(string $k, mixed $d = null): mixed {
        $f = $this->f($k);
        if (!is_file($f)) return $d;

        $content = file_get_contents($f);
        if ($content === false) return $d;

        $x = @unserialize($content);
        if (!is_array($x)) return $d;

        if (($x['e'] ?? 0) < time()) {
            @unlink($f);
            return $d;
        }
        return $x['v'];
    }

    public function forget(string $k): void {
        @unlink($this->f($k));
    }
}

