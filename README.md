# K2 GEAR (Unified Admin + Storefront)

This repository is being restructured so the existing admin code and the storefront can run in one PHP project.

## Directory layout

- `admin/` - existing admin dashboard and modules
- `app/` - shared services/models/helpers (`App\\` namespace)
- `api/` - JSON endpoints consumed by storefront code
- `public/` - storefront entrypoint and pages
- `public/assets/` - storefront static assets (placeholder for now)
- `config/` - legacy config compatibility layer
- `database/linhkienmaytinh.sql` - DB schema + seed data (import trước khi chạy app)

## Quick start

1. Install dependencies:
   ```bash
   composer install
   ```
2. Configure environment:
   ```bash
   cp .env.example .env
   ```
   Sửa `.env` theo thông tin database của bạn (xem hướng dẫn bên dưới).

3. **Tạo database và import schema** (chọn một trong hai cách):

   **Cách A – phpMyAdmin (XAMPP):**
   1. Mở `http://localhost/phpmyadmin`
   2. Click **New** → đặt tên `linhkienmaytinh` → **Create**
   3. Chọn database `linhkienmaytinh` vừa tạo → tab **Import**
   4. Chọn file `database/linhkienmaytinh.sql` → **Go**

   **Cách B – command line:**
   ```bash
   mysql -u root linhkienmaytinh < database/linhkienmaytinh.sql
   ```

4. Cấu hình file `.env`:
   ```
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_NAME=linhkienmaytinh
   DB_USER=root
   DB_PASS=
   BASE_URL=http://localhost/PHP-copilot-restructure-pcdk-vn-repo/public
   APP_ENV=local
   ```
   > **Lưu ý:** `DB_PASS` để trống nếu XAMPP không đặt mật khẩu MySQL.  
   > `BASE_URL` là đường dẫn tới thư mục `public/` trên máy bạn.

5. Truy cập trang web:
   - XAMPP: `http://localhost/PHP-copilot-restructure-pcdk-vn-repo/public/`
   - PHP built-in server:
     ```bash
     php -S 127.0.0.1:8000 public/index.php
     ```
     Sau đó mở `http://127.0.0.1:8000/`

## Integration notes

- Shared DB is now centralized in `app/Db.php` (PDO + dotenv).
- Admin can include `admin/_db_include.php` to receive `$pdo` from shared DB service.
- Product APIs available:
  - `GET /api/products.php?limit=20&offset=0&q=keyword&category=...`
  - `GET /api/product.php?id=1` or `GET /api/product.php?slug=...`
- `public/assets/` currently contains a placeholder note; copy client assets from `khangqda/k2gear` in a follow-up merge.
