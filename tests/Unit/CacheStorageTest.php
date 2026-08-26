<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';

use Vedairo\Cache\FileCache;
use Vedairo\Storage\Storage;

// Test FileCache
$cache = new FileCache();
$cache->put('test_key_123', 'cached_value_xyz', 60);
assert($cache->get('test_key_123') === 'cached_value_xyz', 'Cache get failed');
assert($cache->get('non_existent', 'default') === 'default', 'Cache default value failed');
$cache->forget('test_key_123');
assert($cache->get('test_key_123') === null, 'Cache forget failed');

// Test Storage put and delete
$path = Storage::put('test_unit_file.txt', 'Hello Storage');
assert(is_file($path), 'Storage put failed');
assert(file_get_contents($path) === 'Hello Storage', 'Storage content mismatch');
Storage::delete('test_unit_file.txt');
assert(!is_file($path), 'Storage delete failed');

echo "CacheStorageTest: PASS\n";
return true;
