<?php
namespace Vedairo\Validation;
final class Rules {public static function email(string $v):bool{return filter_var($v,FILTER_VALIDATE_EMAIL)!==false;}public static function url(string $v):bool{return filter_var($v,FILTER_VALIDATE_URL)!==false;}public static function integer(mixed $v):bool{return filter_var($v,FILTER_VALIDATE_INT)!==false;}public static function numeric(mixed $v):bool{return is_numeric($v);}public static function boolean(mixed $v):bool{return is_bool($v)||in_array($v,[0,1,'0','1','true','false'],true);}}
