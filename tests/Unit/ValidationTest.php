<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';

use Vedairo\Validation\Validator;
use Vedairo\Validation\Rules;

// Test 1: Required rule
$v1 = new Validator(['name' => 'John', 'empty' => '', 'null' => null], [
    'name' => 'required',
    'empty' => 'required',
    'null' => 'required'
]);
assert($v1->validate() === false, 'Validator required rule should fail on empty string and null');
assert(!isset($v1->errors()['name']), 'Valid required field should not have error');
assert(isset($v1->errors()['empty']), 'Empty string required field should have error');
assert(isset($v1->errors()['null']), 'Null required field should have error');

// Test 2: Integer rule including 0 and '0'
$v2 = new Validator([
    'zero_int' => 0,
    'zero_str' => '0',
    'pos_int' => 42,
    'pos_str' => '100',
    'invalid' => 'abc'
], [
    'zero_int' => 'required|integer',
    'zero_str' => 'required|integer',
    'pos_int' => 'required|integer',
    'pos_str' => 'required|integer',
    'invalid' => 'required|integer',
]);
assert($v2->validate() === false, 'Validator integer rule should fail on non-integer');
assert(!isset($v2->errors()['zero_int']), '0 should be valid integer');
assert(!isset($v2->errors()['zero_str']), "'0' should be valid integer");
assert(!isset($v2->errors()['pos_int']), '42 should be valid integer');
assert(!isset($v2->errors()['pos_str']), "'100' should be valid integer");
assert(isset($v2->errors()['invalid']), "'abc' should fail integer validation");

// Test 3: Email rule
$v3 = new Validator([
    'valid_email' => 'user@example.com',
    'invalid_email' => 'not-an-email'
], [
    'valid_email' => 'required|email',
    'invalid_email' => 'required|email'
]);
assert($v3->validate() === false);
assert(!isset($v3->errors()['valid_email']), 'Valid email should pass');
assert(isset($v3->errors()['invalid_email']), 'Invalid email should fail');

// Test 4: Min / Max
$v4 = new Validator([
    'short' => 'ab',
    'long' => 'abcdefghij'
], [
    'short' => 'min:3',
    'long' => 'max:5'
]);
assert($v4->validate() === false);
assert(isset($v4->errors()['short']));
assert(isset($v4->errors()['long']));

// Test 5: Rules helper
assert(Rules::integer(0) === true);
assert(Rules::integer('0') === true);
assert(Rules::integer(123) === true);
assert(Rules::integer('abc') === false);
assert(Rules::email('test@vedairo.local') === true);
assert(Rules::email('invalid') === false);

echo "ValidationTest: PASS\n";
return true;
