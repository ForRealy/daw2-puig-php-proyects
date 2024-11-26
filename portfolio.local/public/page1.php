<?php
require_once '../vendor/autoload.php';
include '../src/controller/DatabaseController.php';
include '../src/controller/ProjectController.php';

$currentFile = basename($_SERVER['PHP_SELF']);
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

// Establish the database connection
$conn = DatabaseController::connect();

if ($conn) {
    $sql = "SELECT * FROM Project";  // Adjust this query as needed
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute();
        $projectsFromDb = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error executing query: " . $e->getMessage());  // Log error in production
        echo "An error occurred while fetching the projects.";
        $projectsFromDb = [];  // Default to empty array on error
    }

    // Optionally close the connection
    $conn = null;
} else {
    echo "Failed to connect to the database.";
    $projectsFromDb = [];  // Default to empty array if connection failed
}

// Navigation Items
$navItems = [
    ['name' => 'Sobre Mí', 'link' => 'index.php', 'active' => $currentFile == 'index.php', 'disabled' => false],
    ['name' => 'Proyectos', 'link' => 'page1.php', 'active' => $currentFile == 'page1.php', 'disabled' => false],
    ['name' => 'Tecnologías', 'link' => 'page2.php', 'active' => $currentFile == 'page2.php', 'disabled' => false],
];

// Static Projects (in case database fails)
$projects = [
    [
        'name' => '',
        'description' => '',
        'link' => 'https://github.com/ForRealy/DAW2-Puig/tree/main/FirstTwig',  
        'image' => './assets/img/twig-logo-300x155.png',
    ],
    [
        'name' => '',
        'description' => '',
        'link' => 'https://github.com/ForRealy/TokyoNightV2',
        'image' => './assets/img/preview.png',
    ],
];

// If projects from DB exist, merge them with static projects
foreach ($projects as $index => &$project) {
    if (isset($projectsFromDb[$index])) {
        $project['name'] = $projectsFromDb[$index]['name'];  // Override name with DB data
        $project['description'] = $projectsFromDb[$index]['description'];  // Override description with DB data
    }
}

// Render the Twig template with data
echo $twig->render('page1.html', [
    'navItems' => $navItems,
    'projects' => $projects,
]);
