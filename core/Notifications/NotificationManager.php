<?php
namespace Vedairo\Notifications;
use Vedairo\Database\DB;
final class NotificationManager {public function __construct(private DB $db){}public function database(?int $userId,string $type,array $data):int{return $this->db->table('notifications')->insert(['user_id'=>$userId,'type'=>$type,'data'=>json_encode($data)]);}public function markRead(int $id,?int $userId=null):int{$q=$this->db->table('notifications')->whereEq('id',$id);if($userId!==null)$q->whereEq('user_id',$userId);return $q->update(['read_at'=>date('Y-m-d H:i:s')]);}public function unread(?int $userId):array{$q=$this->db->table('notifications')->whereNull('read_at');if($userId!==null)$q->whereEq('user_id',$userId);return $q->orderBy('id','DESC')->limit(100)->get();}}
