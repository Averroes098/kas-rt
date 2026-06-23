<?php

/**
 * Vercel entrypoint for Laravel 12.
 * Routes all HTTP requests to Laravel's public/index.php.
 */

// Safe environment diagnostics
if (isset($_GET['check_key'])) {
    $key = getenv('APP_KEY') ?: ($_ENV['APP_KEY'] ?? ($_SERVER['APP_KEY'] ?? null));
    echo "<h3>APP_KEY Diagnostics:</h3>";
    echo "getenv('APP_KEY'): " . (getenv('APP_KEY') ? 'FOUND (' . strlen(getenv('APP_KEY')) . ' chars)' : 'NOT FOUND') . "<br>";
    echo "\$_ENV['APP_KEY']: " . (isset($_ENV['APP_KEY']) ? 'FOUND (' . strlen($_ENV['APP_KEY']) . ' chars)' : 'NOT FOUND') . "<br>";
    echo "\$_SERVER['APP_KEY']: " . (isset($_SERVER['APP_KEY']) ? 'FOUND (' . strlen($_SERVER['APP_KEY']) . ' chars)' : 'NOT FOUND') . "<br>";
    if ($key) {
        echo "Format: " . (str_starts_with($key, 'base64:') ? 'Valid Base64 Prefix' : 'Missing base64: prefix') . "<br>";
        echo "First 10 chars: <code>" . htmlspecialchars(substr($key, 0, 10)) . "...</code><br>";
    }
    echo "<hr><h3>Available Server Variables:</h3><pre>";
    print_r(array_keys($_SERVER));
    echo "</pre>";
    exit;
}

// Set the public path for Vercel's read-only filesystem
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../public';

// Vercel serverless environment overrides to use read-write /tmp path
$variables = [
    'APP_CONFIG_CACHE' => '/tmp/config.php',
    'APP_EVENTS_CACHE' => '/tmp/events.php',
    'APP_PACKAGES_CACHE' => '/tmp/packages.php',
    'APP_ROUTES_CACHE' => '/tmp/routes.php',
    'APP_SERVICES_CACHE' => '/tmp/services.php',
    'VIEW_COMPILED_PATH' => '/tmp',
    'LOG_CHANNEL' => 'stderr',
];

foreach ($variables as $key => $value) {
    putenv("{$key}={$value}");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

// Default driver settings to prevent read-only filesystem errors
$defaults = [
    'CACHE_STORE' => 'array',
    'SESSION_DRIVER' => 'cookie',
];

foreach ($defaults as $key => $value) {
    if (!getenv($key)) {
        putenv("{$key}={$value}");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

// Laravel's front controller execution with error capture
try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo "<h2>Laravel Bootstrap Exception Captured:</h2>";
    echo "<strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "<br>";
    echo "<strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (Line " . $e->getLine() . ")<br>";
    echo "<h3>Stack Trace:</h3><pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}