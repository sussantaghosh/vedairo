<?php
namespace Vedairo\Routing;

use Vedairo\Http\Request;
use Vedairo\Http\Response;

class Router
{
    public array $routes = [];
    private array $group = [];

    public function add(string $m, string $p, mixed $a, array $mw = []): self
    {
        $this->routes[] = new Route(strtoupper($m), $p, $a, array_merge($this->group, $mw));
        return $this;
    }

    public function get($p, $a, $mw = []): self { return $this->add('GET', $p, $a, $mw); }
    public function post($p, $a, $mw = []): self { return $this->add('POST', $p, $a, $mw); }
    public function put($p, $a, $mw = []): self { return $this->add('PUT', $p, $a, $mw); }
    public function delete($p, $a, $mw = []): self { return $this->add('DELETE', $p, $a, $mw); }

    public function middleware(array $m, callable $cb): void
    {
        $old = $this->group;
        $this->group = array_merge($old, $m);
        $cb($this);
        $this->group = $old;
    }

    public function dispatch(Request $r): never
    {
        foreach ($this->routes as $route) {
            $re = '#^' . preg_replace('/\{([^}]+)\}/', '(?P<$1>[^/]+)', rtrim($route->path, '/')) . '/?$#';

            if ($route->method === $r->method && preg_match($re, $r->path, $m)) {
                foreach ($route->middleware as $mw) {
                    (new \Vedairo\Middleware\Pipeline)->handle($r, $mw);
                }

                $args = [];
                foreach ($m as $k => $v) {
                    if (!is_int($k)) $args[] = $v;
                }

                $a = $route->action;
                if (is_string($a) && str_contains($a, '@')) {
                    $x = explode('@', $a);
                    $obj = \Vedairo\Application::make($x[0]);
                    $result = $obj->{$x[1]}($r, ...$args);
                } elseif (is_callable($a)) {
                    $result = $a($r, ...$args);
                } else {
                    throw new \RuntimeException('Invalid route action');
                }

                if ($result !== null) {
                    if ($r->wantsJson() || is_array($result)) {
                        Response::json($result);
                    } else {
                        Response::html((string)$result);
                    }
                }
            }
        }

        Response::json(['success' => false, 'message' => 'Route not found'], 404);
    }
}

