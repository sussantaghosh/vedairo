<?php
namespace Vedairo\AI;
class Agent {
    /** @var array<string,array{handler:callable,schema:array<string,mixed>}> */
    private array $tools = [];

    public function __construct(private AIManager $ai) {}

    public function getAi(): AIManager { return $this->ai; }

    /** @param array<string,mixed> $schema
     *  @return $this
     */
    public function tool(string $name, callable $handler, array $schema = []): self { $this->tools[$name] = ['handler' => $handler, 'schema' => $schema]; return $this; }

    /** @param array<string,mixed> $context
     *  @return array<string,mixed>
     */
    public function run(string $prompt, array $context = []): array { return ['prompt' => $prompt, 'tools' => array_map(fn($v) => $v['schema'], $this->tools), 'context' => $context, 'message' => 'Agent planning layer ready; execute only explicitly registered tools.']; }

    /** @param array<string,mixed> $args
     *  @return mixed
     */
    public function callTool(string $name, array $args): mixed { if (!isset($this->tools[$name])) throw new \InvalidArgumentException('Tool not allowed: ' . $name); return ($this->tools[$name]['handler'])($args); }
}
