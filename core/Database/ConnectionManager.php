<?php
namespace Vedairo\Database;
final class ConnectionManager {
    /** @var array<string,DB> */
    private array $connections = [];

    public function add(string $name, DB $db): void { $this->connections[$name] = $db; }

    public function get(string $name = 'default'): DB { if (!isset($this->connections[$name])) throw new \RuntimeException('Database connection not configured: ' . $name); return $this->connections[$name]; }
}
