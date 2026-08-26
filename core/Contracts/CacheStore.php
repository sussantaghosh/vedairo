<?php
namespace Vedairo\Contracts;
interface CacheStore { public function get(string $key, mixed $default=null): mixed; public function put(string $key, mixed $value, int $seconds=3600): void; public function forget(string $key): void; public function has(string $key): bool; }
