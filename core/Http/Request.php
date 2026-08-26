<?php
namespace Vedairo\Http;

class Request {
    public string $method;
    public string $path;
    /** @var array<string,mixed> */
    public array $query = [];
    /** @var array<string,mixed> */
    public array $input = [];
    /** @var array<string,mixed> */
    public array $server = [];

    /**
     * @param array<string,mixed>|null $query
     * @param array<string,mixed>|null $input
     * @param array<string,mixed>|null $server
     */
    public function __construct(?array $query = null, ?array $input = null, ?array $server = null) {
        $this->server = $server ?? $_SERVER;
        $this->method = strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
        $rawPath = parse_url($this->server['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $this->path = is_string($rawPath) && $rawPath !== '' ? $rawPath : '/';
        $this->query = $query ?? $_GET;

        if ($input !== null) {
            $this->input = $input;
        } else {
            $raw = @file_get_contents('php://input');
            $json = $raw ? json_decode($raw, true) : null;
            if (is_array($json)) {
                $this->input = $json;
            } elseif (in_array($this->method, ['PUT', 'PATCH', 'DELETE'], true) && is_string($raw) && $raw !== '') {
                parse_str($raw, $parsed);
                $this->input = $parsed;
            } else {

                $this->input = $_POST;
            }
        }
    }

    /**
     * @param array<string,mixed> $input
     * @param array<string,mixed> $query
     * @param array<string,mixed> $server
     */
    public static function create(string $method, string $uri, array $input = [], array $query = [], array $server = []): self {
        $server['REQUEST_METHOD'] = strtoupper($method);
        $server['REQUEST_URI'] = $uri;
        return new self($query, $input, $server);
    }

    public function input(?string $k = null, mixed $d = null): mixed {
        return $k === null ? $this->input : ($this->input[$k] ?? $d);
    }

    public function wantsJson(): bool {
        return str_contains($this->server['HTTP_ACCEPT'] ?? '', 'application/json')
            || str_starts_with($this->path, '/api/');
    }
}

