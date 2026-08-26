<?php
namespace Vedairo\Middleware;

class Pipeline {
    public function handle(mixed $request, string $name): void {
        $parts = explode(':', $name, 2);
        $alias = $parts[0];
        $param = $parts[1] ?? '';

        $map = [
            'auth' => \App\Middleware\AuthMiddleware::class,
            'csrf' => \App\Middleware\CsrfMiddleware::class,
            'guest' => \App\Middleware\GuestMiddleware::class,
            'throttle' => \App\Middleware\ThrottleMiddleware::class,
            'role' => \App\Middleware\RoleMiddleware::class,
            'api' => \App\Middleware\ApiTokenMiddleware::class,
            'security' => \App\Middleware\SecurityHeadersMiddleware::class,
            'ApiTokenMiddleware' => \App\Middleware\ApiTokenMiddleware::class,
            'AuthMiddleware' => \App\Middleware\AuthMiddleware::class,
            'CsrfMiddleware' => \App\Middleware\CsrfMiddleware::class,
            'GuestMiddleware' => \App\Middleware\GuestMiddleware::class,
            'RoleMiddleware' => \App\Middleware\RoleMiddleware::class,
            'ThrottleMiddleware' => \App\Middleware\ThrottleMiddleware::class,
            'SecurityHeadersMiddleware' => \App\Middleware\SecurityHeadersMiddleware::class,
        ];

        $class = $map[$alias] ?? (class_exists($alias) ? $alias : null);
        if (!$class) {
            throw new \RuntimeException("Middleware [{$alias}] not found");
        }

        $obj = new $class();
        if ($alias === 'role' || $class === \App\Middleware\RoleMiddleware::class) {
            $obj->handle($request, $param);
        } else {
            $obj->handle($request);
        }
    }
}

