<?php

declare(strict_types=1);

namespace App\Models;

use App\Db;
use PDO;

final class Product
{
    public static function list(array $filters = []): array
    {
        $limit = max(1, min((int) ($filters['limit'] ?? 20), 100));
        $offset = max(0, (int) ($filters['offset'] ?? 0));
        $q = trim((string) ($filters['q'] ?? ''));
        $category = trim((string) ($filters['category'] ?? ''));

        $sql = 'SELECT p.id, p.name, p.slug, p.thumbnail, p.price, p.sale_price, p.stock, p.status, p.category_id,
                       c.name AS category_name
                FROM products p
                LEFT JOIN categories c ON c.id = p.category_id
                WHERE 1=1';

        $params = [];

        if ($q !== '') {
            $sql .= ' AND (p.name LIKE :q OR p.slug LIKE :q)';
            $params[':q'] = '%' . $q . '%';
        }

        if ($category !== '') {
            if (ctype_digit($category)) {
                $sql .= ' AND p.category_id = :category_id';
                $params[':category_id'] = (int) $category;
            } else {
                $sql .= ' AND c.name = :category_name';
                $params[':category_name'] = $category;
            }
        }

        $sql .= ' ORDER BY p.id DESC LIMIT :limit OFFSET :offset';

        $stmt = Db::connection()->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function getById(int $id): ?array
    {
        $stmt = Db::connection()->prepare(
            'SELECT p.*, c.name AS category_name
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.id = :id
             LIMIT 1'
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $product = $stmt->fetch();

        return $product ?: null;
    }

    public static function getBySlug(string $slug): ?array
    {
        $stmt = Db::connection()->prepare(
            'SELECT p.*, c.name AS category_name
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.slug = :slug
             LIMIT 1'
        );
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();

        $product = $stmt->fetch();

        return $product ?: null;
    }
}
