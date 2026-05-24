<?php
namespace Config;
use Dotenv\Dotenv;
use PDO;
use PDOException;
class Database {
private static $pdo;

public static function getConnection() {
if (!self::$pdo) {
// Charger les variables d'environnement
$dotenv = Dotenv::createImmutable(dirname(__DIR__)); 
// Pointer vers la racine
$dotenv->load();



// Test des variabes

$host = $_ENV['DB_HOST'] ?? null;
$dbname = $_ENV['DB_NAME'] ?? null;
$user = $_ENV['DB_USER'] ?? null;
$password = $_ENV['DB_PASSWORD'] ?? null;

// Vérifier les variables chargées
if (!$host || !$dbname || !$user) {
die("Erreur : Les variables d'environnement ne sont pas correctement chargées.");
}

try {
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
self::$pdo = new PDO($dsn, $user, $password);
self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
die("Erreur de connexion : " . $e->getMessage());
}
}
return self::$pdo;
}
}