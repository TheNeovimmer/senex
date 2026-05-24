<?php

namespace Controllers;

class ErrorController
{
    public function show404()
    {
        http_response_code(404);
        $file = __DIR__ . '/../../templates/404.php';

        if (file_exists($file)) {
            include $file;
        } else {
            echo "Erreur 404 : Page non trouvée.";
        }
        exit; // Arrêter l'exécution après affichage de l'erreur
    }

    public function show500($message = null)
    {
        http_response_code(500);
        $file = __DIR__ . '/../../templates/500.php';
        $this->logError("Erreur 500 : " . $message);
        if (file_exists($file)) {
            include $file;
        } else {
            echo "Erreur 500 : Erreur interne du serveur.<br>";
            echo "Message : " . htmlspecialchars($message);
        }
        exit; // Arrêter l'exécution après affichage de l'erreur
    }
    private function logError($message) {
        $logFile = __DIR__ . '/../../logs/error.log';
        $date = date('Y-m-d H:i:s');
        $formattedMessage = "[$date] ERROR: $message" . PHP_EOL;
    
        // Vérifier si le fichier existe, sinon le créer
        if (!file_exists($logFile)) {
            file_put_contents($logFile, "[$date] Fichier de log créé." . PHP_EOL);
        }
    
        // Vérifier si le fichier est accessible en écriture
        if (!is_writable($logFile)) {
            die("Erreur : Impossible d'écrire dans logs/error.log !");
        }
    
        file_put_contents($logFile, $formattedMessage, FILE_APPEND);
    }
    
}
