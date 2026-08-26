<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';

use Vedairo\Support\Str;
use Vedairo\Support\Arr;

// Test Str::slug
assert(Str::slug('Hello World 2026!') === 'hello-world-2026', 'Slug generation failed');
assert(Str::slug('  Multiple   Spaces  ') === 'multiple-spaces', 'Slug spacing failed');

// Test Str::random
$rand1 = Str::random(16);
$rand2 = Str::random(16);
assert(strlen($rand1) === 16, 'Str::random length incorrect');
assert($rand1 !== $rand2, 'Str::random randomness failed');

// Test Arr::get
$data = ['user' => ['profile' => ['name' => 'Alice']]];
assert(Arr::get($data, 'user.profile.name') === 'Alice', 'Arr::get nested failed');
assert(Arr::get($data, 'user.profile.age', 25) === 25, 'Arr::get default failed');

// Test Arr::only & Arr::except
$orig = ['a' => 1, 'b' => 2, 'c' => 3];
assert(Arr::only($orig, ['a', 'c']) === ['a' => 1, 'c' => 3], 'Arr::only failed');
assert(Arr::except($orig, ['b']) === ['a' => 1, 'c' => 3], 'Arr::except failed');

// Test helpers
assert(is_string(csrf_token()), 'csrf_token should return string');
assert(e('<script>') === '&lt;script&gt;', 'e() escaping failed');

echo "SupportTest: PASS\n";
return true;
