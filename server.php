<?php

// Fallback router for PHP's built-in server used by `php artisan serve`.
// If a requested file exists in /public, let the server serve it directly; otherwise, bootstrap Laravel.

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));
$publicPath = __DIR__.'/public';

// Prevent path traversal and only allow files inside /public to be served directly
$requested = realpath($publicPath.$uri);
if ($uri !== '/' && $requested && str_starts_with($requested, realpath($publicPath)) && is_file($requested)) {
    return false; // Serve the static file directly
}

require_once $publicPath.'/index.php';
