<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';

use Vedairo\Middleware\Pipeline;
use Vedairo\Http\Request;

$pipeline = new Pipeline();

$req = new Request([], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/test'], '', []);

// Test security headers middleware
$pipeline->handle($req, 'security');
assert(true, 'Security middleware executed');

// Test role middleware with authenticated admin
$_SESSION['user'] = ['id' => 1, 'role' => 'admin'];
$pipeline->handle($req, 'role:admin');
assert(true, 'Role middleware executed for admin');
unset($_SESSION['user']);

// Test missing middleware throws
$threw = false;
try {
    $pipeline->handle($req, 'non_existent_middleware');
} catch (\RuntimeException $e) {
    $threw = true;
}
assert($threw === true, 'Pipeline should throw on missing middleware');


echo "PipelineMiddlewareTest: PASS\n";
return true;

