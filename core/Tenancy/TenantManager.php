<?php
namespace Vedairo\Tenancy;

class TenantManager {
    private static function start(): void {
        if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
            @session_start();
        }
    }

    public static function set(int $id): void {
        self::start();
        $_SESSION['tenant_id'] = $id;
    }

    public static function id(): ?int {
        self::start();
        return isset($_SESSION['tenant_id']) ? (int) $_SESSION['tenant_id'] : null;
    }

    public static function clear(): void {
        self::start();
        unset($_SESSION['tenant_id']);
    }

    public static function assertMembership(int $userId, int $tenantId): bool {
        $db = \Vedairo\Application::$container->get('db');
        return (bool) $db->table('tenant_users')->whereEq('user_id', $userId)->whereEq('tenant_id', $tenantId)->first();
    }
}

