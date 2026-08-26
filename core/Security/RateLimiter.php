<?php
namespace Vedairo\Security;
use Vedairo\Database\DB;
final class RateLimiter { public function __construct(private DB $db){} public function hit(string $key,int $limit=60,int $window=60):bool{$now=time();$row=$this->db->query('SELECT * FROM rate_limits WHERE rate_key=? LIMIT 1',[$key])->fetch();if(!$row||strtotime($row['reset_at'])<time()){ $reset=date('Y-m-d H:i:s',$now+$window);$this->db->query('INSERT INTO rate_limits(rate_key,hits,reset_at) VALUES(?,1,?) ON DUPLICATE KEY UPDATE hits=1,reset_at=VALUES(reset_at)',[$key,$reset]);return true;}if((int)$row['hits']>=$limit)return false;$this->db->query('UPDATE rate_limits SET hits=hits+1 WHERE rate_key=?',[$key]);return true;} }
