<?php
namespace Vedairo;

class Application {
    public static Container $container;

    public static function boot(): void {
        self::$container = new Container();
        if (session_status() !== PHP_SESSION_ACTIVE && php_sapi_name() !== 'cli' && !headers_sent()) {
            session_start();
        }
        self::$container->singleton('db', fn() => new Database\DB());
        self::$container->singleton('router', fn() => new Routing\Router());
        self::$container->singleton('request', fn() => new Http\Request());
        self::$container->singleton('logger', fn() => new Logging\Logger());
        self::$container->singleton('auth', fn() => new Auth\AuthManager(self::$container->get('db')));
        self::$container->singleton('rbac', fn() => new Authorization\Rbac(self::$container->get('db')));
        self::$container->singleton('rateLimiter', fn() => new Security\RateLimiter(self::$container->get('db')));
        self::$container->singleton('scheduler', fn() => new Schedule\Scheduler());
        self::$container->singleton('queueWorker', fn() => new Queue\Worker(self::$container->get('db')));
        self::$container->singleton('backup', fn() => new Backup\BackupManager(self::$container->get('db')));
        self::$container->singleton('2fa', fn() => new Auth\TwoFactor(self::$container->get('db')));
        self::$container->singleton('oauth', fn() => new OAuth\OAuthServer(self::$container->get('db')));
        self::$container->singleton('notifications', fn() => new Notifications\NotificationManager(self::$container->get('db')));
        self::$container->singleton('tax', fn() => new Business\Tax(self::$container->get('db')));
        self::$container->singleton('invoice', fn() => new Business\Invoice(self::$container->get('db')));
        self::$container->singleton('coupon', fn() => new Business\Coupon(self::$container->get('db')));
        Observability\RequestId::header();
        self::$container->singleton('ai', fn() => self::aiManager());
        Security\Headers::apply();
        self::loadRoutes();
    }

    public static function loadRoutes(): void {
        require base_path('routes/web.php');
        require base_path('routes/api.php');
    }

    public static function run(): void {
        try {
            self::$container->get('router')->dispatch(self::$container->get('request'));
        } catch (\Throwable $e) {
            (new Exceptions\Handler)->render($e);
        }
    }

    /**
     * @param class-string $class
     */
    public static function make(string $class): mixed {
        return self::$container->make($class);
    }

    public static function aiManager(): AI\AIManager {
        $m = new AI\AIManager();
        if ($k = env('OPENAI_API_KEY', '')) {
            $m->register('openai', new AI\OpenAICompatibleProvider(env('OPENAI_BASE_URL', 'https://api.openai.com/v1/chat/completions'), $k, env('OPENAI_MODEL', 'gpt-4o-mini')));
        }
        if ($k = env('GEMINI_API_KEY', '')) {
            $m->register('gemini', new AI\GeminiProvider($k, env('GEMINI_MODEL', 'gemini-2.5-flash')));
        }
        if ($k = env('ANTHROPIC_API_KEY', '')) {
            $m->register('anthropic', new AI\AnthropicProvider($k, env('ANTHROPIC_MODEL', 'claude-3-5-sonnet-latest')));
        }
        return $m;
    }
}

