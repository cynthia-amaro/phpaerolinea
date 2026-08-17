<?php

namespace App\Controllers;

use App\Models\Vuelo;
use App\Models\Avion;

class VueloController
{
    public function index(): void
    {
        $vuelos = Vuelo::all();

        require_once __DIR__ . '/../Views/vuelos/index.php';
    }

    public function crear(): void
    {
        $aviones = Avion::all();

        require_once __DIR__ . '/../Views/vuelos/crear.php';
    }

    public function guardar(): void
    {
        $fechaHoraS = $_POST['fecha_hora_s'] ?? '';
        $fechaHoraL = $_POST['fecha_hora_l'] ?? '';
        $matricula = $_POST['matricula'] ?? '';

        if ($fechaHoraS === '' || $fechaHoraL === '' || $matricula === '') {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';

            header('Location: ' . BASE_URL . '/vuelos/crear');
            exit;
        }

        $vuelo = new Vuelo($fechaHoraS, $fechaHoraL, $matricula);

        $ok = $vuelo->guardar();

        if ($ok) {
            $_SESSION['mensaje'] = 'Vuelo creado correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo crear el vuelo.';
        }

        header('Location: ' . BASE_URL . '/vuelos');
        exit;
    }

    public function editar(): void
    {
        $idVuelo = (int) ($_GET['id'] ?? 0);

        $vuelo = Vuelo::find($idVuelo);
        $aviones = Avion::all();

        if (!$vuelo) {
            $_SESSION['error'] = 'Vuelo no encontrado.';

            header('Location: ' . BASE_URL . '/vuelos');
            exit;
        }

        require_once __DIR__ . '/../Views/vuelos/editar.php';
    }

    public function actualizar(): void
    {
        $idVuelo = (int) ($_POST['id_vuelo'] ?? 0);
        $fechaHoraS = $_POST['fecha_hora_s'] ?? '';
        $fechaHoraL = $_POST['fecha_hora_l'] ?? '';
        $matricula = $_POST['matricula'] ?? '';

        if ($idVuelo <= 0 || $fechaHoraS === '' || $fechaHoraL === '' || $matricula === '') {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';

            header('Location: ' . BASE_URL . '/vuelos');
            exit;
        }

        $ok = Vuelo::actualizar($idVuelo, $fechaHoraS, $fechaHoraL, $matricula);

        if ($ok) {
            $_SESSION['mensaje'] = 'Vuelo actualizado correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo actualizar el vuelo.';
        }

        header('Location: ' . BASE_URL . '/vuelos');
        exit;
    }

    public function eliminar(): void
    {
        $idVuelo = (int) ($_POST['id_vuelo'] ?? 0);

        if ($idVuelo <= 0) {
            $_SESSION['error'] = 'Vuelo inválido.';

            header('Location: ' . BASE_URL . '/vuelos');
            exit;
        }

        try {
            $ok = Vuelo::eliminar($idVuelo);

            if ($ok) {
                $_SESSION['mensaje'] = 'Vuelo eliminado correctamente.';
            } else {
                $_SESSION['error'] = 'No se pudo eliminar el vuelo.';
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = 'No se puede eliminar el vuelo porque tiene reservas asociadas.';
        }

        header('Location: ' . BASE_URL . '/vuelos');
        exit;
    }
}