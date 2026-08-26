<?php
namespace Vedairo\Observability;
class Health { public static function report(array $checks):array{$out=[];$ok=true;foreach($checks as $name=>$fn){try{$r=$fn();$out[$name]=['ok'=>(bool)$r];if(!$r)$ok=false;}catch(\Throwable $e){$ok=false;$out[$name]=['ok'=>false,'error'=>$e->getMessage()];}}return ['ok'=>$ok,'checks'=>$out,'time'=>date(DATE_ATOM)];} }
