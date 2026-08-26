<?php
namespace Vedairo\AI;

class AIManager {
    /** @var array<string,Provider> */
    private array $providers = [];

    public function register(string $name, Provider $provider): self {
        $this->providers[$name] = $provider;
        return $this;
    }

    public function defaultProvider(): string {
        $configured = (string) env('AI_PROVIDER', 'openai');
        if (isset($this->providers[$configured])) {
            return $configured;
        }
        $names = array_keys($this->providers);
        return $names[0] ?? $configured;
    }

    public function provider(?string $name = null): Provider {
        $name = $name ?: $this->defaultProvider();
        if (!isset($this->providers[$name])) {
            throw new \InvalidArgumentException("AI provider [$name] is not configured");
        }
        return $this->providers[$name];
    }

    /** @return list<string> */
    public function names(): array {
        return array_keys($this->providers);
    }

    /**
     * @param string|array<int,mixed> $providerOrMessages
     * @param array<int|string,mixed> $messagesOrOptions
     * @param array<string,mixed> $options
     * @return array<string,mixed>
     */
    public function chat(string|array $providerOrMessages, array $messagesOrOptions = [], array $options = []): array {
        if (is_array($providerOrMessages)) {
            $provider = $this->defaultProvider();
            $messages = $providerOrMessages;
            /** @var array<string,mixed> $opts */
            $opts = $messagesOrOptions;
        } else {
            $provider = $providerOrMessages;
            /** @var array<int,mixed> $messages */
            $messages = $messagesOrOptions;
            $opts = $options;
        }
        return $this->provider($provider)->chat($messages, $opts);
    }

    /**
     * @param string $providerOrText
     * @param string|array<string,mixed> $textOrOptions
     * @param array<string,mixed> $options
     * @return array<string,mixed>
     */
    public function embed(string $providerOrText, string|array $textOrOptions = '', array $options = []): array {
        if (is_array($textOrOptions)) {
            $provider = $this->defaultProvider();
            $text = $providerOrText;
            $opts = $textOrOptions;
        } else {
            $provider = $providerOrText;
            $text = (string)$textOrOptions;
            $opts = $options;
        }
        return $this->provider($provider)->embed($text, $opts);
    }
}

