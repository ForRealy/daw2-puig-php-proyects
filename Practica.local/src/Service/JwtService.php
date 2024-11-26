<?php
// src/Service/JwtService.php
namespace App\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JwtService {

    private const JWT_SECRET_KEY = 'secreto'; // Your secret key

    public static function generateToken($username) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // JWT valid for 1 hour
        $payload = [
            "iat" => $issuedAt,        // Issued At
            "exp" => $expirationTime,  // Expiration time
            "username" => $username    // User's username
        ];

        // Generate the JWT token using the secret key and the HS256 algorithm
        return JWT::encode($payload, self::JWT_SECRET_KEY, 'HS256'); 
    }

    public static function validateToken($jwt) {
        try {
            // Decode the JWT using the secret key and the HS256 algorithm
            $decoded = JWT::decode($jwt, new Key(self::JWT_SECRET_KEY, 'HS256'));
            return true;  // If successful, the token is valid
        } catch (Exception $e) {
            // Handle decoding failure
            return false;  // If an error occurs, the token is invalid
        }
    }
}
