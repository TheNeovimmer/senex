<?php
namespace Core;
use Controllers\ErrorController;
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

        // Map POST /action to action.post route
        if ($method === 'POST' && isset($this->routes[$requestUri . '.post'])) {
            $requestUri = $requestUri . '.post';
        }

        $matchedRoute = null;
        $params = [];

        foreach ($this->routes as $route => $config) {
            if (!isset($config['method'])) continue;
            $routeMethods = (array)$config['method'];
            if (!in_array($method, $routeMethods)) continue;

            $pattern = preg_replace('#:([\w]+)#', '(?P<$1>[^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $requestUri, $matches)) {
                $matchedRoute = $config;
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                break;
            }
        }

        if (!$matchedRoute) {
            $this->handle404();
            return;
        }

        if (isset($matchedRoute['middleware'])) {
            $middlewares = (array)$matchedRoute['middleware'];
            foreach ($middlewares as $middleware) {
                $result = $this->executeMiddleware($middleware, $params);
                if ($result === false) {
                    return;
                }
            }
        }

        [$controllerClass, $controllerMethod] = $matchedRoute['controller'];
        if (!class_exists($controllerClass)) {
            throw new \Exception("Le contrôleur $controllerClass n'existe pas.", 500);
        }

        $controller = new $controllerClass($this->pdo);
        echo call_user_func_array([$controller, $controllerMethod], $params);
    }

    private function executeMiddleware($middleware, array $params) {
        if (is_string($middleware)) {
            if ($middleware === 'auth' && !$this->isAuth()) {
                $_SESSION['redirect_after'] = $_SERVER['REQUEST_URI'];
                header('Location: /login');
                return false;
            }
            if ($middleware === 'guest' && $this->isAuth()) {
                header('Location: /dashboard');
                return false;
            }
            if (str_starts_with($middleware, 'role:')) {
                if (!$this->isAuth()) {
                    $_SESSION['redirect_after'] = $_SERVER['REQUEST_URI'];
                    header('Location: /login');
                    return false;
                }
                $roles = explode(',', substr($middleware, 5));
                if (!in_array($_SESSION['role'] ?? '', $roles)) {
                    header('Location: /dashboard');
                    return false;
                }
            }
        }
        return true;
    }

    private function isAuth(): bool {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    private function handle404() {
        $errorController = new ErrorController();
        echo $errorController->show404();
    }
}
