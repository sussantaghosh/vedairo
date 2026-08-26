<?php
namespace Vedairo\Observability;
final class Metrics {private static array $counters=[];private static array $timers=[];public static function inc(string $name,int $n=1):void{self::$counters[$name]=(self::$counters[$name]??0)+$n;}public static function observe(string $name,float $seconds):void{self::$timers[$name][]=round($seconds,6);}public static function all():array{return ['counters'=>self::$counters,'timers'=>self::$timers];}}
