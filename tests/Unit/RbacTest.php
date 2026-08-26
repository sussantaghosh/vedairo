<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';

use Vedairo\Authorization\Rbac;
use Vedairo\Database\DB;

// Create SQLite in-memory DB
$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$pdo->exec("
    CREATE TABLE roles (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL UNIQUE
    );
    CREATE TABLE permissions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL UNIQUE
    );
    CREATE TABLE user_roles (
        user_id INTEGER NOT NULL,
        role_id INTEGER NOT NULL,
        PRIMARY KEY (user_id, role_id)
    );
    CREATE TABLE role_permissions (
        role_id INTEGER NOT NULL,
        permission_id INTEGER NOT NULL,
        PRIMARY KEY (role_id, permission_id)
    );
");

$pdo->exec("INSERT INTO roles (id, name) VALUES (1, 'editor')");
$pdo->exec("INSERT INTO permissions (id, name) VALUES (1, 'edit_posts'), (2, 'delete_posts')");

$db = new DB($pdo);
$rbac = new Rbac($db);

// Assign role 1 (editor) to user 10
$pdo->exec("INSERT INTO user_roles (user_id, role_id) VALUES (10, 1)");

// Grant permission 1 (edit_posts) to role 1 (editor)
$pdo->exec("INSERT INTO role_permissions (role_id, permission_id) VALUES (1, 1)");

assert($rbac->can(10, 'edit_posts') === true, 'User 10 should have edit_posts permission');
assert($rbac->can(10, 'delete_posts') === false, 'User 10 should not have delete_posts permission');
assert($rbac->can(99, 'edit_posts') === false, 'User 99 should have no permissions');

$roles = $rbac->roles(10);
assert(count($roles) === 1 && $roles[0]['name'] === 'editor', 'Roles retrieval failed');

echo "RbacTest: PASS\n";
return true;
