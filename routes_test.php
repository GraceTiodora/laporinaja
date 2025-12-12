#!/usr/bin/env php
<?php
/**
 * Route Integrity Test Script
 * Verifies that all routes have matching controller methods
 * 
 * Run: php artisan tinker < routes_test.php
 * Or:  php routes_test.php
 */

// Get all routes
$routes = [];
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Get routes from route collection
$routeCollection = app('router')->getRoutes();

$errors = [];
$successes = [];

foreach ($routeCollection as $route) {
    $action = $route->getAction();
    
    // Skip middleware and other non-controller actions
    if (!isset($action['controller'])) {
        continue;
    }
    
    $controller = $action['controller'];
    
    // Parse controller@method format
    if (is_string($controller)) {
        [$controllerClass, $method] = explode('@', $controller);
        
        // Remove namespace if present
        $baseClass = class_basename($controllerClass);
        
        try {
            $reflection = new ReflectionClass($controllerClass);
            if (!$reflection->hasMethod($method)) {
                $errors[] = [
                    'route' => $route->uri(),
                    'controller' => $controllerClass,
                    'method' => $method,
                    'error' => "Method '$method' does not exist in $baseClass"
                ];
            } else {
                $successes[] = [
                    'route' => $route->uri(),
                    'controller' => $baseClass,
                    'method' => $method
                ];
            }
        } catch (ReflectionException $e) {
            $errors[] = [
                'route' => $route->uri(),
                'controller' => $controllerClass,
                'method' => $method,
                'error' => "Controller class not found: $controllerClass"
            ];
        }
    } elseif (is_array($controller)) {
        // For [ControllerClass::class, 'method'] format
        $controllerClass = $controller[0];
        $method = $controller[1];
        
        $baseClass = class_basename($controllerClass);
        
        try {
            $reflection = new ReflectionClass($controllerClass);
            if (!$reflection->hasMethod($method)) {
                $errors[] = [
                    'route' => $route->uri(),
                    'controller' => $controllerClass,
                    'method' => $method,
                    'error' => "Method '$method' does not exist in $baseClass"
                ];
            } else {
                $successes[] = [
                    'route' => $route->uri(),
                    'controller' => $baseClass,
                    'method' => $method
                ];
            }
        } catch (ReflectionException $e) {
            $errors[] = [
                'route' => $route->uri(),
                'controller' => $controllerClass,
                'method' => $method,
                'error' => "Controller class not found: $controllerClass"
            ];
        }
    }
}

// Output results
echo "\n";
echo "═════════════════════════════════════════════════════════════\n";
echo "  ROUTE INTEGRITY TEST RESULTS\n";
echo "═════════════════════════════════════════════════════════════\n\n";

if (!empty($errors)) {
    echo "❌ ERRORS FOUND: " . count($errors) . "\n\n";
    foreach ($errors as $error) {
        echo "  • Route: {$error['route']}\n";
        echo "    Controller: {$error['controller']}\n";
        echo "    Method: {$error['method']}\n";
        echo "    Error: {$error['error']}\n\n";
    }
} else {
    echo "✅ NO ERRORS: All routes have valid controller methods!\n\n";
}

echo "✅ ROUTES VERIFIED: " . count($successes) . "\n";
echo "❌ ROUTES WITH ERRORS: " . count($errors) . "\n";
echo "═════════════════════════════════════════════════════════════\n\n";

exit(count($errors) > 0 ? 1 : 0);
