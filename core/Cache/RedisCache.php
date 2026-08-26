<?php
namespace Vedairo\Cache;
use Vedairo\Contracts\CacheStore;
class RedisCache implements CacheStore {
    private \Redis $redis;

    /**
     * @param array<string,mixed> $config
     */
    public function __construct(private array $config){
        if (!class_exists('Redis')) throw new \RuntimeException('phpredis extension is required for RedisCache.');
        $r = new \Redis();
        $host = $this->config['host'] ?? '127.0.0.1';
        $port = (int) ($this->config['port'] ?? 6379);
        if (!$r->connect($host, $port, (float) ($this->config['timeout'] ?? 2))) throw new \RuntimeException('Redis connection failed.');
        if (!empty($this->config['password'])) $r->auth($this->config['password']);
        if (isset($this->config['db'])) $r->select((int) $this->config['db']);
        $this->redis = $r;
    }

    public function get(string $key, mixed $default = null): mixed { $v = $this->redis->get($key); return $v === false ? $default : unserialize((string)$v); }
    public function put(string $key, mixed $value, int $seconds = 3600): void { $this->redis->setex($key, $seconds, serialize($value)); }
    public function forget(string $key): void { $this->redis->del($key); }
    public function has(string $key): bool { return (bool)$this->redis->exists($key); }
}
