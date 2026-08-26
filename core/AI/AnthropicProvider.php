<?php
namespace Vedairo\AI;
final class AnthropicProvider implements Provider {
    public function __construct(private string $apiKey, private string $model = 'claude-3-5-sonnet-latest') {}

    /**
     * @param array<int,mixed> $messages
     * @param array<string,mixed> $options
     * @return array<string,mixed>
     */
    public function chat(array $messages, array $options = []): array {
        $body = ['model' => $options['model'] ?? $this->model, 'max_tokens' => $options['max_tokens'] ?? 1024, 'messages' => $messages];
        $raw = HttpGateway::request('https://api.anthropic.com/v1/messages', 'POST', ['x-api-key' => $this->apiKey, 'anthropic-version' => '2023-06-01', 'content-type' => 'application/json'], json_encode($body));
        $j = json_decode($raw, true) ?? [];
        return ['text' => $j['content'][0]['text'] ?? '', 'raw' => $j];
    }

    /**
     * @param array<string,mixed> $options
     * @return array<string,mixed>
     */
    public function embed(string $text, array $options = []): array {
        throw new \RuntimeException('Anthropic does not expose a native embeddings API; configure a separate embedding provider.');
    }
}
