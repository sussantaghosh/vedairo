<?php
namespace Vedairo\Storage;

final class StorageManager {
    /**
     * @param array<string,mixed> $disks
     */
    public function __construct(private array $disks = []) {}

    public function disk(string $name = 'local'): mixed {
        if (!isset($this->disks[$name])) {
            throw new \RuntimeException('Storage disk not configured: ' . $name);
        }
        return $this->disks[$name];
    }
}

