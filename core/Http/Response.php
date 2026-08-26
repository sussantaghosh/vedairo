<?php
namespace Vedairo\Http;

class Response {
    public static function json(mixed $data, int $status = 200): never {
        if (!headers_sent()) {
            http_response_code($status);
            header('Content-Type: application/json; charset=utf-8');
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public static function html(string $html, int $status = 200): never {
        if (!headers_sent()) {
            http_response_code($status);
            header('Content-Type: text/html; charset=utf-8');
        }
        echo $html;
        exit;
    }
}

