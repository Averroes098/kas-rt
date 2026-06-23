<?php

/**
 * Vercel entrypoint for Laravel 12.
 * Routes all HTTP requests to Laravel's public/index.php.
 */

// Set the public path for Vercel's read-only filesystem
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../public';

// Laravel's front controller
require __DIR__ . '/../public/index.php';