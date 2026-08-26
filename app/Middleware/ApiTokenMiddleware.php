<?php
namespace App\Middleware;

use App\Models\User;

class ApiTokenMiddleware {
    public function handle(\Vedairo\Http\Request $r): void {
        $h = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        if (!preg_match('/^Bearer\s+(.+)$/i', $h, $m)) {
            \Vedairo\Http\Response::json(['success' => false, 'message' => 'API token required'], 401);
        }
        $hash = hash('sha256', $m[1]);
        $u = User::query()->whereEq('api_token_hash', $hash)->first();
        if (!$u) {
            \Vedairo\Http\Response::json(['success' => false, 'message' => 'Invalid API token'], 401);
        }
        if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
            @session_start();
        }
        $_SESSION['user'] = $u;
        $_SESSION['user_id'] = $u['id'];
    }
}

