<?php
namespace Vedairo\Auth;
use Vedairo\Database\DB;
final class TwoFactor {
    public function __construct(private DB $db) {}

    /**
     * @return array<string,mixed>
     */
    public function enable(int $userId): array {
        $secret = Totp::secret();
        $codes = [];
        for ($i = 0; $i < 8; $i++) $codes[] = bin2hex(random_bytes(5));
        $this->db->query('INSERT INTO user_2fa(user_id,secret,enabled,recovery_codes) VALUES(?,?,1,?) ON DUPLICATE KEY UPDATE secret=VALUES(secret),enabled=1,recovery_codes=VALUES(recovery_codes)', [$userId, $secret, json_encode($codes)]);
        return ['secret' => $secret, 'otpauth' => Totp::uri(env('APP_NAME', 'VEDAIRO'), (string) $userId, $secret), 'recovery_codes' => $codes];
    }

    /**
     * @param string $code
     */
    public function verify(int $userId, string $code): bool {
        $r = $this->db->query('SELECT secret,recovery_codes,enabled FROM user_2fa WHERE user_id=?', [$userId])->fetch();
        if (!$r || !(int) $r['enabled']) return false;
        if (Totp::verify($r['secret'], $code)) return true;
        $codes = json_decode($r['recovery_codes'] ?? '[]', true) ?: [];
        $idx = array_search($code, $codes, true);
        if ($idx !== false) {
            array_splice($codes, (int)$idx, 1);
            $this->db->query('UPDATE user_2fa SET recovery_codes=? WHERE user_id=?', [json_encode($codes), $userId]);
            return true;
        }
        return false;
    }

    public function disable(int $userId): void { $this->db->query('UPDATE user_2fa SET enabled=0 WHERE user_id=?', [$userId]); }
}
