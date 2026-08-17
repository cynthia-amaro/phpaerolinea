<?php

namespace App\Models;

use App\Core\ActiveRecord;

class Vuelo extends ActiveRecord
{
    protected static string $tabla = 'Vuelo';
    protected static string $primaryKey = 'IDVuelo';

    private string $fechaHoraS;
    private string $fechaHoraL;
    private string $matricula;

    public function __construct(string $fechaHoraS, string $fechaHoraL, string $matricula)
    {
        $this->fechaHoraS = $fechaHoraS;
        $this->fechaHoraL = $fechaHoraL;
        $this->matricula = $matricula;
    }

    public function guardar(): bool
    {
        $sql = "INSERT INTO Vuelo (FechaHoraS, FechaHoraL, Matricula)
                VALUES (:fechaHoraS, :fechaHoraL, :matricula)";

        $stmt = self::db()->prepare($sql);

        return $stmt->execute([
            ':fechaHoraS' => $this->fechaHoraS,
            ':fechaHoraL' => $this->fechaHoraL,
            ':matricula' => $this->matricula
        ]);
    }

    public static function actualizar(
        int $idVuelo,
        string $fechaHoraS,
        string $fechaHoraL,
        string $matricula
    ): bool {
        $sql = "UPDATE Vuelo
                SET FechaHoraS = :fechaHoraS,
                    FechaHoraL = :fechaHoraL,
                    Matricula = :matricula
                WHERE IDVuelo = :idVuelo";

        $stmt = self::db()->prepare($sql);

        return $stmt->execute([
            ':idVuelo' => $idVuelo,
            ':fechaHoraS' => $fechaHoraS,
            ':fechaHoraL' => $fechaHoraL,
            ':matricula' => $matricula
        ]);
    }

    public static function eliminar(int $idVuelo): bool
    {
        $sql = "DELETE FROM Vuelo WHERE IDVuelo = :idVuelo";

        $stmt = self::db()->prepare($sql);

        return $stmt->execute([
            ':idVuelo' => $idVuelo
        ]);
    }
}