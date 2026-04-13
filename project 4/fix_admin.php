<?php
$config = require_once __DIR__ . '/config/config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);

$hash = password_hash('admin123', PASSWORD_DEFAULT);
$stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE email = 'admin@blog.ru'");
$stmt->execute([$hash]);

echo "Done. Rows updated: " . $stmt->rowCount() . "<br>";
echo "Delete this file from server after use!";

unlink(__FILE__);
