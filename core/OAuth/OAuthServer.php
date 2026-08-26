<?php
namespace Vedairo\OAuth;

use Vedairo\Database\DB;

final class OAuthServer {
    public function __construct(private DB $db) {}

    /**
     * @param array<int,string> $redirectUris
     * @return array<string,string>
     */
    public function createClient(string $name, array $redirectUris): array {
        $id = bin2hex(random_bytes(16));
        $secret = bin2hex(random_bytes(32));
        $this->db->query(
            'INSERT INTO oauth_clients(client_id,client_secret_hash,name,redirect_uris) VALUES(?,?,?,?)',
            [$id, hash('sha256', $secret), $name, json_encode(array_values($redirectUris))]
        );
        return ['client_id' => $id, 'client_secret' => $secret];
    }

    public function authorize(string $clientId, int $userId, string $redirectUri, string $scope = ''): string {
        $c = $this->db->query('SELECT * FROM oauth_clients WHERE client_id=?', [$clientId])->fetch();
        if (!$c) {
            throw new \RuntimeException('Invalid client or redirect URI');
        }
        $uris = json_decode($c['redirect_uris'] ?? '[]', true) ?: [];
        if (!in_array($redirectUri, $uris, true)) {
            throw new \RuntimeException('Invalid client or redirect URI');
        }
        $code = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + 300);
        $this->db->query(
            'INSERT INTO oauth_authorization_codes(code_hash,client_id,user_id,redirect_uri,scope,expires_at) VALUES(?,?,?,?,?,?)',
            [hash('sha256', $code), $clientId, $userId, $redirectUri, $scope, $expiresAt]
        );
        return $code;
    }

    /**
     * @return array<string,mixed>
     */
    public function token(string $clientId, string $secret, string $code): array {
        $c = $this->db->query('SELECT * FROM oauth_clients WHERE client_id=?', [$clientId])->fetch();
        if (!$c || !hash_equals($c['client_secret_hash'], hash('sha256', $secret))) {
            throw new \RuntimeException('Invalid client');
        }
        $now = date('Y-m-d H:i:s');
        $row = $this->db->query(
            'SELECT * FROM oauth_authorization_codes WHERE code_hash=? AND client_id=? AND used_at IS NULL AND expires_at>?',
            [hash('sha256', $code), $clientId, $now]
        )->fetch();
        if (!$row) {
            throw new \RuntimeException('Invalid or expired authorization code');
        }
        $this->db->query('UPDATE oauth_authorization_codes SET used_at=? WHERE code_hash=?', [$now, hash('sha256', $code)]);
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + 3600);
        $this->db->query(
            'INSERT INTO oauth_access_tokens(token_hash,client_id,user_id,scope,expires_at) VALUES(?,?,?,?,?)',
            [hash('sha256', $token), $clientId, $row['user_id'], $row['scope'], $expiresAt]
        );
        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => 3600,
            'scope' => $row['scope'],
        ];
    }

    /**
     * @return array<string,mixed>|null
     */
    public function validate(string $token): ?array {
        $now = date('Y-m-d H:i:s');
        $row = $this->db->query(
            'SELECT * FROM oauth_access_tokens WHERE token_hash=? AND revoked_at IS NULL AND expires_at>?',
            [hash('sha256', $token), $now]
        )->fetch();
        return $row ?: null;
    }
}

