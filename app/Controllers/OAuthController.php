<?php
namespace App\Controllers;
use Vedairo\Http\Request;
use Vedairo\Http\Response;
use Vedairo\Application;
final class OAuthController {
 /**
 * @return array<string,mixed>
 */
public function token(Request $r): array {
    $o = Application::$container->get('oauth');
    try {
        return $o->token((string)$r->input('client_id'), (string)$r->input('client_secret'), (string)$r->input('code'));
    } catch (\Throwable $e) {
        Response::json(['error' => 'invalid_grant', 'error_description' => $e->getMessage()], 400);
    }
}
public function authorize(Request $r): never {
    $auth = Application::$container->get('auth');
    if (!$auth->check()) Response::json(['error' => 'login_required'], 401);

    $o = Application::$container->get('oauth');
    try {
        $code = $o->authorize((string)$r->input('client_id'), $auth->id(), (string)$r->input('redirect_uri'), (string)$r->input('scope', ''));
        $uri = (string)$r->input('redirect_uri');
        $sep = str_contains($uri, '?') ? '&' : '?';
        redirect($uri . $sep . 'code=' . rawurlencode($code));
    } catch (\Throwable $e) {
        Response::json(['error' => 'invalid_request', 'error_description' => $e->getMessage()], 400);
    }
}
}
