<?php
$r=\Vedairo\Application::$container->get('router');
$r->get('/api/v1/health',fn()=>['success'=>true,'framework'=>'VEDAIRO','version'=>'5.0.0']);
$r->get('/api/v1/users','App\Controllers\\UserController@apiIndex',['auth','throttle']);
$r->get('/api/v1/products','App\Controllers\\ProductController@apiIndex',['auth','throttle']);

$r->post('/api/v1/auth/token','App\Controllers\ApiAuthController@token',['throttle']);
$r->get('/api/v1/me','App\Controllers\ApiAuthController@me',['api']);
$r->get('/api/v1/openapi.json','App\\Controllers\\OpenApiController@spec');
$r->post('/api/v1/checkout','App\\Controllers\\OrderController@checkout',['api','throttle']);
$r->get('/api/v1/orders','App\\Controllers\\OrderController@index',['api','throttle']);

$r->get('/v1/health','App\Controllers\HealthController@index');
$r->get('/v1/events','App\Controllers\HealthController@sse');

$r->get('/api/v1/metrics', function($r){ return ['success'=>true,'data'=>\Vedairo\Observability\Metrics::all()]; }, ['api']);
$r->get('/api/v1/notifications', function($r){ $id=\Vedairo\Application::$container->get('auth')->id(); return ['success'=>true,'data'=>\Vedairo\Application::$container->get('notifications')->unread($id)]; }, ['api']);

