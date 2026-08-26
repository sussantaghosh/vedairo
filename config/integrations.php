<?php

return [
    'payments' => [
        'stripe' => [
            'secret_key' => env('STRIPE_SECRET_KEY', env('STRIPE_SECRET', '')),
        ],
        'razorpay' => [
            'key_id' => env('RAZORPAY_KEY_ID', ''),
            'key_secret' => env('RAZORPAY_KEY_SECRET', ''),
        ],
    ],
    'mail' => [
        'driver' => env('MAIL_DRIVER', 'mail'),
        'host' => env('MAIL_HOST', 'smtp.example.com'),
        'port' => (int) env('MAIL_PORT', 587),
        'username' => env('MAIL_USERNAME', ''),
        'password' => env('MAIL_PASSWORD', ''),
        'from' => env('MAIL_FROM', 'no-reply@example.com'),
    ],
    'redis' => [
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'port' => (int) env('REDIS_PORT', 6379),
        'password' => env('REDIS_PASSWORD', ''),
        'db' => (int) env('REDIS_DB', 0),
    ],
    'ai' => [
        'openai' => [
            'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),
            'api_key' => env('OPENAI_API_KEY', ''),
            'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
            'embedding_model' => env('OPENAI_EMBEDDING_MODEL', 'text-embedding-3-small'),
        ],
        'gemini' => [
            'base_url' => env('GEMINI_OPENAI_BASE_URL', ''),
            'api_key' => env('GEMINI_API_KEY', ''),
            'model' => env('GEMINI_MODEL', 'gemini-2.5-flash'),
        ],
        'ollama' => [
            'base_url' => env('OLLAMA_BASE_URL', 'http://127.0.0.1:11434/v1'),
            'api_key' => env('OLLAMA_API_KEY', 'ollama'),
            'model' => env('OLLAMA_MODEL', 'llama3.2'),
        ],
    ],
    'storage' => [
        'endpoint' => env('S3_ENDPOINT', ''),
        'bucket' => env('S3_BUCKET', ''),
        'access_key' => env('S3_ACCESS_KEY', ''),
        'secret_key' => env('S3_SECRET_KEY', ''),
    ],
];

