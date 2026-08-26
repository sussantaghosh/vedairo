<?php
namespace App\Middleware;
use Vedairo\Security\Headers;
class SecurityHeadersMiddleware {public function handle(\Vedairo\Http\Request $request, ?callable $next = null): mixed { \Vedairo\Security\Headers::apply(); return $next ? $next($request) : null; }}
