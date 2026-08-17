<?php

namespace App\Models;

use App\Core\ActiveRecord;

class Persona extends ActiveRecord
{
    protected static string $tabla = 'Persona';
    protected static string $primaryKey = 'CI';

    private int $ci;
    private string $credencial;
    private string $fechaNac;
    private string $nombre;

    public function __construct(int $ci, string $credencial, string $fechaNac, string $nombre)
    {
        $this->ci = $ci;
        $this->credencial = $credencial;
        $this->fechaNac = $fechaNac;
        $this->nombre = $nombre;
    }

    public static function buscarParaLogin(int $ci, string $credencial): ?array
    {
        $sql = "SELECT * FROM Persona 
                WHERE CI = :ci AND Credencial = :credencial";

        $stmt = self::db()->prepare($sql);

        $stmt->execute([
            ':ci' => $ci,
            ':credencial' => $credencial
        ]);

        $persona = $stmt->fetch();

        return $persona ?: null;
    }

    public function guardarComoPasajero(): bool
    {
        $pdo = self::db();

        try {
            $pdo->beginTransaction();

            $sqlPersona = "INSERT INTO Persona (CI, Credencial, FechaNac, Nombre)
                           VALUES (:ci, :credencial, :fechaNac, :nombre)";

            $stmt = $pdo->prepare($sqlPersona);

            $stmt->execute([
                ':ci' => $this->ci,
                ':credencial' => $this->credencial,
                ':fechaNac' => $this->fechaNac,
                ':nombre' => $this->nombre
            ]);

            $sqlPasajero = "INSERT INTO Pasajero (CI)
                            VALUES (:ci)";

            $stmt = $pdo->prepare($sqlPasajero);
            $stmt->execute([
                ':ci' => $this->ci
            ]);

            $pdo->commit();

            return true;

        } catch (\Exception $e) {
            $pdo->rollBack();

            return false;
        }
    }
}