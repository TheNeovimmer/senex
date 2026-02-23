<?php
class Database {
 private static $pdo;
 public static function getConnection() {
 if (!self::$pdo) {
 $host = getenv('DB_HOST');
 $dbname = getenv('DB_NAME');
 $user = getenv('DB_USER');
 $password = getenv('DB_PASSWORD');
 $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
 self::$pdo = new PDO($dsn, $user, $password);
 self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }
 return self::$pdo;
 }
} 
 
