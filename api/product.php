<?php

declare(strict_types=1);

use App\Models\Product;

require_once __DIR__ . '/../vendor/autoload.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $product = null;

    if (isset($_GET['id']) && ctype_digit((string) $_GET['id'])) {
        $product = Product::getById((int) $_GET['id']);
    } elseif (!empty($_GET['slug'])) {
        $product = Product::getBySlug((string) $_GET['slug']);
    }

    if ($product === null) {
        http_response_code(404);
        echo json_encode(['error' => 'Product not found'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode(['data' => $product], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Unable to fetch product',
    ], JSON_UNESCAPED_UNICODE);
}
