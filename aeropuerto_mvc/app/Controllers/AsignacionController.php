<?php

namespace App\Controllers;

use App\Models\Vuelo;
use App\Models\Tripulante;

class AsignacionController
{
    public function index(): void
    {
        $asignaciones = $_SESSION['asignaciones_tripulantes'] ?? [];

        require_once __DIR__ . '/../Views/asignaciones/index.php';
    }

    public function crear(): void
    {
        $vuelos = Vuelo::all();
        $tripulantes = Tripulante::allConDatos();

        require_once __DIR__ . '/../Views/asignaciones/crear.php';
    }

    public function guardar(): void
    {
        $idVuelo = (int) ($_POST['id_vuelo'] ?? 0);
        $ciTripulante = (int) ($_POST['ci_tripulante'] ?? 0);

        if ($idVuelo <= 0 || $ciTripulante <= 0) {
            $_SESSION['error'] = 'Debe seleccionar un vuelo y un tripulante.';

            header('Location: ' . BASE_URL . '/asignaciones/crear');
            exit;
        }

        $vuelo = Vuelo::find($idVuelo);
        $tripulante = Tripulante::findConDatos($ciTripulante);

        if (!$vuelo || !$tripulante) {
            $_SESSION['error'] = 'El vuelo o el tripulante no existen.';

            header('Location: ' . BASE_URL . '/asignaciones/crear');
            exit;
        }

        $_SESSION['asignaciones_tripulantes'] ??= [];

        foreach ($_SESSION['asignaciones_tripulantes'] as $asignacion) {
            if (
                $asignacion['id_vuelo'] === $idVuelo &&
                $asignacion['ci_tripulante'] === $ciTripulante
            ) {
                $_SESSION['error'] = 'Ese tripulante ya está asignado a ese vuelo.';

                header('Location: ' . BASE_URL . '/asignaciones');
                exit;
            }
        }

        $_SESSION['asignaciones_tripulantes'][] = [
            'id_vuelo' => $idVuelo,
            'ci_tripulante' => $ciTripulante,
            'nombre_tripulante' => $tripulante['Nombre'],
            'cargo' => $tripulante['Cargo'],
            'fecha_salida' => $vuelo['FechaHoraS'],
            'fecha_llegada' => $vuelo['FechaHoraL'],
            'matricula' => $vuelo['Matricula']
        ];

        $_SESSION['mensaje'] = 'Tripulante asignado correctamente al vuelo.';

        header('Location: ' . BASE_URL . '/asignaciones');
        exit;
    }

    public function eliminar(): void
    {
        $indice = (int) ($_POST['indice'] ?? -1);

        if ($indice < 0 || !isset($_SESSION['asignaciones_tripulantes'][$indice])) {
            $_SESSION['error'] = 'Asignación inválida.';

            header('Location: ' . BASE_URL . '/asignaciones');
            exit;
        }

        unset($_SESSION['asignaciones_tripulantes'][$indice]);

        $_SESSION['asignaciones_tripulantes'] = array_values($_SESSION['asignaciones_tripulantes']);

        $_SESSION['mensaje'] = 'Asignación eliminada correctamente.';

        header('Location: ' . BASE_URL . '/asignaciones');
        exit;
    }

    public function vuelosDeTripulante(): void
    {
        $ciTripulante = (int) ($_GET['ci'] ?? 0);

        $tripulante = Tripulante::findConDatos($ciTripulante);

        if (!$tripulante) {
            $_SESSION['error'] = 'Tripulante no encontrado.';

            header('Location: ' . BASE_URL . '/tripulantes');
            exit;
        }

        $todasLasAsignaciones = $_SESSION['asignaciones_tripulantes'] ?? [];

        $asignaciones = array_filter($todasLasAsignaciones, function ($asignacion) use ($ciTripulante) {
            return $asignacion['ci_tripulante'] === $ciTripulante;
        });

        require_once __DIR__ . '/../Views/asignaciones/vuelos_tripulante.php';
    }
}