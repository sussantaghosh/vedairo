<?php
namespace Vedairo\AI;
class OpenAICompatibleProvider implements Provider {
    public function __construct(private string $baseUrl, private string $apiKey, private string $model = 'gpt-4o-mini') {}

    /**
     * @param array<string,mixed> $payload
     * @return array<string,mixed>
     */
    private function post(string $url, array $payload): array {
        $ch = curl_init($url);
        $body = json_encode($payload);
        if ($body === false) $body = '';
        /** @var array<int,mixed> $opts */
        $opts = [CURLOPT_POST => true, CURLOPT_RETURNTRANSFER => true, CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $this->apiKey, 'Content-Type: application/json'], CURLOPT_POSTFIELDS => $body, CURLOPT_TIMEOUT => 60];
        curl_setopt_array($ch, $opts);
        $raw = curl_exec($ch);
        if ($raw === false) throw new \RuntimeException(curl_error($ch));
        $raw = (string) $raw;
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $data = json_decode($raw, true) ?? [];
        if ($code >= 400) throw new \RuntimeException("AI HTTP $code: $raw");
        return $data;
    }

    /**
     * @param array<int,mixed> $messages
     * @param array<string,mixed> $options
     * @return array<string,mixed>
     */
    public function chat(array $messages, array $options = []): array {
        $d = $this->post($this->baseUrl, ['model' => $options['model'] ?? $this->model, 'messages' => $messages, 'temperature' => $options['temperature'] ?? 0.2]);
        return ['text' => $d['choices'][0]['message']['content'] ?? '', 'raw' => $d];
    }

    /**
     * @param array<string,mixed> $options
     * @return array<string,mixed>
     */
    public function embed(string $text, array $options = []): array {
        $url = str_contains($this->baseUrl, '/chat/completions') ? str_replace('/chat/completions', '/embeddings', $this->baseUrl) : rtrim($this->baseUrl, '/') . '/embeddings';
        $d = $this->post($url, ['model' => $options['model'] ?? 'text-embedding-3-small', 'input' => $text]);
        return ['vector' => $d['data'][0]['embedding'] ?? [], 'raw' => $d];
    }
}
