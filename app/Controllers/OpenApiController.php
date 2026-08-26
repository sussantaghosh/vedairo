<?php
namespace App\Controllers;
class OpenApiController {
    /**
     * @return array<string,mixed>
     */
    public function spec(): array {
        return [
            '$schema' => 'https://spec.openapis.org/oas/3.0/dialect/base',
            'openapi' => '3.0.3',
            'info' => ['title' => 'VEDAIRO API', 'version' => '3.0.0'],
            'paths' => [
                '/api/v1/health' => ['get' => ['responses' => ['200' => ['description' => 'Health check']]]],
                '/api/v1/products' => ['get' => ['responses' => ['200' => ['description' => 'Product collection']]]],
            ],
        ];
    }
}
