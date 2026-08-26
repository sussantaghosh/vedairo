<?php
namespace Vedairo\Payments;
class WebhookVerifier {
 public static function stripe(string $payload,string $signature,string $secret,int $tolerance=300):array{ $parts=[];foreach(explode(',',$signature) as $p){[$k,$v]=array_pad(explode('=',$p,2),2,null);$parts[$k]=$v;}if(empty($parts['t'])||empty($parts['v1']))throw new \RuntimeException('Invalid Stripe signature');if(abs(time()-(int)$parts['t'])>$tolerance)throw new \RuntimeException('Expired Stripe signature');$expected=hash_hmac('sha256',$parts['t'].'.'.$payload,$secret);if(!hash_equals($expected,$parts['v1']))throw new \RuntimeException('Invalid Stripe signature');return json_decode($payload,true,512,JSON_THROW_ON_ERROR); }
 public static function razorpay(string $payload,string $signature,string $secret):array{ $expected=hash_hmac('sha256',$payload,$secret);if(!hash_equals($expected,$signature))throw new \RuntimeException('Invalid Razorpay signature');return json_decode($payload,true,512,JSON_THROW_ON_ERROR); }
}
