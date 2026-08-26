<?php

function base_path(string $p = ''): string {
    return dirname(__DIR__, 2) . ($p ? DIRECTORY_SEPARATOR . ltrim($p, '/\\') : '');
}

function config(string $key, mixed $default = null): mixed {
    $v = $GLOBALS['config'] ?? [];
    foreach (explode('.', $key) as $k) {
        if (!is_array($v) || !array_key_exists($k, $v)) {
            return $default;
        }
        $v = $v[$k];
    }
    return $v;
}

function env(string $key, mixed $default = null): mixed {
    static $e = null;
    if ($e === null) {
        $e = [];
        $f = base_path('.env');
        if (is_file($f)) {
            $lines = file($f, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if (is_array($lines)) {
                foreach ($lines as $l) {
                    $l = trim($l);
                    if ($l === '' || $l[0] === '#' || !str_contains($l, '=')) {
                        continue;
                    }
                    [$k, $v] = explode('=', $l, 2);
                    $val = trim($v, " \"'");
                    $e[trim($k)] = $val;
                }
            }
        }
    }

    if (isset($e[$key])) {
        return $e[$key];
    }
    if (isset($_ENV[$key])) {
        return $_ENV[$key];
    }
    $val = getenv($key);
    if ($val !== false) {
        return $val;
    }
    return $default;
}

function url(string $path = ''): string {
    return rtrim((string)env('APP_URL', 'http://localhost'), '/') . '/' . ltrim($path, '/');
}

function redirect(string $to): never {
    header('Location: ' . (str_starts_with($to, 'http') ? $to : url($to)));
    exit;
}

function csrf_token(): string {
    return Vedairo\Security\Csrf::token();
}

function old(string $key, mixed $default = ''): mixed {
    return $_SESSION['_old'][$key] ?? $default;
}

function flash(string $key, mixed $value = null): mixed {
    if (func_num_args() === 2) {
        $_SESSION['_flash'][$key] = $value;
        return null;
    }
    $v = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $v;
}

function e(mixed $v): string {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function dd(mixed ...$v): never {
    header('Content-Type: text/plain');
    var_dump(...$v);
    exit;
}

