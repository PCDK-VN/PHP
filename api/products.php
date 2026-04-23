<?php

declare(strict_types=1);

use App\Models\Product;

require_once __DIR__ . '/../vendor/autoload.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $filters = [
        'limit' => $_GET['limit'] ?? 20,
        'offset' => $_GET['offset'] ?? 0,
        'q' => $_GET['q'] ?? '',
        'category' => $_GET['category'] ?? '',
    ];

    echo json_encode([
        'data' => Product::list($filters),
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Unable to fetch products',
    ], JSON_UNESCAPED_UNICODE);
}
