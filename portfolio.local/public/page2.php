<?php
require_once '../vendor/autoload.php';
include '../src/controller/DatabaseController.php';
include '../src/controller/ProjectController.php';

$currentFile = basename($_SERVER['PHP_SELF']);
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

// Folder path where your images are stored
$imageFolder = './assets/img/';

// Function to map technology names to image file paths
function getImagePathForTechnology($techName, $imageFolder) {
    // Generate a sanitized filename based on the technology name
    $sanitizedTechName = strtolower(str_replace(' ', '-', $techName));  // Example: "HTML" becomes "html"
    $imagePath = $imageFolder . $sanitizedTechName . '.png';  // Assuming all images are .png

    // Check if the image file exists in the folder
    if (file_exists($imagePath)) {
        return $imagePath;
    } else {
        return $imageFolder . 'default.png';  // Default image if the file doesn't exist
    }
}

// Establish the database connection
$conn = DatabaseController::connect();

$navItems = [
    ['name' => 'Sobre Mí', 'link' => 'index.php', 'active' => $currentFile == 'index.php', 'disabled' => false],
    ['name' => 'Proyectos', 'link' => 'page1.php', 'active' => $currentFile == 'page1.php', 'disabled' => false],
    ['name' => 'Tecnologías', 'link' => 'page2.php', 'active' => $currentFile == 'page2.php', 'disabled' => false],
];

// Initialize an empty array for technologies
$technologies = [];

if ($conn) {
    // Query to fetch technologies from the database
    $sql = "SELECT name, description FROM Technology";  // Adjust the table name and columns based on your DB schema
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute();
        $technologiesFromDb = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Fetch the results as associative arrays

        // Loop through the fetched data and populate the $technologies array
        foreach ($technologiesFromDb as $tech) {
            $technologies[] = [
                'name' => $tech['name'],
                'description' => $tech['description'] ?? '',  // Use the description if it exists, otherwise set as an empty string
                'image' => getImagePathForTechnology($tech['name'], $imageFolder)  // Dynamically get image path based on the name
            ];
        }
    } catch (PDOException $e) {
        error_log("Error executing query: " . $e->getMessage());  // Log error for debugging
        echo "An error occurred while fetching technologies.";
    }

    // Optionally close the connection
    $conn = null;
} else {
    echo "Failed to connect to the database.";
}

// Render the Twig template with navigation items and technologies
echo $twig->render('page2.html', [
    'navItems' => $navItems,
    'technologies' => $technologies,  // Pass the technologies fetched from the DB
]);
