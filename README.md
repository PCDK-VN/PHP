# K2 GEAR (Unified Admin + Storefront)

This repository is being restructured so the existing admin code and the storefront can run in one PHP project.

## Directory layout

- `admin/` - existing admin dashboard and modules
- `app/` - shared services/models/helpers (`App\\` namespace)
- `api/` - JSON endpoints consumed by storefront code
- `public/` - storefront entrypoint and pages
- `public/assets/` - storefront static assets (placeholder for now)
- `config/` - legacy config compatibility layer
- `linhkienmaytinh.sql` - target DB dump (import before running app)

## Quick start

1. Install dependencies:
   ```bash
   composer install
   ```
2. Configure environment:
   ```bash
   cp .env.example .env
   ```
   Fill DB credentials and `BASE_URL` in `.env`.
3. Import database dump:
   ```bash
   mysql -u root -p linhkienmaytinh < linhkienmaytinh.sql
   ```
4. Run locally:
   - Apache/XAMPP: point document root to project root (or `public/` for storefront routes).
   - PHP built-in server:
     ```bash
     php -S 127.0.0.1:8000 -t .
     ```

## Integration notes

- Shared DB is now centralized in `app/Db.php` (PDO + dotenv).
- Admin can include `admin/_db_include.php` to receive `$pdo` from shared DB service.
- Product APIs available:
  - `GET /api/products.php?limit=20&offset=0&q=keyword&category=...`
  - `GET /api/product.php?id=1` or `GET /api/product.php?slug=...`
- `public/assets/` currently contains a placeholder note; copy client assets from `khangqda/k2gear` in a follow-up merge.
