<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';

use Vedairo\Security\Csrf;
use Vedairo\Security\Encryption;
use Vedairo\Security\PasswordPolicy;
use Vedairo\Auth\Totp;

// Test CSRF
$token = Csrf::token();
assert(is_string($token) && strlen($token) === 64, 'Csrf token invalid length');
assert(Csrf::check($token) === true, 'Csrf check failed with valid token');
assert(Csrf::check('invalid_token') === false, 'Csrf check passed with invalid token');

// Test Encryption
$key = 'secret-key-for-test-suite-32byte';
$enc = new Encryption($key);
$plain = 'Sensitive data 123';
$cipher = $enc->encrypt($plain);
assert($cipher !== $plain, 'Cipher matches plaintext');
$decrypted = $enc->decrypt($cipher);
assert($decrypted === $plain, 'Decrypted text does not match original plaintext');

// Test Password Policy
$weak = PasswordPolicy::validate('weak');
assert(count($weak) > 0, 'Weak password should have policy errors');
$strong = PasswordPolicy::validate('SuperSecret@2026!');
assert(count($strong) === 0, 'Strong password should have no policy errors');

// Test TOTP
$secret = Totp::secret();
assert(strlen($secret) === 20, 'TOTP secret length invalid');
$code = Totp::code($secret);
assert(strlen($code) === 6, 'TOTP code length invalid');
assert(Totp::verify($secret, $code) === true, 'TOTP verification failed');
assert(Totp::verify($secret, '000000') === false, 'Invalid TOTP code should not verify');

echo "SecurityTest: PASS\n";
return true;
