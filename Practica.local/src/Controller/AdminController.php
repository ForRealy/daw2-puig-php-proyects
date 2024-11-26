<?php
// src/Controller/AdminController.php

namespace App\Controller;

use App\Controller\AuthController;
use App\Controller\DatabaseController;
use Twig\Environment;

class AdminController {
    
    private $authController;
    private $databaseController;
    private $twig;

    public function __construct(AuthController $authController, DatabaseController $databaseController, Environment $twig) {
        $this->authController = $authController;
        $this->databaseController = $databaseController;
        $this->twig = $twig;
    }

    // Página de administración protegida
    public function dashboard() {
        // Extract JWT from headers (or cookies/session as per your app design)
        $jwt = $this->getAuthorizationToken();

        if (!$jwt || !$this->authController->isAuthenticated($jwt)) {
            // Si no está autenticado, redirigir a la página de login o mostrar un error
            header('Location: /login');
            exit();
        }

        try {
            // Obtener los medicamentos desde la base de datos
            $medications = $this->databaseController->getAllMedications();

            // Renderizar la vista del dashboard con los datos obtenidos
            echo $this->twig->render('admin_dashboard.twig', ['medications' => $medications]);
        } catch (\Exception $e) {
            // Manejar errores, como fallos en la base de datos
            echo $this->twig->render('error.twig', ['message' => 'Error loading dashboard data.']);
        }
    }

    // Helper function to retrieve JWT from Authorization header
    private function getAuthorizationToken() {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $authorizationHeader = $headers['Authorization'];
            if (preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
                return $matches[1]; // Return the JWT token
            }
        }
        return null; // No token found
    }
}
