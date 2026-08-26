<?php
namespace Vedairo\Logging;

class Logger {
    /**
     * @param array<string,mixed> $context
     */
    public function log(string $level, string $message, array $context = []): void {
        $dir = base_path('storage/logs');
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        $line = date('c') . " [$level] $message " . json_encode($context) . PHP_EOL;
        file_put_contents($dir . '/app.log', $line, FILE_APPEND | LOCK_EX);
    }
}

