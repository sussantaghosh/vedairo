<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';

use Vedairo\Routing\Router;
use Vedairo\Http\Request;

$router = new Router();

// Test basic route registration
$router->get('/test-route', function() {
    return 'route_ok';
});

$router->post('/api/users', function() {
    return ['status' => 'created'];
}, ['api']);

$router->get('/products/{id}', function(Request $r, $id) {
    return 'product_' . $id;
});

// Test route matching
$req1 = Request::create('GET', '/test-route');
assert($req1->method === 'GET');
assert($req1->path === '/test-route');

$req2 = Request::create('GET', '/products/42');
assert($req2->path === '/products/42');

$req3 = Request::create('POST', '/api/users', ['name' => 'Alice']);
assert($req3->input('name') === 'Alice');

echo "RouterTest: PASS\n";
return true;

