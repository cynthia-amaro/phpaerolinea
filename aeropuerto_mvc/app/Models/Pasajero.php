<?php

namespace App\Models;

use App\Core\ActiveRecord;

class Pasajero extends ActiveRecord
{
    protected static string $tabla = 'Pasajero';
    protected static string $primaryKey = 'CI';

    public static function allConDatos(): array
    {
        $sql = "SELECT 
                    p.CI,
                    p.Credencial,
                    p.FechaNac,
                    p.Nombre
                FROM Pasajero pa
                INNER JOIN Persona p ON pa.CI = p.CI
                ORDER BY p.Nombre ASC";

        $stmt = self::db()->query($sql);

        return $stmt->fetchAll();
    }

    public static function findConDatos(int $ci): ?array
    {
        $sql = "SELECT 
                    p.CI,
                    p.Credencial,
                    p.FechaNac,
                    p.Nombre
                FROM Pasajero pa
                INNER JOIN Persona p ON pa.CI = p.CI
                WHERE p.CI = :ci";

        $stmt = self::db()->prepare($sql);
        $stmt->execute([
            ':ci' => $ci
        ]);

        $pasajero = $stmt->fetch();

        return $pasajero ?: null;
    }

    public static function crear(
        int $ci,
        string $credencial,
        string $fechaNac,
        string $nombre
    ): bool {
        $pdo = self::db();

        try {
            $pdo->beginTransaction();

            $sqlPersona = "INSERT INTO Persona (CI, Credencial, FechaNac, Nombre)
                           VALUES (:ci, :credencial, :fechaNac, :nombre)";

            $stmt = $pdo->prepare($sqlPersona);
            $stmt->execute([
                ':ci' => $ci,
                ':credencial' => $credencial,
                ':fechaNac' => $fechaNac,
                ':nombre' => $nombre
            ]);

            $sqlPasajero = "INSERT INTO Pasajero (CI)
                            VALUES (:ci)";

            $stmt = $pdo->prepare($sqlPasajero);
            $stmt->execute([
                ':ci' => $ci
            ]);

            $pdo->commit();

            return true;

        } catch (\Exception $e) {
            $pdo->rollBack();

            return false;
        }
    }

    public static function actualizar(
        int $ci,
        string $credencial,
        string $fechaNac,
        string $nombre
    ): bool {
        $sql = "UPDATE Persona
                SET Credencial = :credencial,
                    FechaNac = :fechaNac,
                    Nombre = :nombre
                WHERE CI = :ci";

        $stmt = self::db()->prepare($sql);

        return $stmt->execute([
            ':ci' => $ci,
            ':credencial' => $credencial,
            ':fechaNac' => $fechaNac,
            ':nombre' => $nombre
        ]);
    }

    public static function eliminar(int $ci): bool
    {
        $pdo = self::db();

        try {
            $pdo->beginTransaction();

            $sqlPasajero = "DELETE FROM Pasajero WHERE CI = :ci";
            $stmt = $pdo->prepare($sqlPasajero);
            $stmt->execute([
                ':ci' => $ci
            ]);

            $sqlPersona = "DELETE FROM Persona WHERE CI = :ci";
            $stmt = $pdo->prepare($sqlPersona);
            $stmt->execute([
                ':ci' => $ci
            ]);

            $pdo->commit();

            return true;

        } catch (\Exception $e) {
            $pdo->rollBack();

            return false;
        }
    }
}