<?php
namespace Vedairo\Jobs;
class DatabaseQueue {
 public static function push(string $name,array $payload,int $delay=0):int{ $db=\Vedairo\Application::$container->get('db'); return $db->table('jobs')->insert(['queue'=>'default','name'=>$name,'payload'=>json_encode($payload),'available_at'=>date('Y-m-d H:i:s',time()+max(0,$delay)),'attempts'=>0,'reserved_at'=>null,'created_at'=>date('Y-m-d H:i:s')]); }
 public static function reserve():?array{ $db=\Vedairo\Application::$container->get('db');$pdo=$db->pdo();$pdo->beginTransaction();try{$row=$db->table('jobs')->where('available_at','<=',date('Y-m-d H:i:s'))->whereNull('reserved_at')->orderBy('id')->first();if(!$row){$pdo->commit();return null;}$db->table('jobs')->whereEq('id',$row['id'])->update(['reserved_at'=>date('Y-m-d H:i:s'),'attempts'=>$row['attempts']+1]);$pdo->commit();return $row;}catch(\Throwable $e){$pdo->rollBack();throw $e;}}
 public static function fail(array $job,string $error):void{$db=\Vedairo\Application::$container->get('db');$db->table('failed_jobs')->insert(['queue'=>$job['queue'],'payload'=>$job['payload'],'error'=>$error]);$db->table('jobs')->whereEq('id',$job['id'])->delete();}
 public static function complete(array $job):void{\Vedairo\Application::$container->get('db')->table('jobs')->whereEq('id',$job['id'])->delete();}
}
