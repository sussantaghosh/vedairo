<?php
declare(strict_types=1);

echo "=== VEDAIRO DEEP TEST SUITE ===\n\n";

require_once __DIR__ . '/../core/bootstrap.php';

// 1. Inspect Router and check all defined routes
$router = \Vedairo\Application::$container->get('router');
$routes = $router->routes;
echo "1. Checking registered routes (" . count($routes) . " routes):\n";

$routeErrors = [];
foreach ($routes as $route) {
    $method = $route->method;
    $path = $route->path;
    $action = $route->action;
    $middleware = $route->middleware;

    if (is_string($action) && str_contains($action, '@')) {
        [$class, $methodName] = explode('@', $action, 2);
        if (!class_exists($class)) {
            $routeErrors[] = "[$method $path] Target class '$class' does not exist.";
        } elseif (!method_exists($class, $methodName)) {
            $routeErrors[] = "[$method $path] Method '$methodName' does not exist in '$class'.";
        }
    } elseif (!is_callable($action)) {
        $routeErrors[] = "[$method $path] Action is neither Class@method nor callable: " . print_r($action, true);
    }
}

if (empty($routeErrors)) {
    echo "  [PASS] All " . count($routes) . " route endpoints resolve to valid classes and methods.\n";
} else {
    echo "  [FAIL] " . count($routeErrors) . " route errors found:\n";
    foreach ($routeErrors as $err) {
        echo "    - $err\n";
    }
}

// 2. Inspect all Controllers, Services, Models, Middleware
echo "\n2. Checking classes in app/:\n";
$appFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/../app'));
$classCheckErrors = [];
foreach ($appFiles as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getRealPath();
        $content = file_get_contents($path);
        if (preg_match('/namespace\s+([^;]+);/', $content, $nsMatch) &&
            preg_match('/(?:class|interface|trait|enum)\s+([a-zA-Z0-9_]+)/', $content, $clsMatch)) {
            $fullClass = $nsMatch[1] . '\\' . $clsMatch[1];
            try {
                if (!class_exists($fullClass) && !interface_exists($fullClass) && !trait_exists($fullClass)) {
                    $classCheckErrors[] = "Class '$fullClass' not found from file $path";
                } else {
                    // Try reflecting on class to verify method dependencies/types
                    $ref = new ReflectionClass($fullClass);
                }
            } catch (Throwable $e) {
                $classCheckErrors[] = "Reflection error on '$fullClass': " . $e->getMessage();
            }
        }
    }
}

if (empty($classCheckErrors)) {
    echo "  [PASS] All app classes and reflections verified.\n";
} else {
    echo "  [FAIL] " . count($classCheckErrors) . " class errors found:\n";
    foreach ($classCheckErrors as $err) {
        echo "    - $err\n";
    }
}

// 3. Inspect all Core classes
echo "\n3. Checking classes in core/:\n";
$coreFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/../core'));
$coreCheckErrors = [];
foreach ($coreFiles as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getRealPath();
        $content = file_get_contents($path);
        if (preg_match('/namespace\s+([^;]+);/', $content, $nsMatch) &&
            preg_match('/(?:class|interface|trait|enum)\s+([a-zA-Z0-9_]+)/', $content, $clsMatch)) {
            $fullClass = $nsMatch[1] . '\\' . $clsMatch[1];
            try {
                if (!class_exists($fullClass) && !interface_exists($fullClass) && !trait_exists($fullClass)) {
                    $coreCheckErrors[] = "Class '$fullClass' not found from file $path";
                } else {
                    $ref = new ReflectionClass($fullClass);
                }
            } catch (Throwable $e) {
                $coreCheckErrors[] = "Reflection error on '$fullClass': " . $e->getMessage();
            }
        }
    }
}

if (empty($coreCheckErrors)) {
    echo "  [PASS] All core classes and reflections verified.\n";
} else {
    echo "  [FAIL] " . count($coreCheckErrors) . " core class errors found:\n";
    foreach ($coreCheckErrors as $err) {
        echo "    - $err\n";
    }
}

// 4. Inspect CLI commands
echo "\n4. Checking CLI commands in Console:\n";
try {
    $refConsole = new ReflectionClass('Vedairo\\Console\\Console');
    echo "  [PASS] Console class reflection passed.\n";
} catch (Throwable $e) {
    echo "  [FAIL] Console error: " . $e->getMessage() . "\n";
}

// 5. Inspect database migrations SQL
echo "\n5. Checking SQL Migrations:\n";
$migrationFiles = glob(__DIR__ . '/../database/migrations/*.sql');
echo "  Found " . count($migrationFiles) . " migration files.\n";
foreach ($migrationFiles as $mf) {
    $sql = file_get_contents($mf);
    if (empty(trim($sql))) {
        echo "  [WARN] Migration " . basename($mf) . " is empty!\n";
    } else {
        echo "  [PASS] Migration " . basename($mf) . " (" . strlen($sql) . " bytes)\n";
    }
}

echo "\nDeep test suite complete.\n";
