<?php
namespace Vedairo\AI;
interface Provider {
    /**
     * @param array<int,mixed> $messages
     * @param array<string,mixed> $options
     * @return array<string,mixed>
     */
    public function chat(array $messages, array $options = []): array;

    /**
     * @param array<string,mixed> $options
     * @return array<string,mixed>
     */
    public function embed(string $text, array $options = []): array;
}
