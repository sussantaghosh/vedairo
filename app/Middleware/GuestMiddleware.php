<?php namespace App\Middleware; class GuestMiddleware {public function handle(\Vedairo\Http\Request $r): void { if(\Vedairo\Auth\Auth::check())\redirect('/dashboard'); }}
