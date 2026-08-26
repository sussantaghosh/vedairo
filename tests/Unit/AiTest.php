<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';

use Vedairo\AI\AIManager;
use Vedairo\AI\Agent;
use Vedairo\AI\Provider;

// Mock AI provider for unit testing
$mockProvider = new class implements Provider {
    public function chat(array $messages, array $options = []): array {
        return ['text' => 'Echo: ' . ($messages[0]['content'] ?? ''), 'raw' => []];
    }
    public function embed(string $text, array $options = []): array {
        return ['vector' => [0.1, 0.2, 0.3], 'raw' => []];
    }
};

$ai = new AIManager();
$ai->register('mock', $mockProvider);

assert(in_array('mock', $ai->names(), true), 'AIManager should list registered provider');
$res = $ai->chat('mock', [['role' => 'user', 'content' => 'Hello']]);
assert($res['text'] === 'Echo: Hello', 'AIManager chat response mismatch');

$embed = $ai->embed('mock', 'Test text');
assert(count($embed['vector']) === 3, 'AIManager embed vector mismatch');

// Test Agent with tools
$agent = new Agent($ai);
$agent->tool('calculator', function($args) {
    return ($args['a'] ?? 0) + ($args['b'] ?? 0);
}, ['name' => 'calculator', 'description' => 'Add two numbers']);

$result = $agent->callTool('calculator', ['a' => 10, 'b' => 32]);
assert($result === 42, 'Agent tool execution failed');

echo "AiTest: PASS\n";
return true;
