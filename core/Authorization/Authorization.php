<?php
namespace Vedairo\Authorization;
use Vedairo\Auth\Auth;
class Authorization {
    public static function role(string $role): bool { return Auth::check() && (Auth::role() === $role || Auth::role() === 'super_admin'); }
    public static function permission(string $permission): bool { return Auth::can($permission); }

    /**
     * @param list<string> $permissions
     */
    public static function any(array $permissions): bool { foreach ($permissions as $p) if (self::permission($p)) return true; return false; }

    /**
     * @param list<string> $permissions
     */
    public static function all(array $permissions): bool { foreach ($permissions as $p) if (!self::permission($p)) return false; return true; }

    public static function denyUnless(string $permission): void { if (!self::permission($permission)) { http_response_code(403); throw new \RuntimeException('Forbidden'); } }
}
