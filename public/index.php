<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Config/app.php';
use Core\Router;
use Config\Database;
// Obtenir la connexion PDO
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$pdo = Database::getConnection();

$router = new Router($pdo);
$router->handleRequest();
?>