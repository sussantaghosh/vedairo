<?php
$r=\Vedairo\Application::$container->get('router');
$r->get('/','App\Controllers\\HomeController@index');
$r->get('/login','App\Controllers\\AuthController@showLogin',['guest']);
$r->post('/login','App\Controllers\\AuthController@login',['guest','csrf']);
$r->post('/logout','App\Controllers\\AuthController@logout',['auth','csrf']);
$r->get('/dashboard','App\Controllers\\HomeController@dashboard',['auth']);
$r->get('/users','App\Controllers\\UserController@index',['auth']);
$r->post('/users','App\Controllers\\UserController@store',['auth','csrf']);
$r->get('/products','App\Controllers\\ProductController@index',['auth']);
$r->post('/products','App\Controllers\\ProductController@store',['auth','csrf']);
$r->put('/products/{id}','App\Controllers\\ProductController@update',['auth','csrf']);
$r->delete('/products/{id}','App\Controllers\\ProductController@destroy',['auth','csrf']);
$r->get('/cart','App\Controllers\\CartController@index',['auth']);
$r->post('/cart/add','App\Controllers\\CartController@add',['auth','csrf']);
$r->put('/cart/{id}','App\Controllers\\CartController@update',['auth','csrf']);
$r->delete('/cart/{id}','App\Controllers\\CartController@remove',['auth','csrf']);
$r->delete('/cart','App\Controllers\\CartController@clear',['auth','csrf']);
$r->post('/checkout','App\\Controllers\\OrderController@checkout',['auth','csrf']);
$r->get('/orders','App\\Controllers\\OrderController@index',['auth']);

$r->get('/admin', 'App\\Controllers\\AdminController@dashboard', ['auth']);
$r->get('/security/2fa/setup', 'App\\Controllers\\SecurityController@twoFactorSetup', ['auth']);
$r->post('/security/2fa/verify', 'App\\Controllers\\SecurityController@twoFactorVerify', ['auth']);
$r->post('/security/2fa/disable', 'App\\Controllers\\SecurityController@twoFactorDisable', ['auth']);
$r->get('/oauth/authorize', 'App\\Controllers\\OAuthController@authorize', ['auth']);
$r->post('/oauth/token', 'App\\Controllers\\OAuthController@token');
