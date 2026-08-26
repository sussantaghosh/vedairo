<?php
namespace Vedairo\Security;
final class PasswordPolicy {public static function validate(string $p):array{$e=[];if(strlen($p)<12)$e[]='Password must be at least 12 characters';if(!preg_match('/[A-Z]/',$p))$e[]='Password needs uppercase';if(!preg_match('/[a-z]/',$p))$e[]='Password needs lowercase';if(!preg_match('/\d/',$p))$e[]='Password needs a number';if(!preg_match('/[^A-Za-z0-9]/',$p))$e[]='Password needs a symbol';return $e;}}
