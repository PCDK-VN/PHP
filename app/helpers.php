<?php

declare(strict_types=1);

if (!function_exists('e')) {
    function e(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('url')) {
    function url(string $path = ''): string
    {
        $base = rtrim($_ENV['BASE_URL'] ?? '', '/');
        $path = '/' . ltrim($path, '/');

        return $base !== '' ? $base . $path : $path;
    }
}
