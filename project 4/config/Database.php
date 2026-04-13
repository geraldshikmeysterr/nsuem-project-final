<?php
class Database {
    private static ?PDO $instance = null;

    private function __construct() {
        // Singleton: direct instantiation is intentionally prevented.
    }

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $config = require_once __DIR__ . '/config.php';
            $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
            self::$instance = new PDO($dsn, $config['user'], $config['pass']);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        return self::$instance;
    }
}
