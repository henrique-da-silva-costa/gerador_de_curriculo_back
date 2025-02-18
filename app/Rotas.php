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

    public function deletar($route, $callback)
    {
        $this->routes["DELETE"][$route] = $callback;
    }

    public function dispatch($requestUri, $requestMethod)
    {
        // Verifica se há rotas para o método de requisição atual
        if (!isset($this->routes[$requestMethod])) {
            http_response_code(405); // Método não permitido
            echo json_encode("Método não permitido");
            return;
        }

        // Itera sobre todas as rotas para o método de requisição atual
        foreach ($this->routes[$requestMethod] as $route => $callback) {
            // Transforma a rota em uma expressão regular
            $routeRegex = preg_replace('/\{(\w+)\}/', '([a-zA-Z0-9-_]+)', $route);
            $routeRegex = str_replace('/', '\/', $routeRegex);
            $routeRegex = "/^" . $routeRegex . "$/";

            // Verifica se a URI corresponde ao padrão da rota
            if (preg_match($routeRegex, $requestUri, $matches)) {
                array_shift($matches); // Remove o primeiro item (a string completa)

                // Se for uma função anônima, passa os parâmetros
                if (is_callable($callback)) {
                    return call_user_func_array($callback, $matches);
                } elseif (is_string($callback)) {
                    return $this->loadControllerWithParams($callback, $matches);
                }
            }
        }

        // Se nenhuma rota foi encontrada, retorna 404
        http_response_code(404);
        echo json_encode("Página não encontrada");
    }

    private function loadControllerWithParams($controller, $params)
    {
        [$class, $method] = explode("@", $controller);
        $class = "App\\Controllers\\$class";

        if (class_exists($class)) {
            $instance = new $class();
            if (method_exists($instance, $method)) {
                return call_user_func_array([$instance, $method], $params);
            }
        }

        http_response_code(500);
        echo json_encode("Erro no controlador");
    }
}
