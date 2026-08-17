<?php

namespace App\Models;

use App\Core\ActiveRecord;

class Reserva extends ActiveRecord
{
    protected static string $tabla = 'Reserva';
    protected static string $primaryKey = 'IDReserva';

    public static function crear(string $clase, string $costo, int $ci, int $idVuelo): bool
    {
        $sql = "INSERT INTO Reserva (Clase, Costo, CI, IDVuelo)
                VALUES (:clase, :costo, :ci, :idVuelo)";

        $stmt = self::db()->prepare($sql);

        return $stmt->execute([
            ':clase' => $clase,
            ':costo' => $costo,
            ':ci' => $ci,
            ':idVuelo' => $idVuelo
        ]);
    }

    public static function reservasDeCliente(int $ci): array
    {
        $sql = "SELECT 
                    r.IDReserva,
                    r.Clase,
                    r.Costo,
                    r.CI,
                    r.IDVuelo,
                    v.FechaHoraS,
                    v.FechaHoraL,
                    v.Matricula
                FROM Reserva r
                INNER JOIN Vuelo v ON r.IDVuelo = v.IDVuelo
                WHERE r.CI = :ci
                ORDER BY r.IDReserva DESC";

        $stmt = self::db()->prepare($sql);
        $stmt->execute([
            ':ci' => $ci
        ]);

        return $stmt->fetchAll();
    }
}