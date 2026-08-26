<?php
namespace Vedairo\Support;

final class Str {
    public static function random(int $n = 32): string {
        $bytes = max(1, (int) ceil($n / 2));
        return substr(bin2hex(random_bytes($bytes)), 0, max(1, $n));
    }

    public static function slug(string $v): string {
        $trans = iconv('UTF-8', 'ASCII//TRANSLIT', $v);
        $v = is_string($trans) ? $trans : $v;
        $v = preg_replace('/[^a-zA-Z0-9]+/', '-', strtolower($v));
        return trim((string) $v, '-');
    }
}

