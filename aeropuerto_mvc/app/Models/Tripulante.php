<?php

namespace App\Models;

use App\Core\ActiveRecord;

class Tripulante extends ActiveRecord
{
    protected static string $tabla = 'Tripulante';
    protected static string $primaryKey = 'CI';

    public static function allConDatos(): array
    {
        $sql = "SELECT 
                    p.CI,
                    p.Credencial,
                    p.FechaNac,
                    p.Nombre,
                    t.Cargo
                FROM Tripulante t
                INNER JOIN Persona p ON t.CI = p.CI
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
                    p.Nombre,
                    t.Cargo
                FROM Tripulante t
                INNER JOIN Persona p ON t.CI = p.CI
                WHERE p.CI = :ci";

        $stmt = self::db()->prepare($sql);
        $stmt->execute([
            ':ci' => $ci
        ]);

        $tripulante = $stmt->fetch();

        return $tripulante ?: null;
    }

    public static function crear(
        int $ci,
        string $credencial,
        string $fechaNac,
        string $nombre,
        string $cargo
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

            $sqlTripulante = "INSERT INTO Tripulante (CI, Cargo)
                              VALUES (:ci, :cargo)";

            $stmt = $pdo->prepare($sqlTripulante);
            $stmt->execute([
                ':ci' => $ci,
                ':cargo' => $cargo
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
        string $nombre,
        string $cargo
    ): bool {
        $pdo = self::db();

        try {
            $pdo->beginTransaction();

            $sqlPersona = "UPDATE Persona
                           SET Credencial = :credencial,
                               FechaNac = :fechaNac,
                               Nombre = :nombre
                           WHERE CI = :ci";

            $stmt = $pdo->prepare($sqlPersona);
            $stmt->execute([
                ':ci' => $ci,
                ':credencial' => $credencial,
                ':fechaNac' => $fechaNac,
                ':nombre' => $nombre
            ]);

            $sqlTripulante = "UPDATE Tripulante
                              SET Cargo = :cargo
                              WHERE CI = :ci";

            $stmt = $pdo->prepare($sqlTripulante);
            $stmt->execute([
                ':ci' => $ci,
                ':cargo' => $cargo
            ]);

            $pdo->commit();

            return true;

        } catch (\Exception $e) {
            $pdo->rollBack();

            return false;
        }
    }

    public static function eliminar(int $ci): bool
    {
        $pdo = self::db();

        try {
            $pdo->beginTransaction();

            $sqlTripulante = "DELETE FROM Tripulante WHERE CI = :ci";
            $stmt = $pdo->prepare($sqlTripulante);
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