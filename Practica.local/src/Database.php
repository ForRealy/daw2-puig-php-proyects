<?php
// src/Database.php

namespace App;

use PDO;
use PDOException;

class Database {
    private $host = 'localhost';  // o tu host de la base de datos
    private $dbname = 'medicamentdb';  // nombre de tu base de datos
    private $user = 'root';  // tu usuario de la base de datos
    private $password = 'usuario';  // tu contraseña de la base de datos
    private $connection;

    public function connect() {
        try {
            if (!$this->connection) {
                $dsn = "mysql:host=$this->host;dbname=$this->dbname";
                $this->connection = new PDO($dsn, $this->user, $this->password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->connection;
            }
        } catch (PDOException $e) {
            die("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }
}
