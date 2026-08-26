<?php
namespace Vedairo\Queue;
class Queue {public static function push(string $job,array $payload=[]):int{return \Vedairo\Jobs\DatabaseQueue::push($job,$payload);}public static function work(callable $dispatcher,int $maxJobs=0):int{$n=0;while($maxJobs===0||$n<$maxJobs){$job=\Vedairo\Jobs\DatabaseQueue::reserve();if(!$job)break;try{$dispatcher($job['name'],json_decode($job['payload'],true)?:[]);\Vedairo\Jobs\DatabaseQueue::complete($job);}catch(\Throwable $e){\Vedairo\Jobs\DatabaseQueue::fail($job,$e->getMessage());}$n++;}return $n;}}
