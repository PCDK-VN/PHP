<?php

declare(strict_types=1);

use App\Models\Product;

$products = [];
$error = null;

try {
    $products = Product::list([
        'limit' => $_GET['limit'] ?? 12,
        'offset' => $_GET['offset'] ?? 0,
        'q' => $_GET['q'] ?? '',
        'category' => $_GET['category'] ?? '',
    ]);
} catch (Throwable $e) {
    $error = 'Database connection is not ready. Configure `.env` and import DB first.';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>K2 GEAR - Products</title>
    <link rel="stylesheet" href="/public/assets/styles.css">
</head>
<body>
<main style="max-width: 1100px; margin: 2rem auto; font-family: Arial, sans-serif;">
    <h1>K2 GEAR Products</h1>
    <form method="get" style="margin-bottom: 1rem; display:flex; gap:.5rem;">
        <input type="text" name="q" value="<?= e((string) ($_GET['q'] ?? '')) ?>" placeholder="Search products" />
        <input type="text" name="category" value="<?= e((string) ($_GET['category'] ?? '')) ?>" placeholder="Category or ID" />
        <button type="submit">Filter</button>
    </form>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1rem;">
        <?php if ($error !== null): ?>
            <p><?= e($error) ?></p>
        <?php endif; ?>
        <?php foreach ($products as $product): ?>
            <article style="border:1px solid #ddd;border-radius:8px;padding:1rem;">
                <a href="<?= e(url('/product/' . (string) $product['slug'])) ?>" style="text-decoration:none;color:inherit;">
                    <strong><?= e($product['name']) ?></strong>
                </a>
                <p style="margin:.5rem 0;">Category: <?= e($product['category_name'] ?? 'N/A') ?></p>
                <p style="margin:.5rem 0;">Price: <?= number_format((float) ($product['sale_price'] ?: $product['price']), 0, ',', '.') ?>₫</p>
                <p style="margin:.5rem 0;">Stock: <?= (int) ($product['stock'] ?? 0) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
