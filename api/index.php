<?php

/**
 * Vercel entrypoint for Laravel 12.
 * Routes all HTTP requests to Laravel's public/index.php.
 */

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

// Laravel's front controller
require __DIR__ . '/../public/index.php';