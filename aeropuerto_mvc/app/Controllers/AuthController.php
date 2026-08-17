<?php

namespace App\Controllers;

use App\Models\Persona;

class AuthController
{
    public function login(): void
    {
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    public function procesarLogin(): void
    {
        $ci = (int) ($_POST['ci'] ?? 0);
        $credencial = $_POST['credencial'] ?? '';

        $persona = Persona::buscarParaLogin($ci, $credencial);

        if ($persona) {
            $_SESSION['usuario'] = [
                'ci' => $persona['CI'],
                'nombre' => $persona['Nombre'],
                'credencial' => $persona['Credencial']
            ];

            header('Location: ' . BASE_URL . '/vuelos');
            exit;
        }

        $_SESSION['error'] = 'CI o credencial incorrectos.';

        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    public function registro(): void
    {
        require_once __DIR__ . '/../Views/auth/registro.php';
    }

    public function procesarRegistro(): void
    {
        $ci = (int) ($_POST['ci'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $credencial = trim($_POST['credencial'] ?? '');
        $fechaNac = $_POST['fecha_nac'] ?? '';

        if ($ci <= 0 || $nombre === '' || $credencial === '' || $fechaNac === '') {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';

            header('Location: ' . BASE_URL . '/registro');
            exit;
        }

        $persona = new Persona($ci, $credencial, $fechaNac, $nombre);

        $ok = $persona->guardarComoPasajero();

        if ($ok) {
            $_SESSION['mensaje'] = 'Registro correcto. Ahora podés iniciar sesión.';

            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $_SESSION['error'] = 'No se pudo registrar. Puede que la CI o la credencial ya existan.';

        header('Location: ' . BASE_URL . '/registro');
        exit;
    }

    public function logout(): void
    {
        session_destroy();

        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}