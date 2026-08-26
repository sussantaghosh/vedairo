<?php
namespace App\Models;
class User extends \Vedairo\Database\Model {protected static string $table='users'; /**
 * @return array<string,mixed>|null
 */
public static function byEmail(string $email): ?array { return static::query()->whereEq('email', $email)->first(); }

/**
 * @param array<string,mixed> $user
 * @return list<string>
 */
public static function permissions(array $user): array {
    return match ($user['role'] ?? 'user') {
        'admin' => ['products.view', 'products.create', 'products.update', 'products.delete', 'users.view'],
        'super_admin' => ['*'],
        default => ['products.view']
    };
}}
