<?php
declare(strict_types=1);

require dirname(__DIR__) . '/core/bootstrap.php';

if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent() && php_sapi_name() !== 'cli') {
    session_start();
}

Vedairo\Application::run();

