<?php namespace Vedairo;
class Container {
    /** @var array<string,callable> */
    private array $bindings = [];

    /** @var array<string,mixed> */
    private array $instances = [];

    public function singleton(string $a, callable $f): void { $this->bindings[$a] = $f; }

    public function get(string $a): mixed { if (isset($this->instances[$a])) return $this->instances[$a]; if (isset($this->bindings[$a])) return $this->instances[$a] = ($this->bindings[$a])($this); return $this->make($a); }

    /**
     * @param class-string $class
     */
    public function make(string $class): mixed {
        $r = new \ReflectionClass($class);
        $ctor = $r->getConstructor();
        if (!$ctor) return $r->newInstance();

        $args = [];
        foreach ($ctor->getParameters() as $p) {
            $t = $p->getType();
            if ($t instanceof \ReflectionNamedType && !$t->isBuiltin()) {
                $args[] = $this->get($t->getName());
            } elseif ($p->isDefaultValueAvailable()) {
                $args[] = $p->getDefaultValue();
            } else {
                throw new \RuntimeException("Cannot resolve {$class}::{$p->getName()}");
            }
        }

        return $r->newInstanceArgs($args);
    }
}
