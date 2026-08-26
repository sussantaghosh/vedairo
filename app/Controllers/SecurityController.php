<?php
namespace App\Controllers;
use Vedairo\Http\Request;
use Vedairo\Http\Response;
use Vedairo\Application;
final class SecurityController {
 /**
 * @return array<string,mixed>
 */
public function twoFactorSetup(Request $r): array {
    $id = Application::$container->get('auth')->id();
    if (!$id) Response::json(['success' => false, 'message' => 'Unauthenticated'], 401);
    return ['success' => true, 'data' => Application::$container->get('2fa')->enable($id)];
}
 /**
 * @return array<string,mixed>
 */
public function twoFactorVerify(Request $r): array {
    $id = Application::$container->get('auth')->id();
    if (!$id) Response::json(['success' => false, 'message' => 'Unauthenticated'], 401);
    $ok = Application::$container->get('2fa')->verify($id, (string)($r->input('code') ?? ''));
    return ['success' => $ok, 'message' => $ok ? '2FA verified' : 'Invalid code'];
}
 /**
 * @return array<string,mixed>
 */
public function twoFactorDisable(Request $r): array {
    $id = Application::$container->get('auth')->id();
    if (!$id) Response::json(['success' => false, 'message' => 'Unauthenticated'], 401);
    Application::$container->get('2fa')->disable($id);
    return ['success' => true];
}
}
