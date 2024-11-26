<?php

namespace App\Routing;

class Router
{
    private array $routes = [];

    /**
     * Define una ruta.
     */
    public function add(string $method, string $path, callable $callback): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'callback' => $callback,
        ];
    }

    /**
     * Despacha la ruta solicitada.
     */
    public function dispatch(string $requestMethod, string $requestUri): void
{
    foreach ($this->routes as $route) {
        if ($route['method'] === strtoupper($requestMethod) && $route['path'] === $requestUri) {
            call_user_func($route['callback']); // Se llama una sola vez
            return; // Asegúrate de salir después de ejecutar el callback
        }
    }

    // Manejo de error 404
    http_response_code(404);
    echo "404 - Página no encontrada";
}

}
