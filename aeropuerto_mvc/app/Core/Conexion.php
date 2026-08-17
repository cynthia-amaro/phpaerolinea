<?php

namespace App\Core;

use PDO;
use PDOException;

class Conexion
{
    private static ?Conexion $instancia = null;
    private PDO $pdo;

    private function __construct()
    {
        require_once __DIR__ . '/../../config/config.php';

        try {
            $this->pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }

    public static function getInstancia(): Conexion
    {
        if (self::$instancia === null) {
            self::$instancia = new Conexion();
        }

        return self::$instancia;
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }
}