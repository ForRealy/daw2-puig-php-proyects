<?php
// src/Controller/AuthController.php

namespace App\Controller;

use App\Service\JwtService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Controller\DatabaseController;

class AuthController {
    private $key = 'secret_key';  // Define your secret key

    private $databaseController;

    public function __construct() {
        $this->databaseController = new DatabaseController();
    }

    // Generate JWT for a given user ID
    public function generateJWT($userId) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // 1 hour
        $payload = [
            'iss' => 'your-issuer',
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'userId' => $userId
        ];

        return JWT::encode($payload, $this->key, 'HS256');
    }

    // Verify JWT
    public function verifyJWT($jwt) {
        try {
            $key = new Key($this->key, 'HS256');
            return JWT::decode($jwt, $key);
        } catch (\Exception $e) {
            return null; // Token is invalid or expired
        }
    }

    // Login function to authenticate a user and return a JWT
    public function login($username, $password) {
        $user = $this->databaseController->getUserByUsernameAndPassword($username, $password);
        if ($user) {
            $jwt = $this->generateJWT($user['id']);
            return ['jwt' => $jwt];
        } else {
            return ['error' => 'Invalid credentials'];
        }
    }

    // Register a new user and return a JWT
    public function register($username, $password) {
        $userId = $this->databaseController->createUser($username, $password);

        if ($userId) {
            $jwt = $this->generateJWT($userId);
            return ['jwt' => $jwt];
        } else {
            return ['error' => 'User registration failed'];
        }
    }

    // Check if a JWT is valid
    public function isAuthenticated($jwt) {
        return $this->verifyJWT($jwt) !== null;
    }

    // Validate JWT from Authorization header
    public function validateAuthorizationHeader() {
        if (!empty($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
            if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                return $matches[1];
            }
        }
        return null; // No valid JWT found in Authorization header
    }
}
