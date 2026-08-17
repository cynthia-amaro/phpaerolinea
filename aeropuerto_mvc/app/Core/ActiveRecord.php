<?php

namespace App\Core;

use PDO;

abstract class ActiveRecord
{
    protected static string $tabla;
    protected static string $primaryKey;

    protected static function db(): PDO
    {
        return Conexion::getInstancia()->getPDO();
    }

    public static function all(): array
    {
        $sql = "SELECT * FROM " . static::$tabla;
        $stmt = static::db()->query($sql);
        return $stmt->fetchAll();
    }

    public static function find(int|string $id): ?array
    {
        $sql = "SELECT * FROM " . static::$tabla . " WHERE " . static::$primaryKey . " = :id";
        $stmt = static::db()->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $resultado = $stmt->fetch();

        return $resultado ?: null;
    }
}