<?php
namespace Vedairo\Support;
final class ConfigRepository {public function __construct(private array $items=[]){ }public function get(string $key,mixed $default=null):mixed{$parts=explode('.',$key);$v=$this->items;foreach($parts as $p){if(!is_array($v)||!array_key_exists($p,$v))return $default;$v=$v[$p];}return $v;}public function set(string $key,mixed $value):void{$parts=explode('.',$key);$ref=&$this->items;foreach($parts as $p){if(!isset($ref[$p])||!is_array($ref[$p]))$ref[$p]=[];$ref=&$ref[$p];}$ref=$value;}public function all():array{return $this->items;}}
