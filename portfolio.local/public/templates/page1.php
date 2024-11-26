<?php
require_once '.../vendor/autoload.php';
include '../src/controller/DatabaseController.php';
include '../src/controller/ProjectController.php';

$currentFile = basename($_SERVER['PHP_SELF']);
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

// Conexión a la base de datos
$conn = DatabaseController::connect();  // Asegúrate de que esto devuelve el objeto PDO

if ($conn) {
    // Preparar y ejecutar la consulta SQL
    $sql = "SELECT * FROM Project";  // Ejemplo de consulta
    $stmt = $conn->prepare($sql);
    
   
}
