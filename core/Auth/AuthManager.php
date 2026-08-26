<?php
namespace Vedairo\Auth;
use Vedairo\Database\DB;
final class AuthManager {
    public function __construct(private DB $db) {}

    /**
     * @param string $email
     * @param string $password
     * @param bool $remember
     * @return bool
     */
    public function attempt(string $email, string $password, bool $remember = false): bool {
        $u = $this->db->query('SELECT * FROM users WHERE email=? AND status=1 LIMIT 1', [$email])->fetch();
        if (!$u || !password_verify($password, $u['password'])) return false;
        session_regenerate_id(true);
        $_SESSION['auth_user_id'] = $u['id'];
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $hash = hash('sha256', $token);
            $this->db->query('INSERT INTO remember_tokens(user_id,token_hash,expires_at) VALUES(?,?,DATE_ADD(NOW(),INTERVAL 30 DAY))', [$u['id'], $hash]);
            setcookie('vedairo_remember', $token, ['expires' => time() + 2592000, 'httponly' => true, 'secure' => !empty($_SERVER['HTTPS']), 'samesite' => 'Lax', 'path' => '/']);
        }
        return true;
    }

    /**
     * @return array<string,mixed>|null
     */
    public function user(): ?array {
        if (isset($_SESSION['auth_user_id'])) return $this->db->query('SELECT * FROM users WHERE id=?', [(int) $_SESSION['auth_user_id']])->fetch() ?: null;
        $token = $_COOKIE['vedairo_remember'] ?? null;
        if ($token) {
            $row = $this->db->query('SELECT u.* FROM remember_tokens r JOIN users u ON u.id=r.user_id WHERE r.token_hash=? AND r.expires_at>NOW() LIMIT 1', [hash('sha256', $token)])->fetch();
            if ($row) { $_SESSION['auth_user_id'] = $row['id']; return $row; }
        }
        return null;
    }

    public function check(): bool { return $this->user() !== null; }

    public function id(): ?int { $u = $this->user(); return $u ? (int) $u['id'] : null; }

    public function logout(): void {
        if (isset($_SESSION['auth_user_id'])) $this->db->query('DELETE FROM remember_tokens WHERE user_id=?', [$_SESSION['auth_user_id']]);
        $_SESSION = [];
        if (ini_get('session.use_cookies')) { $p = session_get_cookie_params(); setcookie((string) session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']); }
        session_destroy();
    }

    public function createUser(string $name, string $email, string $password): int { $this->db->query('INSERT INTO users(name,email,password,status,created_at,updated_at) VALUES(?,?,?,1,NOW(),NOW())', [$name, $email, password_hash($password, PASSWORD_DEFAULT)]); return (int) $this->db->pdo()->lastInsertId(); }
}
