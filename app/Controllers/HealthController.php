<?php namespace App\Controllers; class HealthController {public function index(): never { \Vedairo\Http\Response::json(['success' => true, 'framework' => 'VEDAIRO', 'version' => '5.0.0', 'php' => PHP_VERSION, 'time' => date(DATE_ATOM)]); }
    public function sse(): void { \Vedairo\Realtime\Sse::send('heartbeat', ['time' => date(DATE_ATOM)]); }
}
