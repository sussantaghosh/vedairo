<?php
namespace Vedairo\Observability;

final class RequestId {
    public static function get(): string {
        if (!isset($_SERVER['HTTP_X_REQUEST_ID'])) {
            $_SERVER['HTTP_X_REQUEST_ID'] = bin2hex(random_bytes(16));
        }
        return $_SERVER['HTTP_X_REQUEST_ID'];
    }

    public static function header(): void {
        if (!headers_sent()) {
            header('X-Request-ID: ' . self::get());
        }
    }
}

