<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$scriptBase = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');

if ($scriptBase !== '' && $scriptBase !== '/' && str_starts_with($uriPath, $scriptBase)) {
    $uriPath = substr($uriPath, strlen($scriptBase)) ?: '/';
}

if ($uriPath === '/product' || preg_match('#^/product/([^/]+)$#', $uriPath, $matches) === 1) {
    if (isset($matches[1])) {
        $_GET['slug'] = urldecode($matches[1]);
    }

    $product = null;
    try {
        if (isset($_GET['id']) && ctype_digit((string) $_GET['id'])) {
            $product = App\Models\Product::getById((int) $_GET['id']);
        } elseif (!empty($_GET['slug'])) {
            $product = App\Models\Product::getBySlug((string) $_GET['slug']);
        }
    } catch (Throwable $e) {
        http_response_code(500);
        echo '<h1>Database is not ready. Configure .env and import linhkienmaytinh.sql.</h1>';
        exit;
    }

    if (!$product) {
        http_response_code(404);
        echo '<h1>Product not found</h1>';
        exit;
    }

    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= e($product['name']) ?> - K2 GEAR</title>
        <link rel="stylesheet" href="/public/assets/styles.css">
    </head>
    <body>
    <main style="max-width: 1000px; margin: 2rem auto; font-family: Arial, sans-serif;">
        <p><a href="<?= e(url('/')) ?>">&larr; Back to products</a></p>
        <h1><?= e($product['name']) ?></h1>
        <?php if (!empty($product['thumbnail'])): ?>
            <img src="<?= e((string) $product['thumbnail']) ?>" alt="<?= e($product['name']) ?>" style="max-width: 280px; display:block;">
        <?php endif; ?>
        <p><strong>Category:</strong> <?= e($product['category_name'] ?? 'N/A') ?></p>
        <p><strong>Price:</strong> <?= number_format((float) ($product['sale_price'] ?: $product['price']), 0, ',', '.') ?>₫</p>
        <p><?= nl2br(e((string) ($product['description'] ?? ''))) ?></p>
    </main>
    </body>
    </html>
    <?php
    return;
}

require __DIR__ . '/product-list.php';
