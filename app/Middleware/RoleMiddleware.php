<?php
namespace App\Middleware;
class RoleMiddleware { public function handle(\Vedairo\Http\Request $r, string $role=''): void { $u=\Vedairo\Auth\Auth::user(); if(!$u || !in_array($u['role']??'',array_map('trim',explode(',',$role)),true)) \Vedairo\Http\Response::json(['success'=>false,'message'=>'Forbidden'],403); } }
