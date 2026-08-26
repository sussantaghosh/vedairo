<?php
namespace Vedairo\Auth;
/**
 * Authentication helper
 */
class Auth {
   /**
    * @param array<string,mixed> $user
    */
   public static function login(array $user, bool $remember = false): void { self::start(); session_regenerate_id(true); $_SESSION['user'] = $user; $_SESSION['user_id'] = $user['id']; }

   public static function logout(): void {
       self::start();
       $_SESSION = [];
       if (ini_get('session.use_cookies')) {
           $p = session_get_cookie_params();
           $path = $p['path'];
           $domain = $p['domain'];
           $secure = $p['secure'];
           $httponly = $p['httponly'];
           $samesite = $p['samesite'];

           setcookie((string) session_name(), '', [
               'expires' => time() - 42000,
               'path' => $path,
               'domain' => $domain,
               'secure' => $secure,
               'httponly' => $httponly,
               'samesite' => $samesite,
           ]);
       }
       session_destroy();
   }

   /**
    * @return array<string,mixed>|null
    */
   public static function user(): ?array { self::start(); return $_SESSION['user'] ?? null; }

   public static function check(): bool { return self::user() !== null; }

   public static function id(): ?int { $u = self::user(); return $u ? (int) $u['id'] : null; }

   public static function role(): ?string { $u = self::user(); return $u['role'] ?? null; }

   public static function can(string $permission): bool { $u = self::user(); if (!$u) return false; if (($u['role'] ?? '') === 'super_admin') return true; $permissions = $u['permissions'] ?? []; return in_array($permission, $permissions, true); }

    private static function start(): void {
        if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
            @session_start();
        }
    }
}

