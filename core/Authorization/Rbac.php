<?php
namespace Vedairo\Authorization;

use Vedairo\Database\DB;

final class Rbac {
    public function __construct(private DB $db) {}

    /**
     * @return list<array<string,mixed>>
     */
    public function roles(int $userId): array {
        return array_values($this->db->query('SELECT r.* FROM roles r JOIN user_roles ur ON ur.role_id=r.id WHERE ur.user_id=?', [$userId])->fetchAll());
    }

    public function can(int $userId, string $permission): bool {
        $row = $this->db->query('SELECT COUNT(*) as n FROM permissions p JOIN role_permissions rp ON rp.permission_id=p.id JOIN user_roles ur ON ur.role_id=rp.role_id WHERE ur.user_id=? AND p.name=?', [$userId, $permission])->fetch();
        return $row ? ((int) $row['n'] > 0) : false;
    }

    public function assignRole(int $userId, int $roleId): void {
        $this->db->query('INSERT IGNORE INTO user_roles(user_id,role_id) VALUES(?,?)', [$userId, $roleId]);
    }

    public function grant(int $roleId, int $permissionId): void {
        $this->db->query('INSERT IGNORE INTO role_permissions(role_id,permission_id) VALUES(?,?)', [$roleId, $permissionId]);
    }
}

