<?php
namespace Vedairo\Schedule;
final class Scheduler {private array $tasks=[];public function everyMinute(callable $fn):self{$this->tasks[]=['interval'=>60,'fn'=>$fn];return $this;}public function due():array{return $this->tasks;}public function runDue():void{foreach($this->tasks as $t)($t['fn'])();}}
