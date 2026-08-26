<?php
namespace Vedairo\Schedule;
final class ScheduleManager {private array $tasks=[];public function everyMinute(callable $cb):self{$this->tasks[]=['expr'=>'* * * * *','cb'=>$cb];return $this;}public function daily(callable $cb):self{$this->tasks[]=['expr'=>'0 0 * * *','cb'=>$cb];return $this;}public function run():void{foreach($this->tasks as $t)($t['cb'])();}}
