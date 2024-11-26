<?php
// src/Controller/DatabaseController.php

namespace App\Controller;

use PDO;

class DatabaseController {
    
    private $pdo;

    // Constructor: Initialize the database connection
    public function __construct() {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=practica', 'root', 'password');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die('Database connection error: ' . $e->getMessage());
        }
    }

    // --- User-related methods (as defined earlier) ---

    // Method to retrieve all medications
    public function getAllMedications() {
        $sql = 'SELECT * FROM medications'; // Adjust table name as needed
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to retrieve a specific medication by ID
    public function getMedicationById($id) {
        $sql = 'SELECT * FROM medications WHERE id = :id LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to update a medication
    public function updateMedication($id, $name, $description) {
        $sql = 'UPDATE medications SET name = :name, description = :description WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':name' => $name, ':description' => $description, ':id' => $id]);
        return $stmt->rowCount(); // Number of rows updated
    }

    // Method to delete a medication
    public function deleteMedication($id) {
        $sql = 'DELETE FROM medications WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount(); // Number of rows deleted
    }

    // Method to create a new medication (optional)
    public function createMedication($name, $description) {
        $sql = 'INSERT INTO medications (name, description) VALUES (:name, :description)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':name' => $name, ':description' => $description]);
        return $this->pdo->lastInsertId(); // ID of the newly inserted medication
    }
}
