-- ============================================================
-- K2 GEAR – database bootstrap
-- Chạy file này trong phpMyAdmin (tab SQL) sau khi tạo database
-- ============================================================

CREATE DATABASE IF NOT EXISTS `linhkienmaytinh`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `linhkienmaytinh`;

-- ------------------------------------------------------------
-- Bảng danh mục sản phẩm
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `categories` (
    `id`         INT            NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(255)   NOT NULL,
    `created_at` TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Bảng sản phẩm
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `products` (
    `id`          INT            NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(255)   NOT NULL,
    `slug`        VARCHAR(255)   NOT NULL,
    `thumbnail`   VARCHAR(500)   DEFAULT NULL,
    `price`       DECIMAL(15,2)  NOT NULL DEFAULT 0,
    `sale_price`  DECIMAL(15,2)  DEFAULT NULL,
    `stock`       INT            NOT NULL DEFAULT 0,
    `status`      TINYINT        NOT NULL DEFAULT 1,
    `category_id` INT            DEFAULT NULL,
    `description` TEXT           DEFAULT NULL,
    `created_at`  TIMESTAMP      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_products_slug` (`slug`),
    CONSTRAINT `fk_products_category`
        FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Dữ liệu mẫu – danh mục
-- ------------------------------------------------------------
INSERT INTO `categories` (`name`) VALUES
    ('CPU'),
    ('RAM'),
    ('GPU'),
    ('SSD'),
    ('Mainboard'),
    ('Tản nhiệt');

-- ------------------------------------------------------------
-- Dữ liệu mẫu – sản phẩm
-- ------------------------------------------------------------
INSERT INTO `products` (`name`, `slug`, `price`, `sale_price`, `stock`, `status`, `category_id`, `description`) VALUES
    ('Intel Core i5-12400F', 'intel-core-i5-12400f', 3500000, 3200000, 50, 1, 1, 'CPU Intel thế hệ 12, 6 nhân 12 luồng, không tích hợp GPU.'),
    ('Intel Core i7-12700K', 'intel-core-i7-12700k', 7200000, 6900000, 30, 1, 1, 'CPU Intel thế hệ 12, 12 nhân 20 luồng, hiệu năng cao.'),
    ('AMD Ryzen 5 5600X', 'amd-ryzen-5-5600x', 4200000, 3900000, 40, 1, 1, 'CPU AMD Zen 3, 6 nhân 12 luồng, chơi game cực mạnh.'),
    ('Kingston Fury 8GB DDR4-3200', 'kingston-fury-8gb-ddr4-3200', 800000, NULL, 100, 1, 2, 'RAM DDR4 3200MHz, tản nhiệt nhôm, tương thích rộng.'),
    ('Kingston Fury 16GB DDR4-3200', 'kingston-fury-16gb-ddr4-3200', 1500000, 1400000, 80, 1, 2, 'RAM DDR4 16GB kit (2x8GB), tốc độ 3200MHz.'),
    ('NVIDIA GeForce RTX 3060 12GB', 'nvidia-rtx-3060-12gb', 9500000, 8900000, 20, 1, 3, 'Card đồ họa NVIDIA Ampere, 12GB GDDR6, hỗ trợ ray-tracing.'),
    ('NVIDIA GeForce RTX 4070', 'nvidia-rtx-4070', 18000000, 17500000, 10, 1, 3, 'Card đồ họa NVIDIA Ada Lovelace, 12GB GDDR6X, DLSS 3.'),
    ('Samsung 980 Pro 500GB NVMe', 'samsung-980-pro-500gb', 1200000, 1100000, 75, 1, 4, 'SSD NVMe PCIe 4.0, đọc 6900MB/s, ghi 5000MB/s.'),
    ('WD Black SN850X 1TB NVMe', 'wd-black-sn850x-1tb', 2500000, 2300000, 60, 1, 4, 'SSD NVMe PCIe 4.0, đọc 7300MB/s, dành cho game thủ.'),
    ('ASUS ROG STRIX B660-F', 'asus-rog-strix-b660-f', 5500000, 5200000, 25, 1, 5, 'Mainboard Intel B660, DDR5, PCIe 5.0, WiFi 6E.'),
    ('Noctua NH-D15', 'noctua-nh-d15', 1800000, NULL, 35, 1, 6, 'Tản nhiệt khí cao cấp, 2 quạt 140mm, TDP 250W.');
