<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';

use Vedairo\OAuth\OAuthServer;
use Vedairo\Database\DB;

// Create SQLite in-memory DB
$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$pdo->exec("
    CREATE TABLE oauth_clients (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        client_id TEXT NOT NULL UNIQUE,
        client_secret_hash TEXT NOT NULL,
        name TEXT NOT NULL,
        redirect_uris TEXT NOT NULL
    );
    CREATE TABLE oauth_authorization_codes (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        code_hash TEXT NOT NULL UNIQUE,
        client_id TEXT NOT NULL,
        user_id INTEGER NOT NULL,
        redirect_uri TEXT NOT NULL,
        scope TEXT NOT NULL,
        expires_at TEXT NOT NULL,
        used_at TEXT NULL
    );
    CREATE TABLE oauth_access_tokens (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        token_hash TEXT NOT NULL UNIQUE,
        client_id TEXT NOT NULL,
        user_id INTEGER NOT NULL,
        scope TEXT NOT NULL,
        expires_at TEXT NOT NULL,
        revoked_at TEXT NULL
    );
");

$db = new DB($pdo);
$oauth = new OAuthServer($db);

// 1. Create client
$client = $oauth->createClient('Mobile App', ['https://app.example.com/callback']);
assert(isset($client['client_id']) && isset($client['client_secret']), 'Client creation failed');

// 2. Authorize and get auth code
$authCode = $oauth->authorize($client['client_id'], 42, 'https://app.example.com/callback', 'read,write');
assert(is_string($authCode) && strlen($authCode) === 64, 'Auth code generation failed');

// 3. Exchange code for access token
$tokenResponse = $oauth->token($client['client_id'], $client['client_secret'], $authCode);
assert(isset($tokenResponse['access_token']) && $tokenResponse['token_type'] === 'Bearer', 'Token exchange failed');
assert($tokenResponse['scope'] === 'read,write');

// 4. Validate token
$tokenData = $oauth->validate($tokenResponse['access_token']);
assert($tokenData !== null, 'Token validation failed');
assert((int)$tokenData['user_id'] === 42, 'Token user_id mismatch');
assert($tokenData['client_id'] === $client['client_id'], 'Token client_id mismatch');

echo "OAuthServerTest: PASS\n";
return true;
