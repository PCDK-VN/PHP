<?php

declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;
use PDO;

final class Db
{
    private static ?PDO $connection = null;
    private static bool $dotenvLoaded = false;

    public static function connection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        self::loadEnvironment();

        $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $port = $_ENV['DB_PORT'] ?? '3306';
        $db = $_ENV['DB_NAME'] ?? 'linhkienmaytinh';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? '';
        $charset = 'utf8mb4';

        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $host, $port, $db, $charset);
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        self::$connection = new PDO($dsn, $user, $pass, $options);

        return self::$connection;
    }

    private static function loadEnvironment(): void
    {
        if (self::$dotenvLoaded || file_exists(__DIR__ . '/../.env') === false) {
            self::$dotenvLoaded = true;
            return;
        }

        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->safeLoad();
        self::$dotenvLoaded = true;
    }
}
