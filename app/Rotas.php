<?php

namespace App;

class Rotas
{
    private $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function get($route, $callback)
    {
        $this->routes["GET"][$route] = $callback;
    }

    public function post($route, $callback)
    {
        $this->routes["POST"][$route] = $callback;
    }

    public function delete($route, $callback)
    {
        $this->routes["DELETE"][$route] = $callback;
    }

    public function dispatch($requestUri, $requestMethod)
    {
        $requestUri = parse_url($requestUri, PHP_URL_PATH);

        if (isset($this->routes[$requestMethod][$requestUri])) {
            $callback = $this->routes[$requestMethod][$requestUri];

            if (is_callable($callback)) {
                return call_user_func($callback);
            } elseif (is_string($callback)) {
                $this->loadController($callback);
            }
        }

        http_response_code(404);
        echo "404 - Página não encontrada";
    }

    private function loadController($controller)
    {
        [$class, $method] = explode("@", $controller);
        $class = "App\\Controllers\\$class";

        if (class_exists($class)) {
            $instance = new $class();
            if (method_exists($instance, $method)) {
                return call_user_func([$instance, $method]);
            }
        }

        http_response_code(500);
        echo "Erro no controlador";
    }
}
