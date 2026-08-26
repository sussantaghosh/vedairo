<?php
declare(strict_types=1);

$startTime = microtime(true);
echo "=== VEDAIRO DIAGNOSTIC TOOL ===\n";

// 1. PHP Lint on all project files
echo "\n--- Step 1: Linting all PHP files ---\n";
$dir = new RecursiveDirectoryIterator(__DIR__ . '/..');
$iterator = new RecursiveIteratorIterator($dir);
$phpFiles = [];
$lintErrors = [];

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getRealPath();
        if (str_contains($path, DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR) || str_contains($path, DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR)) {
            continue;
        }
        $phpFiles[] = $path;
        $output = [];
        $returnVar = 0;
        exec('php -l ' . escapeshellarg($path), $output, $returnVar);
        if ($returnVar !== 0) {
            $lintErrors[$path] = implode("\n", $output);
        }
    }
}

echo "Total PHP files checked: " . count($phpFiles) . "\n";
if (empty($lintErrors)) {
    echo "[PASS] No syntax errors in PHP files.\n";
} else {
    echo "[FAIL] Syntax errors in " . count($lintErrors) . " files:\n";
    foreach ($lintErrors as $path => $err) {
        echo "  - $path:\n    $err\n";
    }
}

// 2. Bootstrap the application
echo "\n--- Step 2: Bootstrapping application ---\n";
try {
    require_once __DIR__ . '/../core/bootstrap.php';
    echo "[PASS] Bootstrap loaded successfully.\n";
} catch (Throwable $e) {
    echo "[FAIL] Bootstrap failed: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
}

// 3. Autoload & class verification
echo "\n--- Step 3: Verifying class autoloading & loading all project classes ---\n";
$classErrors = [];
foreach ($phpFiles as $path) {
    // Try to require or check classes declared in file
    $content = file_get_contents($path);
    if (preg_match('/namespace\s+([^;]+);/', $content, $nsMatch)) {
        $namespace = trim($nsMatch[1]);
        if (preg_match('/(?:class|interface|trait|enum)\s+([a-zA-Z0-9_]+)/', $content, $clsMatch)) {
            $className = $namespace . '\\' . $clsMatch[1];
            try {
                if (!class_exists($className) && !interface_exists($className) && !trait_exists($className) && !enum_exists($className)) {
                    $classErrors[] = "Class/Interface/Trait/Enum '$className' not autoloadable from $path";
                }
            } catch (Throwable $e) {
                $classErrors[] = "Error loading '$className' ($path): " . $e->getMessage();
            }
        }
    }
}

if (empty($classErrors)) {
    echo "[PASS] All classes loaded successfully without autoload issues.\n";
} else {
    echo "[FAIL] Found " . count($classErrors) . " class loading issues:\n";
    foreach ($classErrors as $err) {
        echo "  - $err\n";
    }
}

// 4. Verify Routes and Controller Handlers
echo "\n--- Step 4: Verifying routes and controllers ---\n";
$routeErrors = [];
try {
    // Collect all registered routes
    // Router in Vedairo
    $routerClass = 'Vedairo\\Routing\\Router';
    if (class_exists($routerClass)) {
        // Load web and api routes
        if (file_exists(__DIR__ . '/../routes/web.php')) {
            require_once __DIR__ . '/../routes/web.php';
        }
        if (file_exists(__DIR__ . '/../routes/api.php')) {
            require_once __DIR__ . '/../routes/api.php';
        }

        $routes = $routerClass::getRoutes();
        echo "Registered routes count: " . count($routes) . "\n";
        foreach ($routes as $route) {
            $handler = $route['handler'] ?? ($route['action'] ?? null);
            $method = $route['method'] ?? 'UNKNOWN';
            $uri = $route['uri'] ?? ($route['path'] ?? 'UNKNOWN');

            if (is_string($handler) && str_contains($handler, '@')) {
                [$controller, $action] = explode('@', $handler, 2);
                $fullController = str_starts_with($controller, 'App\\') ? $controller : 'App\\Controllers\\' . $controller;
                if (!class_exists($fullController)) {
                    $routeErrors[] = "Route [$method $uri]: Controller class '$fullController' does not exist.";
                } elseif (!method_exists($fullController, $action)) {
                    $routeErrors[] = "Route [$method $uri]: Method '$action' does not exist on controller '$fullController'.";
                }
            } elseif (is_array($handler) && count($handler) === 2) {
                [$controller, $action] = $handler;
                $fullController = is_string($controller) ? (str_starts_with($controller, 'App\\') ? $controller : 'App\\Controllers\\' . $controller) : (is_object($controller) ? get_class($controller) : null);
                if (!$fullController || !class_exists($fullController)) {
                    $routeErrors[] = "Route [$method $uri]: Controller class '$fullController' does not exist.";
                } elseif (!method_exists($fullController, $action)) {
                    $routeErrors[] = "Route [$method $uri]: Method '$action' does not exist on controller '$fullController'.";
                }
            }
        }
    }
} catch (Throwable $e) {
    $routeErrors[] = "Exception checking routes: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}

if (empty($routeErrors)) {
    echo "[PASS] All route handlers exist and are valid.\n";
} else {
    echo "[FAIL] Found " . count($routeErrors) . " route issues:\n";
    foreach ($routeErrors as $err) {
        echo "  - $err\n";
    }
}

// 5. Test CLI commands
echo "\n--- Step 5: Verifying CLI commands ---\n";
try {
    $consoleClass = 'Vedairo\\Console\\Console';
    if (class_exists($consoleClass)) {
        echo "[PASS] Console class exists.\n";
    }
} catch (Throwable $e) {
    echo "[FAIL] CLI verification error: " . $e->getMessage() . "\n";
}

// 6. Test Environment file configuration
echo "\n--- Step 6: Checking .env and .env.example / .env.enterprise.example ---\n";
if (!file_exists(__DIR__ . '/../.env')) {
    echo "[WARN] .env file does not exist yet in root.\n";
} else {
    echo "[PASS] .env file exists.\n";
}

echo "\nDiagnostic completed in " . round((microtime(true) - $startTime) * 1000, 2) . "ms\n";
