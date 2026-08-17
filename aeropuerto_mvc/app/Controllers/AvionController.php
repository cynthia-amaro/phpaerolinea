<?php

namespace App\Controllers;

use App\Models\Avion;

class AvionController
{
    public function index(): void
    {
        $aviones = Avion::all();

        require_once __DIR__ . '/../Views/aviones/index.php';
    }

    public function crear(): void
    {
        require_once __DIR__ . '/../Views/aviones/crear.php';
    }

    public function guardar(): void
    {
        $matricula = trim($_POST['matricula'] ?? '');
        $fabricante = trim($_POST['fabricante'] ?? '');
        $asientos = (int) ($_POST['asientos'] ?? 0);
        $carga = (int) ($_POST['carga'] ?? 0);
        $modelo = trim($_POST['modelo'] ?? '');

        if ($matricula === '' || $fabricante === '' || $asientos <= 0 || $carga <= 0 || $modelo === '') {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';

            header('Location: ' . BASE_URL . '/aviones/crear');
            exit;
        }

        $avion = new Avion($matricula, $fabricante, $asientos, $carga, $modelo);

        $ok = $avion->guardar();

        if ($ok) {
            $_SESSION['mensaje'] = 'Avión creado correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo crear el avión.';
        }

        header('Location: ' . BASE_URL . '/aviones');
        exit;
    }

    public function editar(): void
    {
        $matricula = $_GET['matricula'] ?? '';

        $avion = Avion::find($matricula);

        if (!$avion) {
            $_SESSION['error'] = 'Avión no encontrado.';

            header('Location: ' . BASE_URL . '/aviones');
            exit;
        }

        require_once __DIR__ . '/../Views/aviones/editar.php';
    }

    public function actualizar(): void
    {
        $matricula = trim($_POST['matricula'] ?? '');
        $fabricante = trim($_POST['fabricante'] ?? '');
        $asientos = (int) ($_POST['asientos'] ?? 0);
        $carga = (int) ($_POST['carga'] ?? 0);
        $modelo = trim($_POST['modelo'] ?? '');

        if ($matricula === '' || $fabricante === '' || $asientos <= 0 || $carga <= 0 || $modelo === '') {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';

            header('Location: ' . BASE_URL . '/aviones');
            exit;
        }

        $ok = Avion::actualizar($matricula, $fabricante, $asientos, $carga, $modelo);

        if ($ok) {
            $_SESSION['mensaje'] = 'Avión actualizado correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo actualizar el avión.';
        }

        header('Location: ' . BASE_URL . '/aviones');
        exit;
    }

    public function eliminar(): void
    {
        $matricula = $_POST['matricula'] ?? '';

        if ($matricula === '') {
            $_SESSION['error'] = 'Matrícula inválida.';

            header('Location: ' . BASE_URL . '/aviones');
            exit;
        }

        try {
            $ok = Avion::eliminar($matricula);

            if ($ok) {
                $_SESSION['mensaje'] = 'Avión eliminado correctamente.';
            } else {
                $_SESSION['error'] = 'No se pudo eliminar el avión.';
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = 'No se puede eliminar el avión porque puede estar asociado a un vuelo.';
        }

        header('Location: ' . BASE_URL . '/aviones');
        exit;
    }
}