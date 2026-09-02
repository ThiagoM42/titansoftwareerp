<?php

namespace Config;

class Router
{
    private array $routes = [];

    public function get($route, $callback): void
    {
        $this->routes['GET'][$route] = $callback;
    }

    public function post($route, $callback): void
    {
        $this->routes['POST'][$route] = $callback;
    }

    public function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $basePath = '/titansoftwareerp/public';

        if (str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

        $uri = rtrim($uri, '/');

        if ($uri === '') {
            $uri = '/';
        }

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            echo 'Página não encontrada';
            return;
        }

        $callback = $this->routes[$method][$uri];

        // Controller + método
        if (is_array($callback)) {
            [$controller, $action] = $callback;

            $controller = new $controller();

            $controller->$action();

            return;
        }

        // Funções anônimas
        if (is_callable($callback)) {
            call_user_func($callback);
        }
    }
}
