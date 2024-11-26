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
    
        case '/validate.php': // Route for the one-use link validation
            if (isset($_GET['token'])) {
                $token = $_GET['token'];
                $linkData = validateOneUseLink($token);
    
                if ($linkData) {
                    // Token is valid
                    echo "Token is valid! You can proceed with your action.";
                    // Business logic goes here (e.g., downloading a file)
                } else {
                    // Token is invalid or has been used
                    echo "This link has already been used or is invalid.";
                }
            } else {
                echo "No token provided.";
            }
            break;
        
    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_link'])) {
    $userId = 1;  // Replace with the actual user ID (e.g., from session data)
    
    // Generate the one-use token and return the link
    $token = createOneUseLink($userId);
    if ($token) {
        // Include the token in the one-use link
        $oneUseLink = "https://www.google.es/"; // Adjust your domain
        $message = "<a href=\"$oneUseLink\" target=\"_blank\">Aqui esta tu link</a>";
        var_dump($message);
    } else {
        $message = "Failed to generate a one-use link.";
    }
} else {
    $message = "";  // Default message when the form is not submitted
}

// Function to generate and store the one-use token
function createOneUseLink($userId)
{
    $token = bin2hex(random_bytes(16));  // Generate a secure token
    $expiryDate = date('Y-m-d H:i:s');  // Current time as expiry (for one-use, can keep null)

    // Insert the token into the database
    $conn = DatabaseController::connect();
    if ($conn) {
        $sql = "INSERT INTO one_use_links (token, user_id, expiry_date, is_used) VALUES (:token, :user_id, :expiry_date, 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':expiry_date', $expiryDate);

        try {
            $stmt->execute();
            return $token;  // Return the token for the link
        } catch (PDOException $e) {
            error_log("Error creating one-use token: " . $e->getMessage());
            return null;
        }
    }
    return null;
}

// Function to validate a one-use link token (you can include this as well)
function validateOneUseLink($token)
{
    $conn = DatabaseController::connect();
    if ($conn) {
        $sql = "SELECT * FROM one_use_links WHERE token = :token";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':token', $token);

        try {
            $stmt->execute();
            $link = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($link) {
                // Check if the link has been used less than a certain limit
                if ($link['is_used'] < 1) {  // Change this condition as needed for your use case
                    // Increment the token usage count
                    $updateSql = "UPDATE one_use_links SET is_used = is_used + 1 WHERE token = :token";
                    $updateStmt = $conn->prepare($updateSql);
                    $updateStmt->bindParam(':token', $token);
                    $updateStmt->execute();

                    return $link;  // Return the token data for further processing
                } else {
                    return null;  // Token has been used the maximum number of times
                }
            } else {
                return null;  // Invalid token
            }
        } catch (PDOException $e) {
            error_log("Error validating token: " . $e->getMessage());
            return null;
        }
    }

    return null;
}

// Render the Twig template with data
echo $twig->render('home.php', ['message' => $message]); // Pass the message to Twig