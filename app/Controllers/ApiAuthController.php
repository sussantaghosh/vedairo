<?php
namespace App\Controllers;
use Vedairo\Http\Request;use Vedairo\Http\Response;use App\Models\User;use Vedairo\Validation\Validator;
class ApiAuthController {
 public function token(Request $r):never{$v=new Validator($r->input(),['email'=>'required|email','password'=>'required|min:6']);if(!$v->validate())Response::json(['success'=>false,'errors'=>$v->errors()],422);$u=User::byEmail((string)$r->input('email'));if(!$u||!password_verify((string)$r->input('password'),$u['password']))Response::json(['success'=>false,'message'=>'Invalid credentials'],401);$token=bin2hex(random_bytes(32));User::updateById((int)$u['id'],['api_token_hash'=>hash('sha256',$token),'updated_at'=>date('Y-m-d H:i:s')]);Response::json(['success'=>true,'token'=>$token,'token_type'=>'Bearer']);}
 public function me(Request $r):never{$u=\Vedairo\Auth\Auth::user();unset($u['password'],$u['api_token_hash']);Response::json(['success'=>true,'data'=>$u]);}
}
