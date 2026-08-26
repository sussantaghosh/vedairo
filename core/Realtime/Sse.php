<?php
namespace Vedairo\Realtime;
final class Sse {public static function start():void{header('Content-Type: text/event-stream');header('Cache-Control: no-cache');header('X-Accel-Buffering: no');}public static function send(string $event,mixed $data):void{echo 'event: '.preg_replace('/[^A-Za-z0-9_.-]/','',$event)."\n";echo 'data: '.json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)."\n\n";@ob_flush();@flush();}public static function heartbeat():void{echo ": heartbeat\n\n";@ob_flush();@flush();}}
