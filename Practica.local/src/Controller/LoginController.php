<?php
// src/Controller/LoginController.php

namespace App\Controller;

use App\Controller\AuthController;

class LoginController {
    
    private $authController;

    public function __construct() {
        $this->authController = new AuthController();
    }

    // Mostrar el formulario de login
    public function showLoginForm() {
        echo $this->render('login.twig');
    }

    // Procesar el formulario de login
    public function login() {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $result = $this->authController->login($username, $password);
            if ($result['status'] === 'success') {
                // Redirigir al panel de administración
                header('Location: /admin/dashboard');
            } else {
                // Mostrar error en caso de que las credenciales sean incorrectas
                echo $this->render('login.twig', ['error' => 'Credenciales incorrectas']);
            }
        }
    }

    // Método para renderizar la vista usando Twig
    private function render($template, $data = []) {
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);
        return $twig->render($template, $data);
    }
}
