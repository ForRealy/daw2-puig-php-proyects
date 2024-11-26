<?php

require_once '../vendor/autoload.php';
include '../src/controller/DatabaseController.php';

// Function to validate the one-use link token
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
                // Check if the token has been used
                if ($link['is_used'] == 0) {
                    // Mark the token as used
                    $updateSql = "UPDATE one_use_links SET is_used = 1 WHERE token = :token";
                    $updateStmt = $conn->prepare($updateSql);
                    $updateStmt->bindParam(':token', $token);
                    $updateStmt->execute();

                    return $link;  // Return the token data for further processing
                } else {
                    return null;  // Token has already been used
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

// Check if a token is provided in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $linkData = validateOneUseLink($token);

    if ($linkData) {
        // Token is valid and has not been used, proceed with the action
        echo "Token is valid! You can proceed with your action.";
        // Here you can place your business logic, like downloading a file or granting access
    } else {
        // Token is either invalid or has already been used
        echo "This link has already been used or is invalid.";
    }
} else {
    echo "No token provided.";
}
