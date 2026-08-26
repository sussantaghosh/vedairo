<?php
namespace Vedairo\AI;

final class ProviderRegistry {
    /** @var array<string,Provider> */
    private array $p = [];

    public function add(string $name, Provider $provider): void { $this->p[$name] = $provider; }

    public function get(string $name): Provider { if (!isset($this->p[$name])) throw new \RuntimeException("AI provider [$name] not configured"); return $this->p[$name]; }

    /** @return list<string> */
    public function names(): array { return array_keys($this->p); }
}

