<?php
namespace Vedairo\AI;
final class HttpGateway {
    /**
     * @param array<string,string> $headers
     * @param string|false|null $body
     */
    public static function request(string $url, string $method = 'GET', array $headers = [], $body = null): string {
        $ch = curl_init($url);
        $hs = [];
        foreach ($headers as $k => $v) $hs[] = $k . ': ' . $v;
        /** @var array<int,mixed> $opts */
        $opts = [CURLOPT_RETURNTRANSFER => true, CURLOPT_CUSTOMREQUEST => $method, CURLOPT_HTTPHEADER => $hs, CURLOPT_TIMEOUT => 60];
        curl_setopt_array($ch, $opts);
        if ($body !== null) curl_setopt($ch, CURLOPT_POSTFIELDS, (string) $body);
        $out = curl_exec($ch);
        if ($out === false) throw new \RuntimeException(curl_error($ch));
        $out = (string) $out;
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($code >= 400) throw new \RuntimeException("HTTP $code: $out");
        return $out;
    }

    /**
     * @param array<string,mixed> $payload
     * @param array<string,string> $headers
     * @return array<string,mixed>
     */
    public static function json(string $url, array $payload, array $headers = []): array {
        $headers = array_merge(['Content-Type' => 'application/json'], $headers);
        return json_decode(self::request($url, 'POST', $headers, json_encode($payload, JSON_UNESCAPED_UNICODE)), true) ?? [];
    }
}
