<?php
// public/index.php
require_once __DIR__ . '/../vendor/autoload.php'; 
use AltoRouter;

// Crear instancia de AltoRouter
$router = new AltoRouter();

// Definir las rutas
$router->map('GET', '/', 'HomeController#index', 'home');
$router->map('GET', '/admin', 'AdminController#index', 'admin');
$router->map('POST', '/login', 'AuthController#login', 'login');

// Comprobar si la ruta coincide
$match = $router->match();

// Ejecutar la función correspondiente si la ruta existe
if ($match) {
    list($controller, $method) = explode('#', $match['target']);
    $controller = 'App\\Controller\\' . $controller;
    $controller = new $controller();
    $controller->$method($match['params']);
} else {
    echo "404 - Página no encontrada";  // Si no hay coincidencia con ninguna ruta
}
