<?php

// Cargar Librerias
require_once '../vendor/autoload.php';
include '../src/controller/DatabaseController.php';
include '../src/controller/ProjectController.php';

// Iniciar plantilla de twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

// Routing
$request = $_SERVER['REQUEST_URI'];
$viewDir = '/templates/';
switch ($request) {
    case '':
    case '/':
        require __DIR__ . $viewDir . 'home.html';
        break;

    case '/templates/users':
        require __DIR__ . $viewDir . 'users.php';
        break;

    case '/contact':
        require __DIR__ . $viewDir . 'contact.php';
        break;
        
    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}

// Render the Twig template with data
echo $twig->render('home.php', []); // Pass the message to Twig