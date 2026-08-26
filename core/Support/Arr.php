<?php
namespace Vedairo\Support;
final class Arr {public static function only(array $a,array $keys):array{return array_intersect_key($a,array_flip($keys));}public static function except(array $a,array $keys):array{return array_diff_key($a,array_flip($keys));}public static function get(array $a,string $key,mixed $default=null):mixed{$v=$a;foreach(explode('.',$key) as $p){if(!is_array($v)||!array_key_exists($p,$v))return $default;$v=$v[$p];}return $v;}}
