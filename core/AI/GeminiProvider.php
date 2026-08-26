<?php
namespace Vedairo\AI;
final class GeminiProvider implements Provider {
    public function __construct(private string $apiKey, private string $model = 'gemini-2.5-flash') {}

    /**
     * @param array<int,mixed> $messages
     * @param array<string,mixed> $options
     * @return array<string,mixed>
     */
    public function chat(array $messages, array $options = []): array {
        $contents = [];
        foreach ($messages as $m) $contents[] = ['role' => ($m['role'] ?? 'user') === 'assistant' ? 'model' : 'user', 'parts' => [['text' => (string)($m['content'] ?? '')]]];

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . rawurlencode($options['model'] ?? $this->model) . ':generateContent?key=' . rawurlencode($this->apiKey);
        $r = HttpGateway::json($url, ['contents' => $contents]);
        return ['text' => $r['candidates'][0]['content']['parts'][0]['text'] ?? '', 'raw' => $r];
    }

    /**
     * @param array<string,mixed> $options
     * @return array<string,mixed>
     */
    public function embed(string $text, array $options = []): array {
        $model = $options['model'] ?? 'text-embedding-004';
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . rawurlencode($model) . ':embedContent?key=' . rawurlencode($this->apiKey);
        $r = HttpGateway::json($url, ['model' => 'models/' . $model, 'content' => ['parts' => [['text' => $text]]]]);
        return ['vector' => $r['embedding']['values'] ?? [], 'raw' => $r];
    }
}
