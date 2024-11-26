<?php
// src/Controller/MedicationController.php

namespace App\Controller;

use App\Controller\DatabaseController;
use Twig\Environment;

class MedicationController {

    private $databaseController;
    private $twig;

    public function __construct(DatabaseController $databaseController, Environment $twig) {
        $this->databaseController = $databaseController;
        $this->twig = $twig;
    }

    // Listar todos los medicamentos
    public function index() {
        try {
            $medications = $this->databaseController->getAllMedications();
            echo $this->twig->render('medications_list.twig', ['medications' => $medications]);
        } catch (\Exception $e) {
            $this->renderError('Error fetching medications list.');
        }
    }

    // Editar medicamento
    public function edit($id) {
        try {
            $medication = $this->databaseController->getMedicationById($id);
            if (!$medication) {
                $this->renderError('Medication not found.');
                return;
            }
            echo $this->twig->render('edit_medication.twig', ['medication' => $medication]);
        } catch (\Exception $e) {
            $this->renderError('Error fetching medication details.');
        }
    }

    // Actualizar medicamento
    public function update($id) {
        try {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            // Simple validation
            if (empty($name) || empty($description)) {
                $this->renderError('Name and description are required.');
                return;
            }

            $this->databaseController->updateMedication($id, $name, $description);

            $this->redirect('/admin/medications');
        } catch (\Exception $e) {
            $this->renderError('Error updating medication.');
        }
    }

    // Eliminar medicamento
    public function delete($id) {
        try {
            $this->databaseController->deleteMedication($id);
            $this->redirect('/admin/medications');
        } catch (\Exception $e) {
            $this->renderError('Error deleting medication.');
        }
    }

    // Método para renderizar vistas usando Twig
    private function renderError($message) {
        echo $this->twig->render('error.twig', ['message' => $message]);
    }

    // Helper method for redirects
    private function redirect($url) {
        header("Location: $url");
        exit();
    }
}
