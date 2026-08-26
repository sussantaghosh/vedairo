<?php
namespace Vedairo\Exceptions;

class Handler {
    public function render(\Throwable $e): never {
        http_response_code(500);
        error_log((string)$e);

        $debug = (bool) env('APP_DEBUG', false);
        $wantsJson = false;

        if (isset(\Vedairo\Application::$container)) {
            try {
                $r = \Vedairo\Application::$container->get('request');
                if ($r instanceof \Vedairo\Http\Request) {
                    $wantsJson = $r->wantsJson();
                }
            } catch (\Throwable) {}
        }

        if ($wantsJson) {
            \Vedairo\Http\Response::json([
                'success' => false,
                'message' => $debug ? $e->getMessage() : 'Internal Server Error',
                'trace' => $debug ? explode("\n", $e->getTraceAsString()) : []
            ], 500);
        }

        if ($debug) {
            echo '<pre>' . e((string)$e) . '</pre>';
        } else {
            echo '<h1>500 Internal Server Error</h1><p>VEDAIRO application error.</p>';
        }
        exit;
    }
}

