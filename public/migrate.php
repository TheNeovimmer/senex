<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';

// Bloquer l'accès depuis le navigateur
if (php_sapi_name() !== 'cli') {
    die("Erreur : Ce script ne peut être exécuté que depuis la ligne de commande.\n");
}

// Vérifier si l'argument est fourni (up ou down)
if ($argc < 2 || !in_array($argv[1], ['up', 'down', 'list'])) {
    die("Usage : php migrate.php [up|down] [nom_de_migration (optionnel)]\n");
}

// Obtenir l'argument (up ou down)
$direction = $argv[1];
$migrationTarget = $argv[2] ?? null; // Nom de la migration spécifique à exécuter en "down"

// Charger les fichiers de migration
$migrations = glob(__DIR__ . '/../migrations/*.php');

// Obtenir la connexion PDO
$pdo = Database::getConnection();

// Vérifier si des migrations existent
if (empty($migrations)) {
    die("Aucune migration trouvée.\n");
}

// Trier les migrations en ordre inverse pour "down"
if ($direction === 'down') {
    rsort($migrations);
}

// Lister les migrations disponibles
if ($direction === 'list') {
    echo "Migrations disponibles :\n";
    foreach ($migrations as $migrationFile) {
        $className = pathinfo($migrationFile, PATHINFO_FILENAME);
        echo "- $className\n";
    }
    exit;
}

try {
    // Début d'une transaction pour rollback en cas d'erreur
    $pdo->beginTransaction();

    foreach ($migrations as $migrationFile) {
        require_once $migrationFile;
    
        // Construire le nom de la classe
        $className = pathinfo($migrationFile, PATHINFO_FILENAME);
        $className = preg_replace('/^\d+_/', '', $className);
        $className = str_replace('_', '', ucwords($className, '_'));
     
        if (!class_exists($className)) {
            throw new Exception("Erreur : La classe $className n'existe pas.");
        }

        // Vérifier si une migration spécifique est demandée en "down"
        if ($direction === 'down' && !is_null($migrationTarget) && $className !== $migrationTarget) {
            continue; // Passe à la migration suivante si elle ne correspond pas
        }
    
        echo "Exécution de la migration $direction : $className\n";
    
        if ($direction === 'up') {
            $className::up($pdo);
        } elseif ($direction === 'down') {
            $className::down($pdo);
        }
    }

    // Valider la transaction si tout s'est bien passé
    $pdo->commit();
    echo "Migration $direction terminée avec succès.\n";

} catch (Exception $e) {
    // Annuler toutes les modifications en cas d'erreur
    $pdo->rollBack();
    echo "Erreur pendant la migration : " . $e->getMessage() . "\n";
}
Réduire




