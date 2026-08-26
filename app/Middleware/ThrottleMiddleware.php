<?php
namespace App\Middleware;

class ThrottleMiddleware {
    public function handle(\Vedairo\Http\Request $r): void {
        if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
            @session_start();
        }
        $k = '_throttle_' . sha1(($r->server['REMOTE_ADDR'] ?? '') . $r->path);
        $now = time();
        $x = $_SESSION[$k] ?? ['t' => $now, 'n' => 0];
        if ($now - $x['t'] > 60) {
            $x = ['t' => $now, 'n' => 0];
        }
        $x['n']++;
        $_SESSION[$k] = $x;
        if ($x['n'] > 60) {
            \Vedairo\Http\Response::json(['success' => false, 'message' => 'Too many requests'], 429);
        }
    }
}

