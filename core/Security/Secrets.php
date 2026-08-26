<?php
namespace Vedairo\Security;
final class Secrets {public static function generate(int $bytes=32):string{return base64_encode(random_bytes($bytes));}public static function hash(string $secret):string{return hash('sha256',$secret);}public static function verify(string $secret,string $hash):bool{return hash_equals($hash,self::hash($secret));}}
