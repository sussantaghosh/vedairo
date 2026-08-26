<?php
namespace Vedairo\Security;

class Csrf {
    public static function token(): string {
        if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
            @session_start();
        }
        return $_SESSION['_csrf'] ??= bin2hex(random_bytes(32));
    }

    public static function check(?string $token): bool {
        return is_string($token) && hash_equals(self::token(), $token);
    }
}

