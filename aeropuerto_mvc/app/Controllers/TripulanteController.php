<?php

namespace App\Controllers;

use App\Models\Tripulante;

class TripulanteController
{
    public function index(): void
    {
        $tripulantes = Tripulante::allConDatos();

        require_once __DIR__ . '/../Views/tripulantes/index.php';
    }

    public function crear(): void
    {
        require_once __DIR__ . '/../Views/tripulantes/crear.php';
    }

    public function guardar(): void
    {
        $ci = (int) ($_POST['ci'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $credencial = trim($_POST['credencial'] ?? '');
        $fechaNac = $_POST['fecha_nac'] ?? '';
        $cargo = trim($_POST['cargo'] ?? '');

        if ($ci <= 0 || $nombre === '' || $credencial === '' || $fechaNac === '' || $cargo === '') {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';

            header('Location: ' . BASE_URL . '/tripulantes/crear');
            exit;
        }

        $ok = Tripulante::crear($ci, $credencial, $fechaNac, $nombre, $cargo);

        if ($ok) {
            $_SESSION['mensaje'] = 'Tripulante creado correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo crear el tripulante. Puede que la CI o la credencial ya existan.';
        }

        header('Location: ' . BASE_URL . '/tripulantes');
        exit;
    }

    public function editar(): void
    {
        $ci = (int) ($_GET['ci'] ?? 0);

        $tripulante = Tripulante::findConDatos($ci);

        if (!$tripulante) {
            $_SESSION['error'] = 'Tripulante no encontrado.';

            header('Location: ' . BASE_URL . '/tripulantes');
            exit;
        }

        require_once __DIR__ . '/../Views/tripulantes/editar.php';
    }

    public function actualizar(): void
    {
        $ci = (int) ($_POST['ci'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $credencial = trim($_POST['credencial'] ?? '');
        $fechaNac = $_POST['fecha_nac'] ?? '';
        $cargo = trim($_POST['cargo'] ?? '');

        if ($ci <= 0 || $nombre === '' || $credencial === '' || $fechaNac === '' || $cargo === '') {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';

            header('Location: ' . BASE_URL . '/tripulantes');
            exit;
        }

        $ok = Tripulante::actualizar($ci, $credencial, $fechaNac, $nombre, $cargo);

        if ($ok) {
            $_SESSION['mensaje'] = 'Tripulante actualizado correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo actualizar el tripulante.';
        }

        header('Location: ' . BASE_URL . '/tripulantes');
        exit;
    }

    public function eliminar(): void
    {
        $ci = (int) ($_POST['ci'] ?? 0);

        if ($ci <= 0) {
            $_SESSION['error'] = 'CI inválida.';

            header('Location: ' . BASE_URL . '/tripulantes');
            exit;
        }

        $ok = Tripulante::eliminar($ci);

        if ($ok) {
            $_SESSION['mensaje'] = 'Tripulante eliminado correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo eliminar el tripulante.';
        }

        header('Location: ' . BASE_URL . '/tripulantes');
        exit;
    }
}