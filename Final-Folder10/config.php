<?php
// config.php – shared database connection + session

$host = 'localhost';
$db   = 'recipe_site';
$user = 'recipe_app';           // match your MySQL user
$pass = 'StrongPassword123!';   // match your MySQL password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

session_start();
