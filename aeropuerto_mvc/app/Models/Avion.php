<?php

namespace App\Models;

use App\Core\ActiveRecord;

class Avion extends ActiveRecord
{
    protected static string $tabla = 'Avion';
    protected static string $primaryKey = 'Matricula';

    private string $matricula;
    private string $fabricante;
    private int $asientos;
    private int $carga;
    private string $modelo;

    public function __construct(
        string $matricula,
        string $fabricante,
        int $asientos,
        int $carga,
        string $modelo
    ) {
        $this->matricula = $matricula;
        $this->fabricante = $fabricante;
        $this->asientos = $asientos;
        $this->carga = $carga;
        $this->modelo = $modelo;
    }

    public function guardar(): bool
    {
        $sql = "INSERT INTO Avion (Matricula, Fabricante, Asientos, Carga, Modelo)
                VALUES (:matricula, :fabricante, :asientos, :carga, :modelo)";

        $stmt = self::db()->prepare($sql);

        return $stmt->execute([
            ':matricula' => $this->matricula,
            ':fabricante' => $this->fabricante,
            ':asientos' => $this->asientos,
            ':carga' => $this->carga,
            ':modelo' => $this->modelo
        ]);
    }

    public static function actualizar(
        string $matricula,
        string $fabricante,
        int $asientos,
        int $carga,
        string $modelo
    ): bool {
        $sql = "UPDATE Avion
                SET Fabricante = :fabricante,
                    Asientos = :asientos,
                    Carga = :carga,
                    Modelo = :modelo
                WHERE Matricula = :matricula";

        $stmt = self::db()->prepare($sql);

        return $stmt->execute([
            ':matricula' => $matricula,
            ':fabricante' => $fabricante,
            ':asientos' => $asientos,
            ':carga' => $carga,
            ':modelo' => $modelo
        ]);
    }

    public static function eliminar(string $matricula): bool
    {
        $sql = "DELETE FROM Avion WHERE Matricula = :matricula";

        $stmt = self::db()->prepare($sql);

        return $stmt->execute([
            ':matricula' => $matricula
        ]);
    }
}