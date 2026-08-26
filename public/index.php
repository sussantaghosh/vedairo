<?php
declare(strict_types=1);

// Built-in PHP CLI development server static file bypass
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    if ($path !== '/' && is_file(__DIR__ . $path)) {
        return false;
    }
}

require dirname(__DIR__) . '/core/bootstrap.php';

if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent() && php_sapi_name() !== 'cli') {
    session_start();
}

Vedairo\Application::run();

