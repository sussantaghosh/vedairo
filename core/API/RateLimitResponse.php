<?php
namespace Vedairo\API;
final class RateLimitResponse {public static function headers(int $limit,int $remaining,int $reset):void{header('X-RateLimit-Limit: '.$limit);header('X-RateLimit-Remaining: '.max(0,$remaining));header('X-RateLimit-Reset: '.$reset);}}
