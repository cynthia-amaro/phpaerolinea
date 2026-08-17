<?php

namespace App\Controllers;

use App\Models\Pasajero;

class PasajeroController
{
    public function index(): void
    {
        $pasajeros = Pasajero::allConDatos();

        require_once __DIR__ . '/../Views/pasajeros/index.php';
    }

    public function crear(): void
    {
        require_once __DIR__ . '/../Views/pasajeros/crear.php';
    }

    public function guardar(): void
    {
        $ci = (int) ($_POST['ci'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $credencial = trim($_POST['credencial'] ?? '');
        $fechaNac = $_POST['fecha_nac'] ?? '';

        if ($ci <= 0 || $nombre === '' || $credencial === '' || $fechaNac === '') {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';

            header('Location: ' . BASE_URL . '/pasajeros/crear');
            exit;
        }

        $ok = Pasajero::crear($ci, $credencial, $fechaNac, $nombre);

        if ($ok) {
            $_SESSION['mensaje'] = 'Pasajero creado correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo crear el pasajero. Puede que la CI o la credencial ya existan.';
        }

        header('Location: ' . BASE_URL . '/pasajeros');
        exit;
    }

    public function editar(): void
    {
        $ci = (int) ($_GET['ci'] ?? 0);

        $pasajero = Pasajero::findConDatos($ci);

        if (!$pasajero) {
            $_SESSION['error'] = 'Pasajero no encontrado.';

            header('Location: ' . BASE_URL . '/pasajeros');
            exit;
        }

        require_once __DIR__ . '/../Views/pasajeros/editar.php';
    }

    public function actualizar(): void
    {
        $ci = (int) ($_POST['ci'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $credencial = trim($_POST['credencial'] ?? '');
        $fechaNac = $_POST['fecha_nac'] ?? '';

        if ($ci <= 0 || $nombre === '' || $credencial === '' || $fechaNac === '') {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';

            header('Location: ' . BASE_URL . '/pasajeros');
            exit;
        }

        $ok = Pasajero::actualizar($ci, $credencial, $fechaNac, $nombre);

        if ($ok) {
            $_SESSION['mensaje'] = 'Pasajero actualizado correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo actualizar el pasajero.';
        }

        header('Location: ' . BASE_URL . '/pasajeros');
        exit;
    }

    public function eliminar(): void
    {
        $ci = (int) ($_POST['ci'] ?? 0);

        if ($ci <= 0) {
            $_SESSION['error'] = 'CI inválida.';

            header('Location: ' . BASE_URL . '/pasajeros');
            exit;
        }

        $ok = Pasajero::eliminar($ci);

        if ($ok) {
            $_SESSION['mensaje'] = 'Pasajero eliminado correctamente.';
        } else {
            $_SESSION['error'] = 'No se puede eliminar el pasajero porque puede tener reservas asociadas.';
        }

        header('Location: ' . BASE_URL . '/pasajeros');
        exit;
    }
}