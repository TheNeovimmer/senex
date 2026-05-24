<?php


namespace Core;


use Controllers\ErrorController;
require __DIR__ . '/../../Config/app.php';
use PDO;

class Router {
    private array $routes;
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->routes = require __DIR__ . '/../../Config/routes.php';
        $this->pdo = $pdo;
    }

    public function handleRequest() {
        $requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $method = $_SERVER['REQUEST_METHOD'];
        if ($requestUri === '' || $requestUri === 'index.php') {
            $requestUri = 'home';
        }
        if (str_starts_with($requestUri, 'blog/')) {
                foreach ($this->routes as $route => $config) {
                    if ($config['method'] !== $method) continue;
                    $pattern = preg_replace('#:([\w]+)#', '(?P<$1>[^/]+)', $route);
                    $pattern = '#^' . $pattern . '$#';
                    if (preg_match($pattern, $requestUri, $matches)) {
                        $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                        [$controllerClass, $controllerMethod] = $config['controller'];
                        $controller = new $controllerClass($this->pdo);
                        echo call_user_func_array([$controller, $controllerMethod], $params);
                        return;
                    }
                }
            }
        
        // Vérifier si la route existe avec .post pour les requêtes POST
        if ($method === 'POST' && isset($this->routes[$requestUri . '.post'])) {
            $routeKey = $requestUri . '.post';
        } else {
            $routeKey = $requestUri;
        }
    

    
        if (isset($this->routes[$routeKey])) {
            $route = $this->routes[$routeKey];
    
            if ($route['method'] === $method) {
                [$controllerClass, $controllerMethod] = $route['controller'];
    
                if (!class_exists($controllerClass)) {
                    throw new \Exception("Le contrôleur $controllerClass n'existe pas.", 500);
                }
    
                $controller = new $controllerClass($this->pdo);
                echo $controller->$controllerMethod();
            } else {
                throw new \Exception("Méthode HTTP non autorisée.", 405);
            }
        } else {
            $this->handle404();
        }
    }
    

    private function handle404() {
        $errorController = new ErrorController();
        echo $errorController->show404();
    }

    private function handle500($message) {
        $errorController = new ErrorController();
        echo $errorController->show500($message);
    }
    private function logError($message) {
        $logFile = __DIR__ . '/../../logs/error.log';
        $date = date('Y-m-d H:i:s');
        $formattedMessage = "[$date] ERROR: $message" . PHP_EOL;
    
        // Vérifier si le fichier est accessible
        if (!file_exists($logFile)) {
            file_put_contents($logFile, "[$date] Fichier de log créé." . PHP_EOL);
        }
        
        if (!is_writable($logFile)) {
            die("Erreur : Impossible d'écrire dans error.log. Vérifie les permissions.");
        }
    
        file_put_contents($logFile, $formattedMessage, FILE_APPEND);
    }
}